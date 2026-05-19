<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorController extends Controller
{
    public function __construct(private readonly Google2FA $google2fa) {}

    /**
     * Show the 2FA setup page.
     * Generates a fresh secret (stored in session, NOT in DB yet)
     * and renders the QR code for the user to scan.
     */
    public function setup(Request $request): View
    {
        $user = $request->user();

        // If already enabled, redirect to profile
        if ($user->hasTwoFactorEnabled()) {
            return view('auth.two-factor.manage', ['enabled' => true]);
        }

        // Generate a new secret and hold it in session until the user confirms
        if (! $request->session()->has('2fa_setup_secret')) {
            $request->session()->put('2fa_setup_secret', $this->google2fa->generateSecretKey());
        }

        $secret = $request->session()->get('2fa_setup_secret');

        // getQRCodeInline() returns an SVG string (via bacon/bacon-qr-code)
        $qrCodeSvg = $this->google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret,
        );

        return view('auth.two-factor.setup', compact('secret', 'qrCodeSvg'));
    }

    /**
     * Confirm setup: verify the user scanned correctly by checking their first OTP.
     * Only after this does the secret get persisted to the database.
     */
    public function enable(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
            'code'     => ['required', 'string', 'digits:6'],
        ]);

        $secret = $request->session()->get('2fa_setup_secret');

        if (! $secret) {
            return redirect()->route('two-factor.setup')
                ->withErrors(['code' => 'Session expired. Please start the setup again.']);
        }

        $valid = $this->google2fa->verifyKey($secret, $request->input('code'));

        if (! $valid) {
            return back()->withErrors(['code' => 'Invalid code. Please try again.']);
        }

        $request->user()->update([
            'two_factor_secret'       => $secret,
            'two_factor_confirmed_at' => now(),
        ]);

        $request->session()->forget('2fa_setup_secret');

        // Mark the current session as 2FA-verified so the middleware
        // doesn't challenge the user who just confirmed a valid OTP.
        $request->session()->put(config('google2fa.session_var'), now()->timestamp);

        Log::info('2FA enabled', ['user_id' => $request->user()->id]);

        return redirect()->route('two-factor.manage')
            ->with('success', 'Two-factor authentication has been enabled.');
    }

    /**
     * Disable 2FA — requires password confirmation for extra safety.
     */
    public function disable(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $request->user()->update([
            'two_factor_secret'       => null,
            'two_factor_confirmed_at' => null,
        ]);

        // Invalidate the 2FA session flag so the middleware won't glitch
        $request->session()->forget('google2fa');

        Log::warning('2FA disabled', ['user_id' => $request->user()->id]);

        return redirect()->route('two-factor.manage')
            ->with('success', 'Two-factor authentication has been disabled.');
    }

    /**
     * Show the management page (enable / disable status).
     */
    public function manage(Request $request): View
    {
        return view('auth.two-factor.manage', [
            'enabled' => $request->user()->hasTwoFactorEnabled(),
        ]);
    }
}

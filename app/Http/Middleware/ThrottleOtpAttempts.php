<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ThrottleOtpAttempts
{
    /**
     * Allow 5 OTP attempts per user per 5 minutes.
     * Applies only when the request carries an `one_time_password` field
     * (i.e., the user is submitting the 2FA challenge form).
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->has('one_time_password') || ! $request->user()) {
            return $next($request);
        }

        $key = 'otp_attempts:' . $request->user()->id;

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return redirect()->back()->withErrors([
                'one_time_password' => "Too many attempts. Try again in {$seconds} seconds.",
            ]);
        }

        // Always count the attempt upfront (5-minute decay window)
        RateLimiter::hit($key, 300);

        $response = $next($request);

        // If the 2FA middleware marked the session as verified, the OTP was correct → clear the counter
        if ($request->session()->get(config('google2fa.session_var'))) {
            RateLimiter::clear($key);
        }

        return $response;
    }
}

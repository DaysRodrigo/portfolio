<x-guest-layout>
    <h2 class="text-lg font-semibold text-gray-900 mb-2">{{ __('Set up Two-Factor Authentication') }}</h2>

    <p class="text-sm text-gray-600 mb-4">
        {{ __('Scan the QR code below with your authenticator app (Google Authenticator, Authy, etc.), then enter the 6-digit code to confirm.') }}
    </p>

    {{-- QR Code — SVG returned directly by bacon/bacon-qr-code --}}
    <div class="flex justify-center mb-4 [&_svg]:w-48 [&_svg]:h-48">
        {!! $qrCodeSvg !!}
    </div>

    {{-- Manual entry fallback --}}
    <details class="mb-4 text-sm text-gray-500">
        <summary class="cursor-pointer hover:text-gray-700">{{ __("Can't scan? Enter the key manually") }}</summary>
        <p class="mt-2 font-mono tracking-widest break-all bg-gray-50 rounded p-2">{{ $secret }}</p>
    </details>

    <form method="POST" action="{{ route('two-factor.enable') }}">
        @csrf

        {{-- Password confirmation prevents a stolen session from registering a new TOTP --}}
        <div class="mb-4">
            <x-input-label for="password" :value="__('Current Password')" />
            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="code" :value="__('Confirmation Code')" />
            <x-text-input
                id="code"
                class="block mt-1 w-full tracking-widest text-center text-lg"
                type="text"
                name="code"
                inputmode="numeric"
                autocomplete="one-time-code"
                autofocus
                maxlength="6"
                placeholder="000000"
            />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Enable 2FA') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<x-guest-layout>
    <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Two-Factor Authentication') }}</h2>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($enabled)
        <div class="mb-4 flex items-center gap-2 text-sm text-green-700">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ __('Two-factor authentication is enabled.') }}
        </div>

        <p class="text-sm text-gray-600 mb-4">
            {{ __('To disable 2FA, confirm your current password.') }}
        </p>

        <form method="POST" action="{{ route('two-factor.disable') }}">
            @csrf

            <div>
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

            <div class="flex items-center justify-end mt-4">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Disable 2FA') }}
                </button>
            </div>
        </form>
    @else
        <div class="mb-4 flex items-center gap-2 text-sm text-gray-500">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            {{ __('Two-factor authentication is not enabled.') }}
        </div>

        <p class="text-sm text-gray-600 mb-4">
            {{ __('Add an extra layer of security to your account by enabling two-factor authentication.') }}
        </p>

        <div class="flex items-center justify-end">
            <a href="{{ route('two-factor.setup') }}">
                <x-primary-button>{{ __('Enable 2FA') }}</x-primary-button>
            </a>
        </div>
    @endif
</x-guest-layout>

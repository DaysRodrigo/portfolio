@extends('layouts.admin')

@section('content')
{{-- Page content stays behind the modal overlay --}}
@endsection

@push('overlay')
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="w-full max-w-sm rounded-xl bg-white p-8 shadow-2xl mx-4">

        {{-- Icon --}}
        <div class="mb-5 flex justify-center">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50">
                <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
            </div>
        </div>

        <h2 class="mb-1 text-center text-lg font-semibold text-gray-900">Two-Factor Authentication</h2>
        <p class="mb-6 text-center text-sm text-gray-500">Open your authenticator app and enter the 6-digit code.</p>

        {{-- Error from middleware --}}
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('two-factor.challenge') }}">
            @csrf

            <div>
                <x-input-label for="one_time_password" :value="__('Authentication Code')" />
                <x-text-input
                    id="one_time_password"
                    class="mt-1 block w-full tracking-[0.5em] text-center text-xl font-mono"
                    type="text"
                    name="one_time_password"
                    inputmode="numeric"
                    autocomplete="one-time-code"
                    autofocus
                    maxlength="6"
                    placeholder="000000"
                />
                <x-input-error :messages="$errors->get('one_time_password')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-primary-button class="w-full justify-center">
                    {{ __('Verify') }}
                </x-primary-button>
            </div>
        </form>

        {{-- Escape hatch --}}
        <div class="mt-4 text-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs text-gray-400 hover:text-red-500">
                    Sign out instead
                </button>
            </form>
        </div>

    </div>
</div>
@endpush

@extends('layouts.public')

@section('title', __('timeline.title') . ' — Rodrigo Dias Sales')

@section('content')

<section class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
    <div class="mb-12">
        <h1 class="text-3xl font-bold">{{ __('timeline.title') }}</h1>
        <p class="mt-2 text-gray-500 dark:text-gray-400">{{ __('timeline.subtitle') }}</p>
    </div>

    <ol class="relative border-l border-gray-200 dark:border-gray-800">
        @foreach($entries as $entry)
        <li class="mb-10 ml-6">
            {{-- Icon --}}
            <span class="absolute -left-3 flex h-6 w-6 items-center justify-center rounded-full ring-8 ring-white dark:ring-gray-950
                {{ $entry['type'] === 'work' ? 'bg-indigo-600' : 'bg-emerald-600' }}">
                @if($entry['type'] === 'work')
                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zm-9 9H7v-2h4v2zm6 0h-4v-2h4v2zM9 7V5a1 1 0 011-1h4a1 1 0 011 1v2H9z"/>
                </svg>
                @else
                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6L21 9 12 3zm0 12.5L7 12.62V9.38L12 12l5-2.62v3.24L12 15.5z"/>
                </svg>
                @endif
            </span>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <div class="mb-1 flex flex-wrap items-center justify-between gap-2">
                    <h3 class="font-semibold">{{ $entry['title'] }}</h3>
                    <time class="text-xs text-gray-500 dark:text-gray-400">
                        {{ \Carbon\Carbon::createFromFormat('Y-m', $entry['start'])->format('M Y') }}
                        —
                        {{ $entry['end'] === 'present' ? 'Present' : \Carbon\Carbon::createFromFormat('Y-m', $entry['end'])->format('M Y') }}
                    </time>
                </div>
                <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                    {{ $entry['company'] }}
                    <span class="ml-2 font-normal text-gray-500 dark:text-gray-400">· {{ $entry['location'] }}</span>
                </p>
                <p class="mt-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ $entry['description'] }}
                </p>
                @if(!empty($entry['skills']))
                <div class="mt-3 flex flex-wrap gap-1.5">
                    @foreach($entry['skills'] as $skill)
                    <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium dark:bg-gray-800">
                        {{ $skill }}
                    </span>
                    @endforeach
                </div>
                @endif
            </div>
        </li>
        @endforeach
    </ol>
</section>

@endsection

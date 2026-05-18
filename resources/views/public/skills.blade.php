@extends('layouts.public')

@section('title', __('skills.title') . ' — Rodrigo Dias Sales')

@section('content')

<section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
    <div class="mb-12">
        <h1 class="text-3xl font-bold">{{ __('skills.title') }}</h1>
        <p class="mt-2 text-gray-500 dark:text-gray-400">{{ __('skills.subtitle') }}</p>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($skills as $category => $tags)
        <div class="rounded-xl border border-gray-200 p-6 dark:border-gray-800">
            <h2 class="mb-4 text-sm font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400">
                {{ $category }}
            </h2>
            <ul class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                <li>
                    <span class="rounded-full bg-gray-100 px-3 py-1.5 text-sm font-medium dark:bg-gray-800">
                        {{ $tag->name }}
                    </span>
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
</section>

@endsection

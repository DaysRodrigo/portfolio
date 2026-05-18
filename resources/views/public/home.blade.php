@extends('layouts.public')

@section('title', 'Rodrigo Dias Sales — Backend Engineer')

@section('content')

{{-- Hero --}}
<section class="mx-auto max-w-6xl px-4 py-24 sm:px-6 sm:py-32">
    <div class="max-w-2xl">
        <p class="mb-2 text-sm font-semibold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">
            Backend Engineer
        </p>
        <h1 class="mb-4 text-4xl font-bold tracking-tight sm:text-5xl">
            {{ __('hero.title') }}
        </h1>
        <p class="mb-8 text-lg text-gray-600 dark:text-gray-400">
            {{ __('hero.subtitle') }}
        </p>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('projects.index') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-indigo-600">
                {{ __('hero.cta_projects') }}
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="mailto:rodrigodcontato@gmail.com"
               class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold hover:border-indigo-500 hover:text-indigo-600 dark:border-gray-700 dark:hover:border-indigo-400 dark:hover:text-indigo-400">
                {{ __('hero.cta_contact') }}
            </a>
        </div>
    </div>
</section>

{{-- Featured Projects --}}
@if($projects->isNotEmpty())
<section class="border-t border-gray-100 bg-gray-50 py-16 dark:border-gray-800 dark:bg-gray-900">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="mb-10 flex items-end justify-between">
            <div>
                <h2 class="text-2xl font-bold">{{ __('projects.title') }}</h2>
                <p class="mt-1 text-gray-500 dark:text-gray-400">{{ __('projects.subtitle') }}</p>
            </div>
            <a href="{{ route('projects.index') }}" class="text-sm font-medium text-indigo-600 hover:underline dark:text-indigo-400">
                {{ __('projects.view_details') }} →
            </a>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($projects as $project)
            <article class="flex flex-col rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-gray-800 dark:bg-gray-950">
                <h3 class="mb-2 font-semibold">
                    <a href="{{ route('projects.show', $project->slug) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                        {{ $project->title }}
                    </a>
                </h3>
                <p class="mb-4 flex-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ Str::limit($project->description, 120) }}
                </p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($project->skillTags->take(4) as $tag)
                    <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                        {{ $tag->name }}
                    </span>
                    @endforeach
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Skills preview --}}
<section class="py-16">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <h2 class="mb-2 text-2xl font-bold">{{ __('skills.title') }}</h2>
        <p class="mb-10 text-gray-500 dark:text-gray-400">{{ __('skills.subtitle') }}</p>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($skills as $category => $tags)
            <div class="rounded-xl border border-gray-200 p-5 dark:border-gray-800">
                <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    {{ $category }}
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-sm font-medium dark:bg-gray-800">
                        {{ $tag->name }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

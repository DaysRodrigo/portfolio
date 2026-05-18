@extends('layouts.public')

@section('title', $project->title . ' — Rodrigo Dias Sales')

@section('content')

<section class="mx-auto max-w-4xl px-4 py-16 sm:px-6">

    <a href="{{ route('projects.index') }}" class="mb-8 inline-flex items-center gap-1 text-sm text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400">
        ← {{ __('projects.back') }}
    </a>

    <h1 class="mt-4 text-3xl font-bold">{{ $project->title }}</h1>
    <p class="mt-4 text-gray-600 dark:text-gray-400 leading-relaxed">{{ $project->description }}</p>

    {{-- GitHub stats --}}
    @if($project->github_stars !== null || $project->github_forks !== null || $project->github_last_push)
    <div class="mt-6 flex flex-wrap gap-6 text-sm text-gray-500 dark:text-gray-400">
        @if($project->github_stars !== null)
        <span class="flex items-center gap-1">
            <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            {{ $project->github_stars }} {{ __('projects.stars') }}
        </span>
        @endif
        @if($project->github_forks !== null)
        <span class="flex items-center gap-1">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h.01M8 11h.01M8 15h.01M16 7h.01M16 11h.01M16 15h.01M12 3v18M3 12h18"/>
            </svg>
            {{ $project->github_forks }} {{ __('projects.forks') }}
        </span>
        @endif
        @if($project->github_last_push)
        <span>{{ __('projects.last_push') }}: {{ $project->github_last_push->diffForHumans() }}</span>
        @endif
    </div>
    @endif

    {{-- Tech stack --}}
    @if($project->skillTags->isNotEmpty())
    <div class="mt-8">
        <h2 class="mb-3 text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
            {{ __('projects.tech_stack') }}
        </h2>
        <div class="flex flex-wrap gap-2">
            @foreach($project->skillTags as $tag)
            <span class="rounded-full bg-indigo-50 px-3 py-1 text-sm font-medium text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                {{ $tag->name }}
            </span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Links --}}
    <div class="mt-8 flex flex-wrap gap-3">
        @if($project->repo_url)
        <a href="{{ $project->repo_url }}" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium hover:border-indigo-500 hover:text-indigo-600 dark:border-gray-700 dark:hover:border-indigo-400 dark:hover:text-indigo-400">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
            </svg>
            {{ __('projects.view_source') }}
        </a>
        @endif
        @if($project->live_url)
        <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            {{ __('projects.view_live') }}
        </a>
        @endif
    </div>

</section>

@endsection

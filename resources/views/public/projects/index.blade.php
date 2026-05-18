@extends('layouts.public')

@section('title', __('projects.title') . ' — Rodrigo Dias Sales')

@section('content')

<section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
    <div class="mb-12">
        <h1 class="text-3xl font-bold">{{ __('projects.title') }}</h1>
        <p class="mt-2 text-gray-500 dark:text-gray-400">{{ __('projects.subtitle') }}</p>
    </div>

    @if($projects->isEmpty())
        <p class="text-gray-500 dark:text-gray-400">{{ __('projects.empty') }}</p>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($projects as $project)
            <article class="flex flex-col rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-gray-800 dark:bg-gray-950">
                <div class="mb-4 flex-1">
                    <h2 class="mb-2 text-lg font-semibold">
                        <a href="{{ route('projects.show', $project->slug) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                            {{ $project->title }}
                        </a>
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ Str::limit($project->description, 140) }}
                    </p>
                </div>

                <div class="mb-4 flex flex-wrap gap-1.5">
                    @foreach($project->skillTags as $tag)
                    <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                        {{ $tag->name }}
                    </span>
                    @endforeach
                </div>

                <div class="flex items-center gap-3 text-sm">
                    @if($project->repo_url)
                    <a href="{{ $project->repo_url }}" target="_blank" rel="noopener noreferrer"
                       class="flex items-center gap-1 text-gray-600 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                        </svg>
                        {{ __('projects.view_source') }}
                    </a>
                    @endif
                    @if($project->live_url)
                    <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer"
                       class="flex items-center gap-1 text-gray-600 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        {{ __('projects.view_live') }}
                    </a>
                    @endif
                    <a href="{{ route('projects.show', $project->slug) }}"
                       class="ml-auto font-medium text-indigo-600 hover:underline dark:text-indigo-400">
                        {{ __('projects.view_details') }} →
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    @endif
</section>

@endsection

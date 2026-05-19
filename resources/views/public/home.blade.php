@extends('layouts.public')

@section('content')

{{-- ── Hero ──────────────────────────────────────────────────────────── --}}
<section class="relative overflow-hidden py-24 sm:py-32">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="max-w-2xl">
            <p class="mb-3 text-sm font-semibold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">
                Backend Engineer
            </p>
            <h1 class="mb-5 text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                {{ __('hero.title') }}<span class="text-indigo-600 dark:text-indigo-400">.</span>
            </h1>
            <p class="mb-8 text-lg text-gray-600 dark:text-gray-400">
                {{ __('hero.subtitle') }}
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="#projects"
                   class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                    {{ __('hero.cta_projects') }}
                </a>
                <a href="#contact"
                   class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                    {{ __('hero.cta_contact') }}
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ── About / Timeline ─────────────────────────────────────────────── --}}
<section id="about" class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <h2 class="mb-3 text-3xl font-bold">{{ __('timeline.title') }}</h2>
        <p class="mb-12 text-gray-500 dark:text-gray-400">{{ __('timeline.subtitle') }}</p>

        <div class="relative border-l-2 border-gray-200 dark:border-gray-700 pl-8 space-y-10">
            @foreach($timeline as $item)
            <div class="relative">
                <span class="absolute -left-[2.65rem] flex h-8 w-8 items-center justify-center rounded-full
                    {{ $item['type'] === 'work' ? 'bg-indigo-100 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-300' : 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900 dark:text-emerald-300' }}">
                    @if($item['type'] === 'work')
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    @else
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 14l9-5-9-5-9 5 9 5zm0 7l-9-5 9-5 9 5-9 5z"/>
                        </svg>
                    @endif
                </span>

                <div>
                    <p class="mb-0.5 text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wide">
                        @php
                            $start = \Carbon\Carbon::parse($item['start'])->translatedFormat('M Y');
                            $end   = $item['end'] ? \Carbon\Carbon::parse($item['end'])->translatedFormat('M Y') : __('timeline.present');
                        @endphp
                        {{ $start }} – {{ $end }} · {{ $item['location'] }}
                    </p>
                    <h3 class="text-lg font-semibold">{{ $item['title'] }}</h3>
                    <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400 mb-2">{{ $item['company'] }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $item['description'] }}</p>
                    @if(!empty($item['skills']))
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($item['skills'] as $skill)
                        <span class="rounded-full bg-gray-200 px-2.5 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                            {{ $skill }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Skills ───────────────────────────────────────────────────────── --}}
<section id="skills" class="py-20">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <h2 class="mb-3 text-3xl font-bold">{{ __('skills.title') }}</h2>
        <p class="mb-12 text-gray-500 dark:text-gray-400">{{ __('skills.subtitle') }}</p>

        <div class="space-y-8">
            @foreach($skills as $category => $tags)
            <div>
                <h3 class="mb-3 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                    {{ $category }}
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                    <span class="rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        {{ $tag->name }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Projects ─────────────────────────────────────────────────────── --}}
<section id="projects" class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <h2 class="mb-3 text-3xl font-bold">{{ __('projects.title') }}</h2>
        <p class="mb-12 text-gray-500 dark:text-gray-400">{{ __('projects.subtitle') }}</p>

        @if($projects->isEmpty())
            <p class="text-gray-500">{{ __('projects.empty') }}</p>
        @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($projects as $project)
            @php
                $images = $project->images->map(fn($img) => [
                    'url' => Storage::url($img->path),
                    'alt' => $img->alt ?? $project->title,
                ])->values()->toArray();
                $cover  = $images[0]['url'] ?? null;
                $skills = $project->skillTags->pluck('name')->toArray();
            @endphp
            @php
                $projectJson = json_encode([
                    'title'            => $project->title,
                    'description'      => $project->description,
                    'long_description' => $project->long_description,
                    'repo_url'         => $project->repo_url,
                    'live_url'         => $project->live_url,
                    'skills'           => $skills,
                    'images'           => $images,
                    'stars'            => $project->github_stars,
                    'forks'            => $project->github_forks,
                    'last_push'        => $project->github_last_push?->diffForHumans(),
                ], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS);
            @endphp
            <div class="group flex cursor-pointer flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md dark:border-gray-700 dark:bg-gray-800"
                 @click="openProject(JSON.parse($el.dataset.project))"
                 data-project='{{ $projectJson }}'>

                @if($cover)
                <div class="h-44 overflow-hidden">
                    <img src="{{ $cover }}" alt="{{ $project->title }}"
                         class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                </div>
                @else
                <div class="flex h-44 items-center justify-center bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-950 dark:to-indigo-900">
                    <svg class="h-10 w-10 text-indigo-300 dark:text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </div>
                @endif

                <div class="flex flex-1 flex-col p-5">
                    <h3 class="mb-1 font-semibold text-gray-900 dark:text-white">{{ $project->title }}</h3>
                    <p class="mb-4 flex-1 text-sm text-gray-500 dark:text-gray-400 line-clamp-3">{{ $project->description }}</p>

                    @if($project->skillTags->isNotEmpty())
                    <div class="flex flex-wrap gap-1">
                        @foreach($project->skillTags->take(4) as $tag)
                        <span class="rounded-full bg-indigo-50 px-2 py-0.5 text-xs font-medium text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                            {{ $tag->name }}
                        </span>
                        @endforeach
                        @if($project->skillTags->count() > 4)
                        <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-500 dark:bg-gray-700 dark:text-gray-400">
                            +{{ $project->skillTags->count() - 4 }}
                        </span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- ── Modal ──────────────────────────────────────────────────────── --}}
    <div x-show="modalOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         @click.self="modalOpen = false"
         @keydown.escape.window="modalOpen = false"
         style="display:none">

        <div class="relative w-full max-w-3xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl dark:bg-gray-900">

            <button @click="modalOpen = false"
                    class="absolute right-4 top-4 z-10 rounded-full bg-gray-100 p-1.5 text-gray-500 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Carousel --}}
            <template x-if="modalProject && modalProject.images.length > 0">
                <div class="relative bg-black rounded-t-2xl overflow-hidden" style="height:340px">
                    <img :src="modalProject.images[modalSlide].url" :alt="modalProject.images[modalSlide].alt"
                         class="h-full w-full object-contain">

                    <button x-show="modalSlide > 0" @click.stop="modalPrev()"
                            class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-black/50 p-2 text-white hover:bg-black/75">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>

                    <button x-show="modalProject && modalSlide < modalProject.images.length - 1" @click.stop="modalNext()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-black/50 p-2 text-white hover:bg-black/75">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5">
                        <template x-for="(img, i) in modalProject.images" :key="i">
                            <button @click.stop="modalSlide = i"
                                    :class="modalSlide === i ? 'bg-white' : 'bg-white/40'"
                                    class="h-1.5 w-1.5 rounded-full transition-colors"></button>
                        </template>
                    </div>
                </div>
            </template>

            <template x-if="modalProject && modalProject.images.length === 0">
                <div class="flex h-48 items-center justify-center rounded-t-2xl bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-950 dark:to-indigo-900">
                    <svg class="h-12 w-12 text-indigo-300 dark:text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </div>
            </template>

            <div class="p-6" x-show="modalProject">
                <h2 class="mb-1 text-2xl font-bold" x-text="modalProject?.title"></h2>

                <div class="mb-4 flex flex-wrap gap-4 text-sm text-gray-500 dark:text-gray-400">
                    <template x-if="modalProject && modalProject.stars > 0">
                        <span>⭐ <span x-text="modalProject.stars"></span></span>
                    </template>
                    <template x-if="modalProject && modalProject.forks > 0">
                        <span>🍴 <span x-text="modalProject.forks"></span></span>
                    </template>
                    <template x-if="modalProject && modalProject.last_push">
                        <span x-text="'{{ __('projects.last_push') }}: ' + modalProject.last_push"></span>
                    </template>
                </div>

                <p class="mb-4 text-gray-600 dark:text-gray-400" x-text="modalProject?.long_description || modalProject?.description"></p>

                <template x-if="modalProject && modalProject.skills.length > 0">
                    <div class="mb-5 flex flex-wrap gap-1.5">
                        <template x-for="skill in modalProject.skills" :key="skill">
                            <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300"
                                  x-text="skill"></span>
                        </template>
                    </div>
                </template>

                <div class="flex gap-3">
                    <template x-if="modalProject && modalProject.live_url">
                        <a :href="modalProject.live_url" target="_blank" rel="noopener"
                           class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                            {{ __('projects.view_live') }} ↗
                        </a>
                    </template>
                    <template x-if="modalProject && modalProject.repo_url">
                        <a :href="modalProject.repo_url" target="_blank" rel="noopener"
                           class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                            {{ __('projects.view_source') }}
                        </a>
                    </template>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

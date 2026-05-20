@extends('layouts.public')

@section('content')

{{-- ── Hero ──────────────────────────────────────────────────────────── --}}
<section class="relative overflow-hidden py-24 sm:py-32">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="max-w-2xl">
            <p class="mb-3 text-sm font-semibold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">
                {{ $profile->job_title }}
            </p>
            <h1 class="mb-5 text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                {{ $profile->job_title }}<span class="text-indigo-600 dark:text-indigo-400">.</span>
            </h1>
            <p class="mb-4 text-lg text-gray-600 dark:text-gray-400">
                {{ $profile->tagline }}
            </p>
            @if($profile->about)
            <p class="mb-8 text-gray-600 dark:text-gray-400 leading-relaxed">
                {{ $profile->about }}
            </p>
            @else
            <div class="mb-8"></div>
            @endif
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
                    {{ $item->type === \App\Enums\TimelineType::Work ? 'bg-indigo-100 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-300' : 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900 dark:text-emerald-300' }}">
                    @if($item->type === \App\Enums\TimelineType::Work)
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
                        {{ $item->start_date->translatedFormat('M Y') }}
                        –
                        {{ $item->end_date ? $item->end_date->translatedFormat('M Y') : __('timeline.present') }}
                        · {{ $item->location }}
                    </p>
                    <h3 class="text-lg font-semibold">{{ $item->title }}</h3>
                    <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400 mb-2">{{ $item->organization }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $item->description }}</p>
                    @if(!empty($item->skills))
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($item->skills as $skill)
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

{{-- ── Contact ──────────────────────────────────────────────────────── --}}
<section id="contact" class="py-20">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <h2 class="mb-3 text-3xl font-bold">{{ __('contact.title') }}</h2>
        <p class="mb-12 text-gray-500 dark:text-gray-400">{{ __('contact.subtitle') }}</p>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 lg:gap-6">

            {{-- GitHub --}}
            @if($profile->github_url)
            <a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer"
               class="group flex flex-col items-center gap-4 rounded-2xl border border-gray-200 bg-white px-4 py-8 text-center shadow-sm transition hover:-translate-y-1 hover:border-gray-400 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-gray-500">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-700 transition group-hover:bg-gray-900 group-hover:text-white dark:bg-gray-700 dark:text-gray-300 dark:group-hover:bg-white dark:group-hover:text-gray-900">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">GitHub</p>
                    @if($profile->github_username)
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $profile->github_username }}</p>
                    @endif
                </div>
            </a>
            @endif

            {{-- LinkedIn --}}
            @if($profile->linkedin_url)
            <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener noreferrer"
               class="group flex flex-col items-center gap-4 rounded-2xl border border-gray-200 bg-white px-4 py-8 text-center shadow-sm transition hover:-translate-y-1 hover:border-[#0A66C2]/40 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-[#0A66C2]/60">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-700 transition group-hover:bg-[#0A66C2] group-hover:text-white dark:bg-gray-700 dark:text-gray-300">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">LinkedIn</p>
                    @if($profile->linkedin_username)
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $profile->linkedin_username }}</p>
                    @endif
                </div>
            </a>
            @endif

            {{-- Email --}}
            @if($profile->email)
            <a href="mailto:{{ $profile->email }}"
               class="group flex flex-col items-center gap-4 rounded-2xl border border-gray-200 bg-white px-4 py-8 text-center shadow-sm transition hover:-translate-y-1 hover:border-indigo-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-indigo-600">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-700 transition group-hover:bg-indigo-600 group-hover:text-white dark:bg-gray-700 dark:text-gray-300">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Email</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 break-all">{{ $profile->email }}</p>
                </div>
            </a>
            @endif

            {{-- WhatsApp --}}
            @if($profile->whatsapp)
            <a href="https://wa.me/{{ $profile->whatsapp }}" target="_blank" rel="noopener noreferrer"
               class="group flex flex-col items-center gap-4 rounded-2xl border border-gray-200 bg-white px-4 py-8 text-center shadow-sm transition hover:-translate-y-1 hover:border-[#25D366]/40 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-[#25D366]/60">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-700 transition group-hover:bg-[#25D366] group-hover:text-white dark:bg-gray-700 dark:text-gray-300">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">WhatsApp</p>
                    @if($profile->whatsapp_label)
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $profile->whatsapp_label }}</p>
                    @endif
                </div>
            </a>
            @endif

        </div>
    </div>
</section>

@endsection

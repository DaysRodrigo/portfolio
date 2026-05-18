<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Rodrigo Dias Sales — Backend Engineer specialising in PHP, Laravel & Docker.">
    <title>@yield('title', 'Rodrigo Dias Sales — Backend Engineer')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 antialiased dark:bg-gray-950 dark:text-gray-100"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }"
      x-init="$watch('dark', v => { localStorage.setItem('theme', v ? 'dark' : 'light'); document.documentElement.classList.toggle('dark', v) }); document.documentElement.classList.toggle('dark', dark)">

    {{-- Navbar --}}
    <header class="sticky top-0 z-50 border-b border-gray-200 bg-white/80 backdrop-blur dark:border-gray-800 dark:bg-gray-950/80">
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3 sm:px-6">

            <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight hover:text-indigo-600 dark:hover:text-indigo-400">
                Rodrigo<span class="text-indigo-600 dark:text-indigo-400">.</span>
            </a>

            {{-- Desktop nav --}}
            <div class="hidden items-center gap-6 text-sm font-medium sm:flex">
                <a href="{{ route('home') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 {{ request()->routeIs('home') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                    {{ __('nav.home') }}
                </a>
                <a href="{{ route('projects.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 {{ request()->routeIs('projects.*') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                    {{ __('nav.projects') }}
                </a>
                <a href="{{ route('skills.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 {{ request()->routeIs('skills.*') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                    {{ __('nav.skills') }}
                </a>
                <a href="{{ route('timeline.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 {{ request()->routeIs('timeline.*') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                    {{ __('nav.timeline') }}
                </a>
            </div>

            <div class="flex items-center gap-3">
                {{-- Language toggle --}}
                <a href="{{ route(Route::currentRouteName() ?? 'home', array_merge(Route::current()?->parameters() ?? [], ['locale_switch' => app()->getLocale() === 'en' ? 'pt_BR' : 'en'])) }}"
                   onclick="event.preventDefault(); document.cookie='app_locale={{ app()->getLocale() === 'en' ? 'pt_BR' : 'en' }};path=/;max-age=31536000'; location.reload();"
                   class="rounded-md border border-gray-300 px-2.5 py-1 text-xs font-semibold uppercase tracking-wide hover:border-indigo-500 hover:text-indigo-600 dark:border-gray-700 dark:hover:border-indigo-400 dark:hover:text-indigo-400"
                   title="{{ __('nav.toggle_language') }}">
                    {{ app()->getLocale() === 'en' ? 'PT' : 'EN' }}
                </a>

                {{-- Dark mode toggle --}}
                <button @click="dark = !dark"
                        class="rounded-md p-1.5 hover:bg-gray-100 dark:hover:bg-gray-800"
                        aria-label="Toggle dark mode">
                    <svg x-show="!dark" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg x-show="dark" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>

                {{-- Mobile menu toggle --}}
                <button class="sm:hidden rounded-md p-1.5 hover:bg-gray-100 dark:hover:bg-gray-800"
                        data-hs-collapse="#mobile-menu" aria-controls="mobile-menu" aria-label="Toggle menu">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </nav>

        {{-- Mobile menu --}}
        <div id="mobile-menu" class="hs-collapse hidden overflow-hidden sm:hidden">
            <div class="flex flex-col gap-1 px-4 pb-4 text-sm font-medium">
                <a href="{{ route('home') }}" class="rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('home') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">{{ __('nav.home') }}</a>
                <a href="{{ route('projects.index') }}" class="rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('projects.*') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">{{ __('nav.projects') }}</a>
                <a href="{{ route('skills.index') }}" class="rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('skills.*') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">{{ __('nav.skills') }}</a>
                <a href="{{ route('timeline.index') }}" class="rounded-md px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('timeline.*') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">{{ __('nav.timeline') }}</a>
            </div>
        </div>
    </header>

    {{-- Page content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-200 bg-white py-8 dark:border-gray-800 dark:bg-gray-950">
        <div class="mx-auto max-w-6xl px-4 sm:px-6">
            <div class="flex flex-col items-center justify-between gap-2 text-sm text-gray-500 sm:flex-row dark:text-gray-400">
                <p>&copy; {{ date('Y') }} Rodrigo Dias Sales. {{ __('footer.rights') }}</p>
                <p>{{ __('footer.built_with') }}</p>
            </div>
        </div>
    </footer>

</body>
</html>

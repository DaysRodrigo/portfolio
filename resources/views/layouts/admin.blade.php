<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — Portfolio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

    <nav class="border-b border-gray-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6">
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.projects.index') }}" class="text-sm font-semibold text-indigo-600">
                    Portfolio Admin
                </a>
                <a href="{{ route('admin.projects.index') }}"
                   class="text-sm text-gray-600 hover:text-gray-900 {{ request()->routeIs('admin.projects.*') ? 'font-semibold text-gray-900' : '' }}">
                    Projects
                </a>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('home') }}" target="_blank" class="text-gray-500 hover:text-gray-700">
                    View Site ↗
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-red-600">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6">

        @if(session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </main>

</body>
</html>

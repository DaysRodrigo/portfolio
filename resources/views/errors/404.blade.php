<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Page Not Found</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 antialiased dark:bg-gray-950 dark:text-gray-100"
      style="font-family: 'Inter', sans-serif;">

    <div class="flex min-h-screen flex-col items-center justify-center px-6 text-center">
        <p class="text-sm font-semibold uppercase tracking-widest text-indigo-500">404</p>
        <h1 class="mt-4 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
            Page not found
        </h1>
        <p class="mt-4 text-base text-gray-500 dark:text-gray-400">
            The page you're looking for doesn't exist or has been moved.
        </p>
        <a href="{{ route('home') }}"
           class="mt-8 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
            ← Back to home
        </a>
    </div>

</body>
</html>

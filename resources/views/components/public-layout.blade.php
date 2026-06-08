<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
    x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ArrayType') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-[#f3f2ef] dark:text-gray-100 dark:bg-ai-bg">
    <div class="min-h-screen">
        <header class="glass sticky top-0 z-50 border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto" alt="ArrayType Logo">
                        <span class="font-semibold tracking-tight text-gray-100">ArrayType</span>
                    </a>
                    <nav class="hidden md:flex items-center space-x-6 text-sm text-gray-300">
                        <a href="{{ route('products.index') }}" class="hover:text-white transition">Products</a>
                        <a href="{{ route('products.leaderboard', 'today') }}"
                            class="hover:text-white transition">Leaderboards</a>
                        <a href="{{ route('news.index') }}" class="hover:text-white transition">AI News</a>
                        <a href="{{ route('jobs.index') }}" class="hover:text-white transition">AI Jobs</a>
                    </nav>
                    <div class="flex items-center space-x-3">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="text-sm font-medium text-gray-200 hover:text-white transition">Dashboard</a>
                            <a href="{{ route('products.create') }}"
                                class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-3 py-1.5 rounded-lg text-sm font-medium">Submit
                                Product</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-sm font-medium text-gray-200 hover:text-white transition">Log in</a>
                            <a href="{{ route('register') }}"
                                class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-3 py-1.5 rounded-lg text-sm font-medium">Sign
                                up</a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
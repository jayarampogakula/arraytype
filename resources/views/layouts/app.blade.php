<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
    x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-[#f3f2ef] dark:text-gray-100 dark:bg-ai-bg">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="glass sticky top-0 z-40">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Floating Flash Notifications -->
        <div class="fixed top-20 right-4 z-50 space-y-3 max-w-sm w-full pointer-events-none">
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="pointer-events-auto bg-emerald-50 dark:bg-emerald-950/90 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-lg flex items-center justify-between gap-3 transform transition-all duration-300" role="alert">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-xs font-bold">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" type="button" class="text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-400 focus:outline-none">
                        <svg class="fill-current h-4 w-4" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" /></svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="pointer-events-auto bg-red-50 dark:bg-red-950/90 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 p-4 rounded-xl shadow-lg flex items-center justify-between gap-3 transform transition-all duration-300" role="alert">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-xs font-bold">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" type="button" class="text-red-500 hover:text-red-700 dark:hover:text-red-400 focus:outline-none">
                        <svg class="fill-current h-4 w-4" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" /></svg>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" class="pointer-events-auto bg-red-50 dark:bg-red-950/90 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 p-4 rounded-xl shadow-lg flex items-start justify-between gap-3 transform transition-all duration-300" role="alert">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="text-xs font-bold">
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button @click="show = false" type="button" class="text-red-500 hover:text-red-700 dark:hover:text-red-400 focus:outline-none">
                        <svg class="fill-current h-4 w-4" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" /></svg>
                    </button>
                </div>
            @endif
        </div>

        <!-- Page Content -->
@php
    $showLeft = !($hideLeftSidebar ?? false);
    $showRight = !($hideRightSidebar ?? false);
@endphp

        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            @if($showLeft || $showRight)
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Left Sidebar -->
                    @if($showLeft)
                        <div class="hidden md:block col-span-1">
                            @if (isset($leftSidebar))
                                {{ $leftSidebar }}
                            @else
                                @include('layouts.partials.left-sidebar')
                            @endif
                        </div>
                    @endif

                    <!-- Center Content -->
                    <div class="col-span-1 {{ ($showLeft && $showRight) ? 'md:col-span-2' : 'md:col-span-3' }}">
                        {{ $slot }}
                    </div>

                    <!-- Right Sidebar -->
                    @if($showRight)
                        <div class="hidden md:block col-span-1">
                            @if (isset($rightSidebar))
                                {{ $rightSidebar }}
                            @else
                                @include('layouts.partials.right-sidebar')
                            @endif
                        </div>
                    @endif
                </div>
            @else
                <!-- Full Width Content (No Sidebars) -->
                <div class="w-full">
                    {{ $slot }}
                </div>
            @endif
        </main>
    </div>
</body>

</html>
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

        <!-- Flash Messages -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 z-50 relative space-y-4">
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm flex items-center justify-between" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="block sm:inline font-medium text-sm">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" type="button" class="text-green-500 hover:text-green-700 focus:outline-none">
                        <svg class="fill-current h-5 w-5" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" /></svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-sm flex items-center justify-between" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="block sm:inline font-medium text-sm">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" type="button" class="text-red-500 hover:text-red-700 focus:outline-none">
                        <svg class="fill-current h-5 w-5" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" /></svg>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div x-data="{ show: true }" x-show="show" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-sm flex items-start justify-between" role="alert">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="block sm:inline font-medium text-sm">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button @click="show = false" type="button" class="text-red-500 hover:text-red-700 focus:outline-none ml-4">
                        <svg class="fill-current h-5 w-5" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" /></svg>
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
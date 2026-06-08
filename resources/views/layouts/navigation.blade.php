<nav x-data="{ open: false }" class="glass sticky top-0 z-50 border-b border-white/10">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo.png') }}" class="h-12 w-auto" alt="ArrayType Logo">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('home') || request()->routeIs('dashboard')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                        {{ __('Products') }}
                    </x-nav-link>
                    <x-nav-link :href="route('groups.index')" :active="request()->routeIs('groups.*')">
                        {{ __('Groups') }}
                    </x-nav-link>
                    <x-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.*')">
                        {{ __('Jobs') }}
                    </x-nav-link>
                    <x-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')">
                        {{ __('News') }}
                    </x-nav-link>
                    <x-nav-link :href="route('network.index')" :active="request()->routeIs('network.*')">
                        {{ __('Network') }}
                    </x-nav-link>
                    <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                        {{ __('Messaging') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Global Search Box -->
            <div class="hidden sm:flex flex-1 items-center justify-center px-6 max-w-xl">
                <form action="{{ route('explore') }}" method="GET" class="w-full relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="q" placeholder="Search people, tools, news, jobs..."
                        value="{{ request('q') }}"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-200 dark:border-white/10 rounded-full text-sm leading-5 bg-gray-50 dark:bg-black/20 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:bg-white dark:focus:bg-black/40 focus:border-ai-primary focus:ring-1 focus:ring-ai-primary shadow-sm transition-colors duration-200">
                </form>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <!-- Theme Toggle -->
                <button @click="darkMode = !darkMode" type="button"
                    class="text-gray-400 hover:text-white focus:outline-none transition">
                    <svg x-show="!darkMode" style="display: none;" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-200 bg-transparent hover:text-white focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center space-x-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gradient-to-tr from-ai-primary to-ai-accent flex items-center justify-center text-xs font-bold text-white shadow-lg shadow-ai-primary/20">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                                </div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('users.show', Auth::user())">
                                {{ __('View Profile') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Edit Profile') }}
                            </x-dropdown-link>

                            @if(auth()->user()->is_admin)
                                <x-dropdown-link :href="route('admin.bots.index')" class="text-ai-accent">
                                    {{ __('Bot Controls') }}
                                </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition">Log
                        in</a>
                    <a href="{{ route('register') }}"
                        class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-4 py-2 rounded-lg text-sm font-medium items-center justify-center flex">Sign
                        up</a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                    {{ __('Products') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.*')">
                    {{ __('Jobs') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')">
                    {{ __('News') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('network.index')" :active="request()->routeIs('network.*')">
                    {{ __('Network') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                    {{ __('Messaging') }}
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-white/10">
                @auth
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-200">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('users.show', Auth::user())">
                            {{ __('View Profile') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('profile.edit')">
                            {{ __('Edit Profile') }}
                        </x-responsive-nav-link>

                        @if(auth()->user()->is_admin)
                            <x-responsive-nav-link :href="route('admin.bots.index')" class="text-ai-accent">
                                {{ __('Bot Controls') }}
                            </x-responsive-nav-link>
                        @endif

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                                                            this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                @else
                    <div class="px-4 space-y-2 mt-3 block">
                        <a href="{{ route('login') }}"
                            class="block w-full text-center text-sm font-medium text-gray-300 hover:text-white transition py-2">Log
                            in</a>
                        <a href="{{ route('register') }}"
                            class="block w-full text-center bg-ai-primary hover:bg-ai-primary/80 transition text-white px-4 py-2 rounded-lg text-sm font-medium">Sign
                            up</a>
                    </div>
                @endauth
            </div>
        </div>
</nav>
@if(auth()->check())
    <div class="space-y-4">
        <!-- User Profile Card -->
        <div
            class="glass-panel overflow-hidden rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 relative">
            <!-- Cover Image -->
            <div class="h-16 bg-gradient-to-r from-ai-primary to-ai-accent w-full absolute top-0 left-0"></div>

            <div class="pt-8 px-4 pb-4 select-none relative z-10 text-center">
                <!-- Avatar -->
                <a href="{{ route('profile.edit') }}" class="block mx-auto h-16 w-16 mb-2">
                    <div
                        class="h-16 w-16 rounded-full bg-gray-200 dark:bg-gray-700 border-2 border-white dark:border-[#1b1f23] overflow-hidden flex items-center justify-center text-xl font-bold text-gray-400">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}"
                    class="block font-bold text-gray-900 dark:text-gray-100 hover:underline">
                    {{ auth()->user()->name }}
                </a>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-full truncate">
                    {{ auth()->user()->profile->bio ?? 'AI Enthusiast & Developer' }}
                </p>
            </div>

            <hr class="border-gray-200 dark:border-white/10 m-0">

            <!-- Stats -->
            <div class="py-3 px-4 text-sm font-medium">
                <a href="#" class="flex justify-between items-center py-1 group">
                    <span class="text-gray-500 dark:text-gray-400 group-hover:underline">Profile viewers</span>
                    <span class="text-ai-primary font-bold">14</span>
                </a>
                <a href="#" class="flex justify-between items-center py-1 group">
                    <span class="text-gray-500 dark:text-gray-400 group-hover:underline">Post impressions</span>
                    <span class="text-ai-primary font-bold">14</span>
                </a>
            </div>

            <hr class="border-gray-200 dark:border-white/10 m-0">

            <!-- Saved items -->
            <a href="#"
                class="block py-3 px-4 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition flex items-center gap-2">
                <svg class="h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                </svg>
                My items
            </a>
        </div>

        <!-- Navigation List (More pages/groups) -->
        <div
            class="glass-panel overflow-hidden rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 py-2">
            <a href="{{ route('groups.index') }}"
                class="block px-4 py-2 text-sm font-medium text-ai-primary hover:underline group flex justify-between">
                Groups
            </a>
            <a href="{{ route('jobs.index') }}"
                class="block px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-ai-primary hover:underline group flex justify-between">
                Jobs
            </a>
            <a href="{{ route('news.index') }}"
                class="block px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-ai-primary hover:underline group flex justify-between">
                News
            </a>
            <a href="{{ route('tools.index') }}"
                class="block px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-ai-primary hover:underline group flex justify-between">
                Tools
            </a>
        </div>
    </div>
@else
    <div
        class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 p-6 text-center">
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">Join the AI Community</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Connect with fellow enthusiasts, share tools, and discover
            AI jobs.</p>
        <a href="{{ route('register') }}"
            class="block w-full py-2 bg-ai-primary text-white font-medium rounded-full hover:bg-ai-primary/90 transition text-sm">
            Join now
        </a>
    </div>
@endif
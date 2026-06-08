<x-app-layout>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Explore AI</h1>
    </div>

    <div class="space-y-6">
        <div class="relative">
            <input type="text"
                class="w-full bg-white dark:bg-ai-card border border-gray-300 dark:border-white/10 rounded-xl text-gray-900 dark:text-gray-200 py-3 pl-10 pr-4 focus:ring-ai-primary focus:border-ai-primary"
                placeholder="Search for models, tools, experts, or jobs...">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('products.index') }}"
                class="glass-panel rounded-xl p-6 hover:border-ai-primary/50 transition">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200 mb-2">Launch & Discover</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">View leaderboards of the best new AI products, vote
                    on favorites, and
                    launch your own.</p>
            </a>

            <a href="{{ route('tools.index') }}"
                class="glass-panel rounded-xl p-6 hover:border-ai-accent/50 transition">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200 mb-2">Discover AI API Tools</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Find the latest capabilities in generative AI,
                    coding, video
                    generation, and more.</p>
            </a>

            <a href="{{ route('groups.index') }}"
                class="glass-panel rounded-xl p-6 hover:border-ai-accent/50 transition">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200 mb-2">Join Communities</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Connect with prompt engineers, ML developers, and AI
                    researchers.</p>
            </a>

            <a href="{{ route('jobs.index') }}"
                class="glass-panel rounded-xl p-6 hover:border-ai-primary/50 transition">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200 mb-2">Find AI Jobs</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Discover your next career opportunity in the
                    fast-growing AI sector.
                </p>
            </a>

            <a href="{{ route('news.index') }}" class="glass-panel rounded-xl p-6 hover:border-ai-accent/50 transition">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200 mb-2">Read AI News</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Stay updated with the latest breakthroughs in LLMs
                    and AI technology.
                </p>
            </a>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="leftSidebar">
        <div
            class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 p-4 sticky top-24 space-y-4">
            <div class="space-y-2">
                <a href="#"
                    class="flex items-center gap-3 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 p-2 rounded transition">
                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Preferences
                </a>
                <a href="#"
                    class="flex items-center gap-3 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 p-2 rounded transition">
                    <svg class="h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                    </svg>
                    Job tracker
                </a>
                <a href="#"
                    class="flex items-center gap-3 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 p-2 rounded transition">
                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    My Career Insights
                </a>
            </div>

            <hr class="border-gray-200 dark:border-white/10">

            @auth
                <a href="{{ route('jobs.create') }}"
                    class="flex items-center gap-3 text-sm font-semibold text-ai-primary hover:bg-blue-50 dark:hover:bg-ai-primary/10 p-2 rounded transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Post a job
                </a>
                <a href="#"
                    class="flex items-center gap-3 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 p-2 rounded transition">
                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Manage job posts
                </a>
            @endauth
        </div>
    </x-slot>

    <!-- Main Content -->
    <div
        class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 p-6 mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-1">Top job picks for you</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Based on your profile, preferences, and activity like
            applies, searches, and saves</p>

        <!-- Filters Form -->
        <form method="GET" action="{{ route('jobs.index') }}"
            class="mb-6 pb-6 border-b border-gray-200 dark:border-white/10 border-dashed">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <input type="text" name="location" value="{{ request('location') }}"
                        class="w-full rounded text-sm bg-gray-50 dark:bg-black/20 border-gray-300 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:border-ai-primary focus:ring-ai-primary"
                        placeholder="Search by location..." />
                </div>
                <div>
                    <select name="type"
                        class="w-full rounded text-sm bg-gray-50 dark:bg-black/20 border-gray-300 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:border-ai-primary focus:ring-ai-primary">
                        <option value="">All Job Types</option>
                        @foreach(['Full-time', 'Part-time', 'Contract', 'Freelance', 'Remote'] as $type)
                            <option value="{{ $type }}" @selected(request('type') === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-3">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                        <input type="checkbox" name="remote" value="1" {{ request('remote') ? 'checked' : '' }}
                            class="rounded border-gray-300 dark:border-white/10 bg-gray-50 dark:bg-black/20 text-ai-primary focus:ring-ai-primary" />
                        Remote only
                    </label>
                    <button type="submit"
                        class="ml-auto bg-gray-100 hover:bg-gray-200 dark:bg-white/10 dark:hover:bg-white/20 transition text-gray-900 dark:text-white px-3 py-1.5 rounded text-sm font-semibold">
                        Filter
                    </button>
                </div>
            </div>
        </form>

        <!-- Job Listings -->
        <div class="space-y-0">
            @forelse($jobs as $job)
                <div class="relative py-4 border-b border-gray-200 dark:border-white/5 last:border-0 group">
                    <button
                        class="absolute top-4 right-2 p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 bg-transparent hover:bg-gray-100 dark:hover:bg-white/10 rounded-full transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <a href="{{ route('jobs.show', $job) }}" class="flex items-start gap-4 pr-10">
                        <div
                            class="h-14 w-14 rounded bg-white flex-shrink-0 flex items-center justify-center border border-gray-200 overflow-hidden">
                            @if($job->company && $job->company->logo)
                                <img src="{{ $job->company->logo }}" alt="{{ $job->company->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <span
                                    class="text-gray-900 font-bold text-xl">{{ substr($job->company->name ?? '?', 0, 1) }}</span>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-ai-primary group-hover:underline">{{ $job->title }}</h3>
                            <div class="text-sm text-gray-900 dark:text-gray-100 mt-0.5">
                                {{ $job->company?->name ?? 'Unknown Company' }} &bull;
                                {{ $job->remote ? 'Remote' : ($job->location ?? 'Location TBD') }}</div>
                            <div class="flex items-center gap-2 mt-1">
                                <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Actively reviewing applicants</span>
                            </div>
                            <div class="text-xs text-gray-400 mt-1 flex items-center gap-2">
                                Promoted
                                <span class="flex items-center text-blue-600 dark:text-blue-400 font-semibold gap-1">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 448 512">
                                        <path
                                            d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z" />
                                    </svg>
                                    Easy Apply
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="py-8 text-center text-sm text-gray-500">
                    No matching AI jobs right now. Try adjusting your preferences.
                </div>
            @endforelse
        </div>

        @if(count($jobs) > 0)
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-white/10 text-center">
                <a href="#"
                    class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-ai-primary hover:underline">Show
                    all &rarr;</a>
            </div>
        @endif
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="leftSidebar">
        <div x-data="{ activeTab: 'all' }" x-on:switch-tab.window="activeTab = $event.detail"
            class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 p-4 sticky top-24 space-y-4">
            <div class="space-y-2">
                <!-- Job Board -->
                <a href="#" @click.prevent="$dispatch('switch-tab', 'all')"
                    :class="activeTab === 'all' ? 'text-ai-primary bg-blue-50 dark:bg-ai-primary/10' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5'"
                    class="flex items-center gap-3 text-sm font-semibold p-2 rounded transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Job Board
                </a>
                
                <!-- Preferences -->
                <a href="#" @click.prevent="$dispatch('switch-tab', 'preferences')"
                    :class="activeTab === 'preferences' ? 'text-ai-primary bg-blue-50 dark:bg-ai-primary/10' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5'"
                    class="flex items-center gap-3 text-sm font-semibold p-2 rounded transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Preferences
                </a>
                
                <!-- Job Tracker -->
                <a href="#" @click.prevent="$dispatch('switch-tab', 'tracker')"
                    :class="activeTab === 'tracker' ? 'text-ai-primary bg-blue-50 dark:bg-ai-primary/10' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5'"
                    class="flex items-center gap-3 text-sm font-semibold p-2 rounded transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Job tracker
                </a>
                
                <!-- Career Insights -->
                <a href="#" @click.prevent="$dispatch('switch-tab', 'insights')"
                    :class="activeTab === 'insights' ? 'text-ai-primary bg-blue-50 dark:bg-ai-primary/10' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5'"
                    class="flex items-center gap-3 text-sm font-semibold p-2 rounded transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                <a href="#" @click.prevent="$dispatch('switch-tab', 'manage')"
                    :class="activeTab === 'manage' ? 'text-ai-primary bg-blue-50 dark:bg-ai-primary/10' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5'"
                    class="flex items-center gap-3 text-sm font-semibold p-2 rounded transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Manage job posts
                </a>
            @endauth
        </div>
    </x-slot>

    <!-- Main Content -->
    <div x-data="{ 
        activeTab: 'all', 
        selectedJobId: {{ $jobs->first() ? $jobs->first()->id : 'null' }},
        applyJobId: null,
        applyJobTitle: '',
        applyCoverLetter: ''
    }" 
    x-on:switch-tab.window="activeTab = $event.detail; if ($event.detail === 'all') { selectedJobId = {{ $jobs->first() ? $jobs->first()->id : 'null' }} }"
    class="space-y-6">
        
        <!-- ==================== JOB BOARD TAB ==================== -->
        <div x-show="activeTab === 'all'" class="space-y-6">
            
            <!-- Search and Filter Panel -->
            <div class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] border border-gray-200 dark:border-white/10 p-5 shadow-sm">
                <form method="GET" action="{{ route('jobs.index') }}" class="space-y-4">
                    @if(request('role'))
                        <input type="hidden" name="role" value="{{ request('role') }}">
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                        <!-- Keyword Search -->
                        <div class="md:col-span-3 relative flex items-center">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full h-12 pl-10 pr-4 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:border-ai-primary focus:ring-ai-primary placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none"
                                placeholder="Search keywords..." />
                        </div>
                        
                        <!-- Location -->
                        <div class="md:col-span-3 relative flex items-center">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <input type="text" name="location" value="{{ request('location') }}"
                                class="w-full h-12 pl-10 pr-4 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:border-ai-primary focus:ring-ai-primary placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none"
                                placeholder="Location or remote..." />
                        </div>
                        
                        <!-- Job Type -->
                        <div class="md:col-span-2">
                            <select name="type"
                                class="w-full h-12 px-3 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:border-ai-primary focus:ring-ai-primary focus:outline-none">
                                <option value="">All Job Types</option>
                                @foreach(['Full-time', 'Part-time', 'Contract', 'Freelance', 'Remote'] as $type)
                                    <option value="{{ $type }}" @selected(request('type') === $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Date Posted -->
                        <div class="md:col-span-2">
                            <select name="date_posted"
                                class="w-full h-12 px-3 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:border-ai-primary focus:ring-ai-primary focus:outline-none">
                                <option value="">Date Posted</option>
                                <option value="24h" @selected(request('date_posted') === '24h')>Past 24 hours</option>
                                <option value="week" @selected(request('date_posted') === 'week')>Past week</option>
                                <option value="month" @selected(request('date_posted') === 'month')>Past month</option>
                            </select>
                        </div>
                        
                        <!-- Search Button -->
                        <div class="md:col-span-2">
                            <button type="submit"
                                class="w-full h-12 bg-ai-primary hover:bg-ai-primary/90 transition text-white rounded-xl text-sm font-semibold shadow-sm shadow-blue-500/10 flex items-center justify-center gap-1.5">
                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Search
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between pt-2">
                        <label class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer">
                            <input type="checkbox" name="remote" value="1" {{ request('remote') ? 'checked' : '' }}
                                class="rounded border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-black/20 text-ai-primary focus:ring-ai-primary" />
                            Remote positions only
                        </label>
                        @if(request()->anyFilled(['search', 'location', 'type', 'remote', 'role', 'date_posted']))
                            <a href="{{ route('jobs.index') }}" class="text-xs font-semibold text-gray-500 hover:text-ai-primary transition">Clear filters</a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Role Tabs / Quick Filters -->
            <div class="flex flex-wrap gap-2 pb-2">
                <a href="{{ route('jobs.index', array_merge(request()->except('role'), ['role' => null])) }}" 
                    class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ !$activeRole ? 'bg-ai-primary text-white shadow shadow-blue-500/10' : 'bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                    All Jobs
                </a>
                <a href="{{ route('jobs.index', array_merge(request()->except(['role', 'page']), ['role' => 'ai-engineer'])) }}" 
                    class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ $activeRole === 'ai-engineer' ? 'bg-ai-primary text-white shadow shadow-blue-500/10' : 'bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                    AI Engineer
                </a>
                <a href="{{ route('jobs.index', array_merge(request()->except(['role', 'page']), ['role' => 'ml-engineer'])) }}" 
                    class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ $activeRole === 'ml-engineer' ? 'bg-ai-primary text-white shadow shadow-blue-500/10' : 'bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                    ML Engineer
                </a>
                <a href="{{ route('jobs.index', array_merge(request()->except(['role', 'page']), ['role' => 'prompt-engineer'])) }}" 
                    class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ $activeRole === 'prompt-engineer' ? 'bg-ai-primary text-white shadow shadow-blue-500/10' : 'bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                    Prompt Engineer
                </a>
                <a href="{{ route('jobs.index', array_merge(request()->except(['role', 'page']), ['role' => 'data-engineer'])) }}" 
                    class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ $activeRole === 'data-engineer' ? 'bg-ai-primary text-white shadow shadow-blue-500/10' : 'bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                    Data Engineer
                </a>
            </div>

            <!-- Unified background wrapper card around split pane -->
            <div class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] border border-gray-200 dark:border-white/10 p-5 shadow-sm">
                <!-- Split-Pane Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    
                    <!-- Left Pane: Job Listings (5/12 columns) -->
                    <div class="lg:col-span-5 space-y-3 max-h-[750px] overflow-y-auto no-scrollbar pr-1">
                        @forelse($jobs as $job)
                            <div @click="if (window.innerWidth >= 1024) { selectedJobId = {{ $job->id }} } else { window.location.href = '{{ route('jobs.show', $job) }}' }"
                                :class="selectedJobId === {{ $job->id }} ? 'border-ai-primary bg-ai-primary/5 dark:bg-ai-primary/5' : '{{ $job->featured_until && $job->featured_until->isFuture() ? 'border-indigo-500/30 bg-indigo-500/5 hover:border-indigo-500/50' : 'border-gray-200 dark:border-white/5 hover:border-gray-300 dark:hover:border-white/10 bg-gray-50/50 dark:bg-black/10' }}'"
                                class="p-4 rounded-xl border cursor-pointer transition relative group shadow-sm flex items-start gap-4">
                                
                                @if($job->featured_until && $job->featured_until->isFuture())
                                    <div class="absolute top-0 right-0 bg-indigo-600 text-white text-[9px] font-black px-2.5 py-0.5 rounded-tr-lg rounded-bl-lg uppercase tracking-wide">
                                        ★ Promoted
                                    </div>
                                @endif
                                
                                <div class="h-12 w-12 rounded-lg bg-white dark:bg-black/15 flex-shrink-0 flex items-center justify-center border border-gray-150 dark:border-white/10 overflow-hidden shadow-inner">
                                    @if($job->company && $job->company->logo)
                                        <img src="{{ $job->company->logo }}" alt="{{ $job->company->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 font-bold text-lg">{{ substr($job->company->name ?? '?', 0, 1) }}</span>
                                    @endif
                                </div>
                                
                                <div class="flex-grow min-w-0">
                                    <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 group-hover:text-ai-primary transition truncate">{{ $job->title }}</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mt-0.5">{{ $job->company?->name ?? 'Unknown Company' }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 flex items-center gap-1">
                                        <span>{{ $job->remote ? 'Remote' : ($job->location ?? 'Location TBD') }}</span>
                                        <span>&bull;</span>
                                        <span>{{ $job->type }}</span>
                                    </p>
                                    @if($job->salary_range)
                                        <p class="text-xs font-bold text-green-600 dark:text-green-400 mt-1">{{ $job->salary_range }}</p>
                                    @endif
                                    <div class="flex items-center gap-2 mt-2 flex-wrap">
                                        <span class="inline-flex items-center gap-1 text-[10px] bg-green-500/10 text-green-500 font-bold px-1.5 py-0.5 rounded">
                                            <span class="h-1.5 w-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            Active
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500 text-sm bg-gray-55/10 rounded-xl border border-dashed border-gray-200 dark:border-white/10">
                                No AI jobs match your filters.
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- Right Pane: Selected Job Details (7/12 columns) -->
                    <div class="lg:col-span-7 bg-gray-50/50 dark:bg-black/15 border border-gray-200/60 dark:border-white/5 rounded-xl p-6 sticky top-24 max-h-[750px] overflow-y-auto no-scrollbar shadow-sm">
                        @forelse($jobs as $index => $job)
                            <div x-show="selectedJobId === {{ $job->id }}" class="space-y-6">
                                
                                <!-- Header Details -->
                                <div class="flex items-start justify-between gap-4 border-b border-gray-100 dark:border-white/5 pb-5">
                                    <div class="flex items-start gap-4">
                                        <div class="h-16 w-16 rounded-xl bg-white dark:bg-black/20 flex-shrink-0 flex items-center justify-center border border-gray-200 dark:border-white/10 overflow-hidden shadow-sm">
                                            @if($job->company && $job->company->logo)
                                                <img src="{{ $job->company->logo }}" alt="{{ $job->company->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500 font-bold text-2xl">{{ substr($job->company->name ?? '?', 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div class="space-y-1">
                                            <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">{{ $job->title }}</h2>
                                            <p class="text-sm font-semibold text-ai-primary">
                                                @if($job->company?->website)
                                                    <a href="{{ $job->company->website }}" target="_blank" class="hover:underline flex items-center gap-1">
                                                        {{ $job->company->name }}
                                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                                    </a>
                                                @else
                                                    {{ $job->company?->name ?? 'Unknown Company' }}
                                                @endif
                                            </p>
                                            <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-gray-500 dark:text-gray-400 font-medium pt-1">
                                                <span>{{ $job->remote ? 'Remote' : ($job->location ?? 'Location TBD') }}</span>
                                                <span>&bull;</span>
                                                <span>{{ $job->type }}</span>
                                                @if($job->salary_range)
                                                    <span>&bull;</span>
                                                    <span class="font-bold text-green-600 dark:text-green-400">{{ $job->salary_range }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-wrap items-center gap-3">
                                    @if($job->apply_url)
                                        <a href="{{ $job->apply_url }}" target="_blank"
                                            class="flex-grow sm:flex-grow-0 bg-gray-800 hover:bg-gray-900 text-white dark:bg-white/15 dark:hover:bg-white/25 font-semibold text-sm px-6 py-2.5 rounded-xl transition text-center shadow-sm">
                                            Apply Externally
                                        </a>
                                    @endif

                                    @auth
                                        @if(in_array($job->id, $myApplications))
                                            <button disabled class="flex-grow sm:flex-grow-0 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-bold text-sm px-6 py-2.5 rounded-xl flex items-center justify-center gap-1.5">
                                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Applied on ArrayType
                                            </button>
                                        @else
                                            <button @click="applyJobId = {{ $job->id }}; applyJobTitle = '{{ addslashes($job->title) }}'; applyCoverLetter = ''" 
                                                class="flex-grow sm:flex-grow-0 bg-ai-primary hover:bg-ai-primary/95 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition text-center shadow-sm shadow-blue-500/10">
                                                Quick Apply with Profile
                                            </button>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" 
                                            class="flex-grow sm:flex-grow-0 bg-ai-primary hover:bg-ai-primary/95 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition text-center shadow-sm">
                                            Login to Apply
                                        </a>
                                    @endauth

                                    <button @click="
                                        var savedJobs = JSON.parse(localStorage.getItem('saved_jobs') || '[]');
                                        if (!savedJobs.some(j => j.id === {{ $job->id }})) {
                                            savedJobs.push({
                                                id: {{ $job->id }},
                                                title: '{{ addslashes($job->title) }}',
                                                company: '{{ addslashes($job->company?->name ?? 'Unknown Company') }}',
                                                location: '{{ addslashes($job->remote ? 'Remote' : ($job->location ?? 'Location TBD')) }}',
                                                salary: '{{ addslashes($job->salary_range ?? '') }}',
                                                date: 'Just now'
                                            });
                                            localStorage.setItem('saved_jobs', JSON.stringify(savedJobs));
                                            $dispatch('tracker-updated');
                                            alert('Job saved to your tracker!');
                                        } else {
                                            alert('Job is already saved!');
                                        }
                                    " class="bg-gray-150/50 dark:bg-white/5 hover:bg-gray-200 dark:hover:bg-white/10 text-gray-700 dark:text-gray-300 font-semibold text-sm px-4 py-2.5 rounded-xl transition">
                                        Save Job
                                    </button>
                                </div>

                                <!-- Job Description -->
                                <div class="space-y-4 pt-4 border-t border-gray-100 dark:border-white/5">
                                    <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wider">Job Description</h3>
                                    <div class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-wrap select-text">
                                        {!! nl2br(e($job->description)) !!}
                                    </div>
                                </div>

                                <!-- Additional Details -->
                                <div class="bg-gray-50/50 dark:bg-white/5 rounded-xl p-4 text-xs text-gray-500 space-y-2 border border-gray-150 dark:border-white/5">
                                    <p>Posted: {{ $job->created_at->diffForHumans() }}</p>
                                    <p>Actively hiring: Yes (Applicants are being actively reviewed by the creator)</p>
                                    @if($job->featured_until && $job->featured_until->isFuture())
                                        <p class="text-[10px] text-indigo-400 uppercase tracking-wider font-extrabold flex items-center gap-1">
                                            <span>★</span> promoted job listing
                                        </p>
                                    @endif
                                </div>

                            </div>
                        @empty
                            <div class="h-48 flex items-center justify-center text-gray-500 text-sm">
                                Select a job to view its details.
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>

        <!-- ==================== PREFERENCES TAB ==================== -->
        <div x-show="activeTab === 'preferences'" class="space-y-6" style="display: none;" 
            x-data="{ 
                roles: [], 
                jobType: '', 
                location: '', 
                minSalary: 120000, 
                alerts: true, 
                showSuccess: false,
                
                init() {
                    var pref = JSON.parse(localStorage.getItem('user_job_preferences') || '{}');
                    this.roles = pref.roles || [];
                    this.jobType = pref.jobType || '';
                    this.location = pref.location || '';
                    this.minSalary = pref.minSalary || 120000;
                    this.alerts = pref.alerts !== undefined ? pref.alerts : true;
                },
                save() {
                    localStorage.setItem('user_job_preferences', JSON.stringify({
                        roles: this.roles,
                        jobType: this.jobType,
                        location: this.location,
                        minSalary: this.minSalary,
                        alerts: this.alerts
                    }));
                    this.showSuccess = true;
                    setTimeout(() => this.showSuccess = false, 3000);
                }
            }">
            
            <div class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] border border-gray-200 dark:border-white/10 p-6 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-white/5 pb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Job Preferences</h2>
                        <p class="text-xs text-gray-500">Configure your career interests to find the perfect match.</p>
                    </div>
                    <button @click="$dispatch('switch-tab', 'all')" class="text-xs font-semibold text-ai-primary hover:underline flex items-center gap-1">
                        ← Back to Job Board
                    </button>
                </div>
                
                <div x-show="showSuccess" class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl text-sm font-semibold flex items-center gap-2">
                    <span>✨</span> Preferences saved successfully!
                </div>

                <!-- Role preference -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Preferred Roles</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['AI Engineer', 'ML Engineer', 'Prompt Engineer', 'Data Engineer', 'NLP Specialist', 'Computer Vision Specialist'] as $roleName)
                            <button type="button" 
                                @click="if(roles.includes('{{ $roleName }}')) { roles = roles.filter(r => r !== '{{ $roleName }}') } else { roles.push('{{ $roleName }}') }"
                                :class="roles.includes('{{ $roleName }}') ? 'bg-ai-primary text-white border-ai-primary' : 'bg-gray-50 dark:bg-white/5 text-gray-600 dark:text-gray-400 border-gray-200 dark:border-white/10'"
                                class="px-4 py-2 rounded-full text-xs font-bold border transition hover:opacity-90">
                                {{ $roleName }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Job Type -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Preferred Job Type</label>
                        <select x-model="jobType" class="w-full h-11 px-3 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:ring-ai-primary focus:border-ai-primary">
                            <option value="">Any Job Type</option>
                            <option value="Full-time">Full-time</option>
                            <option value="Part-time">Part-time</option>
                            <option value="Contract">Contract</option>
                            <option value="Freelance">Freelance</option>
                            <option value="Remote">Remote</option>
                        </select>
                    </div>
                    <!-- Preferred Location -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Preferred Location</label>
                        <input type="text" x-model="location" placeholder="e.g. San Francisco, Remote, London" class="w-full h-11 px-4 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:ring-ai-primary focus:border-ai-primary" />
                    </div>
                </div>

                <!-- Minimum Salary Slider -->
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm font-bold">
                        <span class="text-gray-700 dark:text-gray-300">Minimum Annual Salary</span>
                        <span class="text-ai-primary" x-text="'$' + (minSalary / 1000) + 'k' + '+'"></span>
                    </div>
                    <input type="range" min="50000" max="300000" step="5000" x-model="minSalary" class="w-full accent-ai-primary h-2 bg-gray-200 dark:bg-white/10 rounded-lg cursor-pointer" />
                    <div class="flex justify-between text-[10px] text-gray-400">
                        <span>$50k</span>
                        <span>$175k</span>
                        <span>$300k</span>
                    </div>
                </div>

                <!-- Alerts Toggle -->
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-150 dark:border-white/5">
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100">AI Match Alerts</h4>
                        <p class="text-xs text-gray-500">Receive weekly emails when new jobs match your preferences.</p>
                    </div>
                    <button type="button" @click="alerts = !alerts" :class="alerts ? 'bg-ai-primary' : 'bg-gray-300 dark:bg-white/10'" class="w-11 h-6 rounded-full p-0.5 transition duration-200 focus:outline-none relative">
                        <span :class="alerts ? 'translate-x-5' : 'translate-x-0'" class="block w-5 h-5 rounded-full bg-white shadow transform transition duration-200"></span>
                    </button>
                </div>

                <!-- Action Button -->
                <div class="pt-4 border-t border-gray-100 dark:border-white/5">
                    <button @click="save()" class="bg-ai-primary hover:bg-ai-primary/95 text-white font-bold py-3 px-6 rounded-xl text-sm transition shadow-md shadow-blue-500/10">
                        Save Preferences
                    </button>
                </div>
            </div>
        </div>

        <!-- ==================== JOB TRACKER TAB ==================== -->
        <div x-show="activeTab === 'tracker'" class="space-y-6" style="display: none;"
            x-data="{ 
                savedJobs: [], 
                appliedJobs: [], 
                showAddModal: false,
                
                newJob: { title: '', company: '', salary: '', status: 'applied', location: '' },
                
                init() {
                    this.load();
                },
                load() {
                    this.savedJobs = JSON.parse(localStorage.getItem('saved_jobs') || '[]');
                    this.appliedJobs = JSON.parse(localStorage.getItem('applied_jobs') || '[]');
                    
                    // Add dummy items if clean
                    if (this.savedJobs.length === 0 && this.appliedJobs.length === 0) {
                        this.savedJobs = [
                            { id: 9991, title: 'AI Prompt Engineer', company: 'Anthropic', location: 'Remote', salary: '$180,000 - $240,000', date: '2 days ago' }
                        ];
                        this.appliedJobs = [
                            { id: 9992, title: 'Machine Learning Researcher', company: 'OpenAI', location: 'San Francisco, CA', salary: '$220,000', status: 'interviewing', date: '5 days ago' }
                        ];
                        this.persist();
                    }
                },
                persist() {
                    localStorage.setItem('saved_jobs', JSON.stringify(this.savedJobs));
                    localStorage.setItem('applied_jobs', JSON.stringify(this.appliedJobs));
                },
                removeSaved(id) {
                    this.savedJobs = this.savedJobs.filter(j => j.id !== id);
                    this.persist();
                },
                removeApplied(id) {
                    this.appliedJobs = this.appliedJobs.filter(j => j.id !== id);
                    this.persist();
                },
                updateStatus(id, status) {
                    this.appliedJobs = this.appliedJobs.map(j => {
                        if (j.id === id) j.status = status;
                        return j;
                    });
                    this.persist();
                },
                applyFromSaved(job) {
                    this.removeSaved(job.id);
                    this.appliedJobs.push({
                        id: job.id,
                        title: job.title,
                        company: job.company,
                        location: job.location,
                        salary: job.salary,
                        status: 'applied',
                        date: 'Just now'
                    });
                    this.persist();
                },
                addNewJob() {
                    if (!this.newJob.title || !this.newJob.company) return;
                    var list = this.newJob.status === 'saved' ? this.savedJobs : this.appliedJobs;
                    list.push({
                        id: Date.now(),
                        title: this.newJob.title,
                        company: this.newJob.company,
                        location: this.newJob.location,
                        salary: this.newJob.salary,
                        status: this.newJob.status,
                        date: 'Added manually'
                    });
                    this.persist();
                    this.newJob = { title: '', company: '', salary: '', status: 'applied', location: '' };
                    this.showAddModal = false;
                }
            }"
            x-on:tracker-updated.window="load()">

            <div class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] border border-gray-200 dark:border-white/10 p-6 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-white/5 pb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">My Job Tracker</h2>
                        <p class="text-xs text-gray-500">Monitor your job search progress, follow-ups, and interviews.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button @click="showAddModal = true" class="bg-ai-primary hover:bg-ai-primary/95 text-white font-bold py-2 px-4 rounded-xl text-xs transition flex items-center gap-1.5 shadow-sm shadow-blue-500/10">
                            <span>+</span> Add Custom Job
                        </button>
                        <button @click="$dispatch('switch-tab', 'all')" class="text-xs font-semibold text-ai-primary hover:underline">
                            ← Back to Board
                        </button>
                    </div>
                </div>

                <!-- Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Saved Jobs -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-extrabold text-gray-850 dark:text-gray-200 uppercase tracking-wider flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                            Saved Listings (<span x-text="savedJobs.length"></span>)
                        </h3>
                        
                        <div class="space-y-3">
                            <template x-for="job in savedJobs" :key="job.id">
                                <div class="p-4 bg-gray-50/50 dark:bg-black/10 rounded-xl border border-gray-150 dark:border-white/5 flex justify-between items-start">
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-gray-100 text-sm" x-text="job.title"></h4>
                                        <p class="text-xs text-gray-500 font-semibold" x-text="job.company"></p>
                                        <p class="text-[11px] text-gray-400 mt-1 flex items-center gap-2">
                                            <span x-text="job.location"></span>
                                            <span x-show="job.salary">&bull;</span>
                                            <span x-text="job.salary" class="text-green-500 font-bold"></span>
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button @click="applyFromSaved(job)" class="bg-ai-primary/10 hover:bg-ai-primary/20 text-ai-primary font-bold text-[10px] px-2.5 py-1.5 rounded transition">
                                            Track Apply
                                        </button>
                                        <button @click="removeSaved(job.id)" class="text-gray-400 hover:text-red-500 p-1.5 transition">
                                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <div x-show="savedJobs.length === 0" class="text-center py-8 text-xs text-gray-500 bg-gray-50/30 dark:bg-white/5 rounded-xl border border-dashed border-gray-200 dark:border-white/10">
                                No saved jobs yet. Click "Save Job" on any posting to track it here.
                            </div>
                        </div>
                    </div>

                    <!-- Applied Jobs -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-extrabold text-gray-855 dark:text-gray-200 uppercase tracking-wider flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            Active Applications (<span x-text="appliedJobs.length"></span>)
                        </h3>
                        
                        <div class="space-y-3">
                            <template x-for="job in appliedJobs" :key="job.id">
                                <div class="p-4 bg-gray-50/50 dark:bg-black/10 rounded-xl border border-gray-150 dark:border-white/5 space-y-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-bold text-gray-900 dark:text-gray-100 text-sm" x-text="job.title"></h4>
                                            <p class="text-xs text-gray-500 font-semibold" x-text="job.company"></p>
                                        </div>
                                        <button @click="removeApplied(job.id)" class="text-gray-400 hover:text-red-500 p-1.5 transition">
                                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                    
                                    <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-white/5">
                                        <span class="text-[10px] text-gray-400" x-text="job.date"></span>
                                        
                                        <div class="flex items-center gap-2">
                                            <label class="text-[10px] text-gray-400 font-bold uppercase">Status:</label>
                                            <select :value="job.status" @change="updateStatus(job.id, $event.target.value)" 
                                                class="text-xs bg-white dark:bg-[#1b1f23] border border-gray-200 dark:border-white/10 rounded px-2 py-0.5 text-gray-700 dark:text-gray-300 focus:outline-none">
                                                <option value="applied">Applied</option>
                                                <option value="screening">Screening</option>
                                                <option value="interviewing">Interviewing</option>
                                                <option value="offer">Offer Received</option>
                                                <option value="rejected">Rejected</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div x-show="appliedJobs.length === 0" class="text-center py-8 text-xs text-gray-500 bg-gray-50/30 dark:bg-white/5 rounded-xl border border-dashed border-gray-200 dark:border-white/10">
                                No active job applications tracked yet.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Custom Job Drawer Popup -->
            <div class="fixed inset-0 overflow-hidden z-50" style="display: none;" x-show="showAddModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showAddModal = false"></div>
                <div class="absolute inset-y-0 right-0 max-w-full flex">
                    <div class="w-screen max-w-md bg-white dark:bg-[#1b1f23] p-6 shadow-2xl relative flex flex-col space-y-6">
                        <div class="flex justify-between items-center border-b border-gray-100 dark:border-white/5 pb-4">
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Add Custom Job Tracker Entry</h3>
                            <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">✕</button>
                        </div>
                        
                        <div class="space-y-4 flex-grow">
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Job Title *</label>
                                <input type="text" x-model="newJob.title" placeholder="e.g. Lead NLP Engineer" class="w-full h-11 px-3.5 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-ai-primary" />
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Company *</label>
                                <input type="text" x-model="newJob.company" placeholder="e.g. Meta" class="w-full h-11 px-3.5 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-ai-primary" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Location</label>
                                    <input type="text" x-model="newJob.location" placeholder="e.g. Remote" class="w-full h-11 px-3.5 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-ai-primary" />
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Salary Range</label>
                                    <input type="text" x-model="newJob.salary" placeholder="e.g. $150k - $200k" class="w-full h-11 px-3.5 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-ai-primary" />
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Initial Status</label>
                                <select x-model="newJob.status" class="w-full h-11 px-3 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-ai-primary">
                                    <option value="saved">Saved (No apply yet)</option>
                                    <option value="applied">Applied</option>
                                    <option value="interviewing">Interviewing</option>
                                </select>
                            </div>
                        </div>
                        
                        <button @click="addNewJob()" class="w-full h-12 bg-ai-primary hover:bg-ai-primary/95 text-white font-bold rounded-xl text-sm shadow-sm transition">
                            Add to Tracker
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== CAREER INSIGHTS TAB ==================== -->
        <div x-show="activeTab === 'insights'" class="space-y-6" style="display: none;">
            <div class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] border border-gray-200 dark:border-white/10 p-6 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-white/5 pb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">AI Career Insights</h2>
                        <p class="text-xs text-gray-500">Real-time statistics and analysis of the Artificial Intelligence job market.</p>
                    </div>
                    <button @click="$dispatch('switch-tab', 'all')" class="text-xs font-semibold text-ai-primary hover:underline">
                        ← Back to Job Board
                    </button>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-5 bg-gradient-to-tr from-blue-500/5 to-indigo-500/5 dark:from-blue-500/10 dark:to-indigo-500/10 rounded-2xl border border-blue-500/10 dark:border-indigo-500/10 space-y-2">
                        <span class="text-[10px] uppercase font-bold text-indigo-400 tracking-wider">Market Demand</span>
                        <h3 class="text-3xl font-black text-gray-900 dark:text-gray-100">+42.8%</h3>
                        <p class="text-xs text-gray-500">Year-on-year increase in active AI job postings.</p>
                    </div>
                    <div class="p-5 bg-gradient-to-tr from-purple-500/5 to-pink-500/5 dark:from-purple-500/10 dark:to-pink-500/10 rounded-2xl border border-purple-500/10 dark:border-pink-500/10 space-y-2">
                        <span class="text-[10px] uppercase font-bold text-purple-400 tracking-wider">Median AI Salary</span>
                        <h3 class="text-3xl font-black text-gray-900 dark:text-gray-100">$168,500</h3>
                        <p class="text-xs text-gray-500">Average starting salary package for mid-level engineers.</p>
                    </div>
                    <div class="p-5 bg-gradient-to-tr from-emerald-500/5 to-teal-500/5 dark:from-emerald-500/10 dark:to-emerald-500/10 rounded-2xl border border-emerald-500/10 dark:border-teal-500/10 space-y-2">
                        <span class="text-[10px] uppercase font-bold text-emerald-400 tracking-wider">Remote Adoption</span>
                        <h3 class="text-3xl font-black text-gray-900 dark:text-gray-100">67.5%</h3>
                        <p class="text-xs text-gray-500">Of job openings support fully-remote or hybrid setups.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Salary Ranges -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-extrabold text-gray-800 dark:text-gray-200 uppercase tracking-wider">Salary Ranges by Specialization</h3>
                        <div class="space-y-4">
                            <div class="space-y-1">
                                <div class="flex justify-between text-xs font-semibold">
                                    <span class="text-gray-700 dark:text-gray-300">ML Research Scientist</span>
                                    <span class="text-gray-500">$180k - $270k</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <div class="flex justify-between text-xs font-semibold">
                                    <span class="text-gray-700 dark:text-gray-300">AI / NLP Engineer</span>
                                    <span class="text-gray-500">$150k - $220k</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full" style="width: 72%"></div>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <div class="flex justify-between text-xs font-semibold">
                                    <span class="text-gray-700 dark:text-gray-300">Prompt / LLM Engineer</span>
                                    <span class="text-gray-500">$120k - $180k</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full" style="width: 58%"></div>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <div class="flex justify-between text-xs font-semibold">
                                    <span class="text-gray-700 dark:text-gray-300">AI Data Infrastructure</span>
                                    <span class="text-gray-500">$140k - $210k</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full" style="width: 68%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Skills heatmap -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-extrabold text-gray-800 dark:text-gray-200 uppercase tracking-wider">Top Skills in High Demand</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-3 bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-150 dark:border-white/5 flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300">Python / PyTorch</span>
                                <span class="text-xs font-black text-indigo-400">92%</span>
                            </div>
                            <div class="p-3 bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-150 dark:border-white/5 flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300">LLM Fine-Tuning</span>
                                <span class="text-xs font-black text-indigo-400">76%</span>
                            </div>
                            <div class="p-3 bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-150 dark:border-white/5 flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300">LangChain / RAG</span>
                                <span class="text-xs font-black text-indigo-400">68%</span>
                            </div>
                            <div class="p-3 bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-150 dark:border-white/5 flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300">Vector Databases</span>
                                <span class="text-xs font-black text-indigo-400">54%</span>
                            </div>
                            <div class="p-3 bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-150 dark:border-white/5 flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300">FastAPI / Docker</span>
                                <span class="text-xs font-black text-indigo-400">45%</span>
                            </div>
                            <div class="p-3 bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-150 dark:border-white/5 flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300">AWS / Kubernetes</span>
                                <span class="text-xs font-black text-indigo-400">38%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== MANAGE JOB POSTS TAB ==================== -->
        <div x-show="activeTab === 'manage'" class="space-y-6" style="display: none;"
            x-data="{ activeAccordion: null }">
            <div class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] border border-gray-200 dark:border-white/10 p-6 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-white/5 pb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Manage Job Posts & Applicants</h2>
                        <p class="text-xs text-gray-500">Track candidates who applied for your listed jobs and view their qualifications.</p>
                    </div>
                    <button @click="$dispatch('switch-tab', 'all')" class="text-xs font-semibold text-ai-primary hover:underline">
                        ← Back to Job Board
                    </button>
                </div>

                <div class="space-y-4">
                    @forelse($myJobs as $myJob)
                        <div class="border border-gray-200 dark:border-white/5 rounded-2xl overflow-hidden bg-gray-50/20 dark:bg-black/5">
                            <!-- Accordion Header -->
                            <div @click="activeAccordion = activeAccordion === {{ $myJob->id }} ? null : {{ $myJob->id }}"
                                class="p-4 flex items-center justify-between cursor-pointer hover:bg-gray-50 dark:hover:bg-white/5 transition">
                                <div class="space-y-1">
                                    <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm flex items-center gap-2">
                                        {{ $myJob->title }}
                                        <span class="text-[10px] bg-indigo-500/10 text-indigo-400 font-bold px-2 py-0.5 rounded-full uppercase">
                                            {{ $myJob->applications->count() }} Applications
                                        </span>
                                    </h3>
                                    <p class="text-xs text-gray-500">
                                        {{ $myJob->type }} &bull; {{ $myJob->remote ? 'Remote' : ($myJob->location ?? 'Location TBD') }}
                                        @if($myJob->featured_until && $myJob->featured_until->isFuture())
                                            &bull; <span class="text-indigo-400 font-bold">★ Promoted until {{ $myJob->featured_until->format('M d, Y') }}</span>
                                        @endif
                                    </p>
                                </div>
                                <svg class="h-5 w-5 text-gray-400 transform transition-transform duration-200" 
                                    :class="activeAccordion === {{ $myJob->id }} ? 'rotate-180' : ''"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>

                            <!-- Accordion Content -->
                            <div x-show="activeAccordion === {{ $myJob->id }}" class="p-4 border-t border-gray-150 dark:border-white/5 bg-white dark:bg-[#1b1f23]/60 space-y-4">
                                <h4 class="text-xs font-extrabold text-gray-800 dark:text-gray-300 uppercase tracking-wider">Candidate Profiles</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @forelse($myJob->applications as $app)
                                        <div class="p-4 bg-gray-50 dark:bg-[#1b1f23] rounded-xl border border-gray-200 dark:border-white/10 space-y-3 relative group shadow-sm flex flex-col justify-between">
                                            <div class="space-y-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="h-10 w-10 rounded-full bg-ai-primary/10 dark:bg-white/5 flex-shrink-0 flex items-center justify-center border border-gray-150 dark:border-white/10 overflow-hidden">
                                                        @if($app->applicant->profile && $app->applicant->profile->avatar)
                                                            <img src="{{ $app->applicant->profile->avatar }}" alt="{{ $app->applicant->name }}" class="w-full h-full object-cover">
                                                        @else
                                                            <span class="text-ai-primary dark:text-white font-bold text-sm">{{ substr($app->applicant->name, 0, 2) }}</span>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h5 class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $app->applicant->name }}</h5>
                                                        <p class="text-[11px] text-gray-500">{{ $app->applicant->email }}</p>
                                                    </div>
                                                </div>

                                                @if($app->applicant->profile && $app->applicant->profile->bio)
                                                    <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-3 select-text leading-relaxed">{{ $app->applicant->profile->bio }}</p>
                                                @else
                                                    <p class="text-xs text-gray-400 italic">No biography provided.</p>
                                                @endif

                                                @if($app->applicant->profile && $app->applicant->profile->skills)
                                                    <div class="flex flex-wrap gap-1 pt-1">
                                                        @foreach(explode(',', $app->applicant->profile->skills) as $skill)
                                                            <span class="text-[9px] bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-400 font-bold px-1.5 py-0.5 rounded border border-gray-200/50 dark:border-white/5">
                                                                {{ trim($skill) }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @if($app->cover_letter)
                                                    <div class="p-2.5 bg-gray-50 dark:bg-black/15 rounded-lg border border-gray-150 dark:border-white/5 text-[11px] text-gray-600 dark:text-gray-400 whitespace-pre-wrap select-text">
                                                        <strong class="block text-gray-800 dark:text-gray-300 mb-0.5 uppercase tracking-wider text-[8px]">Applicant's Note:</strong>
                                                        "{!! nl2br(e($app->cover_letter)) !!}"
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="flex items-center justify-between pt-3 border-t border-gray-150 dark:border-white/5 mt-3">
                                                <div class="flex items-center gap-2">
                                                    @if($app->applicant->profile && $app->applicant->profile->github_url)
                                                        <a href="{{ $app->applicant->profile->github_url }}" target="_blank" class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition">
                                                            <svg class="h-4.5 w-4.5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.17 6.839 9.49.5.092.682-.217.682-.48 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.464-1.11-1.464-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.577.688.479C19.138 20.167 22 16.418 22 12c0-5.523-4.477-10-10-10z" clip-rule="evenodd"/></svg>
                                                        </a>
                                                    @endif
                                                    @if($app->applicant->profile && $app->applicant->profile->linkedin_url)
                                                        <a href="{{ $app->applicant->profile->linkedin_url }}" target="_blank" class="text-gray-400 hover:text-[#0077b5] transition">
                                                            <svg class="h-4.5 w-4.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                                        </a>
                                                    @endif
                                                </div>
                                                
                                                <a href="{{ route('messages.index') }}?chat_with={{ $app->applicant->id }}" 
                                                    class="flex items-center gap-1.5 text-xs text-ai-primary hover:underline font-bold">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                                    Message Applicant
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-span-2 text-center py-6 text-xs text-gray-500 bg-gray-50/20 dark:bg-black/10 rounded-xl">
                                            No applications received for this job yet.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-sm text-gray-500 bg-white dark:bg-[#1b1f23] rounded-xl border border-dashed border-gray-200 dark:border-white/10">
                            You have not posted any jobs yet. Click "Post a Job" in the sidebar to create one.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ==================== QUICK APPLY MODAL POPUP ==================== -->
        <div class="fixed inset-0 overflow-hidden z-50" style="display: none;" x-show="applyJobId !== null" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="applyJobId = null"></div>

            <div class="absolute inset-y-0 right-0 max-w-full flex">
                <!-- Modal Panel -->
                <div class="w-screen max-w-md bg-white dark:bg-[#1b1f23] p-6 shadow-2xl relative flex flex-col justify-between" x-show="applyJobId !== null" x-transition:enter="transform transition ease-in-out duration-300 sm:duration-400" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300 sm:duration-400" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                    
                    <div class="space-y-6 flex-grow overflow-y-auto pr-1">
                        <!-- Header -->
                        <div class="flex justify-between items-start border-b border-gray-150 dark:border-white/5 pb-4">
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Quick Apply</h3>
                                <p class="text-xs text-gray-500 mt-1" x-text="'Applying for: ' + applyJobTitle"></p>
                            </div>
                            <button @click="applyJobId = null" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">✕</button>
                        </div>
                        
                        <!-- Confirmation -->
                        <div class="p-4 bg-indigo-500/5 border border-indigo-500/10 rounded-xl space-y-2">
                            <span class="text-xs font-bold text-indigo-400 uppercase tracking-wider block">Shared Profile Details</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-normal">
                                Applying shares your ArrayType public profile, including your **Name**, **Email**, **Bio**, **Skills**, and social links (GitHub/LinkedIn) with the employer. Make sure your profile is updated!
                            </p>
                        </div>

                        <!-- Form -->
                        <form :action="'/jobs/' + applyJobId + '/apply'" method="POST" id="quick-apply-form" class="space-y-4">
                            @csrf
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Message to Employer (Optional)</label>
                                <textarea name="cover_letter" x-model="applyCoverLetter" rows="6" maxlength="2000"
                                    class="w-full p-3.5 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-ai-primary focus:ring-0 placeholder-gray-400 dark:placeholder-gray-600"
                                    placeholder="Introduce yourself, mention key qualifications, or link to your resume/portfolio..."></textarea>
                                <div class="text-[10px] text-gray-400 text-right">
                                    <span x-text="applyCoverLetter.length"></span>/2000 characters
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Footer -->
                    <div class="pt-4 border-t border-gray-150 dark:border-white/5">
                        <button type="button" @click="document.getElementById('quick-apply-form').submit()" 
                            class="w-full h-12 bg-ai-primary hover:bg-ai-primary/95 text-white font-bold rounded-xl text-sm transition shadow-md shadow-blue-500/10 flex items-center justify-center gap-1.5">
                            <span>🚀</span> Submit Application
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
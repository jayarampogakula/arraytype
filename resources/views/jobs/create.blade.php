<x-app-layout>
    <x-slot name="leftSidebar">
        <div x-data="{ activeTab: 'create' }"
            class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 p-4 sticky top-24 space-y-4">
            <div class="space-y-2">
                <!-- Job Board Link -->
                <a href="{{ route('jobs.index') }}"
                    class="flex items-center gap-3 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 p-2 rounded transition">
                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Job Board
                </a>
                
                <!-- Preferences Link -->
                <a href="{{ route('jobs.index') }}#preferences"
                    class="flex items-center gap-3 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 p-2 rounded transition">
                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Preferences
                </a>
                
                <!-- Job Tracker Link -->
                <a href="{{ route('jobs.index') }}#tracker"
                    class="flex items-center gap-3 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 p-2 rounded transition">
                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Job tracker
                </a>
                
                <!-- Career Insights Link -->
                <a href="{{ route('jobs.index') }}#insights"
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
                <!-- Active Post a job Link -->
                <a href="{{ route('jobs.create') }}"
                    class="flex items-center gap-3 text-sm font-semibold text-ai-primary bg-blue-50 dark:bg-ai-primary/10 p-2 rounded transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Post a job
                </a>
                <a href="{{ route('jobs.index') }}#manage"
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

    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Post an AI Job</h1>
        <p class="text-gray-650 dark:text-gray-400 mt-1 text-sm">Share an AI-related job opportunity with the community.</p>
    </div>

    <!-- Form Panel Wrapper -->
    <div class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] border border-gray-200 dark:border-white/10 p-6 shadow-sm">
        <form action="{{ route('jobs.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Section: Company -->
                <div class="space-y-4">
                    <h3 class="text-xs font-bold text-gray-550 dark:text-gray-400 uppercase tracking-wider pb-2 border-b border-gray-100 dark:border-white/5">Company Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Company Name <span class="text-red-500">*</span></label>
                            <input type="text" name="company_name" value="{{ old('company_name') }}" required
                                class="w-full h-11 px-4 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:ring-ai-primary focus:border-ai-primary focus:outline-none placeholder-gray-400 dark:placeholder-gray-600"
                                placeholder="e.g. OpenAI, Anthropic, Google DeepMind">
                            @error('company_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Company Website <span class="text-gray-400 text-xs font-medium">(optional)</span></label>
                            <input type="url" name="company_website" value="{{ old('company_website') }}"
                                class="w-full h-11 px-4 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:ring-ai-primary focus:border-ai-primary focus:outline-none placeholder-gray-400 dark:placeholder-gray-600"
                                placeholder="https://company.com">
                        </div>
                    </div>
                </div>

                <!-- Section: Job Details -->
                <div class="space-y-4">
                    <h3 class="text-xs font-bold text-gray-550 dark:text-gray-400 uppercase tracking-wider pb-2 border-b border-gray-100 dark:border-white/5">Job Details</h3>
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Job Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                class="w-full h-11 px-4 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:ring-ai-primary focus:border-ai-primary focus:outline-none placeholder-gray-400 dark:placeholder-gray-600"
                                placeholder="e.g. Senior ML Engineer, Prompt Engineer...">
                            @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Location</label>
                                <input type="text" name="location" value="{{ old('location') }}"
                                    class="w-full h-11 px-4 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:ring-ai-primary focus:border-ai-primary focus:outline-none placeholder-gray-400 dark:placeholder-gray-600"
                                    placeholder="Remote, San Francisco, London...">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Job Type <span class="text-red-500">*</span></label>
                                <select name="type" required style="color-scheme: dark;"
                                    class="w-full h-11 px-3 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:ring-ai-primary focus:border-ai-primary focus:outline-none">
                                    @foreach(['Full-time', 'Part-time', 'Contract', 'Freelance', 'Remote'] as $type)
                                        <option value="{{ $type }}" style="background-color: #1b1f23; color: white;" {{ old('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer select-none">
                                <input type="checkbox" name="remote" value="1"
                                    class="rounded border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-black/20 text-ai-primary focus:ring-ai-primary" />
                                Remote role
                            </label>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Apply / Job Link <span class="text-gray-400 text-xs font-medium">(optional)</span></label>
                            <input type="url" name="apply_url" value="{{ old('apply_url') }}"
                                class="w-full h-11 px-4 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:ring-ai-primary focus:border-ai-primary focus:outline-none placeholder-gray-400 dark:placeholder-gray-600"
                                placeholder="https://...">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Salary Range <span class="text-gray-400 text-xs font-medium">(optional)</span></label>
                            <input type="text" name="salary_range" value="{{ old('salary_range') }}"
                                class="w-full h-11 px-4 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:ring-ai-primary focus:border-ai-primary focus:outline-none placeholder-gray-400 dark:placeholder-gray-600"
                                placeholder="e.g. $120k - $160k">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Job Description <span class="text-red-500">*</span></label>
                            <textarea name="description" rows="6" required
                                class="w-full p-3.5 rounded-xl text-sm bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:ring-ai-primary focus:border-ai-primary focus:outline-none placeholder-gray-400 dark:placeholder-gray-600"
                                placeholder="Describe the role, responsibilities, requirements, and benefits...">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-white/5">
                    <button type="submit"
                        class="bg-ai-primary hover:bg-ai-primary/95 text-white font-bold h-11 px-6 rounded-xl text-sm transition shadow-sm shadow-blue-500/10 flex items-center justify-center">
                        Post Job
                    </button>
                    <a href="{{ route('jobs.index') }}"
                        class="bg-gray-150/50 dark:bg-white/5 hover:bg-gray-200 dark:hover:bg-white/10 text-gray-700 dark:text-gray-300 font-semibold h-11 px-6 rounded-xl text-sm transition flex items-center justify-center">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

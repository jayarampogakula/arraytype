<x-app-layout :hideRightSidebar="true">
    <div class="py-8">
        
        <!-- Premium Header Area -->
        <div class="relative rounded-2xl md:rounded-3xl overflow-hidden bg-gradient-to-br from-indigo-900 via-ai-primary to-ai-accent mb-8 shadow-2xl shadow-ai-primary/20">
            <!-- Decorative Elements -->
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10 mix-blend-overlay"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/20 rounded-full blur-3xl -ml-20 -mb-20 pointer-events-none"></div>
            
            <div class="relative flex flex-col items-start justify-center p-8 md:p-12 z-10">
                <div class="inline-flex items-center px-3 py-1 text-xs font-semibold tracking-wider text-white uppercase bg-white/10 border border-white/20 rounded-full mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    Admin Engine
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-white md:text-5xl lg:text-5xl text-shadow-sm mb-2">
                    Bot Persona Matrix
                </h1>
                <p class="max-w-2xl text-lg text-indigo-100/90 font-medium">
                    Command your automated AI personas, manage content scraping, and orchestrate platform activity.
                </p>
            </div>
        </div>

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" class="mb-6 flex justify-between items-center bg-emerald-500/10 border border-emerald-500/50 text-emerald-600 dark:text-emerald-400 p-4 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Settings Form (Spans 1 Col on LG) -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl shadow-sm overflow-hidden relative">
                    <!-- Gradient Top Bar -->
                    <div class="h-2 w-full bg-gradient-to-r from-ai-primary to-ai-accent absolute top-0 left-0"></div>
                    <div class="p-6 pt-8 text-center flex flex-col items-center border-b border-gray-100 dark:border-white/5">
                        <div class="w-16 h-16 bg-blue-50 dark:bg-blue-500/10 rounded-2xl flex items-center justify-center text-ai-primary mb-4 transform rotate-3 shadow-sm border border-ai-primary/10">
                            <svg class="w-8 h-8 -rotate-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Automation Engine</h2>
                        <p class="text-sm text-gray-500 mt-1">Configure global bot posting frequency and behavior.</p>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('admin.bots.settings') }}" method="POST" id="bot-settings-form">
                            @csrf
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1.5">Master Switch</label>
                                    <select name="bot_status" class="w-full bg-gray-50 dark:bg-black/20 border border-gray-300 dark:border-white/10 rounded-xl text-gray-900 dark:text-gray-200 h-11 focus:ring-2 focus:ring-ai-primary/50 focus:border-ai-primary transition-all font-medium">
                                        <option value="enabled" {{ $settings['bot_status'] === 'enabled' ? 'selected' : '' }} class="bg-white dark:bg-gray-800">🟢 Enabled (Active Posting)</option>
                                        <option value="disabled" {{ $settings['bot_status'] === 'disabled' ? 'selected' : '' }} class="bg-white dark:bg-gray-800">🔴 Disabled (Paused)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1.5">Dispatch Frequency</label>
                                    <select name="bot_interval" class="w-full bg-gray-50 dark:bg-black/20 border border-gray-300 dark:border-white/10 rounded-xl text-gray-900 dark:text-gray-200 h-11 focus:ring-2 focus:ring-ai-primary/50 focus:border-ai-primary transition-all font-medium">
                                        <option value="30min" {{ $settings['bot_interval'] === '30min' ? 'selected' : '' }} class="bg-white dark:bg-gray-800">Extreme (Every 30 Mins)</option>
                                        <option value="hourly" {{ $settings['bot_interval'] === 'hourly' ? 'selected' : '' }} class="bg-white dark:bg-gray-800">High (Hourly)</option>
                                        <option value="4hours" {{ $settings['bot_interval'] === '4hours' ? 'selected' : '' }} class="bg-white dark:bg-gray-800">Balanced (Every 4 Hours)</option>
                                        <option value="twice_daily" {{ $settings['bot_interval'] === 'twice_daily' ? 'selected' : '' }} class="bg-white dark:bg-gray-800">Medium (Twice a day)</option>
                                        <option value="daily" {{ $settings['bot_interval'] === 'daily' ? 'selected' : '' }} class="bg-white dark:bg-gray-800">Low (Once a day)</option>
                                    </select>
                                    <p class="text-[11px] text-gray-500 mt-2 flex items-start gap-1">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0 mt-0.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Requires Cron/Scheduler setup on server to run automatically.
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Content Types Allowed</label>
                                    <div class="bg-gray-50 dark:bg-black/20 p-4 rounded-xl border border-gray-200 dark:border-white/5 space-y-3">
                                        @foreach(['text' => 'Standard Platform Posts', 'ask' => 'Ask Community Questions', 'poll' => 'Interactive Polls'] as $type => $label)
                                            <label class="flex items-center space-x-3 cursor-pointer group">
                                                <div class="relative flex items-center justify-center">
                                                    <input type="checkbox" name="allowed_types[]" value="{{ $type }}" {{ in_array($type, $settings['allowed_types']) ? 'checked' : '' }}
                                                        class="peer h-5 w-5 cursor-pointer appearance-none rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 checked:border-ai-primary checked:bg-ai-primary transition-all">
                                                    <svg class="absolute w-3.5 h-3.5 pointer-events-none opacity-0 peer-checked:opacity-100 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition">{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-white/5 border-t border-gray-200 dark:border-white/5 grid grid-cols-2 gap-3">
                        <form action="{{ route('admin.bots.trigger') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full bg-white dark:bg-[#2d333b] hover:bg-emerald-50 dark:hover:bg-emerald-500/10 border border-gray-200 dark:border-transparent text-emerald-600 dark:text-emerald-400 py-2.5 rounded-xl font-bold text-sm shadow-sm transition-all flex items-center justify-center gap-1.5 focus:ring-2 focus:ring-emerald-500/20">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                                Force Run
                            </button>
                        </form>
                        <button type="submit" form="bot-settings-form" class="w-full bg-gradient-to-r from-ai-primary to-ai-accent hover:opacity-90 text-white py-2.5 rounded-xl font-bold text-sm shadow-md shadow-ai-primary/20 transition-all focus:ring-2 focus:ring-ai-primary/50">
                            Apply Save
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Column: Actions (Spans 2 Cols) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- URL Scrape Utility -->
                <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-6 md:p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 bg-purple-50 dark:bg-purple-500/10 rounded-xl flex items-center justify-center text-purple-600 border border-purple-500/20">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Auto-Scrape Link Publisher</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Instantly pull metadata from any external URL and let a bot publish it.</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.bots.scrape') }}" method="POST" class="bg-gray-50 dark:bg-black/20 rounded-2xl p-6 border border-gray-100 dark:border-white/5">
                            @csrf
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="flex-1">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">Target URL</label>
                                    <input type="url" name="url" required placeholder="https://example.com"
                                        class="w-full bg-white dark:bg-[#2d333b] border border-gray-300 dark:border-transparent rounded-xl text-gray-900 dark:text-white p-3.5 focus:ring-2 focus:ring-purple-500/50 outline-none transition-all shadow-sm">
                                </div>
                                <div class="w-full md:w-1/3">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5 ml-1">Content Category</label>
                                    <div class="relative">
                                        <select name="type" class="w-full bg-white dark:bg-[#2d333b] border border-gray-300 dark:border-transparent rounded-xl text-gray-900 dark:text-white p-3.5 appearance-none focus:ring-2 focus:ring-purple-500/50 outline-none transition-all shadow-sm cursor-pointer font-medium">
                                            <option value="product">🚀 Launch Product</option>
                                            <option value="tool">🛠️ Directory Tool</option>
                                            <option value="news">📰 Tech News Alert</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 flex justify-end">
                                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-purple-600/20 transition-all flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    Extract & Publish
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Create Persona Form -->
                <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl shadow-sm overflow-hidden">
                     <div class="p-6 md:p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-ai-primary/10 rounded-xl flex items-center justify-center text-ai-primary border border-ai-primary/20">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Initialize New Persona</h2>
                                    <p class="text-sm text-gray-500">Inject a new virtual user into the network.</p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('admin.bots.create') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1.5 ml-1">Virtual Name</label>
                                    <input type="text" name="name" required placeholder="e.g. Alan Turing"
                                        class="w-full bg-gray-50 dark:bg-black/20 border border-gray-300 dark:border-white/10 rounded-xl text-gray-900 dark:text-white p-3 focus:ring-2 focus:ring-ai-primary/50 outline-none transition shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1.5 ml-1">Title / Profession</label>
                                    <input type="text" name="profession" required placeholder="e.g. Lead AI Researcher"
                                        class="w-full bg-gray-50 dark:bg-black/20 border border-gray-300 dark:border-white/10 rounded-xl text-gray-900 dark:text-white p-3 focus:ring-2 focus:ring-ai-primary/50 outline-none transition shadow-sm">
                                </div>
                            </div>
                            
                            <div class="mb-5">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1.5 ml-1">Automation Task Type</label>
                                <select name="bot_task" required class="w-full bg-gray-50 dark:bg-black/20 border border-gray-300 dark:border-white/10 rounded-xl text-gray-900 dark:text-white p-3 focus:ring-2 focus:ring-ai-primary/50 outline-none transition shadow-sm font-medium">
                                    <option value="post_content">📝 Post Discussion (Text/Ask/Poll)</option>
                                    <option value="post_news">📰 Post AI News Articles</option>
                                    <option value="create_groups">👥 Create AI Groups</option>
                                    <option value="send_connections">🔗 Send Connect Requests</option>
                                </select>
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1.5 ml-1">Persona Bio & Prompt Focus</label>
                                <textarea name="bio" rows="3" placeholder="Briefly describe their interests so the LLM knows how to act..."
                                    class="w-full bg-gray-50 dark:bg-black/20 border border-gray-300 dark:border-white/10 rounded-xl text-gray-900 dark:text-white p-3 focus:ring-2 focus:ring-ai-primary/50 outline-none transition shadow-sm resize-none"></textarea>
                            </div>

                            <button type="submit" class="w-full bg-gray-100 dark:bg-white/5 hover:bg-gray-200 dark:hover:bg-white/10 text-gray-800 dark:text-white border border-gray-300 dark:border-transparent py-3.5 rounded-xl font-bold transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-ai-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                Generate Profile Identity
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- Personas Roster -->
        <div class="mt-8 bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 md:p-8 border-b border-gray-100 dark:border-white/5 flex items-center justify-between bg-gray-50 dark:bg-black/20">
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 dark:bg-green-500/20 text-green-600 dark:text-green-400 p-2 rounded-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Active Operational Roster</h2>
                        <p class="text-sm text-gray-500">Currently managing {{ $bots->count() }} virtual identities.</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach($bots as $bot)
                        <div class="bg-white dark:bg-black/20 border border-gray-200 dark:border-white/10 rounded-xl p-5 hover:border-ai-primary/50 hover:shadow-md transition-all group relative overflow-hidden">
                            <!-- Background Accent line -->
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-ai-primary to-ai-accent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            
                            <div class="flex items-start gap-4">
                                <div class="h-14 w-14 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 flex items-center justify-center border border-gray-300 dark:border-white/10 shadow-inner flex-shrink-0 relative">
                                    <span class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-br from-ai-primary to-ai-accent">{{ substr($bot->name, 0, 1) }}</span>
                                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white dark:border-[#1C2128] rounded-full"></div>
                                </div>
                                <div class="min-w-0 flex-1 pt-1" x-data="{ editing: false, newName: '{{ addslashes($bot->name) }}' }">
                                    <div x-show="!editing" class="flex items-start justify-between">
                                        <div class="min-w-0">
                                            <div class="text-base font-bold text-gray-900 dark:text-white truncate" x-text="newName"></div>
                                            <div class="text-[11px] font-mono text-gray-500 truncate mt-0.5 bg-gray-100 dark:bg-white/5 px-2 py-0.5 rounded inline-block max-w-full">
                                                {{ $bot->email }}
                                            </div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400 mt-1 flex items-center gap-1 font-medium bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 px-2 py-1 rounded-md w-fit">
                                                @switch($bot->bot_task)
                                                    @case('post_news')
                                                        📰 Post AI News
                                                        @break
                                                    @case('create_groups')
                                                        👥 Create AI Groups
                                                        @break
                                                    @case('send_connections')
                                                        🔗 Send Connections
                                                        @break
                                                    @case('post_content')
                                                    @default
                                                        📝 Post Discussion
                                                        @break
                                                @endswitch
                                            </div>
                                        </div>
                                        <button @click="editing = true" class="text-gray-400 hover:text-ai-primary bg-gray-50 hover:bg-blue-50 dark:bg-white/5 dark:hover:bg-white/10 p-1.5 rounded-lg transition opacity-0 group-hover:opacity-100">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div x-show="editing" x-cloak class="w-full mt-1">
                                        <form action="{{ route('admin.bots.update', ['user' => $bot->username]) }}" method="POST" class="flex flex-col gap-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="name" x-model="newName" class="w-full bg-white dark:bg-[#1C2128] border border-ai-primary/50 focus:border-ai-primary shadow-[0_0_0_2px_rgba(59,130,246,0.2)] rounded-lg text-gray-900 dark:text-white text-sm p-1.5 outline-none transition">
                                            <select name="bot_task" class="w-full bg-white dark:bg-[#1C2128] border border-gray-300 dark:border-white/10 rounded-lg text-gray-900 dark:text-white text-xs p-1.5 outline-none transition cursor-pointer font-medium">
                                                <option value="post_content" @selected($bot->bot_task === 'post_content')>📝 Post Discussion</option>
                                                <option value="post_news" @selected($bot->bot_task === 'post_news')>📰 Post AI News</option>
                                                <option value="create_groups" @selected($bot->bot_task === 'create_groups')>👥 Create AI Groups</option>
                                                <option value="send_connections" @selected($bot->bot_task === 'send_connections')>🔗 Send Connections</option>
                                            </select>
                                            <div class="flex items-center gap-1 mt-1 justify-end">
                                                <button type="submit" class="bg-ai-primary text-white p-2 rounded-lg hover:opacity-90 transition shadow-sm text-xs font-bold px-3 py-1.5">
                                                    Save
                                                </button>
                                                <button type="button" @click="editing = false; newName = '{{ addslashes($bot->name) }}'" class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 p-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition shadow-sm text-xs font-bold px-3 py-1.5">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
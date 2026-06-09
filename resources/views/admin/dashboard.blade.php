<x-app-layout :hideRightSidebar="true">
    <div class="py-8">
        
        <!-- Premium Header Area -->
        <div class="relative rounded-2xl md:rounded-3xl overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-indigo-900 mb-8 shadow-2xl shadow-indigo-950/30">
            <!-- Decorative Elements -->
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10 mix-blend-overlay"></div>
            <div class="absolute top-0 right-0 w-80 h-80 bg-ai-accent/10 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-ai-primary/10 rounded-full blur-3xl -ml-20 -mb-20 pointer-events-none"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-center justify-between p-8 md:p-12 z-10 gap-6">
                <div>
                    <div class="inline-flex items-center px-3 py-1 text-xs font-semibold tracking-wider text-white uppercase bg-white/10 border border-white/20 rounded-full mb-4">
                        <span class="flex h-2 w-2 relative mr-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        Admin Command Center
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white md:text-5xl text-shadow-sm mb-2">
                        System Overview
                    </h1>
                    <p class="max-w-xl text-lg text-indigo-100/90 font-medium">
                        Real-time analytics, user growth metrics, system activity, and bot automation controls.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.bots.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl font-bold text-sm transition-all shadow-lg shadow-indigo-600/30 hover:scale-[1.02] active:scale-[0.98] flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        Bot Persona Manager
                    </a>
                    <form action="{{ route('admin.bots.trigger') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 rounded-xl font-bold text-sm transition-all shadow-lg shadow-emerald-600/30 hover:scale-[1.02] active:scale-[0.98] flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Force Bot Activity
                        </button>
                    </form>
                </div>
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

        <!-- Premium Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            
            <!-- Users & Active Users -->
            <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-sm relative overflow-hidden group hover:border-ai-primary/50 transition-all duration-300">
                <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-500/5 rounded-full -mr-6 -mt-6 pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center border border-indigo-500/10">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User Base</p>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-0.5">{{ $totalUsers }}</h3>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-white/5 flex items-center justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Active (30d)</span>
                    <span class="font-bold text-emerald-500 flex items-center gap-1">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        {{ $activeUsers }}
                    </span>
                </div>
            </div>

            <!-- Products Metrics -->
            <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-sm relative overflow-hidden group hover:border-ai-accent/50 transition-all duration-300">
                <div class="absolute top-0 right-0 w-24 h-24 bg-ai-accent/5 rounded-full -mr-6 -mt-6 pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-cyan-50 dark:bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 rounded-xl flex items-center justify-center border border-cyan-500/10">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Products Listed</p>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-0.5">{{ $totalProducts }}</h3>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-white/5 flex gap-4 text-xs font-semibold">
                    <span class="text-emerald-500">Approved: {{ $approvedProducts }}</span>
                    @if($pendingProducts > 0)
                        <a href="{{ route('admin.products.pending') }}" class="text-amber-500 hover:underline flex items-center gap-1">
                            Pending: {{ $pendingProducts }}
                            <span class="inline-flex items-center justify-center px-1.5 py-0.5 rounded-full text-[10px] bg-amber-500/10 text-amber-500">Action</span>
                        </a>
                    @else
                        <span class="text-gray-500 dark:text-gray-400">Pending: 0</span>
                    @endif
                </div>
            </div>

            <!-- Jobs Metric -->
            <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-sm relative overflow-hidden group hover:border-purple-500/50 transition-all duration-300">
                <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-full -mr-6 -mt-6 pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 rounded-xl flex items-center justify-center border border-purple-500/10">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jobs Posted</p>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-0.5">{{ $totalJobs }}</h3>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-white/5 flex items-center justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Total Tech Roles</span>
                    <span class="font-bold text-purple-500">{{ $totalJobs }} Opportunities</span>
                </div>
            </div>

            <!-- News Metric -->
            <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-sm relative overflow-hidden group hover:border-emerald-500/50 transition-all duration-300">
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/5 rounded-full -mr-6 -mt-6 pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center border border-emerald-500/10">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1M19 20a2 2 0 002-2V8a2 2 0 00-2-2h-5m2 9L9 11m0 0l-2 2m2-2v6" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">News Articles</p>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-0.5">{{ $totalNews }}</h3>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-white/5 flex items-center justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Total Publications</span>
                    <a href="{{ route('admin.news.pending') }}" class="text-emerald-500 hover:underline font-bold">Review Desk</a>
                </div>
            </div>

        </div>

        <!-- Social Infrastructure Analytics Card Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            
            <!-- Posts Metric -->
            <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-amber-50 dark:bg-amber-500/10 text-amber-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $totalPosts }}</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Discussions & Polls</p>
                    </div>
                </div>
                <span class="text-xs text-gray-400 font-semibold bg-gray-50 dark:bg-white/5 px-2.5 py-1 rounded-md border border-gray-100 dark:border-white/5">Feeds</span>
            </div>

            <!-- Messages Metric -->
            <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-rose-50 dark:bg-rose-500/10 text-rose-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $totalMessages }}</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Messages Exchanged</p>
                    </div>
                </div>
                <span class="text-xs text-gray-400 font-semibold bg-gray-50 dark:bg-white/5 px-2.5 py-1 rounded-md border border-gray-100 dark:border-white/5">Conversations</span>
            </div>

            <!-- Connections Metric -->
            <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-sky-50 dark:bg-sky-500/10 text-sky-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $totalConnections }}</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Friend Connections</p>
                    </div>
                </div>
                <span class="text-xs text-gray-400 font-semibold bg-gray-50 dark:bg-white/5 px-2.5 py-1 rounded-md border border-gray-100 dark:border-white/5">Networks</span>
            </div>

        </div>

        <!-- Details Grid: Lists of Recent Additions -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            <!-- Recent Products listed (Spans 2 Cols) -->
            <div class="xl:col-span-2 space-y-8">
                <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-white/5 flex items-center justify-between bg-gray-50 dark:bg-black/20">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-cyan-400"></span>
                            Recent Products Submitted
                        </h2>
                        @if($pendingProducts > 0)
                            <a href="{{ route('admin.products.pending') }}" class="text-xs font-semibold text-amber-500 bg-amber-500/10 px-3 py-1 rounded-full border border-amber-500/20 hover:bg-amber-500/20 transition">
                                Needs Action ({{ $pendingProducts }})
                            </a>
                        @endif
                    </div>
                    
                    <div class="divide-y divide-gray-100 dark:divide-white/5 overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[600px]">
                            <thead>
                                <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-wider bg-gray-50/50 dark:bg-black/10 border-b border-gray-100 dark:border-white/5">
                                    <th class="py-3.5 px-6">Product</th>
                                    <th class="py-3.5 px-6">Creator</th>
                                    <th class="py-3.5 px-6">Website</th>
                                    <th class="py-3.5 px-6">Status</th>
                                    <th class="py-3.5 px-6 text-right">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                                @forelse($recentProducts as $product)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5 transition duration-150">
                                        <td class="py-4 px-6">
                                            <div class="font-bold text-gray-900 dark:text-white">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1 mt-0.5">{{ $product->tagline }}</div>
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-600 dark:text-gray-300">
                                            {{ $product->creator->name ?? 'Deleted User' }}
                                        </td>
                                        <td class="py-4 px-6 text-sm">
                                            <a href="{{ $product->website_url }}" target="_blank" class="text-ai-primary hover:underline font-semibold flex items-center gap-1">
                                                Link
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="py-4 px-6">
                                            @if($product->status === 'approved')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">Approved</span>
                                            @elseif($product->status === 'rejected')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-500/10 text-red-600 dark:text-red-400">Rejected</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-600 dark:text-amber-400">Pending</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-right text-xs font-medium text-gray-400">
                                            {{ $product->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">No products posted yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent News (Moderation desk list style) -->
                <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-white/5 flex items-center justify-between bg-gray-50 dark:bg-black/20">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                            Recent Tech News Published
                        </h2>
                        <a href="{{ route('admin.news.pending') }}" class="text-xs font-semibold text-gray-500 dark:text-gray-400 hover:text-ai-primary transition flex items-center gap-1">
                            Pending articles
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-white/5">
                        @forelse($recentNews as $news)
                            <div class="p-5 hover:bg-gray-50/50 dark:hover:bg-white/5 transition duration-150 flex items-start gap-4">
                                <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1M19 20a2 2 0 002-2V8a2 2 0 00-2-2h-5" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2">
                                        <h4 class="font-bold text-gray-900 dark:text-white truncate text-sm">{{ $news->title }}</h4>
                                        <span class="text-[10px] text-gray-400 flex-shrink-0 font-medium">{{ $news->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-1">{{ $news->summary }}</p>
                                    <div class="mt-2 flex items-center gap-3 text-[11px] text-gray-400 font-medium">
                                        <span>Author: <span class="text-gray-600 dark:text-gray-300">{{ $news->author->name ?? 'Unknown' }}</span></span>
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-white/10"></span>
                                        <span class="text-indigo-500">{{ $news->category }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-sm text-gray-500 dark:text-gray-400">No news articles published.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Registrations (Spans 1 Col) -->
            <div class="xl:col-span-1 space-y-8">
                <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-black/20">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-400"></span>
                            Recent Active Users
                        </h2>
                    </div>
                    <div class="p-6 divide-y divide-gray-100 dark:divide-white/5 space-y-4">
                        @forelse($recentUsers as $user)
                            <div class="flex items-center justify-between pt-4 first:pt-0">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-ai-primary to-ai-accent flex items-center justify-center text-xs font-bold text-white shadow-inner flex-shrink-0">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-sm text-gray-900 dark:text-white truncate">{{ $user->name }}</h4>
                                        <p class="text-[11px] text-gray-500 truncate mt-0.5">
                                            @if(str_ends_with($user->email, '@arraytype.local'))
                                                🤖 Automated Bot Account
                                            @else
                                                📧 {{ $user->email }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if($user->is_admin)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-indigo-500/10 text-indigo-500">Admin</span>
                                @elseif(str_ends_with($user->email, '@arraytype.local'))
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-500">Bot</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 dark:bg-white/5 text-gray-500 dark:text-gray-400">User</span>
                                @endif
                            </div>
                        @empty
                            <div class="text-center text-sm text-gray-500 dark:text-gray-400">No users registered yet.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Bot Status Panel -->
                <div class="bg-white dark:bg-[#1C2128] border border-gray-200 dark:border-white/10 rounded-2xl shadow-sm overflow-hidden relative">
                    <div class="h-1.5 w-full bg-gradient-to-r from-ai-primary to-ai-accent absolute top-0 left-0"></div>
                    <div class="p-6 border-b border-gray-100 dark:border-white/5">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            🤖 System Automation
                        </h2>
                    </div>
                    <div class="p-6 space-y-4 text-sm font-medium">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 dark:text-gray-400">Bot Service Status</span>
                            <span class="inline-flex items-center gap-1.5 font-bold text-emerald-500">
                                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
                                Operational
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 dark:text-gray-400">Automatic Scheduler</span>
                            <span class="text-indigo-400 font-bold">Enabled</span>
                        </div>
                        <hr class="border-gray-100 dark:border-white/5">
                        <div class="pt-2">
                            <p class="text-xs text-gray-500 leading-relaxed mb-4">
                                Bot activities are distributed dynamically. Each automated run selects a random bot to carry out their designated tasks (news, group generation, connection requests).
                            </p>
                            <a href="{{ route('admin.bots.index') }}" class="w-full bg-indigo-50 dark:bg-indigo-500/10 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 py-3.5 rounded-xl font-bold transition flex items-center justify-center gap-2 text-xs">
                                Edit Task Matrix
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

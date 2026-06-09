<x-app-layout :hideLeftSidebar="true" :hideRightSidebar="true">
    <style>
        body { background-color: #ffffff !important; }
        .dark body { background-color: #0f172a !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-10 lg:gap-16">
            
            <!-- Left Column (70%) -->
            <div class="lg:w-[65%] space-y-8">
                <!-- Header Component -->
                <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                    <div class="flex items-start gap-4">
                        <!-- Logo -->
                        <div class="h-[72px] w-[72px] rounded-xl bg-gray-900 flex items-center justify-center overflow-hidden flex-shrink-0 border border-gray-100 dark:border-white/10 shadow-sm">
                            @if($product->logo)
                                <img src="{{ $product->logo }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-3xl font-black text-gray-500">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        
                        <!-- Title & Tagline -->
                        <div class="pt-0.5">
                            <div class="flex items-center gap-3 flex-wrap">
                                <h1 class="text-[24px] font-bold text-gray-900 dark:text-white leading-tight">{{ $product->name }}</h1>
                                <span class="px-2.5 py-0.5 bg-gradient-to-r from-ai-primary to-ai-accent text-white text-[11px] font-bold rounded-full shadow-sm whitespace-nowrap">Launching today</span>
                                @if($product->creator?->isPremium())
                                    <span class="text-[10px] bg-amber-500/15 text-amber-400 font-extrabold px-2 py-0.5 rounded border border-amber-500/20 uppercase tracking-wider flex items-center gap-1" title="Premium Creator">👑 Pro Creator</span>
                                @endif
                            </div>
                            <p class="text-[20px] text-gray-600 dark:text-gray-300 font-normal leading-tight mt-1">{{ $product->tagline }}</p>
                            <div class="text-[13px] text-gray-500 font-medium mt-1">308 followers</div>
                        </div>
                    </div>
                    
                    @if($product->creator?->isPremium() && $product->custom_cta_text)
                        <a href="{{ route('products.click', $product) }}" target="_blank" rel="noopener" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 border border-transparent text-white rounded-full text-[14px] font-extrabold transition flex-shrink-0 shadow-lg shadow-indigo-600/25">
                            {{ $product->custom_cta_text }}
                        </a>
                    @else
                        <a href="{{ route('products.click', $product) }}" target="_blank" rel="noopener" class="px-5 py-2 border border-gray-200 dark:border-white/20 rounded-full text-[14px] font-bold hover:bg-gray-50 dark:hover:bg-white/5 transition flex-shrink-0">
                            Visit website
                        </a>
                    @endif
                </div>

                <!-- Breadcrumbs / Tags -->
                <div class="flex items-center gap-2 text-[13px] text-gray-500">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    <span>Video editing</span>
                    <span class="text-gray-300">•</span>
                    <span>Podcasting Tools</span>
                </div>

                <!-- Description Text -->
                <div class="text-[16px] leading-[1.6] text-gray-700 dark:text-gray-300 whitespace-pre-line">
                    {{ $product->description }}
                </div>

                <!-- Tabs -->
                <div class="flex items-center gap-6 overflow-x-auto no-scrollbar border-b border-gray-100 dark:border-white/10 pb-0 pt-2">
                    @foreach(['Overview', 'Reviews', 'Alternatives', 'Built with', 'Forum', 'More'] as $tab)
                        <a href="#" class="pb-3 text-[14px] {{ $loop->first ? 'text-gray-900 border-b-2 border-gray-900 dark:text-white dark:border-white font-bold' : 'text-gray-500 hover:text-gray-900 dark:hover:text-white font-medium' }} transition whitespace-nowrap">
                            {{ $tab }}
                        </a>
                    @endforeach
                </div>

                <!-- Gallery -->
                <div class="flex gap-4 overflow-hidden relative group">
                    <!-- Main Video Placeholder -->
                    <div class="w-[60%] aspect-[16/10] bg-gray-900 rounded-lg flex items-center justify-center relative cursor-pointer group/video flex-shrink-0">
                        <img src="https://picsum.photos/seed/tool{{$product->id}}0/800/500" class="absolute inset-0 w-full h-full object-cover rounded-lg opacity-80 mix-blend-overlay" alt="Product Demo">
                        <div class="absolute inset-0 bg-gradient-to-br from-gray-800/50 to-black/80 rounded-lg"></div>
                        <div class="z-10 bg-white/20 p-4 rounded-full backdrop-blur-sm group-hover/video:scale-110 transition duration-300">
                            <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.333-5.89a1.5 1.5 0 000-2.538L6.3 2.841z" /></svg>
                        </div>
                    </div>
                    <!-- Sub images placeholders -->
                    <div class="w-[35%] aspect-[16/10] bg-black rounded-lg relative overflow-hidden flex-shrink-0 border border-gray-800 cursor-pointer">
                        <img src="https://picsum.photos/seed/tool{{$product->id}}1/400/250" class="absolute inset-0 w-full h-full object-cover hover:opacity-80 transition" alt="Screenshot 1">
                    </div>
                    <div class="w-[20%] aspect-[16/10] bg-black rounded-lg relative overflow-hidden flex-shrink-0 border border-gray-800 cursor-pointer">
                        <img src="https://picsum.photos/seed/tool{{$product->id}}2/400/250" class="absolute inset-0 w-full h-full object-cover hover:opacity-80 transition" alt="Screenshot 2">
                    </div>
                    
                    <!-- Carousel indicator/dots (mock) -->
                    <div class="absolute bottom-[16px] left-[30%] flex justify-center gap-1.5 opacity-0 group-hover:opacity-100 transition">
                        <div class="w-1.5 h-1.5 rounded-full bg-ai-primary"></div>
                        <div class="w-1.5 h-1.5 rounded-full bg-gray-300/50"></div>
                        <div class="w-1.5 h-1.5 rounded-full bg-gray-300/50"></div>
                        <div class="w-1.5 h-1.5 rounded-full bg-gray-300/50"></div>
                    </div>
                </div>

                <!-- Launch Tags & Promo -->
                <div class="flex flex-wrap items-center justify-between gap-4 py-2 border-b border-gray-100 dark:border-white/10 border-t mt-8">
                    <div class="flex items-center gap-2 text-[13px] text-gray-600">
                        Free <span class="text-gray-300 mx-1">|</span> Launch tags: 
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                        Marketing <span class="text-gray-300">•</span> Artificial Intelligence <span class="text-gray-300">•</span> Video
                    </div>
                    <div class="px-3 py-1.5 rounded-full border border-ai-primary/30 text-ai-primary text-[13px] font-bold flex items-center gap-1.5 bg-ai-primary/5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" /></svg>
                        25% off your first month
                    </div>
                </div>

                <!-- Built With / Makers -->
                <div class="flex flex-col sm:flex-row items-center justify-between p-4 border border-gray-200 dark:border-white/10 rounded-xl gap-4">
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <div class="h-10 w-10 border border-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <span class="text-[14px] font-bold text-gray-900 dark:text-gray-100">Launch Team / Built With</span>
                    </div>
                    <div class="flex items-center gap-4 w-full sm:w-auto justify-between sm:justify-end">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full border-2 border-white bg-blue-100 flex items-center justify-center text-xs font-bold text-blue-600">{{ substr($product->creator?->name ?? 'A', 0, 1) }}</div>
                            <div class="w-8 h-8 rounded-full border-2 border-white bg-green-100"></div>
                            <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-900 text-white flex items-center justify-center text-xs font-bold">{{ $product->votes_count }}</div>
                        </div>
                        <button class="px-4 py-1.5 border border-gray-200 dark:border-white/20 rounded-full text-[13px] font-bold hover:bg-gray-50 flex items-center gap-1 transition">
                            Show more <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                    </div>
                </div>

                <!-- Comment Input -->
                <div class="border border-gray-200 dark:border-white/10 rounded-xl p-4 shadow-sm" id="discussion">
                    <form method="POST" action="{{ route('products.comment', $product) }}">
                        @csrf
                        <textarea name="content" rows="2" class="w-full border-none focus:ring-0 p-0 text-[15px] resize-none bg-transparent placeholder-gray-400" placeholder="What do you think? ..."></textarea>
                        <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100 dark:border-white/10">
                            <div class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 font-bold">@</div>
                            @auth
                                <button type="submit" class="px-4 py-1.5 border border-gray-200 dark:border-white/20 rounded-full text-[13px] font-bold text-gray-700 hover:bg-gray-50 transition">Comment</button>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-1.5 border border-gray-200 dark:border-white/20 rounded-full text-[13px] font-bold text-gray-700 hover:bg-gray-50 transition">Login to comment</a>
                            @endauth
                        </div>
                    </form>
                </div>

                <!-- Maker's Note & Comments -->
                <div class="space-y-6 pt-6 relative border-l-2 border-gray-100 dark:border-white/5 pl-6 ml-4">
                    <!-- Maker Note Thread -->
                    <div class="relative">
                        <div class="absolute -left-[35px] top-0 w-8 h-8 rounded-full bg-blue-100 border-[3px] border-white flex items-center justify-center font-bold text-blue-600 text-sm z-10">{{ substr($product->creator?->name ?? 'M', 0, 1) }}</div>
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-[15px] text-gray-900 dark:text-white">{{ $product->creator?->name ?? 'Maker' }}</span>
                                <span class="px-1.5 py-0.5 bg-[#14A864] text-white text-[10px] font-bold rounded uppercase tracking-wider flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg> Maker</span>
                                @if($product->creator?->isPremium())
                                    <span class="text-xs text-yellow-400 font-bold ml-1" title="Premium Maker">👑 Pro Maker</span>
                                @endif
                            </div>
                            <div class="text-[15px] text-gray-800 dark:text-gray-300 leading-[1.6]">
                                <p>Hi Product Hunt 👋</p><br>
                                <p>We're super excited to launch {{ $product->name }}. We've been building this tool to solve exactly the problem we faced every day. The learning curve for standard tools was too steep, so we made this instead.</p><br>
                                <p>Would love to hear your feedback!</p>
                            </div>
                            <!-- Comment Actions -->
                            <div class="flex items-center gap-4 text-[13px] text-gray-500 font-bold pt-2">
                                <span class="flex items-center gap-1 cursor-pointer hover:text-gray-900"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg> Upvote (16)</span>
                                <span class="cursor-pointer hover:text-gray-900">Report</span>
                                <span class="cursor-pointer hover:text-gray-900">Share</span>
                                <span class="text-gray-400 font-normal">23h ago</span>
                            </div>
                        </div>
                    </div>

                    <!-- User Comments -->
                    @foreach($product->comments as $comment)
                        <div class="relative pt-6">
                            <div class="absolute -left-[35px] top-6 w-8 h-8 rounded-full bg-gray-100 border-[3px] border-white flex items-center justify-center font-bold text-gray-600 text-sm z-10">{{ substr($comment->user?->name ?? 'U', 0, 1) }}</div>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-[15px] text-gray-900 dark:text-white">{{ $comment->user?->name ?? 'Anonymous User' }}</span>
                                </div>
                                <div class="text-[15px] text-gray-800 dark:text-gray-300 leading-[1.6]">
                                    {{ $comment->content }}
                                </div>
                                <div class="flex items-center gap-4 text-[13px] text-gray-500 font-bold pt-2">
                                    <span class="flex items-center gap-1 cursor-pointer hover:text-gray-900"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg> Upvote</span>
                                    <span class="cursor-pointer hover:text-gray-900">Report</span>
                                    <span class="cursor-pointer hover:text-gray-900">Share</span>
                                    <span class="text-gray-400 font-normal">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Column (35%) -->
            <div class="lg:w-[35%] space-y-8 lg:pt-0 pt-8 mt-8 border-t lg:border-t-0 border-gray-100 lg:pl-4">
                <h3 class="text-[16px] font-bold text-gray-900 dark:text-white">Launching Today</h3>

                <!-- Active Rank and Upvote Card -->
                <div class="border border-gray-200 dark:border-white/10 rounded-xl p-6 shadow-sm">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <div class="text-[28px] font-black text-gray-900 dark:text-white leading-none">#{{ rand(1,5) }}</div>
                            <div class="text-[13px] text-gray-600 font-medium mt-1">Day Rank</div>
                        </div>
                        <div class="flex gap-1.5">
                            <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition"><svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></button>
                            <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition"><svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></button>
                        </div>
                    </div>

                    @auth
                        <form method="POST" action="{{ route('products.vote', $product) }}">
                            @csrf
                            <button type="submit" class="w-full bg-gradient-to-r from-ai-primary to-ai-accent text-white hover:opacity-90 py-4 rounded-lg flex items-center justify-center gap-2 transition shadow-sm font-bold text-[15px]">
                                <svg class="w-5 h-5 -mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" /></svg>
                                Upvote • {{ $product->votes_count }} points
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="w-full bg-gradient-to-r from-ai-primary to-ai-accent text-white hover:opacity-90 py-4 rounded-lg flex items-center justify-center gap-2 transition shadow-sm font-bold text-[15px]">
                            <svg class="w-5 h-5 -mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" /></svg>
                            Upvote • {{ $product->votes_count }} points
                        </a>
                    @endauth
                </div>

                <!-- Sub Actions -->
                <div class="space-y-5 text-[14px] text-gray-600 font-medium py-2">
                    <button class="flex items-center gap-3 w-full hover:text-gray-900 transition text-left">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg> Follow {{ $product->name }}
                    </button>
                    <button class="flex items-center gap-3 w-full hover:text-gray-900 transition text-left">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" /></svg> Add to collection
                    </button>
                    <button class="flex items-center gap-3 w-full hover:text-gray-900 transition text-left">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" /></svg> Share
                    </button>
                    <button class="flex items-center gap-3 w-full hover:text-gray-900 transition text-left">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg> Analytics
                    </button>
                </div>

                <!-- Company Info Section -->
                <div class="space-y-4 pt-4 border-t border-gray-100 dark:border-white/10">
                    <h4 class="text-[14px] font-bold text-gray-900 dark:text-white">Company Info</h4>
                    <a href="{{ $product->website_url }}" class="flex items-center gap-2 text-[14px] text-gray-700 hover:text-gray-900 font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                        domain.com
                    </a>
                </div>

                <!-- Basic Info Section -->
                <div class="space-y-4 pt-4 border-t border-gray-100 dark:border-white/10">
                    <h4 class="text-[14px] font-bold text-gray-900 dark:text-white">{{ $product->name }} Info</h4>
                    <div class="flex items-center gap-2 text-[14px] text-gray-700 font-medium">
                        <div class="w-4 h-4 bg-ai-primary text-white font-bold text-[10px] flex items-center justify-center rounded-sm">Y</div>
                        Y Combinator
                    </div>
                    <div class="flex items-center gap-2 text-[14px] text-gray-700 font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                        Launched in {{ optional($product->launch_date)->format('Y') ?? '2026' }}
                    </div>
                </div>

                <!-- Admin Action Area -->
                @auth
                    @if(auth()->user()->is_admin)
                        <div class="mt-8 p-6 rounded-xl border border-red-500/20 bg-red-500/5 space-y-4">
                            <h4 class="text-[12px] font-black text-red-500 uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                Moderation Area
                            </h4>
                            <div class="space-y-2">
                                <form method="POST" action="{{ route('admin.products.reject', $product) }}">
                                    @csrf
                                    <button class="w-full py-2 bg-red-50 hover:bg-red-100 text-red-600 font-bold rounded-lg text-[13px] transition">Reject / Hide Submission</button>
                                </form>
                                <button class="w-full py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 font-bold rounded-lg text-[13px] transition">Set as Product of the Day</button>
                            </div>
                        </div>
                    @endif
                @endauth

            </div>

        </div>
    </div>
</x-app-layout>
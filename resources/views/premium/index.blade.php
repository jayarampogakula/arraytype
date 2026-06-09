<x-app-layout :hideLeftSidebar="true" :hideRightSidebar="true">
    <!-- Extra styling for premium page -->
    <style>
        .premium-bg {
            background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.15), transparent 50%),
                        radial-gradient(circle at bottom left, rgba(168, 85, 247, 0.15), transparent 50%);
        }
        .glass-premium {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glass-premium-glow {
            box-shadow: 0 0 40px -10px rgba(168, 85, 247, 0.2);
            border: 1px solid rgba(168, 85, 247, 0.3);
        }
    </style>

    <div class="premium-bg min-h-screen py-10" x-data="{ 
        drawerOpen: false, 
        checkoutItem: '', 
        checkoutPrice: '',
        checkoutType: '', /* 'upgrade', 'promote', 'promote_job' */
        selectedProductId: '',
        selectedJobId: '',
        selectedPackage: '',
        isSubmitting: false,
        
        openUpgrade() {
            this.checkoutItem = 'ArrayType User Premium Subscription';
            this.checkoutPrice = '$19.00 / month';
            this.checkoutType = 'upgrade';
            this.drawerOpen = true;
        },
        openPromote(productName, productId, packageName, packagePrice, packageKey) {
            this.checkoutItem = 'Promotion Package for ' + productName + ' (' + packageName + ')';
            this.checkoutPrice = packagePrice;
            this.checkoutType = 'promote';
            this.selectedProductId = productId;
            this.selectedPackage = packageKey;
            this.drawerOpen = true;
        },
        openPromoteJob(jobTitle, jobId, packageName, packagePrice, packageKey) {
            this.checkoutItem = 'Promotion Package for ' + jobTitle + ' (' + packageName + ')';
            this.checkoutPrice = packagePrice;
            this.checkoutType = 'promote_job';
            this.selectedJobId = jobId;
            this.selectedPackage = packageKey;
            this.drawerOpen = true;
        },
        submitPayment() {
            this.isSubmitting = true;
            setTimeout(() => {
                if (this.checkoutType === 'upgrade') {
                    document.getElementById('upgrade-form').submit();
                } else if (this.checkoutType === 'promote') {
                    document.getElementById('promote-product-id').value = this.selectedProductId;
                    document.getElementById('promote-package-name').value = this.selectedPackage;
                    document.getElementById('promote-form').submit();
                } else if (this.checkoutType === 'promote_job') {
                    document.getElementById('promote-job-id').value = this.selectedJobId;
                    document.getElementById('promote-job-package').value = this.selectedPackage;
                    document.getElementById('promote-job-form').submit();
                }
            }, 1800);
        }
    }">

        <!-- Forms for submitting checkout requests -->
        <form id="upgrade-form" action="{{ route('premium.upgrade') }}" method="POST" class="hidden">
            @csrf
        </form>
        <form id="promote-form" action="{{ route('premium.promote') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="product_id" id="promote-product-id" value="">
            <input type="hidden" name="package" id="promote-package-name" value="">
        </form>
        <form id="promote-job-form" action="{{ route('premium.promote-job') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="job_id" id="promote-job-id" value="">
            <input type="hidden" name="package" id="promote-job-package" value="">
        </form>

        <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Alert Banner -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl flex items-center gap-3 animate-pulse">
                    <span class="text-xl">✨</span>
                    <span class="font-semibold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Header Section -->
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-[11px] font-black tracking-widest text-indigo-400 uppercase bg-indigo-500/10 px-3 py-1 rounded-full border border-indigo-500/20">Portal Portal</span>
                <h1 class="text-4xl md:text-5xl font-black text-white mt-4 tracking-tight leading-none bg-gradient-to-r from-white via-indigo-200 to-purple-400 bg-clip-text text-transparent">
                    Upgrade & Promote
                </h1>
                <p class="text-gray-400 mt-4 text-base font-medium">
                    Boost your projects, gain exclusive privileges, and monitor your conversion analytics.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- LEFT COLUMN: User Premium Subscription (5 Cols) -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="glass-premium rounded-3xl p-6 border relative overflow-hidden transition-all duration-300 {{ $user->isPremium() ? 'glass-premium-glow' : '' }}">
                        <!-- Premium Badge Accent -->
                        @if($user->isPremium())
                            <div class="absolute top-0 right-0 bg-gradient-to-l from-purple-600 to-indigo-600 text-white text-[10px] font-black px-4 py-1.5 rounded-bl-xl uppercase tracking-wider">
                                Active Premium
                            </div>
                        @endif

                        <div class="flex items-center gap-3 mb-6">
                            <span class="text-3xl">💎</span>
                            <div>
                                <h2 class="text-xl font-extrabold text-white">User Premium Plan</h2>
                                <p class="text-xs text-gray-400 font-medium">Personal account upgrade</p>
                            </div>
                        </div>

                        <!-- Price Tag -->
                        <div class="mb-8">
                            @if($user->isPremium())
                                <span class="text-3xl font-black text-white">$19.00</span>
                                <span class="text-xs text-emerald-400 font-bold ml-1">/ Month (Subscribed)</span>
                            @else
                                <span class="text-4xl font-black text-white">$19.00</span>
                                <span class="text-sm text-gray-400 font-bold ml-1">/ month</span>
                                <p class="text-[11px] text-gray-500 mt-1">Cancel anytime with 1-click.</p>
                            @endif
                        </div>

                        <!-- Benefits Checklist -->
                        <ul class="space-y-4 text-sm text-gray-300 mb-8 font-medium">
                            <li class="flex items-start gap-3">
                                <span class="text-indigo-400">✦</span>
                                <div>
                                    <strong class="text-white">Gold Premium Crown</strong>
                                    <p class="text-xs text-gray-500">Stand out with a special badge everywhere on the platform.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-indigo-400">✦</span>
                                <div>
                                    <strong class="text-white">Direct Auto-Approval</strong>
                                    <p class="text-xs text-gray-500">Skip moderation. All your product launches approve instantly.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-indigo-400">✦</span>
                                <div>
                                    <strong class="text-white">Custom CTA buttons</strong>
                                    <p class="text-xs text-gray-500">Change "Visit website" to custom text like "Get 20% Off".</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-indigo-400">✦</span>
                                <div>
                                    <strong class="text-white">Live Product Analytics</strong>
                                    <p class="text-xs text-gray-500">Track view counts, redirect clicks, and click-through rates.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-indigo-400">✦</span>
                                <div>
                                    <strong class="text-white">Visual Card Highlight</strong>
                                    <p class="text-xs text-gray-500">A glowing visual border highlight on your listed products.</p>
                                </div>
                            </li>
                        </ul>

                        @if($user->isPremium())
                            <div class="w-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 font-bold py-3 px-4 rounded-xl text-center text-sm flex items-center justify-center gap-2">
                                <span>🛡️</span> Premium Plan Active
                            </div>
                        @else
                            <button @click="openUpgrade()" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold py-3.5 px-4 rounded-xl text-center text-sm transition-all duration-300 transform active:scale-95 shadow-lg shadow-indigo-600/35">
                                Upgrade Account
                            </button>
                        @endif
                    </div>
                </div>

                <!-- RIGHT COLUMN: Product Promotion Packages & Analytics (7 Cols) -->
                <div class="lg:col-span-7 space-y-8">
                    
                    <!-- Analytics & CTA Management (Only shown to Premium Users) -->
                    @if($user->isPremium())
                        <div class="glass-premium rounded-3xl p-6 border">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="text-2xl">📊</span>
                                <div>
                                    <h2 class="text-lg font-bold text-white">Your Product Analytics</h2>
                                    <p class="text-xs text-gray-400">Custom CTA and view counts for your approved products</p>
                                </div>
                            </div>

                            @forelse($myProducts as $prod)
                                <div class="p-4 bg-black/20 rounded-2xl border border-white/5 space-y-4 mb-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-bold text-white text-sm">{{ $prod->name }}</h3>
                                            <span class="text-[11px] text-gray-500">{{ $prod->category?->name }}</span>
                                        </div>
                                        <div class="flex gap-4 text-right">
                                            <div>
                                                <span class="block text-lg font-black text-indigo-400">{{ $prod->views_count }}</span>
                                                <span class="text-[10px] text-gray-500 uppercase font-bold">Views</span>
                                            </div>
                                            <div>
                                                <span class="block text-lg font-black text-purple-400">{{ $prod->clicks_count }}</span>
                                                <span class="text-[10px] text-gray-500 uppercase font-bold">Clicks</span>
                                            </div>
                                            <div>
                                                <span class="block text-lg font-black text-white">
                                                    {{ $prod->views_count > 0 ? number_format(($prod->clicks_count / $prod->views_count) * 100, 1) : '0' }}%
                                                </span>
                                                <span class="text-[10px] text-gray-500 uppercase font-bold">CTR</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- CTA Customizer Form -->
                                    <form method="POST" action="{{ route('products.update-cta', $prod) }}" class="flex items-center gap-2 pt-2 border-t border-white/5">
                                        @csrf
                                        <div class="flex-grow">
                                            <label class="block text-[11px] text-gray-400 font-bold mb-1">Custom CTA Button Text</label>
                                            <input type="text" name="custom_cta_text" value="{{ $prod->custom_cta_text }}" placeholder="e.g. Get 20% Off, Claim Code" class="w-full bg-black/40 border border-white/10 rounded-lg py-1 px-3 text-xs text-white placeholder-gray-600 focus:outline-none focus:border-indigo-500 focus:ring-0">
                                        </div>
                                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-1.5 px-3 rounded-lg text-xs self-end transition">
                                            Update
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="text-center py-6 text-gray-500 text-sm">
                                    You don't have any approved products yet. Approved products will show analytics and customizable buttons here.
                                </div>
                            @endforelse
                        </div>
                    @endif

                    <!-- Promotion Packages List -->
                    <div class="glass-premium rounded-3xl p-6 border">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="text-2xl">🚀</span>
                            <div>
                                <h2 class="text-lg font-bold text-white">Boost Your Launch</h2>
                                <p class="text-xs text-gray-400">Pin your product to the top of the feed to drive immediate leads</p>
                            </div>
                        </div>

                        <!-- Product Selector -->
                        <div class="mb-6 bg-black/15 p-4 rounded-2xl border border-white/5">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">1. Select Product to Promote</label>
                            @php
                                $approvedProductsOwned = auth()->user()->products()->where('status', 'approved')->get();
                            @endphp

                            @if($approvedProductsOwned->count() > 0)
                                <select id="product-selector" class="w-full bg-black/50 border border-white/10 rounded-xl py-2 px-3 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-0">
                                    @foreach($approvedProductsOwned as $prod)
                                        <option value="{{ $prod->id }}" data-name="{{ $prod->name }}">{{ $prod->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <div class="p-3 bg-red-500/10 border border-red-500/20 text-red-400 text-xs rounded-lg flex items-center justify-between">
                                    <span>You need an approved product in order to buy promotion packages.</span>
                                    <a href="{{ route('products.create') }}" class="underline font-bold text-white">Submit product</a>
                                </div>
                            @endif
                        </div>

                        <!-- Promotion Options Cards Grid -->
                        <div class="mb-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-4">2. Choose Promotion Tier</label>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Package 1: Starter -->
                                <div class="border border-white/5 bg-black/20 rounded-2xl p-4 flex flex-col justify-between hover:border-indigo-500/40 transition">
                                    <div>
                                        <h4 class="font-extrabold text-white text-sm">Starter Promo</h4>
                                        <p class="text-[11px] text-indigo-400 font-semibold mt-1">1-Day Category Pin</p>
                                        <ul class="text-[11px] text-gray-400 space-y-1.5 mt-3">
                                            <li>• Top of its Category page</li>
                                            <li>• Guaranteed visibility</li>
                                            <li>• Active for 24 hours</li>
                                        </ul>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between">
                                        <span class="font-black text-white">$10.00</span>
                                        <button 
                                            @if($approvedProductsOwned->count() > 0)
                                                @click="
                                                    var el = document.getElementById('product-selector');
                                                    openPromote(el.options[el.selectedIndex].getAttribute('data-name'), el.value, 'Starter Promo', '$10.00', 'starter');
                                                "
                                            @else
                                                disabled
                                            @endif
                                            class="bg-indigo-600 hover:bg-indigo-500 disabled:opacity-50 text-white font-bold py-1 px-3 rounded-lg text-xs transition">
                                            Select
                                        </button>
                                    </div>
                                </div>

                                <!-- Package 2: Pro -->
                                <div class="border border-indigo-500/20 bg-indigo-500/5 rounded-2xl p-4 flex flex-col justify-between hover:border-indigo-500/40 transition relative">
                                    <div class="absolute top-[-10px] left-4 bg-indigo-600 text-white font-bold text-[9px] px-2 py-0.5 rounded-full uppercase">Popular</div>
                                    <div>
                                        <h4 class="font-extrabold text-white text-sm">Pro Promo</h4>
                                        <p class="text-[11px] text-indigo-400 font-semibold mt-1">1-Day Homepage Pin</p>
                                        <ul class="text-[11px] text-gray-400 space-y-1.5 mt-3">
                                            <li>• Top of Main Homepage</li>
                                            <li>• Maximum platform reach</li>
                                            <li>• Active for 24 hours</li>
                                        </ul>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between">
                                        <span class="font-black text-white">$29.00</span>
                                        <button 
                                            @if($approvedProductsOwned->count() > 0)
                                                @click="
                                                    var el = document.getElementById('product-selector');
                                                    openPromote(el.options[el.selectedIndex].getAttribute('data-name'), el.value, 'Pro Promo', '$29.00', 'pro');
                                                "
                                            @else
                                                disabled
                                            @endif
                                            class="bg-indigo-600 hover:bg-indigo-500 disabled:opacity-50 text-white font-bold py-1 px-3 rounded-lg text-xs transition">
                                            Select
                                        </button>
                                    </div>
                                </div>

                                <!-- Package 3: Elite -->
                                <div class="border border-white/5 bg-black/20 rounded-2xl p-4 flex flex-col justify-between hover:border-indigo-500/40 transition">
                                    <div>
                                        <h4 class="font-extrabold text-white text-sm">Elite Promo</h4>
                                        <p class="text-[11px] text-indigo-400 font-semibold mt-1">7-Day Homepage Pin</p>
                                        <ul class="text-[11px] text-gray-400 space-y-1.5 mt-3">
                                            <li>• Top of Homepage</li>
                                            <li>• Sustained growth & leads</li>
                                            <li>• Active for 7 full days</li>
                                        </ul>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between">
                                        <span class="font-black text-white">$79.00</span>
                                        <button 
                                            @if($approvedProductsOwned->count() > 0)
                                                @click="
                                                    var el = document.getElementById('product-selector');
                                                    openPromote(el.options[el.selectedIndex].getAttribute('data-name'), el.value, 'Elite Promo', '$79.00', 'elite');
                                                "
                                            @else
                                                disabled
                                            @endif
                                            class="bg-indigo-600 hover:bg-indigo-500 disabled:opacity-50 text-white font-bold py-1 px-3 rounded-lg text-xs transition">
                                            Select
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Promotion Card -->
                    <div class="glass-premium rounded-3xl p-6 border mt-8">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="text-2xl">💼</span>
                            <div>
                                <h2 class="text-lg font-bold text-white">Boost Your Job Posting</h2>
                                <p class="text-xs text-gray-400">Pin your job listing to the top of the job feed to get more qualified applicants</p>
                            </div>
                        </div>

                        <!-- Job Selector -->
                        <div class="mb-6 bg-black/15 p-4 rounded-2xl border border-white/5">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">1. Select Job to Promote</label>
                            @if($myJobs->count() > 0)
                                <select id="job-selector" class="w-full bg-black/50 border border-white/10 rounded-xl py-2 px-3 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-0">
                                    @foreach($myJobs as $myJob)
                                        <option value="{{ $myJob->id }}" data-title="{{ $myJob->title }}">{{ $myJob->title }}</option>
                                    @endforeach
                                </select>
                            @else
                                <div class="p-3 bg-red-500/10 border border-red-500/20 text-red-400 text-xs rounded-lg flex items-center justify-between">
                                    <span>You need to post a job in order to buy promotion packages.</span>
                                    <a href="{{ route('jobs.create') }}" class="underline font-bold text-white">Post a job</a>
                                </div>
                            @endif
                        </div>

                        <!-- Job Promotion Options -->
                        <div class="mb-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-4">2. Choose Job Booster Tier</label>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Weekly Booster -->
                                <div class="border border-white/5 bg-black/20 rounded-2xl p-4 flex flex-col justify-between hover:border-indigo-500/40 transition">
                                    <div>
                                        <h4 class="font-extrabold text-white text-sm">Weekly Job Booster</h4>
                                        <p class="text-[11px] text-indigo-400 font-semibold mt-1">7-Day Top Feed Pin</p>
                                        <ul class="text-[11px] text-gray-400 space-y-1.5 mt-3">
                                            <li>• Placed at the very top of the job feed</li>
                                            <li>• Highlights your company logo</li>
                                            <li>• Active for 7 full days</li>
                                        </ul>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between">
                                        <span class="font-black text-white">$19.00</span>
                                        <button 
                                            @if($myJobs->count() > 0)
                                                @click="
                                                    var el = document.getElementById('job-selector');
                                                    openPromoteJob(el.options[el.selectedIndex].getAttribute('data-title'), el.value, 'Weekly Job Booster', '$19.00', 'weekly');
                                                "
                                            @else
                                                disabled
                                            @endif
                                            class="bg-indigo-600 hover:bg-indigo-500 disabled:opacity-50 text-white font-bold py-1 px-3 rounded-lg text-xs transition">
                                            Select
                                        </button>
                                    </div>
                                </div>

                                <!-- Monthly Booster -->
                                <div class="border border-indigo-500/25 bg-indigo-500/5 rounded-2xl p-4 flex flex-col justify-between hover:border-indigo-500/40 transition relative">
                                    <div class="absolute top-[-10px] left-4 bg-indigo-600 text-white font-bold text-[9px] px-2 py-0.5 rounded-full uppercase">Best Value</div>
                                    <div>
                                        <h4 class="font-extrabold text-white text-sm">Monthly Job Booster</h4>
                                        <p class="text-[11px] text-indigo-400 font-semibold mt-1">30-Day Top Feed Pin</p>
                                        <ul class="text-[11px] text-gray-400 space-y-1.5 mt-3">
                                            <li>• Placed at the very top of the job feed</li>
                                            <li>• Retains top placement for 30 days</li>
                                            <li>• Maximum applicant exposure</li>
                                        </ul>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between">
                                        <span class="font-black text-white">$49.00</span>
                                        <button 
                                            @if($myJobs->count() > 0)
                                                @click="
                                                    var el = document.getElementById('job-selector');
                                                    openPromoteJob(el.options[el.selectedIndex].getAttribute('data-title'), el.value, 'Monthly Job Booster', '$49.00', 'monthly');
                                                "
                                            @else
                                                disabled
                                            @endif
                                            class="bg-indigo-600 hover:bg-indigo-500 disabled:opacity-50 text-white font-bold py-1 px-3 rounded-lg text-xs transition">
                                            Select
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- SLIDE-OVER CHECKOUT DRAWER -->
        <div class="fixed inset-0 overflow-hidden z-50" style="display: none;" x-show="drawerOpen" x-transition:enter="transition ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-md" @click="if(!isSubmitting) drawerOpen = false"></div>

            <div class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                <!-- Drawer Panel -->
                <div class="w-screen max-w-md bg-[#0b0f19] border-l border-white/10 shadow-2xl relative flex flex-col" x-show="drawerOpen" x-transition:enter="transform transition ease-in-out duration-300 sm:duration-400" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300 sm:duration-400" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                    
                    <!-- Drawer Header -->
                    <div class="p-6 border-b border-white/10 flex items-center justify-between">
                        <h3 class="text-lg font-black text-white">Secure Checkout</h3>
                        <button class="text-gray-400 hover:text-white transition" @click="if(!isSubmitting) drawerOpen = false" :disabled="isSubmitting">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <!-- Drawer Content -->
                    <div class="flex-grow p-6 overflow-y-auto space-y-8">
                        
                        <!-- Order Summary Card -->
                        <div class="p-4 bg-white/5 rounded-2xl border border-white/5 space-y-2">
                            <span class="text-[10px] text-indigo-400 font-bold uppercase tracking-wider">Item Selected</span>
                            <div class="text-sm font-extrabold text-white leading-tight" x-text="checkoutItem"></div>
                            <div class="flex justify-between items-center pt-3 border-t border-white/5 mt-3">
                                <span class="text-xs text-gray-400 font-bold">Price</span>
                                <span class="text-base font-black text-emerald-400" x-text="checkoutPrice"></span>
                            </div>
                        </div>

                        <!-- Credit Card Mockup -->
                        <div class="relative w-full aspect-[1.58/1] rounded-2xl bg-gradient-to-tr from-purple-800 via-indigo-900 to-indigo-750 p-6 shadow-xl border border-white/10 flex flex-col justify-between overflow-hidden">
                            <div class="absolute inset-0 bg-radial-gradient(circle at top left, rgba(255,255,255,0.05), transparent 60%)"></div>
                            <!-- Card Header -->
                            <div class="flex justify-between items-start z-10">
                                <div class="text-lg font-black italic text-white tracking-widest">VISA</div>
                                <div class="w-8 h-6 bg-yellow-400/20 rounded-md border border-yellow-500/20"></div>
                            </div>
                            <!-- Card Number -->
                            <div class="text-white text-lg font-bold tracking-widest text-center my-4 z-10">
                                ••••  ••••  ••••  4242
                            </div>
                            <!-- Card Footer -->
                            <div class="flex justify-between items-end z-10">
                                <div>
                                    <span class="block text-[8px] text-gray-400 uppercase font-black tracking-wider">Cardholder</span>
                                    <span class="text-xs font-bold text-white truncate max-w-[150px]">{{ Auth::user()->name }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="block text-[8px] text-gray-400 uppercase font-black tracking-wider">Expires</span>
                                    <span class="text-xs font-bold text-white">12/29</span>
                                </div>
                            </div>
                        </div>

                        <!-- Checkout Form -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Card Number</label>
                                <div class="relative">
                                    <input type="text" value="4242 4242 4242 4242" disabled class="w-full bg-black/40 border border-white/10 rounded-xl py-3 px-4 text-sm text-gray-300 focus:outline-none">
                                    <span class="absolute right-3 top-3.5 text-xs text-emerald-400 font-bold">Demo Mode</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Expiration Date</label>
                                    <input type="text" value="12 / 29" disabled class="w-full bg-black/40 border border-white/10 rounded-xl py-3 px-4 text-sm text-gray-300 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">CVC / CVV</label>
                                    <input type="text" value="123" disabled class="w-full bg-black/40 border border-white/10 rounded-xl py-3 px-4 text-sm text-gray-300 focus:outline-none">
                                </div>
                            </div>
                        </div>

                        <!-- Security Notice -->
                        <div class="p-3 bg-indigo-500/5 border border-indigo-500/10 rounded-xl flex gap-2.5 items-start">
                            <span class="text-base text-indigo-400">🛡️</span>
                            <p class="text-[11px] text-gray-400 leading-normal font-medium">
                                Payments are simulated for development demonstration. No real financial credentials will be charged.
                            </p>
                        </div>

                    </div>

                    <!-- Drawer Footer -->
                    <div class="p-6 border-t border-white/10 bg-[#070b13]">
                        <button @click="submitPayment()" :disabled="isSubmitting" class="w-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-bold py-3.5 px-4 rounded-xl text-center text-sm transition-all duration-300 flex items-center justify-center gap-2 active:scale-95 shadow-lg shadow-emerald-500/20">
                            <template x-if="!isSubmitting">
                                <span>🔒 Pay & Activate Now</span>
                            </template>
                            <template x-if="isSubmitting">
                                <div class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>Processing secure payment...</span>
                                </div>
                            </template>
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>

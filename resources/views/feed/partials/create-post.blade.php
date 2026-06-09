<!-- Create Post Box (LinkedIn Style) -->
<div class="glass-panel rounded-xl bg-white dark:bg-[#1b1f23] shadow-sm border border-gray-200 dark:border-white/10 p-4 mb-4"
    x-data="{ 
        expanded: false, 
        postType: '{{ $defaultPostType ?? 'text' }}', 
        pollOptions: ['', ''],
        imageFiles: [],
        videoFile: null,
        videoName: '',
        triggerImageUpload() {
            document.getElementById('post-images').click();
        },
        triggerVideoUpload() {
            document.getElementById('post-video').click();
        },
        handleImagesChange(e) {
            const files = Array.from(e.target.files).slice(0, 5); // Upto 5 images
            this.imageFiles = [];
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = (event) => {
                    this.imageFiles.push({ name: file.name, url: event.target.result });
                };
                reader.readAsDataURL(file);
            });
        },
        handleVideoChange(e) {
            const file = e.target.files[0];
            if (file) {
                this.videoFile = file;
                this.videoName = file.name;
            } else {
                this.videoFile = null;
                this.videoName = '';
            }
        },
        removeImage(index) {
            this.imageFiles.splice(index, 1);
            // Since we can't easily programmatically modify filelist in FileInput,
            // the backend handles whatever gets submitted. But this provides accurate visual states.
        },
        removeVideo() {
            this.videoFile = null;
            this.videoName = '';
            document.getElementById('post-video').value = '';
        }
    }">
    <div class="flex items-start gap-3 mb-2">
        <a href="{{ auth()->check() ? route('profile.edit') : '#' }}" class="flex-shrink-0">
            <div
                class="h-12 w-12 rounded-full bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-white/10 overflow-hidden flex items-center justify-center text-lg font-bold text-gray-400">
                {{ auth()->check() ? substr(auth()->user()->name, 0, 1) : '?' }}
            </div>
        </a>

        <button @click="expanded = true" x-show="!expanded"
            class="flex-grow text-left px-6 py-3 rounded-full border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 hover:bg-gray-100 dark:hover:bg-white/10 transition text-gray-500 dark:text-gray-400 font-bold shadow-inner">
            Start a post
        </button>

        <form x-show="expanded" action="{{ route('feed.store') }}" method="POST" enctype="multipart/form-data" class="flex-grow flex flex-col"
            style="display: none;">
            @csrf
            @if(isset($group))
                <input type="hidden" name="group_id" value="{{ $group->id }}">
            @endif
            <input type="hidden" name="type" x-model="postType">

            <!-- Hidden File Inputs -->
            <input type="file" id="post-images" name="images[]" multiple accept="image/*" class="hidden" @change="handleImagesChange">
            <input type="file" id="post-video" name="video" accept="video/*" class="hidden" @change="handleVideoChange">

            <textarea name="content" rows="4" autofocus
                class="w-full bg-transparent border-none text-gray-900 dark:text-gray-100 p-2 focus:ring-0 placeholder-gray-500 text-lg resize-none"
                :placeholder="postType === 'ask' ? 'Ask the community a question...' : (postType === 'poll' ? 'What do you want to ask in your poll?' : 'What do you want to talk about?')"
                required></textarea>

            <!-- Previews for Images -->
            <div x-show="imageFiles.length > 0" class="grid grid-cols-5 gap-2 mt-3 p-2 bg-gray-50 dark:bg-black/10 rounded-xl border border-gray-200 dark:border-white/5">
                <template x-for="(img, idx) in imageFiles" :key="idx">
                    <div class="relative rounded-lg overflow-hidden border border-gray-200 dark:border-white/10 aspect-square">
                        <img :src="img.url" class="w-full h-full object-cover">
                        <button type="button" @click="removeImage(idx)" class="absolute top-1 right-1 bg-black/60 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-500 transition font-black">
                            &times;
                        </button>
                    </div>
                </template>
            </div>

            <!-- Previews for Video -->
            <div x-show="videoName" class="mt-3 bg-gray-50 dark:bg-black/20 border border-gray-200 dark:border-white/5 p-3 rounded-xl flex items-center justify-between">
                <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 font-semibold">
                    <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <span x-text="videoName" class="truncate max-w-[250px]"></span>
                </div>
                <button type="button" @click="removeVideo" class="text-gray-400 hover:text-red-500 font-black text-sm bg-black/10 hover:bg-black/20 rounded-full w-5 h-5 flex items-center justify-center">
                    &times;
                </button>
            </div>

            <!-- Poll Options -->
            <template x-if="postType === 'poll'">
                <div
                    class="mt-3 space-y-2 bg-gray-50 dark:bg-black/20 p-3 rounded-lg border border-gray-200 dark:border-white/5">
                    <template x-for="(option, index) in pollOptions" :key="index">
                        <div class="flex items-center space-x-2">
                            <input type="text" x-model="pollOptions[index]" :name="'poll_options['+index+']'"
                                class="bg-white dark:bg-white/5 border border-gray-300 dark:border-white/10 rounded-lg text-sm text-gray-900 dark:text-gray-200 px-3 py-2 focus:ring-ai-primary w-full"
                                :placeholder="'Option ' + (index + 1)" required>
                            <button type="button" @click="pollOptions.splice(index, 1)" x-show="pollOptions.length > 2"
                                class="text-gray-400 hover:text-red-500">
                                &times;
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="pollOptions.push('')" x-show="pollOptions.length < 5"
                        class="text-sm font-semibold text-ai-primary hover:bg-blue-50 dark:hover:bg-white/5 px-2 py-1 rounded">
                        + Add Option
                    </button>
                </div>
            </template>

            <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-200 dark:border-white/10">
                <div class="flex gap-1">
                    <button type="button" @click="postType = 'text'"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 transition text-gray-500"
                        :class="{'text-ai-primary bg-blue-50 dark:bg-ai-primary/10': postType === 'text'}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                    <button type="button" @click="postType = 'ask'"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 transition text-gray-500"
                        :class="{'text-ai-primary bg-blue-50 dark:bg-ai-primary/10': postType === 'ask'}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                    <button type="button" @click="postType = 'poll'"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 transition text-gray-500"
                        :class="{'text-ai-primary bg-blue-50 dark:bg-ai-primary/10': postType === 'poll'}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </button>

                    <!-- In-Form File Upload Buttons -->
                    <button type="button" @click="triggerImageUpload"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 transition text-gray-500 hover:text-blue-500"
                        title="Add Photo (up to 5)">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </button>
                    <button type="button" @click="triggerVideoUpload"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 transition text-gray-500 hover:text-green-500"
                        title="Add Video">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </button>
                </div>
                <div class="flex gap-2">
                    <button type="button" @click="expanded = false"
                        class="px-3 py-1.5 rounded-full font-semibold text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 text-sm">Cancel</button>
                    <button type="submit"
                        class="px-4 py-1.5 rounded-full font-semibold bg-ai-primary hover:bg-ai-primary/90 text-white text-sm transition">Post</button>
                </div>
            </div>
        </form>
    </div>

    <!-- LinkedIn Action Buttons -->
    <div x-show="!expanded" class="flex justify-around items-center pt-1 pb-1">
        <button @click="expanded = true; postType = 'text'; $nextTick(() => triggerImageUpload())"
            class="flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-white/5 px-4 py-3 rounded-xl transition font-bold text-gray-700 dark:text-gray-300 text-sm">
            <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Photo
        </button>
        <button @click="expanded = true; postType = 'text'; $nextTick(() => triggerVideoUpload())"
            class="flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-white/5 px-4 py-3 rounded-xl transition font-bold text-gray-700 dark:text-gray-300 text-sm">
            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
            Video
        </button>
        <button @click="expanded = true; postType = 'ask'"
            class="flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-white/5 px-4 py-3 rounded-xl transition font-bold text-gray-700 dark:text-gray-300 text-sm">
            <svg class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Ask Question
        </button>
        <button @click="expanded = true; postType = 'poll'"
            class="flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-white/5 px-4 py-3 rounded-xl transition font-bold text-gray-700 dark:text-gray-300 text-sm">
            <svg class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Poll
        </button>
    </div>
</div>
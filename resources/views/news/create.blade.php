<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-100">Submit AI News</h1>
        <p class="text-gray-400 mt-1">Share a story, research paper, or announcement with the AI community.</p>
    </div>

    <div class="glass-panel rounded-xl p-6">
        <form action="{{ route('news.store') }}" method="POST">
            @csrf

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Headline / Title <span
                            class="text-red-400">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary"
                        placeholder="e.g. OpenAI launches GPT-5 with real-time reasoning">
                    @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Source URL <span
                                class="text-red-400">*</span></label>
                        <input type="url" name="source_url" value="{{ old('source_url') }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary"
                            placeholder="https://...">
                        @error('source_url') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Category <span
                                class="text-red-400">*</span></label>
                        <input type="text" name="category" value="{{ old('category') }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary"
                            placeholder="e.g. Research, Funding, Product Launch">
                        @error('category') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Summary <span
                            class="text-red-400">*</span></label>
                    <textarea name="summary" rows="6" required
                        class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary"
                        placeholder="Write a short summary of the article...">{{ old('summary') }}</textarea>
                    @error('summary') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex space-x-4 pt-2">
                    <button type="submit"
                        class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-6 py-3 rounded-lg font-semibold">
                        Submit News
                    </button>
                    <a href="{{ route('news.index') }}"
                        class="bg-white/10 hover:bg-white/20 transition text-gray-300 px-6 py-3 rounded-lg font-semibold">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

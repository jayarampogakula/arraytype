<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-100">Submit AI Tool</h1>
        <p class="text-gray-400 mt-1">Share a useful AI tool with the ArrayType community.</p>
    </div>

    <div class="glass-panel rounded-xl p-6">
        <form action="{{ route('tools.store') }}" method="POST">
            @csrf

            <div class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Tool Name <span
                                class="text-red-400">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary"
                            placeholder="e.g. ChatGPT, Midjourney, Cursor...">
                        @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Category <span
                                class="text-red-400">*</span></label>
                        <select name="category" required style="color-scheme: dark;"
                            class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary">
                            <option value="" style="background-color: #0f172a; color: white;">Select category...
                            </option>
                            @foreach(['LLM / Chatbot', 'Image Generation', 'Video Generation', 'Voice / Audio', 'Coding Assistant', 'Search / Research', 'Productivity', 'Data Analysis', 'Other AI'] as $cat)
                                <option value="{{ $cat }}" style="background-color: #0f172a; color: white;" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}
                                </option>
                            @endforeach
                        </select>
                        @error('category') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Tool URL <span
                                class="text-red-400">*</span></label>
                        <input type="url" name="url" value="{{ old('url') }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary"
                            placeholder="https://example.com">
                        @error('url') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Logo URL <span
                                class="text-gray-500 text-xs">(optional)</span></label>
                        <input type="url" name="logo" value="{{ old('logo') }}"
                            class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary"
                            placeholder="https://example.com/logo.png">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Description <span
                            class="text-red-400">*</span></label>
                    <textarea name="description" rows="4" required
                        class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary"
                        placeholder="What does this tool do? What is it best for? Who should use it?">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex space-x-4 pt-2">
                    <button type="submit"
                        class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-6 py-3 rounded-lg font-semibold">
                        Submit Tool
                    </button>
                    <a href="{{ route('tools.index') }}"
                        class="bg-white/10 hover:bg-white/20 transition text-gray-300 px-6 py-3 rounded-lg font-semibold">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

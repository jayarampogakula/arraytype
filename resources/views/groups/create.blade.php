<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-100">Create AI Community</h1>
        <p class="text-gray-400 mt-1">Start a new group around an AI topic you care about.</p>
    </div>

    <div class="glass-panel rounded-xl p-6">
        <form action="{{ route('groups.store') }}" method="POST">
            @csrf

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Community Name <span
                            class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full bg-ai-primary/10 border border-white/20 text-white rounded-lg p-3 focus:ring-ai-primary focus:border-ai-primary placeholder-gray-500"
                        placeholder="e.g. Prompt Engineers, AI Agents, LLM Research...">
                    @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full bg-ai-primary/10 border border-white/20 text-white rounded-lg p-3 focus:ring-ai-primary focus:border-ai-primary placeholder-gray-500"
                        placeholder="What is this community about? What can members discuss?">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Privacy Setting</label>
                    <select name="is_private"
                        class="w-full bg-ai-primary/10 border border-white/20 text-white rounded-lg p-3 focus:ring-ai-primary focus:border-ai-primary"
                        style="color-scheme: dark;">
                        <option value="0" style="background: #0f172a; color: white;">Public (Anyone can view and join)
                        </option>
                        <option value="1" style="background: #0f172a; color: white;">Private (Only members can view
                            posts, request to join)</option>
                    </select>
                </div>

                <div class="flex space-x-4 pt-2">
                    <button type="submit"
                        class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-6 py-3 rounded-lg font-semibold">
                        Create Community
                    </button>
                    <a href="{{ route('groups.index') }}"
                        class="bg-white/10 hover:bg-white/20 transition text-gray-300 px-6 py-3 rounded-lg font-semibold">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
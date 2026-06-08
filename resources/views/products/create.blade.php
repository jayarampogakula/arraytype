<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Submit a Product</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Share your AI tool with the AIans community.</p>
    </div>

    <div class="glass-panel rounded-xl p-6 border border-gray-200 dark:border-white/10">
        <form method="POST" action="{{ route('products.store') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="name" value="Product Name" />
                <x-text-input id="name" name="name" class="mt-1 block w-full" value="{{ old('name') }}" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="logo" value="Logo URL" />
                <x-text-input id="logo" name="logo" class="mt-1 block w-full" value="{{ old('logo') }}" required />
                <x-input-error :messages="$errors->get('logo')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="tagline" value="Tagline" />
                <x-text-input id="tagline" name="tagline" class="mt-1 block w-full" value="{{ old('tagline') }}"
                    required />
                <x-input-error :messages="$errors->get('tagline')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="description" value="Description" />
                <textarea id="description" name="description" rows="5"
                    class="mt-1 block w-full rounded-md bg-white dark:bg-gray-900/60 border border-gray-300 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:border-ai-primary focus:ring-ai-primary shadow-sm">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="website_url" value="Website URL" />
                <x-text-input id="website_url" name="website_url" class="mt-1 block w-full"
                    value="{{ old('website_url') }}" required />
                <x-input-error :messages="$errors->get('website_url')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="category_id" value="Category" />
                <select id="category_id" name="category_id"
                    class="mt-1 block w-full rounded-md bg-white dark:bg-gray-900/60 border border-gray-300 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:border-ai-primary focus:ring-ai-primary shadow-sm">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="launch_date" value="Launch Date (optional)" />
                <input type="date" id="launch_date" name="launch_date" value="{{ old('launch_date') }}"
                    class="mt-1 block w-full rounded-md bg-white dark:bg-gray-900/60 border border-gray-300 dark:border-white/10 text-gray-900 dark:text-gray-100 focus:border-ai-primary focus:ring-ai-primary shadow-sm" />
                <x-input-error :messages="$errors->get('launch_date')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end">
                <button type="submit"
                    class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-4 py-2 rounded-lg font-medium">
                    Submit Product
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
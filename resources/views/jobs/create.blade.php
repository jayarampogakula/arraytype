<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-100">Post an AI Job</h1>
        <p class="text-gray-400 mt-1">Share an AI-related job opportunity with the community.</p>
    </div>

    <div class="glass-panel rounded-xl p-6">
        <form action="{{ route('jobs.store') }}" method="POST">
            @csrf

            <div class="space-y-5">
                <!-- Section: Company -->
                <div class="border-b border-white/10 pb-5">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Company Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Company Name <span
                                    class="text-red-400">*</span></label>
                            <input type="text" name="company_name" value="{{ old('company_name') }}" required
                                class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary"
                                placeholder="e.g. OpenAI, Anthropic, Google DeepMind">
                            @error('company_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Company Website <span
                                    class="text-gray-500 text-xs">(optional)</span></label>
                            <input type="url" name="company_website" value="{{ old('company_website') }}"
                                class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary"
                                placeholder="https://company.com">
                        </div>
                    </div>
                </div>

                <!-- Section: Job Details -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Job Details</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Job Title <span
                                    class="text-red-400">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary"
                                placeholder="e.g. Senior ML Engineer, Prompt Engineer...">
                            @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Location</label>
                                <input type="text" name="location" value="{{ old('location') }}"
                                    class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary"
                                    placeholder="Remote, San Francisco, London...">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Job Type <span
                                        class="text-red-400">*</span></label>
                                <select name="type" required style="color-scheme: dark;"
                                    class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary">
                                    @foreach(['Full-time', 'Part-time', 'Contract', 'Freelance', 'Remote'] as $type)
                                        <option value="{{ $type }}" style="background-color: #0f172a; color: white;" {{ old('type') === $type ? 'selected' : '' }}>{{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="inline-flex items-center gap-2 text-sm text-gray-300">
                                <input type="checkbox" name="remote" value="1"
                                    class="rounded border-white/10 bg-gray-900/60 text-ai-primary focus:ring-ai-primary" />
                                Remote role
                            </label>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Apply / Job Link <span
                                    class="text-gray-500 text-xs">(optional)</span></label>
                            <input type="url" name="apply_url" value="{{ old('apply_url') }}"
                                class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary"
                                placeholder="https://...">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Salary Range <span
                                    class="text-gray-500 text-xs">(optional)</span></label>
                            <input type="text" name="salary_range" value="{{ old('salary_range') }}"
                                class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary"
                                placeholder="e.g. $120k - $160k">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Job Description <span
                                    class="text-red-400">*</span></label>
                            <textarea name="description" rows="6" required
                                class="w-full bg-white/5 border border-white/10 rounded-lg text-gray-200 p-3 focus:ring-ai-primary focus:border-ai-primary"
                                placeholder="Describe the role, responsibilities, requirements, and benefits...">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4 pt-2">
                    <button type="submit"
                        class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-6 py-3 rounded-lg font-semibold">
                        Post Job
                    </button>
                    <a href="{{ route('jobs.index') }}"
                        class="bg-white/10 hover:bg-white/20 transition text-gray-300 px-6 py-3 rounded-lg font-semibold">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

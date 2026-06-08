<section>
    <header>
        <h2 class="text-lg font-medium text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-300" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full bg-ai-primary/10 border border-white/20 text-white rounded-lg p-2.5 focus:border-ai-primary focus:ring-ai-primary"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-red-400" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full bg-ai-primary/10 border border-white/20 text-white rounded-lg p-2.5 focus:border-ai-primary focus:ring-ai-primary"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2 text-red-400" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-400">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-400 hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="bio" value="Bio" class="text-gray-300" />
            <textarea id="bio" name="bio" rows="3"
                class="mt-1 block w-full bg-ai-primary/10 border border-white/20 text-white rounded-lg p-2.5 focus:border-ai-primary focus:ring focus:ring-ai-primary focus:ring-opacity-50 placeholder-gray-500"
                placeholder="Tell us about yourself and your AI interests...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
            <x-input-error class="mt-2 text-red-400" :messages="$errors->get('bio')" />
        </div>

        <div>
            <x-input-label for="skills" value="Skills" class="text-gray-300" />
            <x-text-input id="skills" name="skills" type="text"
                class="mt-1 block w-full bg-ai-primary/10 border border-white/20 text-white rounded-lg p-2.5 focus:border-ai-primary focus:ring-ai-primary placeholder-gray-500"
                :value="old('skills', $user->profile->skills ?? '')"
                placeholder="e.g. PyTorch, Next.js, Prompt Engineering" />
            <x-input-error class="mt-2 text-red-400" :messages="$errors->get('skills')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="github_url" value="GitHub URL" class="text-gray-300" />
                <x-text-input id="github_url" name="github_url" type="url"
                    class="mt-1 block w-full bg-ai-primary/10 border border-white/20 text-white rounded-lg p-2.5 focus:border-ai-primary focus:ring-ai-primary placeholder-gray-500"
                    :value="old('github_url', $user->profile->github_url ?? '')" placeholder="https://github.com/..." />
                <x-input-error class="mt-2 text-red-400" :messages="$errors->get('github_url')" />
            </div>

            <div>
                <x-input-label for="linkedin_url" value="LinkedIn URL" class="text-gray-300" />
                <x-text-input id="linkedin_url" name="linkedin_url" type="url"
                    class="mt-1 block w-full bg-ai-primary/10 border border-white/20 text-white rounded-lg p-2.5 focus:border-ai-primary focus:ring-ai-primary placeholder-gray-500"
                    :value="old('linkedin_url', $user->profile->linkedin_url ?? '')"
                    placeholder="https://linkedin.com/in/..." />
                <x-input-error class="mt-2 text-red-400" :messages="$errors->get('linkedin_url')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="bg-ai-primary hover:bg-ai-primary/80 transition text-white px-4 py-2 rounded-lg font-medium text-sm">Save</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
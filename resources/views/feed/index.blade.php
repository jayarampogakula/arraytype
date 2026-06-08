<x-app-layout>
    @auth
        @include('feed.partials.create-post')
    @endauth
    @include('feed.partials.post-list')
</x-app-layout>
@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-ai-primary text-sm font-medium leading-5 text-ai-primary dark:text-gray-100 focus:outline-none focus:border-ai-primary transition duration-150 ease-in-out'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-gray-500 focus:outline-none focus:text-gray-900 dark:focus:text-gray-200 focus:border-gray-300 dark:focus:border-gray-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
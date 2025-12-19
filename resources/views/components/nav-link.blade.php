@props(['active'])

@php
$classes = ($active ?? false)
    ? 'relative inline-flex items-center px-3 py-2 text-sm font-semibold text-blue-600 dark:text-blue-400 
       after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:w-full after:bg-blue-500 after:rounded-full'
    : 'relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400
       hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

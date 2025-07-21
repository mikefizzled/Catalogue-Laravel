@props(['active'])

@php
$classes = ($active ?? false)
            ? 'text-gray-900 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-100 hover:scale-110 text-lg'
            : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:scale-110 text-lg';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

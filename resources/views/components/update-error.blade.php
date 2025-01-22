@props(['class' => 'text-m opacity-70 dark:text-gray-400'])

<p {{ $attributes->merge(['class' => "font-semibold text-l text-gray-800 dark:text-gray-200 $class"]) }}>
    {{ $slot }}
</p>

@props(['class' => ''])

<h3 {{ $attributes->merge(['class' => "font-semibold text-l text-gray-800 dark:text-gray-200 $class"]) }}>
    {{ $slot }}
</h3>

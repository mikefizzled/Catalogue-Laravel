@props(['class' => ''])

<p {{ $attributes->merge(['class' => "text-l text-gray-800 dark:text-gray-200 $class"]) }}>
    {{ $slot }}
</p>

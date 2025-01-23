@props(['class' => ''])

<h2 {{ $attributes->merge(['class' => "font-bold text-xl text-gray-800 dark:text-gray-100 $class"]) }}>
    {{ $slot }}
</h2>

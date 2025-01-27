@props(['for', 'class' => ''])

<label for="{{ $for }}" {{ $attributes->merge(['class' => "block text-m font-medium text-gray-700 dark:text-gray-300 $class"]) }}>
    {{ $slot }}
</label>

{{-- resources/views/components/form/select.blade.php --}}
@props([
  'name',
  'options' => [],
  'selected' => null,
    'value'    => '',
  'disabled' => false,
    'required' => false,
])

  <input
    type="text"
    name="{{ $name }}"
    id="{{ $name }}"
    value="{{ $value }}"
    {{ $required ? 'required' : '' }}
  {{ $attributes->merge([
    'class' => 'mt-1 w-full px-3 py-1 text-md rounded-md
               text-gray-900 dark:text-gray-100
               border-gray-300 dark:border-gray-700
               bg-white dark:bg-gray-800
               focus:border-indigo-500 focus:ring-indigo-500
               shadow-sm'
  ]) }}
>

</input>
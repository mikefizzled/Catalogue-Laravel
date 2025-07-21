@props([
  'name',
  'label',
  'value'    => '',
  'required' => false,
])

<div class="py-2">
  <x-form.label :for="$name">
    {{ $label }}
  </x-form.label>

  <input
    type="text"
    name="{{ $name }}"
    id="{{ $name }}"
    value="{{ $value }}"
    {{ $required ? 'required' : '' }}
    {{ $attributes->merge(['class' => 'mt-1 block w-full p-3
      text-gray-900 dark:text-gray-400
      border-gray-300 dark:border-gray-700 
      bg-gray-50 dark:bg-gray-900
      focus:border-indigo-500 focus:ring-indigo-500 
      shadow-sm focus:shadow-md']) }}
  />
  @error($name)
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

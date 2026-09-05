{{-- resources/views/components/form/select.blade.php --}}
@props([
  'name',
  'id' => null,
  'options' => [],
  'selected' => null,
  'disabled' => false,
])

<select
  name="{{ $name }}"
  id="{{ $id ?? $name }}"
  @disabled($disabled)
  {{ $attributes->merge([
    'class' => 'mt-1 w-full px-3 py-1 text-md rounded-md
               text-gray-900 dark:text-gray-100
               border-gray-300 dark:border-gray-700
               bg-white dark:bg-gray-800
               focus:border-indigo-500 focus:ring-indigo-500
               shadow-sm'
  ]) }}
>
  <option value="" disabled {{ is_null($selected) || $selected === '' ? 'selected' : '' }}>
    — Select —
  </option>

  @foreach($options as $value => $text)
    <option value="{{ $value }}" {{ (string)$value === (string)$selected ? 'selected' : '' }}>
      {{ $text }}
    </option>
  @endforeach
</select>
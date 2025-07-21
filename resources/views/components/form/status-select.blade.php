@props([
  'list',
  'selected' => '',
])

@php

  $options = config('statuses.defaults', []);
  $name = "statuses[{$list->id}]";
  $label   = $list->short_name;
  $id   = $list->import_name;
@endphp

<div class="py-2">

  <x-form.label :for="$id">
    {{ $label }}
  </x-form.label>
  <select
    name="{{ $name }}"
    id="{{ $id }}"
    class='mt-1 block w-full p-3
                  text-gray-900 dark:text-gray-400
                  border-gray-300 dark:border-gray-700
                  bg-gray-50 dark:bg-gray-900
                  focus:border-indigo-500 focus:ring-indigo-500
                  shadow-sm focus:shadow-md'
    required
  >
    <option value="" disabled {{ $selected === '' ? 'selected' : '' }}>
      — Select —
    </option>

    @foreach($options as $value => $label)
      <option
        value="{{ $value }}"
        {{ (string)$value === (string)$selected ? 'selected' : '' }}
      >
        {{ $label }}
      </option>
    @endforeach
  </select>

  @error(str_replace(['[',']'], ['.',''], $name))
    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
  @enderror
</div>

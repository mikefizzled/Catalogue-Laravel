{{-- resources/views/components/form/select.blade.php --}}
@props([
  'name',
  'id',               // e.g. "genus_id" or "statuses[3]"
  'label',              // the text for the <label>
  'options'  => [],     // array of option arrays or objects
  'optionId' => null,           // the key/property for the <option value>
  'optionLabel' => null,        // the key/property for the <option text>
  'selected' => null,   // the current value to mark as selected
  'disabled' => false,
])

<div class="py-2">
  {{-- 1) Label --}}
  <x-form.label :for="$name">
    {{ $label }}
  </x-form.label>

  {{-- 2) Select --}}
  <select
    name="{{ $name }}"
    id="{{ $id }}"
    @disabled($disabled)
    {{ $attributes->merge([
      'class' => 'mt-1 block w-full p-3
                  text-gray-900 dark:text-gray-400
                  border-gray-300 dark:border-gray-700
                  bg-gray-50 dark:bg-gray-900
                  focus:border-indigo-500 focus:ring-indigo-500
                  shadow-sm focus:shadow-md'
    ]) }}
  >
    <option value="" disabled {{ is_null($selected) ? 'selected' : '' }}>
      — Select —
    </option>

  @foreach($options as $value => $text)
      <option value="{{ $value }}"
              {{ (string)$value === (string)$selected ? 'selected' : '' }}>
        {{ $text }}
      </option>
    @endforeach
  </select>

  {{-- 3) Error message --}}
  @error($name)
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

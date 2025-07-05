@props([
  'name',
  'label'       => null,
  'help'        => null,
  'accept'      => null,
  'required'    => false,
  'disabled'    => false,
])

<div class="py-2">
    
  @if($label)
    <x-form.label :for="$name">
    {{ $label }}
  </x-form.label>
  @endif

  {{-- 2) Input --}}
  <input
    type="file"
    name="{{ $name }}"
    id="{{ $name }}"
    @if($accept) accept="{{ $accept }}" @endif
    @disabled($disabled)
    {{ $required ? 'required' : '' }}
    {{ $attributes->merge([
      'class' => 'mt-1 block w-full p-2 
      text-gray-900 dark:text-gray-400
      border border-gray-300 cursor-pointer 
      bg-gray-50 dark:bg-gray-900
      dark:border-gray-700
      focus:outline-none'
    ]) }}
    aria-describedby="{{ $help ? $name . '_help' : null }}"
  />

  {{-- 3) Help text --}}
  @if($help)
    <p id="{{ $name }}_help" class="mt-1 text-sm text-gray-500 dark:text-gray-400">
      {{ $help }}
    </p>
  @endif

  {{-- 4) Error message --}}
  @error($name)
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

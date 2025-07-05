@props([
    'disabled' => false, 
    'label',
    'options', 
    'optionLabel', 
    'optionId'])
<div class="py-2">
    <x-form.label :for="$name">
        {{ $label }}
    </x-form.label>
    <select name="{{ $name }}" @disabled($disabled) {{ $attributes->merge(['class' => '
        mt-1 block w-full p-3
        text-gray-900 dark:text-gray-400
        border-gray-300 dark:border-gray-700 
        bg-gray-50 dark:bg-gray-900
        focus:border-indigo-500 focus:ring-indigo-500 
        shadow-sm focus:shadow-md']) }}>
        <option value="" selected disabled> -- Select --</option>
        @foreach ($options as $option)
            <option value="{{ $option[$optionId] }}" {{ $selected == $option[$optionId] ? 'selected' : '' }}>
                {{ $option[$optionLabel] }}
            </option>
        @endforeach
    </select>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
     @enderror
</div>
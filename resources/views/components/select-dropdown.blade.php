@props(['disabled' => false, 'options', 'optionLabel', 'optionId'])

<select name="{{ $name }}" @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
    <option value="" selected disabled> -- Select --</option>
    @foreach ($options as $option)
        <option value="{{ $option[$optionId] }}" {{ $selected == $option[$optionId] ? 'selected' : '' }}>
            {{ $option[$optionLabel] }}
        </option>
    @endforeach
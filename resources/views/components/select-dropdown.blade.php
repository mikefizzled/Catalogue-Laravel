@props(['disabled' => false, 'options', 'optionLabel', 'selected' => null])

<select @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
    <option value=""> -- Select --</option>
    @foreach ($options as $option)
        <option value="{{ $option->id }}" {{ $selected == $option->id ? 'selected' : '' }}>
            {{ $option[$optionLabel] }}
        </option>
    @endforeach
</select>

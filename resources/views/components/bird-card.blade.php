<a href="{{ $url }}">
  <div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-500 hover:shadow-lg hover:scale-105 transition-transform']) }}>
    <img src="{{ $thumbnail }}" alt="Thumbnail of {{ $name }}" class="w-full object-cover">
    <p class="text-center font-medium text-gray-900 dark:text-gray-100 py-1">
      {{ $name }}
    </p>
  </div>
</a>
      

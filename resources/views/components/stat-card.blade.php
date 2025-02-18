@props(['title', 'count'])

<div class="bg-white dark:bg-gray-800 p-6 shadow-sm rounded-lg text-center">
    <h3 class="text-lg font-bold dark:text-gray-100">{{ $title }}</h3>
    <p class="text-3xl font-semibold dark:text-gray-200">{{ $count }}</p>
</div>

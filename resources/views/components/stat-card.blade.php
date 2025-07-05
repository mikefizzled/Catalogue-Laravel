@props(['title', 'count'])

<div class="bg-gray-200 dark:bg-gray-700 p-4 shadow-md hover:shadow-lg text-center">
    <h2 class="text-xl font-bold dark:text-gray-100">{{ $title }}</h2>
    <p class="text-xl font-semibold dark:text-gray-200">{{ $count }}</p>
</div>

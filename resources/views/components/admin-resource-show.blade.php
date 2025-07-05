@props(['heading','pageTitle'])

<x-public-app-layout>
  @section('title', $pageTitle)

  <div class="min-h-[85vh] max-w-screen-xl mx-auto space-y-2">

    <header class="bg-white dark:bg-gray-800/90 shadow-md px-6 py-4 flex items-center justify-between">
      <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $heading }}</h1>
      <div class="flex space-x-2">
        {{ $actions ?? '' }}
      </div>
    </header>

    <div class="bg-white dark:bg-gray-800/90 backdrop-blur-sm shadow-md px-6 py-4 space-y-6 mx-1">
      {{ $slot }}
    </div>

  </div>
</x-public-app-layout>

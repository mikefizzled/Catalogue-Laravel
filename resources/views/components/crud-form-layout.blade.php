@props([
  'heading',
  'pageTitle',
])

<x-public-app-layout>
    <div class="min-h-[85vh] max-w-screen-xl mx-auto">
        <header class="bg-white dark:bg-gray-800/90 backdrop-blur-sm shadow mb-2">
            <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
                <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                    {{ $heading }}
                </h1>
                @section('title', $pageTitle)
            </div>
        </header>

        {{-- Main content wrapper --}}
        <div class="bg-white dark:bg-gray-800/90 max-w-7xl mx-1 p-4">
         {{ $slot }} 
        </div>
    </div>
</x-public-app-layout>

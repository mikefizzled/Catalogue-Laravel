@section('title', 'Sightings Map')

@vite(['resources/js/completeMap.js'])

<x-public-app-layout>
    <div class="min-h-[85vh] bg-gray-200 dark:bg-gray-900">
        <div class="px-2 sm:px-4 py-2 max-w-7xl mx-auto">
        <div class="text-center mb-2 mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Sightings Map</h1>
            <p class="mt-3 text-lg text-gray-700 dark:text-gray-300">
                Explore the map to see where birds have media recorded. Click on a marker for more details.
            </p>
        </div>
        <div class="flex-grow bg-white dark:bg-gray-800 rounded-lg shadow-lg p-2">
            <div id="map" class="rounded-md shadow w-full h-[650px] mt-2" title="Map of recorded species at locations" aria-label="Interactive map showing species by location"></div>
        </div>
    </div>
    </div>
</x-public-app-layout>

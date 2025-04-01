@section('title', 'Sightings Map')

@vite(['resources/js/completeMap.js'])

<x-public-app-layout>
    <div class="max-w-7xl mx-auto py-2 px-4">
        <div class="text-center my-2">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Sightings Map</h1>
            <p class="mt-3 text-lg text-gray-700 dark:text-gray-300">
                Explore the map to see where birds have media recorded. Click on a marker for more details.
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4">
            <div id="map" style="height:800px;" class="rounded-md shadow"></div>
        </div>
    </div>
</x-public-app-layout>

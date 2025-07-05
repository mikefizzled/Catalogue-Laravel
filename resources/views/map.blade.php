@section('title', 'Sightings Map')

@vite(['resources/js/completeMap.js'])

<x-public-app-layout>
    <div class="max-w-screen-xl mx-auto pb-2 space-y-2">
        <div class="bg-white dark:bg-gray-800/90 shadow-xl px-6 py-6">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Sightings Map</h1>
            <p class="text-md text-gray-600 dark:text-gray-300 mb-2">
                Explore the map to see where birds have media recorded. Click on a marker for more details.
            </p> 
        </div>
        
        <div 
            id="map" 
            class="mx-1 h-1/2 md:h-[500px] lg:h-[650px] shadow-xl " 
            title="Map of recorded species at locations" 
            aria-label="Interactive map showing species by location">
        </div>

    </div> 
</x-public-app-layout>

@section('title', 'Taxonomy')

@vite(['resources/js/taxonomyChart.js'])

<x-public-app-layout>
        <div class="min-h-[85vh] max-w-screen-xl mx-auto space-y-2">
            <div class="bg-white dark:bg-gray-800/90 backdrop-blur-sm shadow-xl px-6 py-6">
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white">Taxonomic Tree</h1>
            <p class="text-gray-600 dark:text-gray-300 mt-2">
                The taxonomic tree shows how species in the database are grouped within their scientific hierarchy.
                It`s a simplified view built from Class → Order → Family → Genus → Species, leaving out intermediate ranks such as infraorders or superfamilies.
                The diagram is generated dynamically to explore relationships across groups, rather than depict evolutionary ancestry.
            </p>
        <!-- Genera Toggle -->
        <div class="flex justify-center mt-2">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" id="toggleGenera" class="form-checkbox">
                <span class="text-gray-600 dark:text-gray-300 ">Include Genera</span>
            </label>
        </div>
        <p class="text-gray-600 dark:text-gray-300 mt-2 text-sm">Hover over the families and species to see more info!</p>
        </div>
        <!-- Chart -->
        <div class="relative">
            <div id="tooltip" class="absolute hidden bg-white border border-gray-300 "></div>
            <div id="chart"  class="bg-gray-100 shadow-lg overflow-auto pb-40"></div>
        </div>

    </div>
</x-public-app-layout>

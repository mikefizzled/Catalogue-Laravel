
@section('title', 'Taxonomy')

@vite(['resources/js/taxonomyChart.js'])

<x-public-app-layout>
        <div class="min-h-[85vh] max-w-screen-xl mx-auto space-y-2">
            <div class="bg-white dark:bg-gray-800/90 backdrop-blur-sm shadow-xl px-6 py-6">
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white">Taxonomic Tree</h1>
            <p class="text-gray-600 dark:text-gray-300 mt-2">
                To help visualise the taxonomic relationship between the species featured, a <a href="https://observablehq.com/@d3/cluster/2" class="underline">D3 cluster tree </a> is used to dynamically create a visual representation of the birds in the database.
                While it does not represent the evolutionary relationships seen in a phylogentic tree, the dendrogram can help establish the similarities within taxonomic classifications.
                <br>
                Class → Orders → Families → Genera → Species
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
            <div id="chart" class="bg-gray-100 shadow-lg  overflow-auto"></div>
        </div>

    </div>
</x-public-app-layout>

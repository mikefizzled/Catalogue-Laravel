
@section('title', 'Taxonomy')

@vite(['resources/js/taxonomyChart.js'])

<x-public-app-layout>
    <div class="min-h-[85vh] bg-gray-200 dark:bg-gray-900">
        <div class="px-2 sm:px-4 py-2 max-w-7xl mx-auto">
        <div class="text-center pb-2 mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Taxonomic Tree</h1>
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
        <div class="my-2 text-center">
           
        </div>
        <!-- Chart -->
        <div class="flex justify-center">
            <div id="tooltip" class="absolute hidden bg-white border border-gray-300 p-2 shadow-md rounded-md"></div>
            <div id="chart" class="bg-gray-100 rounded-lg shadow-lg"></div>
        </div>

    </div>
</x-public-app-layout>

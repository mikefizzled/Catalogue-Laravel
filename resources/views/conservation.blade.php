<x-public-app-layout>
    <div class="max-w-7xl min-h-[85vh] mx-auto p-2 bg-white dark:bg-gray-900 shadow-lg rounded-lg">
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Conservation Lists Overview</h1>
            <p class="text-gray-600 dark:text-gray-300 mt-2">
                This table presents key conservation lists relevant to our project. These documents track species conservation statuses
                across different years, helping us analyze trends and shifts in conservation priorities. By maintaining references to these lists,
                we ensure accurate, historical data integration for better decision-making.
            </p>
        </div>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700" aria-label="Table of Birds of Conservation Concern by the British Birds Journal">
                <thead class="text-xs uppercase bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-300">
                    <tr>
                        <th class="px-6 py-3">Short Name</th>
                        <th class="px-6 py-3">Year</th>
                        <th class="px-6 py-3">Full Report Name</th>
                        <th class="px-6 py-3">Authors</th>
                        <th class="px-6 py-3">File</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($conservationLists as $list)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $list->short_name }}</td>
                            <td class="px-6 py-4">{{ $list->year }}</td>
                            <td class="px-6 py-4">{{ $list->full_name }}</td>
                            <td class="px-6 py-4">{{ $list->authors }}</td>
                            <td class="px-6 py-4">
                                @if($list->filename)
                                    <a href="{{ asset('storage/' . $list->filename) }}" class="text-blue-300 hover:underline">View PDF</a>                                @else
                                    <span class="text-gray-200 italic">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-public-app-layout>

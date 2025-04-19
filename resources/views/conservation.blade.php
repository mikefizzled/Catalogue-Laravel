<x-public-app-layout>
    <div class="min-h-[85vh] bg-gray-200 dark:bg-gray-900">
        <div class="px-2 sm:px-4 py-2 max-w-7xl mx-auto">
            <div class="max-w-7xl  mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow text-center ">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Conservation Overview</h1>
            <p class="text-gray-600 dark:text-gray-300 mt-2 p-2">
                This table contains the reports used for conservation data throughout the project. The inclusion of these was to help better reflect conservation efforts and trends over time.
                <br>
                These were used with permission from the journal of British Birds.
            </p>
        </div>
        </div>
        <div class="overflow-x-auto max-w-7xl mx-auto md:p-6">
            <table class="w-full text-xs md:text-sm text-left text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700" aria-label="Table of Birds of Conservation Concern by the British Birds Journal">
                <thead class="uppercase bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-300">
                    <tr>
                        <th class="p-2 md:p-4">Short Name</th>
                        <th class="p-2 md:p-4">Year</th>
                        <th class="p-2 md:p-4">Full Report Name</th>
                        <th class="p-2 md:p-4">Authors</th>
                        <th class="p-2 md:p-4">File</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($conservationLists as $list)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="p-2 md:p-4">{{ $list->short_name }}</td>
                            <td class="p-2 md:p-4">{{ $list->year }}</td>
                            <td class="p-2 md:p-4">{{ $list->full_name }}</td>
                            <td class="p-2 md:p-4">{{ $list->authors }}</td>
                            <td class="p-2 md:p-4">
                                @if($list->filename)
                                    <a href="{{ asset('storage/' . $list->filename) }}" class="text-blue-700 hover:underline">View PDF</a>                                @else
                                    <span class="text-gray-700 dark:text-gray-500 italic">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-public-app-layout>

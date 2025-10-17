<x-public-app-layout>
    <div class="min-h-[85vh] max-w-screen-xl mx-auto space-y-2">
        <!-- Heading Section -->
        <div class="bg-white dark:bg-gray-800/90 shadow-xl px-6 py-6">
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">Conservation Data Sourcing</h1>
            <p class="text-md text-gray-600 dark:text-gray-300 mt-2">
                Conservation status information on this site is based on the official <em>Birds of Conservation Concern</em> reports published by <em>British Birds</em>.
                <br>
                Used with permission, these data show how species` conservation listings have changed over time.
            </p>
        </div>

        <!-- Data Table -->
        <div class="overflow-x-auto mx-1">
            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700" aria-label="Birds of Conservation Concern Reports">
                <thead class="uppercase bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-1 py-3 md:p-3">Short Name</th>
                        <th scope="col" class="px-1 py-3 md:p-3">Year</th>
                        <th scope="col" class="p-3">Full Report Name</th>
                        <th scope="col" class="p-3">Authors</th>
                        <th scope="col" class="px-1 py-3 md:p-3">File</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($conservationLists as $index => $list)
                        <tr class="{{ $index % 2 === 0 ? 'bg-white dark:bg-gray-800' : 'bg-gray-50 dark:bg-gray-700' }} border-b dark:border-gray-600">
                            <td class="px-1 py-3 md:p-3 font-medium">{{ $list->short_name }}</td>
                            <td class="px-1 py-3 md:p-3">{{ $list->year }}</td>
                            <td class="p-3">{{ $list->full_name }}</td>
                            <td class="p-3">{{ $list->authors }}</td>
                            <td class="px-1 py-3 md:p-3">
                                @if($list->filename)
                                    <a href="{{ $list->filename }}"
                                    class="text-blue-700 hover:underline inline-flex items-center gap-1"
                                    target="_blank" rel="noopener">
                                        <span>View PDF</span>
                                    </a>
                                @else
                                    <span class="italic text-gray-500 dark:text-gray-400">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-public-app-layout>

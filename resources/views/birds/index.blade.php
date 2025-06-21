<x-public-app-layout>
    @section('title', 'Bird Catalogue')

    <div class="min-h-[85vh] bg-gray-200 dark:bg-gray-900">
        <div class="px-2 sm:px-4 py-2 max-w-7xl mx-auto">
            <div class="max-w-7xl  mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow text-center">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Bird Catalogue</h1>
                <label for="taxon" id="taxon-label" class="block text-sm font-medium text-gray-700 dark:text-gray-200 my-2">
                    Filter by Family (grouped by Order)
                </label>
                <select
                    name="family"
                    id="taxon"
                    aria-labelledby="taxon-label"
                    class="block w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:text-gray-200 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <option value="">All families</option>
                    @foreach ($orders as $order)
                        <optgroup label="{{ $order['order_name'] }}">
                            @foreach ($order['families'] as $family)
                                <option value="{{ $family['slug'] }}" {{ request('family') == $family['slug'] ? 'selected' : '' }}>
                                    {{ $family['common_name'] }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>

            </div>
            <div class="py-2 mt-2">
                {{ $animals->links() }}
                </div>
            <div class="py-2">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4" id="results">
                        @forelse ($animals as $bird)
                            <a href="{{ route('birds.show', $bird) }}">
                                <div class="card bg-white dark:bg-gray-800 shadow-md rounded-lg border border-gray-600 hover:scale-105 transition-transform">
                                    <!-- Thumbnail -->
                                    <img src="{{ $bird->thumbnail_url }}" alt="Thumbnail of {{ $bird->common_name }}" class="w-full object-cover rounded-md">
                                    <!-- Name -->
                                    <p class="text-center text-md font-medium text-gray-900 dark:text-gray-100 mt-2">{{ $bird->common_name }}</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-200 col-span-full">No animals found.</p>
                        @endforelse
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-public-app-layout>

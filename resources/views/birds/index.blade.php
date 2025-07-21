<x-public-app-layout>
    <div class="min-h-[85vh] max-w-screen-xl mx-auto">
        <div class="bg-white dark:bg-gray-800/90 backdrop-blur-sm shadow-xl px-6 py-6 mb-2">
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">Birds List</h1>
            <p class="text-md text-gray-600 dark:text-gray-300 mb-4">
                Filter by Family (grouped by Order)
            </p>
            <label for="taxon" id="taxon-label" class="sr-only">Filter by Family</label>
            <select
                name="family"
                id="taxon"
                aria-labelledby="taxon-label"
                class="w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:text-gray-200 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
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
        <div class="bg-white dark:bg-gray-800/90 backdrop-blur-sm shadow-xl px-6 py-6 mx-1">
            <div class="px-2 space-y-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-4" id="results">
                    @forelse ($animals as $bird)
                        <x-bird-card
                            :url="route('birds.show', $bird)"
                            :thumbnail="$bird->thumbnail_url"
                            :name="$bird->common_name"
                        />
                    @empty
                        <p class="text-center text-gray-500 dark:text-gray-200 col-span-full">No animals found.</p>
                    @endforelse
                </div>
            </div>
        </div>

        @if($animals->total() > 0 && $animals->lastPage() === 1)
            <div class="p-2">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Showing {{ $animals->firstItem() }} to {{ $animals->lastItem() }} of {{ $animals->total() }} results
                </p>
            </div>
        @elseif($animals->hasPages())
            <div class="p-2">
                {{ $animals->links() }}
            </div>
        @endif
    </div>
</x-public-app-layout>

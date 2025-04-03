<x-public-app-layout>
@section('title', 'Bird Catalogue')
<div class="p-4 px-8 text-center text-white bg-gray-800 flex flex-wrap justify-center border border-gray-700 dark:bg-gray-900">
       <div>
        <div class="max-w-7xl mx-aut p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Animal Catalogue</h1>
            <div class="mb-4 text-center">
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    Select an Order and/or Family to filter
                </p>
            </div>
            <div class="flex flex-wrap justify-center gap-6">
                <div class="w-full sm:w-1/2 md:w-1/3">
                    <label for="orders" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order</label>
                    <select id="orders" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All</option>

                        @foreach ($orders as $order)
                            <option value="{{ $order->id }}" {{ request('order') == $order->id ? 'selected' : '' }}>{{ $order->order_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full sm:w-1/2 md:w-1/3">
                    <label for="families" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Family</label>
                    <select id="families" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All</option>

                        @foreach ($families as $family)
                            <option value="{{ $family->id }}" {{ request('family') == $family->id ? 'selected' : '' }}>{{ $family->family_name }} - {{$family->common_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <script>
            document.addEventListener("DOMContentLoaded", () => {
                const ordersSelect = document.getElementById("orders");
                const familiesSelect = document.getElementById("families");
            
                ordersSelect.addEventListener("change", applyFilters);
                familiesSelect.addEventListener("change", applyFilters);
            

                
                function applyFilters() {
                    const order = ordersSelect.value;
                    const family = familiesSelect.value;
            
                    let url = new URL(window.location.href);
                    if (order) {
                        url.searchParams.set("order", order);
                    } else {
                        url.searchParams.delete("order");
                    }
                    if (family) {
                        url.searchParams.set("family", family);
                    } else {
                        url.searchParams.delete("family");
                    }

                    window.location.href = url.toString();
                }
                
            
            });

            
        </script>
        </div>
        

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
                @forelse ($animals as $bird)
                    <a href="{{ route('catalogue.show', ['animal' => $bird->id]) }}">
                        <div class="card bg-white dark:bg-gray-800 shadow-md rounded-lg border border-gray-600  hover:scale-105 transition-transform  ">
                            <!-- Thumbnail -->
                            <img src="{{ $bird->thumbnail_url }}" alt="{{ $bird->common_name }}"   class="w-full h-50 object-cover rounded-md">
                            <!-- Name -->
                            <p class="text-center text-md font-medium text-gray-900 dark:text-gray-100 mt-2">{{ $bird->common_name }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-center text-gray-500 dark:text-gray-400 col-span-full">No animals found.</p>
                @endforelse
            </div>
            {{ $animals->links() }}
            
        </div>
    </div>
</x-public-app-layout>

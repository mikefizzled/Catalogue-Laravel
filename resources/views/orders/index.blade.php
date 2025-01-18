<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ request()->routeIs('orders.index') ? 'Taxonomic Orders' : 'Trash'}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @forelse ($orders as $order)
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="font-bold text-xl dark:text-gray-100">
                        {{ $order->order_name }}
                    </h2>
                </div>
            </div>
            @empty
            <p>There are no orders added yet</p>
            @endforelse
            {{ $orders->links()}}
        </div>
    </div>
</x-app-layout>

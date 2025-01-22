<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Order
        </h2>
        @section('title', 'Create Order')
    </x-slot>
    <x-crud-layout>
        <x-slot name="inside">
            <form action="{{ route('orders.create') }}" method="post">
                @csrf
                <div class="py-2">
                    <h3 class="font-semibold text-l text-gray-800 dark:text-gray-200">Order Name</h3>
                    <x-text-input name="order_name-name" class="w-full mt-2" placeholder="Order Name" value=""></x-text-input>
                    
                    @error('order_name')
                        <div class="text-sm mt-1 text-red-500"> {{ $message }}</div>
                    @enderror
                </div>
                <div class="py-2 flex gap-4">
                    <x-primary-button class="mt-1">Save Order</x-primary-button>
                    <x-link-button href="{{url()->previous()}}" class="mt-1">Go Back</x-link-button>
                </div>
            </form>
        </x-slot>
    </x-crud-layout>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <x-h2>
            Edit Order
        </x-h2>
        @section('title', $order->order_name.' - Edit Order')
    </x-slot>
    <x-crud-layout>
        <x-slot name="inside">
            <form action="{{ route('admin.orders.update', $order) }}" method="post">
                @method('put')
                @csrf
                <div class="py-2">
                    <x-h3>Order Name</x-h3>
                    <x-text-input name="order_name" class="w-full mt-2" placeholder="Order Name" value="{{ @old('order_name', $order->order_name)}}"></x-text-input>
                    
                    @error('order_name')
                        <x-update-error class="mt-2">{{ $message }}</x-update-error>
                    @enderror
                </div>
                <div class="py-2 my-2 flex gap-4">
                    <x-primary-button>Save Order</x-primary-button>
                    <x-link-button href="{{ route('admin.orders.show', $order) }}">Go Back</x-link-button>
                </div>
            </form>
        </x-slot>
    </x-crud-layout>
</x-app-layout>

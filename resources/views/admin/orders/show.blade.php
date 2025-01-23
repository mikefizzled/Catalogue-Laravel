<x-app-layout>
    <x-slot name="header">
        <x-h2>
            Orders
        </x-h2>
        @section('title', $order->order_name.' - View Order')
    </x-slot>

    <x-crud-layout>
        <x-slot name="outside">
            <div class="flex gap-2 py-1">
                <p class="opacity-70 dark:text-gray-400 "><strong>Created: </strong>{{ $order->created_at->diffForHumans() }}</p>
                <p class="opacity-70 dark:text-gray-400"><strong>Last Changed: </strong>{{ $order->updated_at->diffForHumans() }}</p>
            </div>
            <div class="flex gap-2 py-2">
                <x-link-button href="{{ route('admin.orders.edit', $order)}}" class="ml-auto">Edit Order</x-link-button>
                <x-link-button class="bg-red-400 hover:bg-red-600 focus:bg-red-600" 
                    onclick="return confirm('Move note to trash?')">
                        Delete Order</x-link-button>
                {{-- 
                <form action="{{ route('admin.notes.destroy', $note) }}" method="post">
                    @method('delete')
                    @csrf
                    <x-primary-button class="bg-red-400 hover:bg-red-600 focus:bg-red-600" onclick="return confirm('Move note to trash?')">
                        Trash Note
                    </x-primary-button>
                </form>--}}
            </div>
        </x-slot>
        <x-slot name="inside">
            <div class="pb-2">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 ">
                    {{ $order->order_name }}
                </h2>
            </div>
            <div class="py-2">
                <x-h3>Parent Class</x-h3>
                <p class="opacity-70 dark:text-gray-400">Aves</p>
            </div>
            <div class="py-2"> 
                <x-h3>Associated Families</x-h3> 
                <ul class="list-disc list-inside"> 
                    @forelse($order->families as $family) 
                        <li class="opacity-70 dark:text-gray-400"><a href="{{route('admin.families.show', $family)}}">{{ $family->family_name }}</a></li> 
                    @empty 
                        <li class="opacity-70 dark:text-gray-400">No families found.</li> 
                    @endforelse 
                </ul> 
            </div>
        </x-slot>
    </x-crud-layout>
</x-app-layout>

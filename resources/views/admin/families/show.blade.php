<x-app-layout>
    <x-slot name="header">
        <x-h2>
            Families
        </x-h2>
        @section('title', $family->family_name)
    </x-slot>

    <x-crud-layout>
        <x-slot name="outside">
            <div class="flex gap-2 py-1">
                <p class="opacity-70 dark:text-gray-400 "><strong>Created: </strong>{{ $family->created_at->diffForHumans() }}</p>
                <p class="opacity-70 dark:text-gray-400"><strong>Last Changed: </strong>{{ $family->updated_at->diffForHumans() }}</p>
            </div>
            <div class="flex gap-2 py-2">
                <x-link-button href="{{ route('admin.families.edit', $family)}}" class="ml-auto">Edit Family</x-link-button>
                <x-link-button class="bg-red-400 hover:bg-red-600 focus:bg-red-600" 
                    onclick="return confirm('Move note to trash?')">
                        Delete Family</x-link-button>
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
                <x-h2>
                    {{ $family->family_name }}
                </x-h2>
            </div>
            <div class="py-2">
                <x-h3>Common Names</x-h3>
                <p class="opacity-70 dark:text-gray-400">{{ $family->common_name}}</p>
            </div>
            <div class="py-2">
                <x-h3>Parent Order</x-h3>
                <p class="opacity-70 dark:text-gray-400"><a href="{{route('admin.orders.show', $family->order)}}">{{ $family->order->order_name}}</a></p>
            </div>
            <div class="py-2"> 
                <x-h3>Associated Genera</x-h3> 
                <ul class="list-disc list-inside"> 
                    @forelse($family->genera as $genus) 
                        <li class="opacity-70 dark:text-gray-400"><a href="{{route('admin.genera.show', $genus)}}">{{ $genus->genus_name }}</a></li> 
                    @empty 
                        <li class="opacity-70 dark:text-gray-400">No genera found.</li> 
                    @endforelse 
                </ul> 
            </div>
        </x-slot>
    </x-crud-layout>
</x-app-layout>

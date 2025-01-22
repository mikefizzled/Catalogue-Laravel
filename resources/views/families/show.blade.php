<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Families
        </h2>
    </x-slot>

    <x-crud-layout>
        <x-slot name="outside">
            <div class="flex gap-2 py-1">
                <p class="opacity-70 dark:text-gray-400 "><strong>Created: </strong>{{ $family->created_at->diffForHumans() }}</p>
                <p class="opacity-70 dark:text-gray-400"><strong>Last Changed: </strong>{{ $family->updated_at->diffForHumans() }}</p>
            </div>
            <div class="flex gap-2 py-2">
                <x-link-button href="{{ route('families.edit', $family)}}" class="ml-auto">Edit Family</x-link-button>
                <x-link-button class="bg-red-400 hover:bg-red-600 focus:bg-red-600" 
                    onclick="return confirm('Move note to trash?')">
                        Delete Family</x-link-button>
                {{-- 
                <form action="{{ route('notes.destroy', $note) }}" method="post">
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
                    {{ $family->family_name }}
                </h2>
            </div>
            <div class="py-2">
                <h3 class="font-semibold text-l text-gray-800 dark:text-gray-200">Common Names</h3>
                <p class="opacity-70 dark:text-gray-400">{{ $family->common_name}}</p>
            </div>
            <div class="py-2">
                <h3 class="font-semibold text-l text-gray-800 dark:text-gray-200">Parent Order</h3>
                <p class="opacity-70 dark:text-gray-400">{{ $family->order->order_name}}</p>
            </div>
            <div class="py-2"> 
                <h3 class="font-semibold text-l text-gray-800 dark:text-gray-200">Associated Genera</h3> 
                <ul class="list-disc list-inside"> 
                    @forelse($family->genera as $genus) 
                        <li class="opacity-70 dark:text-gray-400">{{ $genus->genus_name }}</li> 
                    @empty 
                        <li>No genera found.</li> 
                    @endforelse 
                </ul> 
            </div>
        </x-slot>
    </x-crud-layout>
</x-app-layout>

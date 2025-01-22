<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Genera
        </h2>
        @section('title', $genus->genus_name.' - View Genus')
    </x-slot>

    <x-crud-layout>
        <x-slot name="outside">
            <div class="flex gap-2 py-1">
                <p class="opacity-70 dark:text-gray-400 "><strong>Created: </strong>{{ $genus->created_at->diffForHumans() }}</p>
                <p class="opacity-70 dark:text-gray-400"><strong>Last Changed: </strong>{{ $genus->updated_at->diffForHumans() }}</p>
            </div>
            <div class="flex gap-2 py-2">
                <x-link-button href="{{ route('genera.edit', $genus)}}" class="ml-auto">Edit Genus</x-link-button>
                <x-link-button class="bg-red-400 hover:bg-red-600 focus:bg-red-600" 
                    onclick="return confirm('Move note to trash?')">
                        Delete Genus</x-link-button>
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
                    {{ $genus->genus_name }}
                </h2>
            </div>
            <div class="py-2">
                <h3 class="font-semibold text-l text-gray-800 dark:text-gray-200">Parent Family</h3>
                <p class="opacity-70 dark:text-gray-400">{{$genus->family->family_name}}</p>
            </div>
            <div class="py-2"> 
                <h3 class="font-semibold text-l text-gray-800 dark:text-gray-200">Member of Genus</h3> 
                <ul class="list-disc list-inside"> 
                    @forelse($genus->animals as $animal) 
                        <li class="opacity-70 dark:text-gray-400">{{ $animal->common_name }}</li> 
                    @empty 
                        <li class="opacity-70 dark:text-gray-400">No animals added to genus.</li> 
                    @endforelse 
                </ul> 
            </div>
        </x-slot>
    </x-crud-layout>
</x-app-layout>

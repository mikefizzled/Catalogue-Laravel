<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Genus
        </h2>
        @section('title', $genus->genus_name.' - Edit Genus')
    </x-slot>
    <x-crud-layout>
        <x-slot name="inside">
            <form action="{{ route('admin.genera.show', $genus) }}" method="post">
                @method('put')
                @csrf
                <div class="py-2">
                    <x-h3>Genus Name</x-h3>
                    <x-text-input name="genus_name" class="w-full mt-2" placeholder="Order Name" value="{{ @old('genus_name', $genus->genus_name)}}"></x-text-input>
                    
                    @error('genus_name')
                        <div class="text-m py-1 text-red-500"> {{ $message }}</div>
                    @enderror
                </div>
                <div class="py-2">
                    <x-h3>Parent Family</x-h3>    
                    <x-select-dropdown name="family_id" class="w-full mt-2" :options="$families" optionLabel="family_name" :selected="old('family_id', $genus->family_id)" />  
                </div>
                <div class="py-2 flex gap-4">
                    <x-primary-button class="mt-1">Save Order</x-primary-button>
                    <x-link-button href="{{ route('admin.genera.index')}}" class="mt-1">Go Back</x-link-button>
                </div>
            </form>
        </x-slot>
    </x-crud-layout>
</x-app-layout>

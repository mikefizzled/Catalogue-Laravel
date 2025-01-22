<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Family
        </h2>
    </x-slot>
    <x-crud-layout>
        <x-slot name="inside">
            <form action="{{ route('families.show', $family) }}" method="post">
                @method('put')
                @csrf
                <div class="py-2">
                    <h3 class="font-semibold text-l text-gray-800 dark:text-gray-200">Family Name</h3>
                    <x-text-input name="family_name-name" class="w-full mt-2" placeholder="Family Name" value="{{ @old('family_name', $family->family_name)}}"></x-text-input>
                    
                    @error('family_name')
                        <div class="text-sm mt-1 text-red-500"> {{ $message }}</div>
                    @enderror
                </div>
                <div class="py-2">
                    <h3 class="font-semibold text-l text-gray-800 dark:text-gray-200">Common Names</h3>
                    <x-text-input name="common_name" placeholder="Enter Family Common Names" value="{{ @old('common_name', $family->common_name)}}" class="w-full mt-2"></x-text-input>
                    
                    @error('common_name')
                        <div class="text-sm mt-2 text-red-500"> {{ $message }}</div>
                    @enderror
                </div>
                <div class="py-2">
                    <h3 class="font-semibold text-l text-gray-800 dark:text-gray-200">Parent Order</h3>    
                    <x-select-dropdown name="order_id" class="w-full mt-2" :options="$orders" optionLabel="order_name" :selected="old('order_id', $family->order_id)" />  
                </div>
                <div class="py-2 flex gap-4">
                    <x-primary-button class="mt-1">Save Family</x-primary-button>
                    <x-link-button href="{{url()->previous()}}" class="mt-1">Go Back</x-link-button>
                </div>
            </form>
        </x-slot>
    </x-crud-layout>
</x-app-layout>

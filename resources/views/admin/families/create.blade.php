<x-app-layout>
    <x-slot name="header">
        <x-h2>
            Create Family
        </x-h2>
        @section('title', 'Create Family')
    </x-slot>
    <x-crud-layout>
        <x-slot name="inside">
            <form action="{{ route('families.store') }}" method="post">
                @csrf
                <div class="py-2">
                    <x-h3>Family Name</x-h3>
                    <x-text-input name="family_name" class="w-full mt-2" placeholder="Family Name" value="{{ @old('family_name')}}"></x-text-input>
                    
                    @error('order_name')
                        <x-update-error class="mt-2"> {{ $message }}</x-update-error>
                    @enderror
                </div>
                <div class="py-2">
                    <x-h3>Common Names</x-h3>
                    <x-text-input name="common_name" placeholder="Family Common Names" value="{{ @old('common_name')}}" class="w-full mt-2"></x-text-input>
                    
                    @error('common_name')
                        <x-update-error class="mt-2"> {{ $message }}</x-update-error>
                    @enderror
                </div>
                <div class="py-2 gap-y-2">
                    <x-h3>Parent Order</x-h3>    
                    <x-select-dropdown name="order_id" class="w-full mt-2" :options="$orders" optionLabel="order_name" valueField="order_id"/>  
                    @error('order_id')
                    <x-update-error class="mt-2"> {{ $message }}</x-update-error>
                @enderror
                </div>
                <div class="py-2 my-2 flex gap-4">
                    <x-primary-button class="mt-1">Save Order</x-primary-button>
                    <x-link-button href="{{ route('families.index') }}">Go Back</x-link-button>
                </div>
            </form>
        </x-slot>
    </x-crud-layout>
</x-app-layout>

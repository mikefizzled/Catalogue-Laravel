<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @switch($taxonType)
            @case('orders') 
                Taxonomic Orders 
                @break 
            @case('families') 
                Taxonomic Families
                @break 
            @case('genera') 
                Taxonomic Genera 
                @break
            @endswitch
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @switch($taxonType)
            @case('orders') 
                <x-link-button href="{{ route('orders.index') }}"> + New Order </x-link-button>
                @break 
            @case('families') 
                <x-link-button href="{{ route('orders.index') }}"> + New Family </x-link-button>
                @break 
            @case('genera') 
            <x-link-button href="{{ route('orders.index') }}"> + New Genus </x-link-button>
                @break
        @endswitch
            
            @forelse ($taxa as $taxon)
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="font-bold text-l dark:text-gray-100">
                        @switch($taxonType)
                        @case('orders') 
                            {{ $taxon->order_name }}
                            @break 
                        @case('families') 
                            {{ $taxon->family_name }}
                            @break 
                        @case('genera') 
                            {{ $taxon->genus_name }}
                            @break
                    @endswitch
                        
                    </h2>
                </div>
            </div>
            @empty
            <p>There are no {{ $taxonType}} added yet</p>
            @endforelse
            {{ $taxa->links()}}
        </div>
    </div>
</x-app-layout>

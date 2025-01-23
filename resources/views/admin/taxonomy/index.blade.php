<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @switch($taxonType)
            @case('orders') 
                Taxonomic Orders
                @section('title', 'Orders')
                @break 
            @case('families') 
                Taxonomic Families
                @section('title', 'Families')
                @break 
            @case('genera') 
                Taxonomic Genera 
                @section('title', 'Genera')
                @break
            @endswitch
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @switch($taxonType)
            @case('orders') 
                <x-link-button href="{{ route('admin.orders.create') }}"> + New Order </x-link-button>
                @break 
            @case('families') 
                <x-link-button href="{{ route('admin.families.create') }}"> + New Family </x-link-button>
                @break 
            @case('genera') 
            <x-link-button href="{{ route('admin.orders.index') }}"> + New Genus </x-link-button>
                @break
        @endswitch
            
            @forelse ($taxa as $taxon)
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <span class="mb-2 text-xs dark:text-gray-500">
                    @switch($taxonType)                        
                        @case('families')   
                            {{ $taxon->order->order_name }} > {{$taxon->family_name}}
                            @break 
                        @case('genera') 
                        {{ $taxon->family->order->order_name }} > {{ $taxon->family->family_name }} > {{$taxon->genus_name}}
                            @break
                    @endswitch
                    </span>
                    <h2 class="font-bold text-xl dark:text-gray-100">
                        <a href="
                        @switch($taxonType)
                            @case('orders') 
                                {{ route('admin.orders.show', ['order' => $taxon->slug]) }}
                                @break 
                            @case('families') 
                                {{ route('admin.families.show', ['family' => $taxon->slug]) }}
                                @break 
                            @case('genera') 
                                {{ route('admin.genera.show', ['genus' => $taxon->slug]) }}
                                @break
                        @endswitch
                        ">
                            @switch($taxonType)
                                @case('orders') 
                                    {{ $taxon->order_name }}
                                    @break 
                                @case('families') 
                                    {{ $taxon->family_name }} - {{ $taxon->common_name }}
                                    @break 
                                @case('genera') 
                                    {{ $taxon->genus_name }}
                                    @break
                            @endswitch
                        </a>
                    </h2>
                    

                    <!-- span class="block text-xs mt-2 dark:text-gray-600">{{ $taxon->updated_at->diffForHumans() }}</span-->
                </div>
            </div>
            @empty
            <p>There are no {{ $taxonType}} added yet</p>
            @endforelse
            {{ $taxa->links()}}
        </div>
    </div>
</x-app-layout>

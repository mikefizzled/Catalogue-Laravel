<x-app-layout>
    <x-slot name="header">
        <x-h2>
            Birds
        </x-h2>
        @section('title', 'Manage Birds')
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <x-link-button href="{{ route('admin.animals.create') }}"> + New Bird </x-link-button>
            
                @forelse ($animals as $bird)
                <div class="p-6 sm:p-2 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex gap-6 items-center"> 
                    
                    <div class="flex-shrink-0 w-20 h-20 sm:w-24 sm:h-24 rounded-md p-1">

                        <img src="{{ $bird->thumbnail_url }}" alt="{{ $bird->common_name }}" class="w-full h-full object-cover rounded-md">
                    </div>
                    <div class="flex-1 max-w-xl">
                        <span class="mb-2 text-xs dark:text-gray-500 italic">
                            {{ $bird->scientific_name }}
                        </span>
                        <h2 class="font-bold text-xl dark:text-gray-100">
                            <a href="{{ route('admin.animals.index', ['animal' => $bird->slug]) }}">
                                {{ $bird->common_name }}
                            </a>
                        </h2>
                    </div>
                    <div class="ml-auto text-right">
                        <span class="block mt-4 text-sm opacity-70 text-gray-600 dark:text-gray-600">
                            <strong>Created: {{ $bird->created_at->diffForHumans() }}</strong><br>
                            <strong>Updated: {{ $bird->updated_at->diffForHumans() }}</strong>
                            
                        </span>
                    </div>
                    
                </div>
            @empty
                <p>There are no birds added yet</p>
            @endforelse
            {{ $animals->links() }}
            
        </div>
    </div>
</x-app-layout>

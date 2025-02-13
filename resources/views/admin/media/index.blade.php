<x-app-layout>
    <x-slot name="header">
        <x-h2>
            Birds
        </x-h2>
        @section('title', 'Manage Birds')
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <x-link-button href="{{ route('admin.media.create') }}"> + New Media </x-link-button>
            
                @forelse ($mediaItems as $media)
                <div class="p-6 sm:p-2 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex gap-6 items-center"> 
                    
                    <div class="flex-shrink-0 w-32 h-18 sm:w-32 sm:h-18 rounded-md p-1">

                        <img src="{{ $media->thumbnail_url }}" alt="{{ $media->thumbnail_url }}" class="w-full h-full object-cover rounded-md">
                    </div>
                    <div class="flex-1 max-w-xl">
                        <span class="mb-2 text-xs dark:text-gray-500 italic">
                            {{ $media->location->name }}
                        </span>
                        <h2 class="font-bold text-xl dark:text-gray-100"><!--href="  route('admin.media.show', ['media' => $media->slug]) }}"-->
                            <a>
                                {{ $media->animal->common_name }}
                            </a>
                        </h2>
                    </div>
                    <div class="ml-auto text-right">
                        <span class="block mt-4 pr-6 text-sm opacity-70 text-gray-600 dark:text-gray-400">
                            <strong>Created: {{ $media->created_at->diffForHumans() }}</strong><br>
                            <strong>Updated: {{ $media->updated_at->diffForHumans() }}</strong>
                            
                        </span>
                    </div>
                    
                </div>
            @empty
                <p>There is no media added yet</p>
            @endforelse
            {{ $mediaItems->links() }}
            
        </div>
    </div>
</x-app-layout>

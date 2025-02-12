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
                    
                    <div class="flex-shrink-0 w-20 h-20 sm:w-24 sm:h-24 rounded-md p-1">

                       
                    </div>
                    <div class="flex-1 max-w-xl">
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

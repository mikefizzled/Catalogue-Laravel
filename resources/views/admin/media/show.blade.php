<x-public-app-layout>
    <div class="min-h-[85vh] max-w-screen-xl mx-auto space-y-2">
        <div class="bg-white dark:bg-gray-800/90 shadow-xl px-6 py-6">
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">Media #{{ $media->id }}</h1>
            @section('title', 'Media ' . $media->id)
        </div>
        <div class="space-y-2 mx-1 ">
            <div class="bg-white dark:bg-gray-800 shadow p-5 space-y-2">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center ">
                    <div class="flex gap-x-2 py-2 opacity-80 dark:text-gray-400">
                        <p><strong>Created:</strong> {{ $media->created_at->format('F j, Y g:i A') }}</p>
                        <p><strong>Last Changed:</strong> {{ $media->updated_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex gap-x-2 py-2">
                        <x-link-button href="{{ route('admin.media.edit', $media) }}" class="ml-auto">Edit Media</x-link-button>
                        <x-link-button class="bg-red-400 hover:bg-red-600 focus:bg-red-600" onclick="return confirm('Move note to trash?')">Delete Media</x-link-button>
                    </div>
                </div>
    
                <div class="flex justify-center w-full">
                    @if($media->media_type === 'image')
                        <img src="{{ $media->media_url }}" 
                            alt="{{ $media->caption }}" 
                            class="w-full h-auto object-cover">
                        @elseif ($media->media_type === 'audio')
                        <div class="flex flex-col items-center">
                            <audio controls class="">
                                <source src="{{ $media->media_url}}">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    @endif
                </div>
                    <!-- Next Button -->
                <div class="flex justify-between py-2">
                    <!-- Previous Button -->
                    @if ($previous)
                        <x-link-button href="{{ route('admin.media.show', $previous->id) }}" class="bg-gray-400 hover:bg-gray-600">
                            ← Previous
                        </x-link-button>
                    @else
                        <x-link-button class="bg-gray-200 dark:bg-gray-700 cursor-not-allowed">
                            ← Previous
                        </x-link-button>
                    @endif
                    <!-- Next Button -->
                    @if ($next)
                        <x-link-button href="{{ route('admin.media.show', $next->id) }}" class="bg-gray-400 hover:bg-gray-600">
                            Next →
                        </x-link-button>
                    @else
                    <x-link-button class="bg-gray-200 dark:bg-gray-700 cursor-not-allowed">
                        Next →
                    </x-link-button>
                    @endif
                </div>
            </div>

            <!-- Info and Metadata Tables Side-by-Side -->
            <div class="bg-white dark:bg-gray-800 px-6 py-3 shadow-sm">
                <div class="py-2">
                    <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Details</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Media Info Table -->
                    <table class="w-full border-collapse dark:text-gray-100 text-left border border-gray-300 dark:border-gray-700 rounded-md">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700">
                                <th class="p-2 text-left">Media Info</th>
                                <th class="p-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="p-2">Animal:</th>
                                <td class="p-2">{{ $media->animal->common_name ?? 'Unknown' }}</td>
                            </tr>
                            <tr>
                                <th class="p-2">Location:</th>
                                <td class="p-2">{{ $media->location->name.', '.$media->location->city ?? 'Unknown' }}</td>
                            </tr>
                            <tr>
                                <th class="p-2">Date Taken:</th>
                                <td class="p-2">{{ \Carbon\Carbon::parse($media->date_taken)->format('F j, Y g:i A') }}</td>
                            </tr>
                            <tr>
                                <th class="p-2">Caption:</th>
                                <td class="p-2">{{ $media->caption ?? 'No Caption' }}</td>
                            </tr>
                            <tr><th class="p-2">Rating:</th><td class="p-2">{{ $media->rating ?? 'N/A' }}</td></tr>
                            <tr><th class="p-2">Gender:</th><td class="p-2">{{ ucfirst($media->gender ?? 'Unknown') }}</td></tr>
                            <tr>
                                <th class="p-2">Age:</th>
                                <td class="p-2">{{ ucfirst($media->age ?? 'Unknown') }}</td>
                            </tr>
                            <tr>
                                <th class="p-2">SHA-256:</th>
                                <td class="p-2" style="word-break: break-all;">{{ $media->hash }}</td>
                            </tr>
                            
                        </tbody>
                    </table>

                    <!-- Metadata Table -->
                    <table class="w-full border-collapse dark:text-gray-100 text-left border border-gray-300 dark:border-gray-700 rounded-md">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700">
                                <th class="p-2 text-left">Metadata</th>
                                <th class="p-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (json_decode($media->metadata, true) as $key => $value)
                                <tr>
                                    <th class="pr-4 p-2">{{ ucfirst(str_replace('_', ' ', $key)) }}:</th>
                                    <td class="p-2">{{ $value ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-public-app-layout>

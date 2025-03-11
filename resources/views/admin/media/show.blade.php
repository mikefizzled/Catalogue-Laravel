<x-app-layout>
    <x-slot name="header">
        <x-h2>Media #{{ $media->id }}</x-h2>
        @section('title', 'Media ' . $media->id)
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                <div class="flex gap-2 opacity-70 dark:text-gray-400">
                    <p><strong>Created:</strong> {{ $media->created_at->format('F j, Y g:i A') }}</p>
                    <p><strong>Last Changed:</strong> {{ $media->updated_at->diffForHumans() }}</p>
                </div>
                <div class="flex gap-2">
                    <x-link-button href="{{ route('admin.media.edit', $media) }}" class="ml-auto">Edit Media</x-link-button>
                    <x-link-button class="bg-red-400 hover:bg-red-600 focus:bg-red-600" onclick="return confirm('Move note to trash?')">Delete Media</x-link-button>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 px-6 py-3 shadow-sm sm:rounded-lg text-center">
                <div class="flex justify-center">
                    <div class="w-full">
                        @if($media->media_type === 'image')
                        <img src="{{ $media->media_url }}" 
                             alt="Media Image" 
                             class="w-full h-auto object-cover rounded-md border border-gray-300 dark:border-gray-700">
                        @elseif ($media->media_type === 'audio')
                        <div class="flex flex-col items-center my-5">
                            <audio controls class="">
                                <source src="{{ $media->media_url}}">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                        @endif
                        </div>
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
            <div class="bg-white dark:bg-gray-800 px-6 py-3 shadow-sm sm:rounded-lg">
                <div class="py-2">
                    <x-h2>Details</x-h2>
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
                                <th class="pr-4 p-2">Animal:</th>
                                <td class="p-2">{{ $media->animal->common_name ?? 'Unknown' }}</td>
                            </tr>
                            <tr>
                                <th class="pr-4 p-2">Location:</th>
                                <td class="p-2">{{ $media->location->name.', '.$media->location->city ?? 'Unknown' }}</td>
                            </tr>
                            <tr>
                                <th class="pr-4 p-2">Date Taken:</th>
                                <td class="p-2">{{ \Carbon\Carbon::parse($media->date_taken)->format('F j, Y g:i A') }}</td>
                            </tr>
                            <tr>
                                <th class="pr-4 p-2">Caption:</th>
                                <td class="p-2">{{ $media->caption ?? 'No Caption' }}</td>
                            </tr>
                            <tr><th class="pr-4 p-2">Rating:</th><td class="p-2">{{ $media->rating ?? 'N/A' }}</td></tr>
                            <tr><th class="pr-4 p-2">Gender:</th><td class="p-2">{{ ucfirst($media->gender ?? 'Unknown') }}</td></tr>
                            <tr>
                                <th class="pr-4 p-2">Age:</th>
                                <td class="p-2">{{ ucfirst($media->age ?? 'Unknown') }}</td>
                            </tr>
                            <tr>
                                <th class="pr-4 p-2">SHA-256:</th>
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
</x-app-layout>

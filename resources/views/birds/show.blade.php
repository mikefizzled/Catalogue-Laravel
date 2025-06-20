<head>
    <title>{{$animal->common_name}}</title> @vite(['resources/js/speciesMap.js'])
  </head>
  <script>
    window.existingLocations = @json($locations);
  </script>
  <script type="module" src="{{ asset('resources/js/speciesMap.js') }}"></script>
  <x-public-app-layout>
    <div class="py-2">
      <div class="max-w-7xl mx-auto sm:px-2 lg:px-2 space-y-2">
        <div class="bg-white dark:bg-gray-800 px-6 py-6 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="flex flex-col md:flex-row gap-2">
            <div class="self-center px-5">
              <div class="dark:text-gray-100 text-center md:text-left">
                <h1 class="text-3xl">{{ $animal->common_name }} </h1>
                <h2 class="text-xl italic mb-2">{{ $animal->scientific_name }}</h2>
                <a href='https://ebird.org/species/{{ $animal->ebird_species_code}}' class="underline">eBird</a>
              </div>
            </div>
            <div class="flex-grow self-center px-2">
              <table class="mx-auto w-[75%] table-auto border-collapse dark:text-gray-100" title="Bird Info">
                <tbody>
                  <tr class="border-b">
                    <th class="py-2 px-2">Class</th>
                    <td class="py-2 px-2">Aves</td>
                  </tr>
                  <tr class="border-b">
                    <th class="py-2 px-2">Order</th>
                    <td class="py-2 px-2">{{ $animal->genus->family->order->order_name }}</td>
                  </tr>
                  <tr class="border-b">
                    <th class="py-2 px-2">Family</th>
                    <td class="py-2 px-2">
                      {{ $animal->genus->family->family_name }}
                      <span class="italic"> - {{ $animal->genus->family->common_name }}</span>
                    </td>
                  </tr>
                  <tr>
                    <th class="py-2 px-4">Genus</th>
                    <td class="py-2 px-4">{{ $animal->genus->genus_name }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- Bird Thumbnail -->
            <div class="flex-shrink-0 self-center">
              <div class="w-64 md:w-48 w-64 md:h-48 rounded-md  border border-gray-200 dark:border-gray-700">
                <img src="{{ $animal->thumbnail_url }}" alt="{{ $animal->common_name }}" class="w-full h-full object-cover rounded-md">
              </div>
            </div>
          </div>
        </div>
        <div class="bg-white dark:bg-gray-800 px-6 py-3 shadow-sm sm:rounded-lg content-center"> 
          @if ($animal->conservationStatuses->isNotEmpty())
          <!-- Title -->
          <div class="text-center">
            <x-h2>Conservation Status - Birds of Conservation Concern</x-h2>
          </div>
          <!-- Grid Layout for Conservation Status -->
          <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-6 py-3">
            @foreach ($animal->conservationStatuses as $cs)
                @php
                    $bgClass = \App\Helpers\CatalogueHelper::getStatusBgClass($cs->status);
                @endphp
                <div class="p-4 border rounded-lg shadow-sm text-gray-800 {{ $bgClass }}">
                    <h3 class="text-md text-center dark:text-white ">
                        {{ $cs->conservationList->short_name }} - {{ $cs->conservationList->year }}
                    </h3>
                    <p class="text-m text-center dark:text-white ">
                        <span >{{ ucfirst($cs->status) }}</span>
                    </p>
                    @if ($cs->criteria->isNotEmpty())
                        <details class="text-gray-800 dark:text-white mt-2 text-center">
                            <summary class="cursor-pointer text-sm font-semibold">View Criteria</summary>
                            <ul class="mt-1 space-y-1 text-left">
                                @foreach ($cs->criteria as $criterion)
                                    <li class="text-sm p-1">{{ $criterion->boccCriteria->description }}.</li>
                                @endforeach
                            </ul>
                        </details>
                    @endif
                </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-600 dark:text-gray-400 text-center">No conservation status available.</p>
        @endif
        </div>
        <!-- Flowbite Carousel -->
        @if(count($images))
        <div x-data="{ showMetadata: false, activeMetadata: null }" class="relative">
          <div id="gallery" class="relative w-full" data-carousel="static">
            <!-- Carousel wrapper -->
            <div
  class="relative w-full h-[60vh] sm:h-[calc(100vw*9/16)] md:h-[600px] overflow-hidden rounded-lg border" data-carousel="static">
                @foreach ($images as $media)
                    <div class="hidden ease-in-out w-full h-full flex justify-center items-center" data-carousel-item>
                        @if ($media->media_type === 'image')
                            <img src="{{ $media->media_url }}" class="w-full h-full object-cover rounded-md" alt={{ $media->caption }}>
                            <div class="absolute bottom-5 left-5 bg-black bg-opacity-50 text-white p-3 rounded-lg shadow-lg w-auto text-center">
                        @elseif ($media->media_type === 'video')
                            <video controls class="w-full h-full object-cover rounded-md">
                                <source src="{{ $media->media_url }}" type="video/mp4">
                                <p class="text-gray-600 dark:text-gray-300"> Your browser does not support the video element </p>
                            </video>
                            <div class="absolute top-5 left-5 bg-black bg-opacity-50 text-white p-3 rounded-lg shadow-lg w-auto text-center">
                        @endif
                            <h2 class="text-sm sm:text-lg font-semibold">
                                {{ $media->location->name. ', '.$media->location->city ?? 'Unknown Location' }}
                            </h2>
                        <p class="text-xs sm:text-sm">
                            {{ $media->date_taken ? \Carbon\Carbon::parse($media->date_taken)->format('F j, Y') : 'Date Unknown' }}
                        </p>
                        </div>
                        <button @click="showMetadata = true; activeMetadata = {{ json_encode($media->metadata) }}" class="absolute bottom-0 end-0 z-50 flex items-center justify-center px-2 cursor-pointer group focus:outline-none bg-black bg-opacity-50 text-white"> EXIF </button>
                    </div>
              @endforeach
            </div>
            <!-- Slider controls -->
            <button type="button" class="absolute top-1/2 left-0 z-30 flex items-center justify-center w-12 h-12 px-3 cursor-pointer group focus:outline-none transform -translate-y-1/2" data-carousel-prev>
              <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-300 group-hover:bg-white/50 dark:group-hover:bg-gray-500 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
              </span>
            </button>
            <button type="button" class="absolute top-1/2 right-0 z-30 flex items-center justify-center w-12 h-12 px-3 cursor-pointer group focus:outline-none" data-carousel-next>
              <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-300 group-hover:bg-white/50 dark:group-hover:bg-gray-500 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
              </span>
            </button>
          </div>
          <div x-show="showMetadata" @click.away="showMetadata = false" class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-4 rounded-lg shadow-lg max-w-full z-50">
            <h3 class="text-lg font-semibold">Metadata</h3>
            <table class="w-full border-collapse text-left">
              <tbody>
                <template x-for="[key, value] in Object.entries(activeMetadata)">
                  <tr class="border-b border-gray-300 dark:border-gray-700">
                    <th class="p-2 text-gray-700 dark:text-gray-200 font-medium">
                      <span x-text="key"></span>:
                    </th>
                    <td class="p-2 text-gray-600 dark:text-gray-300">
                      <span x-text="value"></span>
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>
          @else

          @endif
        </div>
        @if (count($audioClips))
        <div class="bg-white dark:bg-gray-800 px-6 py-3 shadow-sm sm:rounded-lg">
            <div class="text-center">
                <x-h2>Calls and Songs</x-h2>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($audioClips as $audio)
                <div class="flex flex-col items-center p-3 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md">
                <audio controls class="w-full rounded-md bg-gray-100 dark:bg-gray-800 p-2">
                    <source src="{{ $audio->media_url }}"> Your browser does not support the audio element.
                </audio>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    {{ $audio->location->name }} - {{ $audio->date_taken ? \Carbon\Carbon::parse($media->date_taken)->format('F j, Y g:i A') : 'Date Unknown' }}
                </p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @if(count($images))
        <!-- Map container -->
        <div class="bg-white dark:bg-gray-800 px-6 py-6 shadow-sm sm:rounded-lg">
          <div class="flex flex-col md:flex-row gap-6">
            <div class="flex-grow">
              <div id="map"
                  class="w-full h-64 sm:h-80 md:h-[450px] mt-2 rounded-md shadow">
              </div>
            </div>
          </div>
        </div>
<<<<<<< Updated upstream:resources/views/catalogue/show.blade.php
      @endif
=======
        @if($animal->resources->isNotEmpty())
  <div class="bg-white dark:bg-gray-800 px-6 py-6 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="self-center p-5 dark:text-gray-100">
      <h2 class="text-2xl mb-4">Additional Resources</h2>
      <ul class="list-disc list-inside space-y-2">
        @foreach($animal->resources as $resource)
          <li>
            <a href="{{ $resource->url }}" class="underline text-blue-600 dark:text-blue-400" target="_blank" rel="noopener">
              {{ $resource->title }}
              @if(!empty($resource->type))
                ({{ $resource->type }})
              @endif
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
@endif


>>>>>>> Stashed changes:resources/views/birds/show.blade.php
      </div>
    </div>
  </x-public-app-layout>
  
<x-public-app-layout>
    @section('title', $animal->common_name)
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
          <div class="bg-white dark:bg-gray-800 px-6 py-3 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex flex-col md:flex-row gap-6">
                <div class="self-center p-5">
                    <div class="dark:text-gray-100">
                        <x-h2>{{ $animal->common_name }} </x-h2><h3 class="italic">{{ $animal->scientific_name }}</h3>
                     
                    </div>
                </div>
              <div class="flex-grow  self-center p-5">
                <table class="w-full table-auto border-collapse dark:text-gray-100">
                  <tbody>
                    <tr class="border-b">
                      <th class=" py-2 px-4">Class</th>
                      <td class="py-2 px-4">Aves</td>
                    </tr>
                    <tr class="border-b">
                      <th class="py-2 px-4">Order</th>
                      <td class="py-2 px-4">{{ $animal->genus->family->order->order_name }}</td>
                    </tr>
                    <tr class="border-b">
                      <th class="py-2 px-4">Family</th>
                      <td class="py-2 px-4">
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
                <div class="w-60 h-60 sm:w-50 sm:h-50 rounded-md p-1 border border-gray-200 dark:border-gray-700">
                  <img src="{{ $animal->thumbnail_url }}" alt="{{ $animal->common_name }}" class="w-full h-full object-cover rounded-md">
                </div>
              </div>
            </div>
          </div>
          <div class="bg-white dark:bg-gray-800 px-6 py-3 shadow-sm sm:rounded-lg content-center">

                @if($animal->conservationStatuses->isNotEmpty())
                    <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-7 py-3 ">
                        <div class="py-2 text-center">
                            <x-h2>Conservation Status</x-h2>
                        </div>
                        @foreach($animal->conservationStatuses as $cs)
                            @php
                                $bgClass = '';
                                switch ($cs->status) {
                                    case 'green':
                                        $bgClass = 'bg-green-100 dark:bg-green-900 text-gray-800 dark:text-gray-200';
                                        break;
                                    case 'amber':
                                        $bgClass = 'bg-yellow-100 dark:bg-yellow-900 text-gray-800 dark:text-gray-200';
                                        break;
                                    case 'red':
                                        $bgClass = 'bg-red-100 dark:bg-red-900 text-gray-800 dark:text-gray-200';
                                        break;
                                    case 'former breeder':
                                        $bgClass = 'bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200';
                                        break;
                                    case 'not assessed':
                                        $bgClass = 'bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200';
                                        break;
                                }
                            @endphp
                            <div class="p-2 border rounded-lg shadow-sm {{ $bgClass }}">
                                <h4 class="text-md font-semibold">
                                    {{ $cs->conservationList->short_name }} ({{ $cs->conservationList->year }})
                                </h4>
                                <p class="text-sm ">
                                    Status: <span class="font-bold">{{ ucfirst($cs->status) }}</span>
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 dark:text-gray-400">No conservation status available.</p>
                @endif

        </div>
        
<!-- Flowbite Carousel -->
<div id="gallery" class="relative w-full" data-carousel="static">
    <!-- Carousel wrapper -->
    <div class="relative h-[calc(100vw*9/16)] max-h-[600px] overflow-hidden rounded-lg border">
        @foreach ($mediaItems as $media)
            <div class="hidden ease-in-out w-full h-full flex justify-center items-center" data-carousel-item>
                <img src="{{ $media->media_url }}" class="w-full h-full object-cover" alt="">
                <div class="absolute bottom-4 left-4 bg-black bg-opacity-50 text-white p-3 rounded-lg shadow-lg w-auto text-center">
                    <h2 class="text-lg font-semibold">
                        {{ $media->location->name. ', '.$media->location->city ?? 'Unknown Location' }}
                    </h2>
                    <p class="text-sm">
                        {{ $media->date_taken ? \Carbon\Carbon::parse($media->date_taken)->format('F j, Y g:i A') : 'Date Unknown' }}
                    </p>
                </div>
            </div>
            
        @endforeach
    </div>
    <!-- Slider controls -->
    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-300 group-hover:bg-white/50 dark:group-hover:bg-gray-500 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-300 group-hover:bg-white/50 dark:group-hover:bg-gray-500 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>

        
          </div>
        </div>
</x-public-app-layout>

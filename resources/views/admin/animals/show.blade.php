<x-app-layout>
    <x-slot name="header">
        <x-h2>
            {{$animal->common_name}}
        </x-h2>
        @section('title', $animal->common_name)
    </x-slot>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">

          <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center ">
            <div class="flex gap-2 opacity-70 dark:text-gray-400">
              <p>
                <strong>Created:</strong> {{ $animal->created_at->diffForHumans() }}
              </p>
              <p>
                <strong>Last Changed:</strong> {{ $animal->updated_at->diffForHumans() }}
              </p>
            </div>
            <div class="flex gap-2">
              <x-link-button href="{{ route('admin.animals.edit', $animal) }}" class="ml-auto"> Edit Bird </x-link-button>
              <form action="{{ route('admin.animals.destroy', $animal) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this bird?');">
                @csrf
                @method('DELETE')
                <x-button type="submit">
                    Delete Bird
                </x-button>
            </form>
                    
            </div>
          </div>
          <div class="bg-white dark:bg-gray-800 px-6 py-3 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="py-2">
                <x-h2>Basic Info</x-h2>
            </div>
            <div class="flex flex-col md:flex-row gap-6">
              <div class="flex-grow">
                <table class="w-full table-auto border-collapse dark:text-gray-100 text-left">
                  <tbody>
                    <tr class="border-b">
                      <th class="py-2 px-4">Common Name</th>
                      <td class="py-2 px-4">{{ $animal->common_name }}</td>
                    </tr>
                    <tr class="border-b">
                      <th class="py-2 px-4">Scientific Name</th>
                      <td class="py-2 px-4">{{ $animal->scientific_name }}</td>
                    </tr>
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
                    <tr  class="border-b">
                      <th class="py-2 px-4">Genus</th>
                      <td class="py-2 px-4">{{ $animal->genus->genus_name }}</td>
                    </tr>
                    <tr>
                      <th class="py-2 px-4">eBird Code</th>
                      <td class="py-2 px-4">{{ $animal->ebird_species_code }}</td>
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
          <div class="bg-white dark:bg-gray-800 px-6 py-3 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="py-2">
                <x-h2>Conservation Status</x-h2>
            </div>
                @if($animal->conservationStatuses->isNotEmpty())
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
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
                            <div class="p-2 border rounded-lg shadow-sm {{ $bgClass }} mb-2">
                                <h4 class="text-md font-semibold">
                                    {{ $cs->conservationList->short_name }} ({{ $cs->conservationList->year }})
                                </h4>
                                <p class="text-sm ">
                                    Status: <span class="font-bold">{{ ucfirst($cs->status) }}</span>
                                </p>
                                <ul class="text-sm">
                                    @foreach ($cs->criteria as $criterion)
                                        <li>{{ $criterion->boccCriteria->description }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>

                @else
                    <p class="text-gray-600 dark:text-gray-400">No conservation status available.</p>
                @endif

        </div>
       
        <div class="bg-white dark:bg-gray-800 px-6 py-3 overflow-hidden sm:rounded-lg">
          <div class="py-2">
            <x-h2>Related Media</x-h2>
          </div>  
          <div class=" grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4">
            @forelse ($mediaItems as $media)
            <a href="{{ route('admin.media.show', $media->id) }}" class="  p-2">
                <div class="border  rounded-lg">
                    <img src="{{ $media->thumbnail_url }}" 
                         alt="Thumbnail" 
                         class="w-full h-32 object-cover rounded-md">
                </div>
            </a>
        @empty
            <p class="text-gray-500 dark:text-gray-400">No related media available.</p>
        @endforelse
          </div>

        </div>
        
          </div>
        </div>
</x-app-layout>

<x-admin-resource-show
  heading="{{$animal->common_name}}"
  pageTitle="{{$animal->common_name}}"
>
<x-slot name="actions">
    <x-action-buttons
      :edit-url="route('admin.animals.edit',  $animal)"
      :delete-url="route('admin.animals.destroy', $animal)"
      resource-name="animal"
    />
</x-slot>
  <div class="flex flex-col sm:flex-row sm:justify-between text-sm text-gray-600 dark:text-gray-400">
    <div class="space-x-4">
      <span><strong>Created:</strong> {{ $animal->created_at->diffForHumans() }}</span>
      <span><strong>Updated:</strong> {{ $animal->updated_at->diffForHumans() }}</span>
    </div>
  </div>
  <div>
      <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Basic Info</h2>
      <div class="flex flex-col md:flex-row gap-6">
        <div class="flex-grow">
          <table class="w-full table-auto border-collapse dark:text-gray-100 text-left">
            <tbody>
              <tr class="border-b">
                <th class="px-1 py-2">Common Name</th>
                <td class="px-1 py-2">{{ $animal->common_name }}</td>
              </tr>
              <tr class="border-b">
                <th class="px-1 py-2">Scientific Name</th>
                <td class="px-1 py-2">{{ $animal->scientific_name }}</td>
              </tr>
              <tr class="border-b">
                <th class="px-1 py-2">Class</th>
                <td class="px-1 py-2">Aves</td>
              </tr>
              <tr class="border-b">
                <th class="px-1 py-2">Order</th>
                <td class="px-1 py-2">{{ $animal->genus->family->order->order_name }}</td>
              </tr>
              <tr class="border-b">
                <th class="px-1 py-2">Family</th>
                <td class="px-1 py-2">
                  {{ $animal->genus->family->family_name }}
                  <span class="italic"> - {{ $animal->genus->family->common_name }}</span>
                </td>
              </tr>
              <tr  class="border-b">
                <th class="px-1 py-2">Genus</th>
                <td class="px-1 py-2">{{ $animal->genus->genus_name }}</td>
              </tr>
              <tr>
                <th class="px-1 py-2">eBird Code</th>
                <td class="px-1 py-2">{{ $animal->ebird_species_code }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Bird Thumbnail -->
        <div class="flex-shrink-0 self-center">
          <div class="w-60 h-60 sm:w-50 sm:h-50 border border-gray-200 dark:border-gray-200">
            <img src="{{ $animal->thumbnail_url }}" alt="{{ $animal->common_name }}" class="w-full h-full object-cover">
          </div>
        </div>
      </div>
    </div>
  <div>
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Conservation Status</h2>
    @if($animal->conservationStatuses->isNotEmpty())
        <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
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
                <div class="p-2 border shadow-sm {{ $bgClass }}">
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
  
  <div>
      <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Related Media</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4">
      @forelse ($mediaItems as $media)
      <a href="{{ route('admin.media.show', $media->id) }}" class="p-1">
          <div class="border">
              <img src="{{ $media->thumbnail_url }}" 
                    alt="Thumbnail" 
                    class="w-full h-32 object-cover">
          </div>
      </a>
      @empty
          <p class="text-gray-500 dark:text-gray-400">No related media available.</p>
      @endforelse
    </div>
  </div>
</x-admin-resource-show>

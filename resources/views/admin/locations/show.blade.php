@push('preload')
  <script>
    window.existingLocations = [{
      id:              {{ $location->id }},
      name:            @js($location->name),
      city:            @js($location->city),
      latitude:        {{ $location->latitude }},
      longitude:       {{ $location->longitude }},
    }];
  </script>

  @vite(['resources/js/speciesMap.js'])
@endpush

<x-admin-resource-show
  heading="Location – {{ $location->name }}"
  page-title="{{ $location->name }}"
>
  <x-slot name="actions">
    <x-action-buttons
      :edit-url="route('admin.locations.edit',   $location)"
      :delete-url="route('admin.locations.destroy',$location)"
      resource-name="{{ $location->name }}"
    />
  </x-slot>

  {{-- 3) Your map container --}}
  <div id="map" class="w-full h-[400px] mb-6 rounded shadow"></div>

  <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    <div>
      <dt class="font-medium text-gray-600 dark:text-gray-400">City</dt>
      <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $location->city }}</dd>
    </div>
    <div>
      <dt class="font-medium text-gray-600 dark:text-gray-400">Latitude</dt>
      <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $location->latitude }}</dd>
    </div>
    <div>
      <dt class="font-medium text-gray-600 dark:text-gray-400">Longitude</dt>
      <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $location->longitude }}</dd>
    </div>
    <div>
      <dt class="font-medium text-gray-600 dark:text-gray-400">Description</dt>
      <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $location->area_caption }}</dd>
    </div>
  </dl>
</x-admin-resource-show>

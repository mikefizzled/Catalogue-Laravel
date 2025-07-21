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

<x-crud-form-layout
  heading="Edit Location"
  page-title="Edit: {{ $location->name }}"
>

  @include('admin.locations._form', [
    'location'     => $location,
    'allLocations' => $allLocations,
  ])
</x-crud-form-layout>

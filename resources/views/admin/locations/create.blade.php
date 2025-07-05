@push('preload')
  @vite(['resources/js/map.js'])
@endpush

<x-crud-form-layout
  heading="Add New Location"
  page-title="Create Location"
>
  @push('scripts')
    <script>window.existingLocations = @json($allLocations);</script>
  @endpush

  @include('admin.locations._form', [
    'location'     => null,
    'allLocations' => $allLocations,
  ])
</x-crud-form-layout>

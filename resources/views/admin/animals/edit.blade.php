<x-crud-form-layout
  heading="Edit Bird"
  page-title="Edit {{ $animal->common_name }}"
>
  @include('admin.animals._form', [
    'animal'            => $animal,
    'genera'            => $genera,
    'conservationLists' => $conservationLists,
    'existingStatuses'  => $existingStatuses,
  ])
</x-crud-form-layout>

<x-crud-form-layout
  heading="Edit Genus"
  page-title="Edit Genus"
>
  @include('admin.genera._form', [
    'families' => $families,
    'genus' => $genus,
  ])
</x-crud-form-layout>

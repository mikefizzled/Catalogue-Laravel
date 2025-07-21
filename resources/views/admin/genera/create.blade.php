<x-crud-form-layout
  heading="Add New Genus"
  page-title="Create Genus"
>
  @include('admin.genera._form', [
    'families' => $families,
    'genus' => $genus,
  ])
</x-crud-form-layout>

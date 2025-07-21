<x-crud-form-layout
  heading="Add New Family"
  page-title="Create Family"
>
  @include('admin.families._form', [
    'orders' => $orders,
    'family' => $family,
  ])
</x-crud-form-layout>

<x-crud-form-layout
  heading="Edit Family"
  page-title="Edit {{ $family->family_name }}"
>

  @include('admin.families._form', [
    'orders' => $orders,
    'family' => $family,
  ])
</x-crud-form-layout>

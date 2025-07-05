<x-crud-form-layout
  heading="Add New Order"
  page-title="Create Order"
>
  @include('admin.orders._form', [
    'order' => $order,
  ])
</x-crud-form-layout>

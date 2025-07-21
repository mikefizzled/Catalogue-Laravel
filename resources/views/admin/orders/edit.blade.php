<x-crud-form-layout
  heading="Edit Order"
  page-title="Edit {{ $order->order_name }}"
>
  @include('admin.orders._form', [
    'order' => $order,
  ])
</x-crud-form-layout>

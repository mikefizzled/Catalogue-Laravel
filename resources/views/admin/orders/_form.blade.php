@props([
  'order',
])

@php
  $isEdit = $order->exists;
  $action = $isEdit
    ? route('admin.orders.update', $order)
    : route('admin.orders.store');
@endphp

<form method="POST" action="{{ $action }}">
  @csrf
  @if($isEdit) @method('PUT') @endif

  {{-- Order Name --}}
  <x-form.text
    name="order_name"
    id="order_name"
    label="Order Name"
    placeholder="Order Name"
    :value="old('order_name', $order->order_name)"
    required
  />

  {{-- Buttons --}}
  <div class="flex space-x-4 pt-4">
    <x-primary-button type="submit">
      {{ $isEdit ? 'Save Changes' : 'Create Order' }}
    </x-primary-button>
    <x-link-button
      href="{{ $isEdit
        ? route('admin.orders.show', $order)
        : route('admin.orders.index')
      }}"
    >
      Cancel
    </x-link-button>
  </div>
</form>

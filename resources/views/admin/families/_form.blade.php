@props([
  'family',
  'orders',
])

@php
  $isEdit = $family->exists;
  $action = $isEdit
    ? route('admin.families.update', $family)
    : route('admin.families.store');
@endphp

<form method="POST" action="{{ $action }}">
  @csrf
  @if($isEdit) @method('PUT') @endif

  {{-- Scientific name --}}
  <x-form.text
    name="family_name"
    label="Family Name"
    placeholder="Enter scientific name"
    :value="old('family_name', $family->family_name)"
    required
  />

  {{-- Common names --}}
  <x-form.text
    name="common_name"
    label="Common Name"
    placeholder="Enter common name"
    :value="old('common_name', $family->common_name)"
  />

  {{-- Parent Order --}}
  <x-form.select
    name="order_id"
    id="order_id"
    label="Parent Order"
    :options="$orders"
    :selected="old('order_id', $family->order_id)"
    required
  />

  {{-- Buttons --}}
  <div class="flex space-x-4 pt-4">
    <x-primary-button type="submit">
      {{ $isEdit ? 'Save Changes' : 'Create Family' }}
    </x-primary-button>
    <x-link-button
      href="{{ $isEdit
        ? route('admin.families.show', $family)
        : route('admin.families.index')
      }}"
    >
      Cancel
    </x-link-button>
  </div>
</form>

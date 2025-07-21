@props([
  'genus',
  'families',
])

@php
  $isEdit = $genus->exists;
  $action = $isEdit
    ? route('admin.genera.update', $genus)
    : route('admin.genera.store');
@endphp

<form method="POST" action="{{ $action }}">
  @csrf
  @if($isEdit) @method('PUT') @endif

  {{-- Scientific name --}}
  <x-form.text
    name="genus_name"
    label="Genus Name"
    placeholder="Enter genus name"
    :value="old('genus_name', $genus->genus_name)"
    required
  />

  {{-- Parent Family --}}
  <x-form.select
    name="family_id"
    id="family_id"
    label="Parent Family"
    :options="$families"
    :selected="old('family_id', $genus->family_id)"
    required
  />

  {{-- Buttons --}}
  <div class="flex space-x-4 pt-4">
    <x-primary-button type="submit">
      {{ $isEdit ? 'Save Changes' : 'Create Genus' }}
    </x-primary-button>
    <x-link-button
      href="{{ $isEdit
        ? route('admin.genera.show', $genus)
        : route('admin.genera.index')
      }}"
    >
      Cancel
    </x-link-button>
  </div>
</form>

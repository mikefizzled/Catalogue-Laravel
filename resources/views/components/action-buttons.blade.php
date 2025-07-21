@props([
  'editUrl',                // e.g., admin.locations.edit
  'deleteUrl',              // e.g., admin.locations.destroy
  'resourceName' => 'item', // e.g., Location
])

<div class="flex space-x-2">
  {{-- Edit --}}
  <x-link-button
    href="{{ $editUrl }}">
    Edit
  </x-link-button>

  {{-- Delete --}}
  <form
    action="{{ $deleteUrl }}"
    method="POST"
    onsubmit="return confirm('Are you sure you want to delete this {{ $resourceName }}?')"
  >
    @csrf
    @method('DELETE')
    <x-primary-button
      type="submit"
    >
      Delete
    </x-primary-button>
  </form>
</div>

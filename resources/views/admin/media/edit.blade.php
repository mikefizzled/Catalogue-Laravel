<x-crud-form-layout
  heading="Edit Media"
  page-title="Edit: {{ $media->id }}"
>

  @include('admin.media._form', [
    'media' => $media,
  ])
</x-crud-form-layout>

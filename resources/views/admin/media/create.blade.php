<x-crud-form-layout
  heading="Add New Media"
  page-title="Add Media"
>
  <form
    action="{{ route('admin.media.store') }}"
    method="POST"
    enctype="multipart/form-data"
    class="space-y-6 px-2"
  >
    @csrf

    {{-- Bird --}}
    <x-form.select
      name="animal_id"
      id="animal_id"
      label="Bird"
      :options="$animals->pluck('common_name','id')->toArray()"
      :selected="old('animal_id')"
      required
    />

    {{-- Location --}}
    <x-form.select
      name="location_id"
      id="location_id"
      label="Location"
      :options="$locations->pluck('name','id')->toArray()"
      :selected="old('location_id')"
      required
    />

    <div class="grid gap-x-2 sm:grid-cols-1 md:grid-cols-3">
      {{-- Age --}}
      <x-form.select
        name="age"
        id="age"
        label="Age"
        :options="collect($ages)->pluck('label','id')->toArray()"
        :selected="old('age')"
        required
      />

      {{-- Gender --}}
      <x-form.select
        name="gender"
        id="gender"
        label="Gender"
        :options="collect($genders)->pluck('label','id')->toArray()"
        :selected="old('gender')"
        required
      />

      {{-- Rating --}}
      <x-form.select
        name="rating"
        id="rating"
        label="Rating"
        :options="collect(range(1,10))->mapWithKeys(fn($i)=>[$i=>$i])->all()"
        :selected="old('rating')"
        required
      />
    </div>

    {{-- Media File --}}
    <x-form.file
      name="media"
      id="media"
      label="Media File"
      help="Upload an image or audio file"
      accept="image/*,audio/*"
      required
    />

    {{-- Caption --}}
    <x-form.text
      name="caption"
      id="caption"
      label="Caption"
      placeholder="Enter a caption"
      :value="old('caption')"
      required
    />

    {{-- Buttons --}}
    <div class="flex gap-4 justify-center pt-4">
      <x-primary-button>Save Media</x-primary-button>
      <x-link-button href="{{ route('admin.media.index') }}">Go Back</x-link-button>
    </div>
  </form>
</x-crud-form-layout>

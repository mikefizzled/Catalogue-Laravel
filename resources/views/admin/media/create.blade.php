<x-crud-form-layout
  heading="Add New Media"
  page-title="Add Media">
  <form action="{{ route('admin.media.store') }}"
    method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="space-y-2 px-2">
      {{-- Animal Select --}}
        <x-form.select 
        id="animal_id" 
        name="animal_id"
        :options="$animals" 
        optionLabel="common_name" 
        optionId="id" 
        label="Bird"
        :selected="old('animal_id')" /> 
      {{-- Location --}}
        <x-form.select 
          id="location_id" 
          name="location_id"
          label="Location"
          :options="$locations" 
          optionLabel="name" 
          optionId="id" 
          :selected="old('location_id')"/>

      <div class="grid gap-x-2 sm:grid-cols-1 md:grid-cols-3">
        {{-- Age --}} 
          <x-form.select
            id="age"
            name="age"
            label="Age"
            :options="$ages" 
            optionLabel="label"
            optionId="id"
            :selected="old('age')" />
        {{-- Gender --}}
          <x-form.select
            id="gender"
            name="gender"
            label="Gender"
            :options="$genders"
            optionLabel="label"
            optionId="id"
            :selected="old('gender')" /> 
        {{-- Rating --}}
          <x-form.select
            id="rating"
            name="rating"
            label="Rating"
            :options="collect(range(1,10))->mapWithKeys(fn($i)=>[$i=>$i])->all()"
            :selected="old('rating')"/>
        </div>
      {{-- File --}}
        <x-form.file
          id="media"
          label="Media File"
          name="media"
          type="file"
          aria-describedby="media_help"/>

      {{-- Caption --}}
        <x-form.text
          id="caption"
          name="caption"
          label="Caption"
          placeholder="Enter Caption"
          value="{{ old('caption') }}" /> 

        {{-- Form Buttons --}}
        <div class="py-2 my-2 flex gap-4 justify-center items-center">
          <x-primary-button>Save Bird</x-primary-button>
          <x-link-button href="{{ route('admin.animals.index') }}">Go Back</x-link-button>
        </div>
    </div>
  </form>
</x-crud-form-layout>
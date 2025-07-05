@props([
  'location'      => null,
  'allLocations',
])

@php
  $isEdit = isset($location) && $location->exists;
@endphp

<form
  method="POST"
  action="{{  $isEdit
       ? route('admin.locations.update', $location)
       : route('admin.locations.store')
  }}"
  enctype="multipart/form-data"
>
  @csrf
  @if($isEdit) @method('PUT') @endif

  {{-- Name + City --}}
  <x-form.text name="name"  label="Location Name"  :value="old('name',  $location->name  ?? '')" required/>
  <x-form.text name="city"  label="Town/City"       :value="old('city',  $location->city  ?? '')" required/>

  {{-- Coordinates --}}
  <x-form.text name="latitude"  label="Latitude"
               type="number" step="any"
               :value="old('latitude',$location->latitude ?? '')" required/>
  <x-form.text name="longitude" label="Longitude"
               type="number" step="any"
               :value="old('longitude',$location->longitude ?? '')" required/>

  {{-- Image --}}
  <x-form.file name="image"
               label="Area Image"
               help="JPG or WebP"
               accept="image/jpeg,image/webp"
               {{ $isEdit ? '' : 'required' }}/>

  {{-- Description --}}
    <x-form.textarea
    name="caption"
    label="Area Description"
    rows="6"
    :value="old('caption', $location->area_caption ?? '')"
    placeholder="Enter a description…"
    />

  {{-- Map placeholder (your JS will hook into #map) --}}
  <div id="map" class="w-full h-[400px] rounded shadow"></div>

  {{-- Buttons --}}
  <div class="flex space-x-4 pt-4">
    <x-primary-button type="submit">
      {{ $isEdit ? 'Save Changes' : 'Create Location' }}
    </x-primary-button>
    <x-link-button href="{{ route('admin.locations.index') }}">Cancel</x-link-button>
  </div>
</form>

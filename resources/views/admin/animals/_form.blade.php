@props([
  'animal',
  'genera',
  'conservationLists',
  'existingStatuses',
])

@php
  $isEdit = $animal->exists;
  $action = $isEdit
    ? route('admin.animals.update', $animal)
    : route('admin.animals.store');
 
    // helper to grab the status record for a given list id
    $getCs = fn(int $listId) =>
    $criteria = $animal->criteria_map;
    // pull your global list of code→label pairs
    $statusOptions = config('statuses.defaults');  
@endphp


<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6">
  @csrf
  @if($isEdit) @method('PUT') @endif

  {{-- General Information --}}
  <div class="space-y-4 px-2">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">General Information</h2>

    {{-- eBird search + Common Name --}}
    <x-form.ebird-search
      common-field="common_name"
      scientific-field="scientific_name"
      code-field="ebird_species_code"
      genus-field="genus_id"
      :initial="old('common_name', $animal->common_name)"
    />

    {{-- Scientific Name --}}
    <x-form.text
      name="scientific_name"
      label="Scientific Name"
      :value="old('scientific_name', $animal->scientific_name)"
      required
    />

    {{-- eBird Code --}}
    <x-form.text
      name="ebird_species_code"
      label="eBird Species Code"
      :value="old('ebird_species_code', $animal->ebird_species_code)"
      readonly
      required
    />

    {{-- Genus --}}
    <x-form.select
      name="genus_id"
      id="genus_id"
      label="Genus Member"
      :options="$genera"
      :selected="old('genus_id', $animal->genus_id)"
      required
    />

    {{-- Thumbnail --}}
    <x-form.file
      name="thumbnail"
      label="Bird Thumbnail"
      help="JPG or WebP – 512×512"
      accept="image/jpeg,image/webp"
    />
  </div>
  @if($isEdit && $animal->thumbnail_url)
      <x-form.text
        name="slug"
        label="Slug"
        :value="old('slug', $animal->slug)"
        readonly
        required
    />
    <div class="py-2">
      <label class="block text-sm text-gray-700 dark:text-gray-300">Current Thumbnail</label>
      <img src="{{ $animal->thumbnail_url }}"
          alt="{{ $animal->common_name }} thumbnail"
          class="w-24 h-24 object-cover rounded mt-1"/>
    </div>
  @endif

  {{-- Conservation Status --}}
  <div class="space-y-4 px-2">
    <div class="flex justify-between items-baseline">
      <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Conservation Status</h2>
      <x-primary-button type="button" id="fetchBoccBtn">
        Fetch from Journal
      </x-primary-button>
    </div>
    <p class="text-sm italic text-gray-600 dark:text-gray-400">
      Use “Not Assessed” for non‐sea birds in BoCC5a.
    </p>

    <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
      @foreach($conservationLists as $list)
        <x-form.status-select
          :list="$list"
          :selected="old('statuses.'.$list->id, $existingStatuses[$list->id] ?? '')"
        />
      @endforeach
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
      {{-- BoCC5 Criteria --}}
      <x-form.text
        name="bocc_5_criteria"
        label="BoCC5 Criteria"
        :value="old('bocc_5_criteria', $animal->bocCriteriaCodes(5))"
        readonly
        required
      />
     
      {{-- BoCC5a Criteria --}}
      <x-form.text
        name="bocc_5a_criteria"
        label="BoCC5a Criteria"
        :value="old('bocc_5_criteria', $animal->bocCriteriaCodes(6))"
        readonly
        required
      />
    </div>
  </div>

  {{-- Submit / Cancel --}}
  <div class="flex justify-center space-x-4 py-4">
    <x-primary-button type="submit">
      {{ $isEdit ? 'Save Changes' : 'Create Bird' }}
    </x-primary-button>
    <x-link-button href="{{ $isEdit
        ? route('admin.animals.show', $animal)
        : route('admin.animals.index')
      }}">
      Cancel
    </x-link-button>
  </div>
</form>

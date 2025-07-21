<x-crud-form-layout
  heading="Add New Bird"
  page-title="Add New Bird">
    <form action="{{ route('admin.animals.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="space-y-4 px-2">
            <div>
                <h2 class="text-lg text-gray-500 dark:text-gray-300">General Information</h2>
                {{-- Common Name --}}
                <x-form.ebird-search
                    scientific-field="scientific_name"
                    code-field="ebird_species_code"
                    genus-field="genus_id"/>

                {{-- Scientific Name --}}
                <x-form.text 
                    name="scientific_name"
                    label="Scientific Name"
                    id="scientific_name"
                    placeholder="Scientific Name"
                    value="{{ old('scientific_name') }}"
                    required/>
                
                {{-- eBird Species Code --}}
                <x-form.text 
                    name="ebird_species_code"
                    id="ebird_species_code"
                    label="eBird Species Code"
                    placeholder="eBird Code"
                    value="{{ old('ebird_species_code') }}"
                    readonly
                    required/>

                {{-- Genus Member --}}
                <x-select-dropdown 
                    id="genus_id" 
                    name="genus_id"
                    label="Genus Member"
                    :options="$genera" 
                    optionLabel="genus_name" 
                    optionId="id"
                    :selected="old('genus_id')"
                    required/>

                {{-- Bird Thumbnail --}}
                <x-form.file
                    name="thumbnail"
                    label="Bird Thumbnail"
                    help="JPG or WebP – 512×512"
                    accept="image/jpeg,image/webp"
                    required/>
            </div>
        
            {{-- Conservation Status ---}}
            <div>
                <div class="flex justify-between w-full">
                    <div class="flex flex-col">
                        <h2 class="text-lg text-gray-500 dark:text-gray-300">Conservation Status</h2>
                        <p class="text-sm italic mt-1 text-gray-500 dark:text-gray-300">
                            Use 'Not Assessed' for all non-sea birds in BoCC5a
                        </p>
                    </div>
                    <x-primary-button type="button" id="fetchBoccBtn">Search Journal</x-primary-button>
                </div>
                @error("statuses")
                    <x-update-error class="mt-2">{{ $message }}</x-update-error>
                @enderror
                <div class="grid gap-1 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($conservationLists as $list)
                        <x-form.status-select
                            :list="$list"
                            :selected="old('statuses.'.$list->id, $existingStatuses[$list->id] ?? '')"
                        />
                        @endforeach
                </div>

                <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-2">
                    {{-- BoCC5 Criteria --}}
                    <x-form.text 
                        name="bocc_5_criteria"
                        label="BoCC5 Criteria"
                        id="bocc_5_criteria"
                        placeholder="Criteria"
                        value="{{ old('bocc_5_criteria') }}"
                        required
                        readonly/>

                    {{-- BoCC5a Criteria --}}
                    <x-form.text 
                        name="bocc_5a_criteria"
                        label="BoCC5a Criteria"
                        id="bocc_5a_criteria"
                        placeholder="Criteria"
                        value="{{ old('bocc_5a_criteria') }}"
                        required
                        readonly/>
                </div>
            </div>

            <div class="py-2 my-2 flex gap-4 justify-center items-center">
                <x-primary-button>Save Bird</x-primary-button>
                <x-link-button href="{{ route('admin.animals.index') }}">Go Back</x-link-button>
            </div>
        </div>
    </form>
</x-crud-form-layout>
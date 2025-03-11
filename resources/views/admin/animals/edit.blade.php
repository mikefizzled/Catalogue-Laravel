<x-app-layout>
    <x-slot name="header">
        <x-h2>Edit Bird</x-h2>
        @section('title', 'Edit Bird')
    </x-slot>
    
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <div class="bg-white dark:bg-gray-800 p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- The Update Form -->
                <form action="{{ route('admin.animals.update', $animal) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Common Name -->
                    <div class="py-2">
                        <x-form-label for="common_name">Common Name</x-form-label>
                        <x-text-input 
                            id="common_name" 
                            name="common_name" 
                            class="w-full mt-2" 
                            placeholder="Common Name" 
                            value="{{ old('common_name', $animal->common_name) }}" 
                        />
                        @error('common_name')
                            <x-update-error class="mt-2">{{ $message }}</x-update-error>
                        @enderror
                    </div>

                    <!-- Scientific Name -->
                    <div class="py-2">
                        <x-form-label for="scientific_name">Scientific Name</x-form-label>
                        <x-text-input 
                            id="scientific_name" 
                            name="scientific_name" 
                            class="w-full mt-2" 
                            placeholder="Scientific Name" 
                            value="{{ old('scientific_name', $animal->scientific_name) }}" 
                        />
                        @error('scientific_name')
                            <x-update-error class="mt-2">{{ $message }}</x-update-error>
                        @enderror
                    </div>

                    <!-- Genus Member -->
                    <div class="py-2">
                        <x-form-label for="genus_id">Genus Member</x-form-label>
                        <x-select-dropdown 
                            id="genus_id" 
                            name="genus_id" 
                            class="w-full mt-2" 
                            :options="$genera" 
                            optionLabel="genus_name" 
                            optionId="id"
                            :selected="old('genus_id', $animal->genus_id)"
                        />
                        @error('genus_id')
                            <x-update-error class="mt-2">{{ $message }}</x-update-error>
                        @enderror
                    </div>
                    {{-- eBird Species Code --}}
                    <div class="py-2">
                    <x-form-label for="slug">Slug</x-form-label>

                        <x-text-input 
                            id="slug" 
                            name="slug" 
                            class="w-full mt-2" 
                            placeholder="eBird Code" 
                            value="{{ old('slug', $animal->slug) }}" 
                            readonly
                        />
                    @error('slug')
                        <x-update-error class="mt-2">{{ $message }}</x-update-error>
                    @enderror
                </div>
                    {{-- eBird Species Code --}}
                    <div class="py-2">
                        <x-form-label for="ebird_species_code">eBird Species Code</x-form-label>

                            <x-text-input 
                                id="ebird_species_code" 
                                name="ebird_species_code" 
                                class="w-full mt-2" 
                                placeholder="eBird Code" 
                                value="{{ old('ebird_species_code', $animal->ebird_species_code) }}" 
                                readonly
                            />
                        @error('ebird_species_code')
                            <x-update-error class="mt-2">{{ $message }}</x-update-error>
                        @enderror
                    </div>
                    <!-- Bird Thumbnail -->
                    <div class="py-2">
                        <x-form-label for="thumbnail">Bird Thumbnail</x-form-label>
                        <input 
                            class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400"
                            id="thumbnail" 
                            name="thumbnail"
                            type="file"
                            aria-describedby="thumbnail_help"
                        >
                        <span id="thumbnail_help" class="text-sm text-gray-500 dark:text-gray-400">JPG or WebP - 512x512. Leave blank to keep the current image.</span>
                        @error('thumbnail')
                            <x-update-error class="mt-2">{{ $message }}</x-update-error>
                        @enderror
                    </div>
                </div>

                <!-- Conservation Status Section -->
                <div class="bg-white dark:bg-gray-800 p-6 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <x-form-label for="conservation_status" class="text-left">Conservation Status</x-form-label>
                    <p class="text-sm italic mt-1 text-gray-500 dark:text-gray-300">Use 'Not Assessed' for all non-sea birds in BoCC5a</p>
                    @error("statuses")
                        <x-update-error class="mt-2">{{ $message }}</x-update-error>
                    @enderror
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 p-2 md:p-2 xl:p-2 mt-2">
                        @foreach ($conservationLists as $conservationList)
                            <div class="px-2 py-2">
                                <x-form-label for="status_{{ $conservationList->id }}">
                                    {{ $conservationList->short_name }}
                                </x-form-label>
                                @php
                                    // Find existing status for this conservation list, if any.
                                    $existingStatus = optional($animal->conservationStatuses->firstWhere('conservation_list_id', $conservationList->id))->status;
                                @endphp
                                <select 
                                    id="status_{{ $conservationList->id }}" 
                                    name="statuses[{{ $conservationList->id }}]" 
                                    class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required 
                                >
                                    <option value="" disabled {{ old("statuses.{$conservationList->id}", $existingStatus) ? '' : 'selected' }}>Select Status</option>
                                    <option value="green" {{ old("statuses.{$conservationList->id}", $existingStatus) == 'green' ? 'selected' : '' }}>Green</option>
                                    <option value="amber" {{ old("statuses.{$conservationList->id}", $existingStatus) == 'amber' ? 'selected' : '' }}>Amber</option>
                                    <option value="red" {{ old("statuses.{$conservationList->id}", $existingStatus) == 'red' ? 'selected' : '' }}>Red</option>
                                    <option value="former breeder" {{ old("statuses.{$conservationList->id}", $existingStatus) == 'former breeder' ? 'selected' : '' }}>Former Breeder</option>
                                    <option value="not assessed" {{ old("statuses.{$conservationList->id}", $existingStatus) == 'not assessed' ? 'selected' : '' }}>Not Assessed</option>
                                </select>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Form Buttons -->
                <div class="py-2 my-2 flex gap-4 justify-center items-center">
                    <x-primary-button>Update Bird</x-primary-button>
                    <x-link-button href="{{ route('admin.animals.index') }}">Go Back</x-link-button>
                </div>
                <!-- End of Form -->
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

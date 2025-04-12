<x-app-layout>
    <x-slot name="header">
        <x-h2>Add New Bird</x-h2>
        @section('title', 'Create Bird')
    </x-slot>
    <div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
    <div class="bg-white dark:bg-gray-800 p-6 overflow-hidden shadow-sm sm:rounded-lg">
        {{-- If your component expects the default slot, simply pass the form directly --}}
        <form action="{{ route('admin.animals.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            {{-- Common Name --}}
            <div class="py-2">
                <x-form-label for="common_name">Common Name</x-form-label>
                <div class="flex items-center gap-2">
                    
                <x-text-input 
                    id="common_name" 
                    name="common_name" 
                    class="w-full mt-2" 
                    placeholder="Common Name" 
                    value="{{ old('common_name') }}" 
                />
                <x-primary-button type="button" onclick="fetchEbirdCode()">Search eBird</x-primary-button>
                </div>
                
                @error('common_name')
                    <x-update-error class="mt-2">{{ $message }}</x-update-error>
                @enderror
            </div>
            <div id="results" class="bg-white mt-1 w-full rounded-md shadow-lg max-h-60 overflow-auto z-10"></div>
            
            {{-- Scientific Name --}}
            <div class="py-2">
                <x-form-label for="scientific_name">Scientific Name</x-form-label>
                <x-text-input 
                    id="scientific_name" 
                    name="scientific_name" 
                    class="w-full mt-2" 
                    placeholder="Scientific Name" 
                    value="{{ old('scientific_name') }}" 
                />
                @error('scientific_name')
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
            value="{{ old('ebird_species_code') }}" 
            readonly
        />
    @error('ebird_species_code')
        <x-update-error class="mt-2">{{ $message }}</x-update-error>
    @enderror
</div>
<script>
    function fetchEbirdCode() {
        let commonName = document.getElementById("common_name").value.trim();
        let resultsDiv = document.getElementById("results");
        resultsDiv.innerHTML = "";
    
        if (commonName.length < 3) return;
    
        fetch(`/search-ebird?query=${encodeURIComponent(commonName)}`)
        .then(response => response.json())
        .then(data => {
            resultsDiv.innerHTML = "";
    
            if (data.error) {
                resultsDiv.innerHTML = `<p class="text-gray-500">No matches found.</p>`;
                return;
            }
    
            data.forEach(species => {
                let listItem = document.createElement("p");
                listItem.innerHTML = `<strong>${species.comName}</strong> (${species.sciName})`;
                listItem.classList.add("cursor-pointer", "p-2", "hover:bg-gray-200", "rounded-md");
    
                listItem.onclick = function() {
                    document.getElementById("common_name").value = species.comName;
                    document.getElementById("scientific_name").value = species.sciName;
                    document.getElementById("ebird_species_code").value = species.speciesCode;


                    // Extract the genus (first word of scientific name)
                let genus = species.sciName.split(" ")[0];

                // Find the corresponding genus in the dropdown
                let genusDropdown = document.getElementById("genus_id");
                for (let i = 0; i < genusDropdown.options.length; i++) {
                    if (genusDropdown.options[i].text.trim().toLowerCase() === genus.toLowerCase()) {
                        genusDropdown.selectedIndex = i;
                        break;
                    }
                }
                    resultsDiv.innerHTML = "";
                };
    
                resultsDiv.appendChild(listItem);
            });
        })
        .catch(error => console.error("Error fetching eBird data:", error));
    }
    </script>
    
        
    
            {{-- Genus Member --}}
            <div class="py-2">
                <x-form-label for="genus_id">Genus Member</x-form-label>
                <x-select-dropdown 
                    id="genus_id" 
                    name="genus_id" 
                    class="w-full mt-2" 
                    :options="$genera" 
                    optionLabel="genus_name" 
                    optionId="id"
                    :selected="old('genus_id')"
                />
                @error('genus_id')
                    <x-update-error class="mt-2">{{ $message }}</x-update-error>
                @enderror
            </div>
            {{-- Bird Thumbnail --}}
            <div class="py-2">
                <x-form-label for="thumbnail">Bird Thumbnail</x-form-label>
                <input 
                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400"
                    id="thumbnail" 
                    name="thumbnail"
                    type="file"
                    aria-describedby="thumbnail_help">
                <span id="thumbnail_help" class="text-sm text-gray-500 dark:text-gray-400">JPG or WebP - 512x512.</span>
                @error('thumbnail')
                    <x-update-error class="mt-2">{{ $message }}</x-update-error>
                @enderror
            </div>
        </div>
        
            {{-- Conservation Status --}}
            <div class="bg-white dark:bg-gray-800 p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex items-center justify-between w-full">
                    <div class="flex flex-col">
                        <x-form-label for="conservation_status" class="text-left">Conservation Status</x-form-label>
                        <p class="text-sm italic mt-1 text-gray-500 dark:text-gray-300">
                            Use 'Not Assessed' for all non-sea birds in BoCC5a
                        </p>
                    </div>
                    <x-primary-button type="button" onclick="fetchBoccData()">Search Journal</x-primary-button>
                </div>
                @error("statuses")
                    <x-update-error class="mt-2">{{ $message }}</x-update-error>
                @enderror
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 p-2 md:p-2 xl:p-2 mt-2">
                    @foreach ($conservationLists as $conservationList)
                        <div class="px-2 py-2">
                            <x-form-label for="{{ $conservationList->import_name }}">
                                {{ $conservationList->short_name }}
                            </x-form-label>
                            <select 
                                id="{{$conservationList->import_name}}" 
                                name="statuses[{{ $conservationList->id }}]"
                                class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required 
                            >
                                <option value="" selected disabled>Select Status</option>
                                <option value="green">Green</option>
                                <option value="amber">Amber</option>
                                <option value="red">Red</option>
                                <option value="former breeder">Former Breeder</option>
                                <option value="not assessed">Not Assessed</option>
                            </select>
                        </div>
                    @endforeach
                </div>
                <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-2 px-5">
                    <div class="p-5">
                        <x-form-label for="bocc_5_criteria">BoCC5 Criteria</x-form-label>
                    
                            <x-text-input 
                                id="bocc_5_criteria" 
                                name="bocc_5_criteria" 
                                class="w-full mt-2" 
                                placeholder="Criteria" 
                                value="{{ old('bocc_5_criteria') }}" 
                                readonly
                            />
                        @error('bocc_5_criteria')
                            <x-update-error class="mt-2">{{ $message }}</x-update-error>
                        @enderror
                    </div>
                    <div class="p-5">
                        <x-form-label for="bocc_5a_criteria">BoCC5a Criteria</x-form-label>
                    
                            <x-text-input 
                                id="bocc_5a_criteria" 
                                name="bocc_5a_criteria" 
                                class="w-full mt-2" 
                                placeholder="Criteria" 
                                value="{{ old('bocc_5a_criteria') }}" 
                                readonly
                            />
                        @error('ebird_species_code')
                            <x-update-error class="mt-2">{{ $message }}</x-update-error>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Form Buttons --}}
            <div class="py-2 my-2 flex gap-4 justify-center items-center">
                <x-primary-button>Save Bird</x-primary-button>
                <x-link-button href="{{ route('admin.animals.index') }}">Go Back</x-link-button>
            </div>
        </form>
    </div>
    </div>
</x-app-layout>
<script>
    async function fetchBoccData() {
        const scientificName = document.getElementById("scientific_name").value.trim();
    
        if (!scientificName) {
            alert("Please enter a scientific name first.");
            return;
        }
    
        try {
            const response = await fetch(`/conservation-status?scientific_name=${encodeURIComponent(scientificName)}`);
    
            if (!response.ok) {
                throw new Error(await response.text());
            }
    
            const birdData = await response.json();

// List of expected conservation status fields
const statusFields = ["bocc_1", "bocc_2", "bocc_3", "bocc_4", "bocc_5", "bocc_5a", "bocc_5_criteria", "bocc_5a_criteria"];

// Loop through all status fields and update the corresponding select field
statusFields.forEach(field => {
    if (birdData.hasOwnProperty(field)) {
        const statusValue = birdData[field].toLowerCase();
        const selectField = document.getElementById(field);

        if (selectField) {
            for (const option of selectField.options) {
                if (option.value.toLowerCase() === statusValue) {
                    selectField.value = option.value;
                    break;
                }
            }
            document.getElementById("bocc_5_criteria").value = birdData.bocc_5_criteria;
            document.getElementById("bocc_5a_criteria").value = birdData.bocc_5a_criteria;
        }
    }
});

alert("Conservation status updated successfully!");
    
        } catch (error) {
            console.error("Error fetching conservation data:", error);
        }
    }
    </script>
    
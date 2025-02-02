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
                <x-text-input 
                    id="common_name" 
                    name="common_name" 
                    class="w-full mt-2" 
                    placeholder="Common Name" 
                    value="{{ old('common_name') }}" 
                />
                @error('common_name')
                    <x-update-error class="mt-2">{{ $message }}</x-update-error>
                @enderror
            </div>

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
                            <select 
                                id="status_{{ $conservationList->id }}" 
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

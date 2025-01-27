<x-app-layout>
    <x-slot name="header">
        <x-h2>
            Create Bird
        </x-h2>
        @section('title', 'Create Bird')
    </x-slot>

    <x-crud-layout>
        <x-slot name="inside">
            <form action="{{ route('admin.animals.index') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="py-2">
                    <x-form-label for="common_name">Common Name</x-form-label>
                    <x-text-input id="common_name" name="common_name" class="w-full mt-2" placeholder="Common Name" value="{{ old('common_name') }}"></x-text-input>
                    @error('common_name')
                        <x-update-error class="mt-2">{{ $message }}</x-update-error>
                    @enderror
                </div>

                <div class="py-2">
                    <x-form-label for="scientific_name">Scientific Name</x-form-label>
                    <x-text-input id="scientific_name" name="scientific_name" class="w-full mt-2" placeholder="Scientific Name" value="{{ old('scientific_name') }}"></x-text-input>
                    @error('scientific_name')
                        <x-update-error class="mt-2">{{ $message }}</x-update-error>
                    @enderror
                </div>

                <div class="py-2">
                    <x-form-label for="genus_id">Genus Member</x-form-label>
                    <x-select-dropdown id="genus_id" name="genus_id" class="w-full mt-2" :options="$genera" optionLabel="genus_name" valueField="genus_id"></x-select-dropdown>
                    @error('genus_id')
                        <x-update-error class="mt-2">{{ $message }}</x-update-error>
                    @enderror
                </div>

                <div class="py-2">
                    <x-form-label for="file_input">Bird Thumbnail</x-form-label>
                    <div class="p-2 w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <input id="file_input" name="thumbnail" type="file" class="w-full text-gray-900 dark:text-gray-300" aria-describedby="file_input_help">
                    </div>
                    <span id="file_input_help" class="text-sm text-gray-500 dark:text-gray-400">JPG or WebP - 512x512.</span>
                </div>

                <div class="py-2">
                    <x-form-label for="conservation_list text-left">Conservation Status</x-form-label>
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 p-3 md:p-4 xl:p-5 gap-2 mt-2 border border-gray-300 dark:border-gray-700">
                      @foreach ($conservationLists as $conservationList)
                        <div class="px-2 py-2">
                          <x-form-label for="status_{{ $conservationList->id }}" class="">{{ $conservationList->short_name }}</x-form-label>
                          <select id="status_{{ $conservationList->id }}" name="statuses[{{ $conservationList->id }}]" class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Select Status</option>
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
                  

                <div class="py-2 my-2 flex gap-4">
                    <x-primary-button class="mt-1">Save Bird</x-primary-button>
                    <x-link-button href="{{ route('admin.animals.index') }}">Go Back</x-link-button>
                </div>
            </form>
        </x-slot>
    </x-crud-layout>
</x-app-layout>

<head>
    @vite(['resources/js/map.js'])
</head>
<x-app-layout>
    <x-slot name="header">
        <x-h2>Add New Location</x-h2>
        @section('title', 'Create Location')
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <div class="bg-white dark:bg-gray-800 p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.locations.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Inputs + Map -->
                    <div class="flex flex-col md:flex-row gap-6">

                        <!-- Coordinate Inputs -->
                        <div class="w-full md:w-1/3 flex flex-col gap-4">
                            <!-- Location Name -->
                            <div>
                                <x-form-label for="name">Location Name</x-form-label>
                                <x-text-input 
                                    id="name" 
                                    name="name" 
                                    class="w-full mt-2" 
                                    placeholder="Location Name" 
                                    value="{{ old('name') }}" 
                                />
                                @error('name')
                                    <x-update-error class="mt-2">{{ $message }}</x-update-error>
                                @enderror
                            </div>
                            <!-- Location Name -->
                            <div>
                                <x-form-label for="name">Town/City</x-form-label>
                                <x-text-input 
                                    id="name" 
                                    name="name" 
                                    class="w-full mt-2" 
                                    placeholder="Location Name" 
                                    value="{{ old('name') }}" 
                                />
                                @error('name')
                                    <x-update-error class="mt-2">{{ $message }}</x-update-error>
                                @enderror
                            </div>

                            <!-- X Coordinate -->
                            <div>
                                <x-form-label for="x-coord">X Coordinate</x-form-label>
                                <x-text-input 
                                    id="x-coord" 
                                    name="x-coord" 
                                    class="w-full mt-2"
                                    type="number"
                                    step="any"
                                    placeholder="X Coordinate" 
                                    value="{{ old('x-coord') }}" 
                                />
                                @error('x-coord')
                                    <x-update-error class="mt-2">{{ $message }}</x-update-error>
                                @enderror
                            </div>

                            <!-- Y Coordinate -->
                            <div>
                                <x-form-label for="y-coord">Y Coordinate</x-form-label>
                                <x-text-input 
                                    id="y-coord" 
                                    name="y-coord" 
                                    class="w-full mt-2"
                                    type="number"
                                    step="any"
                                    placeholder="Y Coordinate" 
                                    value="{{ old('y-coord') }}" 
                                />
                                @error('y-coord')
                                    <x-update-error class="mt-2">{{ $message }}</x-update-error>
                                @enderror
                            </div>
                            <!-- Area Image -->
                            <div>
                                <x-form-label for="image">Area Image</x-form-label>
                                <input 
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400"
                                    id="image" 
                                    name="image"
                                    type="file"
                                    aria-describedby="image-help">
                                <span id="image-help" class="text-sm text-gray-500 dark:text-gray-400 ml-2">JPG or WebP - 512x512.</span>
                                @error('image')
                                    <x-update-error class="mt-2">{{ $message }}</x-update-error>
                                @enderror
                            </div>
                        </div>
                        <!-- Map -->
                        <div class="flex-grow">
                            <div id="map" class="w-full h-[450px] mt-2 rounded-md shadow"></div>
                        </div>
                    </div>
                    <div class="py-2">
                        <x-form-label for="caption">Area Description</x-form-label>
                        <x-text-area id="caption" name="caption" class="w-full mt-2" placeholder="Caption" value="{{ old('caption') }}" /> 
                          @error('caption') 
                              <x-update-error class="mt-2">{{ $message }}</x-update-error> 
                          @enderror
                      </div>
                    <!-- Form Buttons -->
                    <div class="py-2 my-2 flex gap-4 justify-center items-center">
                        <x-primary-button>Save Area</x-primary-button>
                        <x-link-button href="{{ route('admin.locations.index') }}">Go Back</x-link-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
  
</x-app-layout>

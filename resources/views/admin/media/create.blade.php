<!-- resources/views/admin/media/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
      <x-h2>Add New Media</x-h2> @section('title', 'Add Media')
    </x-slot>
    <div class="py-2">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
        <div class="bg-white dark:bg-gray-800 p-6 overflow-hidden shadow-sm sm:rounded-lg">
          <form action="{{ route('admin.media.store') }}" method="post" enctype="multipart/form-data"> 
            @csrf 
            {{-- Animal Select --}}
            <div class="py-2">
              <x-form-label for="animal_id">Animal</x-form-label>
              <div id="app">
                <search-component></search-component>
              </div> 
              @error('animal_id') 
              <x-update-error class="mt-2">{{ $message }}</x-update-error> @enderror
            </div>
            {{-- Location --}}
            <div class="py-2">
              <x-form-label for="location_id">Location</x-form-label>
              <x-select-dropdown id="location_id" name="location_id" class="w-full mt-2" :options="$locations" optionLabel="name" optionId="id" :selected="old('location_id')" /> 
                @error('location_id') 
                    <x-update-error class="mt-2">{{ $message }}</x-update-error>
                @enderror
            </div>
            {{-- Age --}}
            <div class="py-2">
              <x-form-label for="age">Age</x-form-label>
              <x-select-dropdown id="age" name="age" class="w-full mt-2" :options="$ages" optionLabel="label" optionId="id" :selected="old('age')" /> @error('age') <x-update-error class="mt-2">{{ $message }}</x-update-error> @enderror
            </div>
            {{-- Gender --}}
            <div class="py-2">
              <x-form-label for="gender">Gender</x-form-label>
              <x-select-dropdown id="gender" name="gender" class="w-full mt-2" :options="$genders" optionLabel="label" optionId="id" :selected="old('gender')" /> 
                @error('gender') 
                    <x-update-error class="mt-2">{{ $message }}</x-update-error> 
                @enderror
            </div>
            {{-- Media Upload --}}
            <div class="py-2">
              <x-form-label for="media">Media</x-form-label>
              <input class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400" id="media" name="media" type="file" aria-describedby="media_help">
              <span id="media_help" class="text-sm text-gray-500 dark:text-gray-400">Picture</span> 
                @error('media') 
                    <x-update-error class="mt-2">{{ $message }}</x-update-error> 
                @enderror
            </div>
            {{-- Rating --}}
            <div class="py-2">
                <x-form-label for="rating">Rating</x-form-label>
                <select id="rating" name="rating" class="w-full mt-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                @error('rating') 
                    <x-update-error class="mt-2">{{ $message }}</x-update-error> 
                @enderror
            </div>

            {{-- Caption --}}
            <div class="py-2">
              <x-form-label for="scientific_name">Caption</x-form-label>
              <x-text-area id="scientific_name" name="scientific_name" class="w-full mt-2" placeholder="Scientific Name" value="{{ old('scientific_name') }}" /> 
                @error('scientific_name') 
                    <x-update-error class="mt-2">{{ $message }}</x-update-error> 
                @enderror
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
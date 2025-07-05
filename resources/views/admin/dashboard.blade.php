<x-public-app-layout>
  <div class="min-h-[85vh] max-w-screen-xl mx-auto space-y-2">

    {{-- Header --}}
    <header class="bg-white dark:bg-gray-800/90 backdrop-blur-sm shadow mb-2">
      <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
        <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">
          Admin Dashboard
        </h1>
      </div>
    </header>

    {{-- Stats grid --}}
    <section class="bg-white dark:bg-gray-800/90 backdrop-blur-sm shadow px-6 py-6 mx-1">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <x-stat-card title="Total Species" count="{{ $animalCount }}" />
        <x-stat-card title="Total Media"   count="{{ $mediaCount }}" />
        <x-stat-card title="Locations"     count="{{ $locationCount }}" />
        <x-stat-card title="Orders"        count="{{ $orderCount }}" />
        <x-stat-card title="Families"      count="{{ $familyCount }}" />
        <x-stat-card title="Genera"        count="{{ $genusCount }}" />
      </div>
    </section>

    {{-- Recently Added Birds --}}
    <section class="bg-white dark:bg-gray-800/90 backdrop-blur-sm shadow px-6 py-6 mx-1">
      <h2 class="text-xl font-semibold text-gray-900 dark:text-white text-center mb-4">
        Recently Added Birds
      </h2>
      <div class="flex flex-wrap justify-center gap-4">
        @foreach ($recentAnimals as $animal)
          <a href="{{ route('admin.animals.show', $animal) }}"
             class="block w-40 h-40 border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow">
            <img
              src="{{ $animal->thumbnail_url }}"
              alt="Thumbnail of {{ $animal->common_name }}"
              class="w-full h-full object-cover"
            />
          </a>
        @endforeach
      </div>
    </section>

    {{-- Recent Media Uploads --}}
    <section class="bg-white dark:bg-gray-800/90 backdrop-blur-sm shadow px-6 py-6 mx-1">
      <h2 class="text-xl font-semibold text-gray-900 dark:text-white text-center mb-4">
        Recent Media Uploads
      </h2>
      <div class="flex flex-wrap justify-center gap-6">
        @foreach ($recentMedia as $media)
          <div class="w-[350px] aspect-w-16 aspect-h-9 border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
            <img
              src="{{ $media->thumbnail_url }}"
              alt="{{ $media->caption }}"
              class="w-full h-full object-cover"
            />
          </div>
        @endforeach
      </div>
    </section>

  </div>
</x-public-app-layout>

<x-app-layout>
    <x-slot name="header">
        <x-h2>Dashboard</x-h2>
        @section('title', 'Dashboard')
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <x-stat-card title="Total Birds" count="{{ $animalCount }}" />
                <x-stat-card title="Total Media" count="{{ $mediaCount }}" />
                <x-stat-card title="Locations" count="{{ $locationCount }}" />
                <x-stat-card title="Orders" count="{{ $orderCount }}" />
                <x-stat-card title="Families" count="{{ $familyCount }}" />
                <x-stat-card title="Genera" count="{{ $genusCount }}" />
            </div>
            <!-- Recent Animals -->
            <div class="mt-6 bg-white dark:bg-gray-800 p-6 shadow-sm rounded-lg">
                <h3 class="text-lg font-bold dark:text-gray-100 text-center">Recently Added Birds</h3>
                <div class="flex gap-2 pt-2 justify-between">
                    @foreach ($recentAnimals as $animal)
                        <div class="lg:w-[160px] lg:h-[160px] w-[128px] h-[128px] rounded-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <img src="{{ $animal->thumbnail_url }}" class="w-full h-full object-cover">
                            <p class="text-center font-semibold mt-2">{{ $animal->common_name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-6 bg-white dark:bg-gray-800 p-6 shadow-sm rounded-lg">
                <h3 class="text-lg font-bold dark:text-gray-100 text-center">Recent Media Uploads</h3>
                <div class="flex gap-4 pt-2">
                    @foreach ($recentMedia as $media)
                        <div class="w-[400px] h-[225px] rounded-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <img src="{{ $media->thumbnail_url }}" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

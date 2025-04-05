@section('title', 'Home')

<x-public-app-layout>
        <div class="mx-auto">
            <div id="animation-carousel" class="relative overflow-hidden w-full mx-auto bg-black" data-carousel="slide">
                <!-- Carousel wrapper -->
                <div class="relative h-[85vh] overflow-hidden rounded-lg">
                    <!-- Item 1 -->
                    <div class="hidden ease-in-out" data-carousel-item>
                        <img src="{{ asset('kingfisher.jpg') }}" class="absolute w-full h-full object-cover object-center" alt="A Kingfisher perched in a tree">
                    </div>
                    <!-- Item 2 -->
                    <div class="hidden ease-in-out" data-carousel-item>
                        <img src="{{ asset('turnstone-image-1.jpg') }}" class="absolute w-full h-full object-cover object-center" alt="A Turnstone standing on a harbour wall">
                    </div>
                    <!-- Item 3 -->
                    <div class="hidden ease-in-out" data-carousel-item>
                        <img src="{{ asset('starling-1.jpg') }}" class="absolute w-full h-full object-cover object-center" alt="A Starling perched in a cherry tree">
                    </div>
                </div>
                <!-- Slider controls -->
                <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
        </div>
</x-public-layout>

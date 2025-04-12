<x-public-app-layout>
    @section('title', 'About - My Project')
    <div>
      <!-- Section 1 -->
      <section class="relative h-[65vh] overflow-hidden group">
        <img src="{{ asset('turnstone-2.jpg') }}"
             alt="A Turnstone stood on a harbour wall"
             class="w-full h-full object-cover transition-transform duration-[5s] group-hover:scale-105 ">
             <div class="absolute inset-y-0 left-0 w-1/2 flex items-center px-8 text-center">
              <div class="bg-black bg-opacity-60 p-4 rounded">
              <h1 class="text-4xl md:text-5xl font-bold text-white">Documenting UK Bird Species and Conservation Status Over Time</h1>
          </div>
        </div>
      </section>
  
      <!-- Section 2 -->
      <section class="relative h-[65vh] overflow-hidden group">
        <img src="{{ asset('kingfisher-3.jpg') }}" alt="Starling sat in a cherry tree" class="w-full h-full object-cover transition-transform duration-[5s] group-hover:scale-105">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute inset-y-0 right-0 w-2/3 flex items-center px-8 justify-end lg:text-right sm:text-center">
            <div class="bg-black bg-opacity-60 p-8 rounded">
              <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">What is the project</h2>
              <p class="text-lg md:text-xl text-white">
                A full-stack web application for cataloguing bird species and integrating conservation data from British Birds' journal reports.
              </p>
          </div>
        </div>
      </section>
  
      <!-- Section 3 -->
      <section class="relative h-[65vh] overflow-hidden group">
        <img src="{{ asset('starling-2.jpg') }}" alt="Kingfisher sat above the water" class="w-full h-full object-cover transition-transform duration-[5s] group-hover:scale-105">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute inset-y-0 left-0 w-2/3 flex items-center px-8 lg:text-left sm:text-center">
            <div class="bg-black bg-opacity-60 p-8 rounded">
              <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">What Features Does It Contain</h2>
              <p class="text-lg md:text-xl text-white">
                Six editions of conservation assessments, an interactive taxonomy diagram, and generalised maps to highlight shared habitats.
              </p>
          </div>
        </div>
      </section>

      <!-- Section 4 -->
      <section class="relative h-[65vh] overflow-hidden group">
        <img src="{{ asset('blackbird-2.jpg') }}" alt="A Blackbird looking out from a log" class="w-full h-full object-cover transition-transform duration-[5s] group-hover:scale-105">
        <div class="absolute inset-0 bg-black opacity-5"></div>
        <div class="absolute inset-y-0 right-0 w-2/3 flex items-center px-8 justify-end lg:text-right sm:text-center">
            <div class="bg-black bg-opacity-60 p-8 rounded">
              <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">What Is The Core Goal</h2>
              <p class="text-lg md:text-xl text-white">
                To improve accessibility to conservation data and provide interactive tools for exploring species information.
              </p>
          </div>
        </div>
      </section>
    </div>
  </x-public-app-layout>

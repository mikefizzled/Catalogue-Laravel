<x-public-app-layout>
    @section('title', 'About - My Project')
    <div>
      <!-- Section 1 -->
      <section class="relative h-[65vh] overflow-hidden group">
        <img src="{{ asset('turnstone-2.jpg') }}"
             alt="Kingfisher sat above the water"
             class="w-full h-full object-cover transition-transform duration-[5s] group-hover:scale-105">
        <div class="absolute inset-0 flex items-center justify-start px-8 lg:text-left sm:text-center">
            <div class="bg-black bg-opacity-60 p-4 rounded">
              <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">What is this project</h1>
              <p class="text-lg md:text-xl text-white">
                A full-stack web application for cataloguing bird species, integrating conservation data from British Birds journal reports.
              </p>
          </div>
        </div>
      </section>
  
      <!-- Section 2 -->
      <section class="relative h-[65vh] overflow-hidden group">
        <img src="{{ asset('kingfisher-3.jpg') }}" alt="Starling sat in a cherry tree" class="w-full h-full object-cover transition-transform duration-[5s] group-hover:scale-105">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="absolute inset-0 flex items-center justify-end px-8 lg:text-right sm:text-center">
            <div class="bg-black bg-opacity-60 p-4 rounded">
              <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">Project Aim</h2>
              <p class="text-lg md:text-xl text-white">
                To improve accessibility to conservation data and provide interactive tools for exploring species information.
              </p>
          </div>
        </div>
      </section>
  
      <!-- Section 3 -->
      <section class="relative h-[65vh] overflow-hidden group">
        <img src="{{ asset('starling-2.jpg') }}" alt="A Turnstone stood on a harbour wall" class="w-full h-full object-cover transition-transform duration-[5s] group-hover:scale-105">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="absolute inset-0 flex items-center justify-start px-8 lg:text-left sm:text-center">
            <div class="bg-black bg-opacity-60 p-4 rounded">
              <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">What Does It Contain</h2>
              <p class="text-lg md:text-xl text-white">
                Six editions of conservation assessments, an interactive taxonomy diagram, and generalised maps to highlight shared habitats.
              </p>
          </div>
        </div>
      </section>
    </div>
  </x-public-app-layout>

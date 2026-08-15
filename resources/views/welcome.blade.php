<x-public-app-layout>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

    @section('title', 'The Bird Project')
    <div class="text-white text-center md:text-left">
      <!-- Section 1 -->
      <section class="relative h-[65vh] overflow-hidden group">
        <img src="{{ Storage::disk('s3')->url('site/images/starling.webp') }}" alt="Starling sat in a cherry tree" class="w-full h-full object-cover object-[80%] md:object-center  transition-transform duration-[5s] group-hover:scale-105 ">
        <div class="absolute left-0 top-0 w-full md:inset-y-0 md:left-0 md:w-2/3 md:flex md:items-center">
          <div class="bg-black bg-opacity-70 p-4 md:p-8 md:rounded-none ">
            <h1 class="text-2xl md:text-5xl font-bold">Documenting UK Bird Species and Conservation Status</h1>
          </div>
        </div>
      </section>
      <!-- Section 2 -->
      <section class="relative h-[65vh] overflow-hidden group">
        <img src="{{ Storage::disk('s3')->url('site/images/kingfisher.webp') }}" alt="Kingfisher sat above the water" class="w-full h-full object-cover object-[8%] md:object-center transition-transform duration-[5s] group-hover:scale-105">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute right-0 top-0 w-full md:inset-y-0 md:right-0 md:w-2/3 md:flex md:items-center md:justify-end">
          <div class="bg-black bg-opacity-70 p-4">
            <h2 class="text-2xl md:text-4xl font-bold mb-2">What is the project</h2>
            <p class="text-sm md:text-lg"> A full-stack web application for cataloguing bird species and integrating conservation data from British Birds' journal reports. </p>
          </div>
        </div>
      </section>
      <!-- Section 3 -->
      <section class="relative h-[65vh] overflow-hidden group">
         <img src="{{ Storage::disk('s3')->url('site/images/turnstone.webp') }}" alt="A Turnstone stood on a harbour wall" class="w-full h-full object-cover object-[92%] md:object-center transition-transform duration-[5s] group-hover:scale-105">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute left-0 top-0 w-full md:inset-y-0 md:left-0 md:w-2/3 md:flex md:items-center">
          <div class="bg-black bg-opacity-70 p-4">
            <h2 class="text-2xl md:text-4xl font-bold mb-2 text-center md:text-left"> What Features Are Included</h2>
            <p class="text-sm md:text-lg"> Six editions of conservation assessments, an interactive taxonomy diagram, and generalised maps to highlight shared habitats. </p>
          </div>
        </div>
      </section>
      <!-- Section 4 -->
      <section class="relative h-[65vh] overflow-hidden group">
        <img src="{{ Storage::disk('s3')->url('site/images/blackbird.webp') }}" alt="A Blackbird looking out from a log" class="w-full h-full  object-cover object-[15%_45%] md:object-center transition-transform duration-[5s] group-hover:scale-105">
        <div class="absolute inset-0 bg-black opacity-5"></div>
        <div class="absolute right-0 top-0 w-full md:inset-y-0 md:right-0 md:w-2/3 md:flex md:items-center md:justify-end">
          <div class="bg-black bg-opacity-70 text-white p-4 rounded-t-lg md:p-8 md:rounded-none">
            <h2 class="text-2xl md:text-4xl font-bold mb-2">What Is The Core Goal</h2>
            <p class="text-sm md:text-lg"> To improve accessibility to conservation data and provide interactive tools for exploring species information. </p>
          </div>
        </div>
      </section>
    </div>
  </x-public-app-layout>

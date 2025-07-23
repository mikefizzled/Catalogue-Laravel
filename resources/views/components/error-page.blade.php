@props([
  'image',            // URL to the background image
  'title',
  'message',
  'buttonText' => 'Return Home',
  'buttonUrl'  => url('/'),
])

<section
  class="absolute inset-0 bg-cover bg-[40%] bg-no-repeat text-white"
  style="background-image: url('{{ $image }}')"
>
  <!-- dark overlay -->
  <div class="absolute inset-0 bg-black bg-opacity-60"></div>

  <!-- text panel -->
  <div class="relative z-10 flex h-full items-center justify-end px-4">
    <div class="max-w-md text-right space-y-4">
      <h1 class="text-4xl font-bold">{{ $title }}</h1>
      <p class="text-lg md:text-xl">{{ $message }}</p>
      <a
        href="{{ $buttonUrl }}"
        class="inline-block bg-indigo-600 hover:bg-indigo-700 
               text-white font-semibold py-3 px-6 rounded-lg transition"
      >
        {{ $buttonText }}
      </a>
    </div>
  </div>
</section>

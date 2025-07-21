@props(['resource','items'])

@php
    use Illuminate\Support\Str;
    $cfg    = config("admin-resources.{$resource}");
    $label  = $cfg['label'];
    $plural = Str::plural($label);
    $route  = $cfg['route'];
@endphp
<x-public-app-layout>
  <div class="min-h-[85vh] max-w-screen-xl mx-auto">
    {{-- Header --}}
    <header class="bg-white dark:bg-gray-800/90 backdrop-blur-sm shadow mb-2">
      <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
        <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">
          Manage {{ $plural }}
        </h1>
        <x-link-button :href="route($route . '.create')">
          + New {{ $label }}
        </x-link-button>
        @section('title', "Manage {$plural}")
      </div>
    </header>

    {{-- List --}}
    <div class="max-w-7xl mx-1">
      <ul class="space-y-2">
        @forelse($items as $item)
          <li class="bg-white dark:bg-gray-800 shadow-sm p-4 hover:shadow-xl transition-shadow">
            <a href="{{ route($route . '.show', $item) }}" class="flex items-center">
              
              {{-- Thumbnail --}}
              @if(! $cfg['thumb_wrapper'] == null)
                <div class="flex-shrink-0 {{ $cfg['thumb_wrapper'] }}">
                  @if(! empty($cfg['thumb_ratio']))
                    <div class="{{ $cfg['thumb_ratio'] }}">
                      <img
                        src="{{ data_get($item, $cfg['thumbnail_field']) }}"
                        alt="{{ data_get($item, $cfg['title_field']) }}"
                        class="w-full h-full object-cover"
                      />
                    </div>
                  @else
                    <img
                      src="{{ data_get($item, $cfg['thumbnail_field']) }}"
                      alt="{{ data_get($item, $cfg['title_field']) }}"
                      class="w-full h-full object-cover"
                    />
                  @endif
                </div>
              @endif

              {{-- Text --}}
              <div class="flex-1 max-w-xl p-4">
                @if(! $cfg['subtitle_field'] == null)
                  <span class="block mb-1 text-xs italic text-gray-500 dark:text-gray-400">
                    {{ is_callable($cfg['subtitle_field'])
                        ? $cfg['subtitle_field']($item)
                        : data_get($item, $cfg['subtitle_field']) }}
                  </span>
                @endif
                <h2 class="font-bold text-xl dark:text-gray-100">
                  {{ is_callable($cfg['title_field'])
                      ? $cfg['title_field']($item)
                      : data_get($item, $cfg['title_field']) }}
                </h2>
              </div>

            </a>
          </li>
        @empty
          <li class="text-center text-gray-600 dark:text-gray-400">
            No {{ strtolower($plural) }} yet.
          </li>
        @endforelse
      </ul>

      <div class="py-4">
        {{ $items->links() }}
      </div>
    </div>
  </div>
</x-public-app-layout>
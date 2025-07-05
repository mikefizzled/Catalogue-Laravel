{{-- resources/views/components/form/ebird-search.blade.php --}}
@props([
  'commonField'     => 'common_name',
  'scientificField' => 'scientific_name',
  'codeField'       => 'ebird_species_code',
  'genusField'      => 'genus_id',
  'initial'         => '',
])

<div x-data="ebirdSearch('{{ $initial }}')" class="py-2">
  <x-form.label :for="$commonField">Common Name</x-form.label>

  <div class="flex items-center gap-2">
    <input
      x-model="query"
      id="{{ $commonField }}"
      name="{{ $commonField }}"
      type="text"
      placeholder="Common Name"
      class="mt-1 block w-full p-3 text-gray-900 dark:text-gray-400
             border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900
             focus:border-indigo-500 focus:ring-indigo-500 shadow-sm focus:shadow-md"
    />

    <x-button
      type="button"
      @click="search()"
      class="p-1 bg-blue-600 text-white rounded hover:bg-blue-700"
    >
      Search eBird
    </x-button>
  </div>

  <div
    x-show="results.length"
    x-transition
    class="bg-white dark:bg-gray-800 shadow max-h-60 overflow-auto z-10 my-1"
    x-ref="resultsBox"
  >
    <template x-for="item in results" :key="item.speciesCode">
      <p
        @click="select(item)"
        class="cursor-pointer p-2 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400"
        x-text="`${item.comName} (${item.sciName})`"
      ></p>
    </template>
  </div>

  @error($commonField)
    <x-update-error class="mt-2">{{ $message }}</x-update-error>
  @enderror
</div>

<script>
  function ebirdSearch(initial = '') {
    return {
      query: initial,
      results: [],

      async search() {
        if (this.query.length < 3) return;
        let res = await fetch(`/search-ebird?query=${encodeURIComponent(this.query)}`);
        let data = await res.json();
        this.results = data.error ? [] : data;
      },

      select(item) {
        document.getElementById('{{ $commonField }}').value       = item.comName;
        document.getElementById('{{ $scientificField }}').value = item.sciName;
        document.getElementById('{{ $codeField }}').value       = item.speciesCode;

        let genus = item.sciName.split(' ')[0].toLowerCase();
        let sel   = document.getElementById('{{ $genusField }}');
        Array.from(sel.options).forEach(o => {
          if (o.text.toLowerCase() === genus) o.selected = true;
        });

        this.results = [];
      },
    }
  }
</script>

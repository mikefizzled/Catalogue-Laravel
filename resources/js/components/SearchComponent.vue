<template>
  <div style="position: relative;">
    <input type="text" v-model="query" @input="searchSpecies" @focus="showResults = true" placeholder="Search for species..." class="w-full mt-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
    <div v-if="speciesResults.length && showResults" style="position: absolute; background: white; border: 1px solid #ccc; width: 100%; z-index: 10;">
      <ul class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300  focus:border-indigo-500 focus:ring-indigo-500">
        <li v-for="species in speciesResults" :key="species.id" @click="selectSpecies(species)" style="cursor: pointer; padding: 8px; border-bottom: 1px solid grey;">
          {{ species.common_name }}
        </li>
      </ul>
    </div>
    <input type="hidden" name="animal_id" :value="selectedSpecies.id">
  </div>
</template>

<script>
export default {
  data() {
    return {
      query: '',
      speciesResults: [],
      selectedSpecies: {},
      showResults: false
    };
  },
  methods: {
    searchSpecies() {
      if (this.query.length > 0) {
        console.log('Fetching data for:', this.query);
        fetch(`/admin/search-species?query=${this.query}`)
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {
            console.log('Data received:', data);
            this.speciesResults = data;
          })
          .catch(error => {
            console.error('Error fetching data:', error);
          });
      } else {
        this.speciesResults = [];
        this.showResults = false;
      }
    },
    selectSpecies(species) {
      this.selectedSpecies = species;
      this.query = species.common_name;
      this.showResults = false;
    },
    selectAll(event) {
      event.target.select();
    }
  }
};
</script>

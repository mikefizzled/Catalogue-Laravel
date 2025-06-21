<x-public-app-layout>
  @section('title', 'Changelog')

  <div class="min-h-[85vh] bg-gray-200 dark:bg-gray-900 py-6 px-2 sm:px-4">
    <div class="max-w-4xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
      <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-gray-100 mb-6">Changes</h1>

      <div class="space-y-6">
        <div class="bg-gray-200 dark:bg-gray-700 shadow rounded p-5">
          <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">v1.01 – June 2025</h2>
          <ul class="list-disc list-inside text-gray-800 dark:text-gray-200">
            <li>Added external resources for individual birds (e.g. articles, livestreams, etc.)</li>
            <li>Added dynamic map centering for individual birds</li>
            <li>Replace references of "Catalogue" in favour of "Birds"</li>
            <li>Bird pages and filtering now use cleaner web addresses</li>
          </ul>
        </div>

        <div class="bg-gray-200 dark:bg-gray-700 shadow rounded p-5">
          <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">v1.0 – Dissertation - May 2025</h2>
          <ul class="list-disc list-inside text-gray-800 dark:text-gray-200">
            <li>Initial release of bird conservation platform</li>
            <li>Includes birds, conservation status, and media</li>
            <li>Interactive mapping of media locations</li>
            <li>Interactive taxonomic dendrogram</li>
            <li>Simple home and conservation pages</li>
            <li>Simple consistent styling and branding, along with both light and dark mode</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</x-public-app-layout>

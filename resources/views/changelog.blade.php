<x-public-app-layout>
  @section('title', 'Changelog')

  <div class="min-h-[85vh] bg-gray-200 dark:bg-gray-900 py-6 px-2 sm:px-4">
    <div class="max-w-4xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
      <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-gray-100 mb-6">Changes</h1>

      <div class="space-y-6">
        <div class="bg-gray-200 dark:bg-gray-700 shadow rounded p-5">
          <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">v1.1 – June 2025</h2>
          <ul class="list-disc list-inside text-gray-800 dark:text-gray-200">
            <li>Added external resources for indivudal birds (e.g. articles, livestreams, etc.)</li>
            <li>Added dynamic map centering for individual birds</li>
            <li>Replace references of "Catalogue" in favour of "Birds"</li>
            <li>Bird pages now use cleaner web addresses (e.g. /birds/peregrine-falcon)</li>
          </ul>
        </div>

        <div class="bg-gray-200 dark:bg-gray-700 shadow rounded p-5">
          <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">v1.0 – Dissertation - May 2025</h2>
          <ul class="list-disc list-inside text-gray-800 dark:text-gray-200">
            <li>Initial release of bird conservation platform</li>
            <li>Includes taxonomy browsing, conservation status, and personal media</li>
            <li>Interactive mapping of sighting locations</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</x-public-app-layout>

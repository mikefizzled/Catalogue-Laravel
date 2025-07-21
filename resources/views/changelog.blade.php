<x-public-app-layout>
  @section('title', 'Changelog')

    <div class="min-h-[85vh] max-w-screen-xl mx-auto space-y-2">
        <!-- Heading Section -->
        <div class="bg-white dark:bg-gray-800/90 shadow-xl px-6 py-6">
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">Changes</h1>
        </div>
      <div class="space-y-6">
        <div class="bg-gray-200 dark:bg-gray-700 shadow p-5">
          <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">v1.01 – June 2025</h2>
          <ul class="list-disc list-inside text-gray-800 dark:text-gray-200">
            <li>Added external resources for individual birds (e.g. articles, livestreams, etc.)</li>
            <li>Added dynamic map centering for individual birds</li>
            <li>Replace references of "Catalogue" in favour of "Birds"</li>
            <li>Bird index and filtering use bird names, rather than numbers. Filtering also improved.</li>
            <li>Added the changelog page</li>
            <li>Visual redesign for all pages, navigation bars and branding</li>
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
            <li>Simple styling and limited branding, along with both light and dark mode</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</x-public-app-layout>

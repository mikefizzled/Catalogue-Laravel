<nav    x-data="{ open: false }" 
        class="bg-white dark:bg-gray-800 border-b border-gray-300" aria-label="Primary site navigation">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">

                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2 group">
                        <x-application-logo class="w-12 h-12 " />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:items-center sm:ml-6 sm:flex">
                    <a href="{{ url('/birds') }}"           class="text-gray-700 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-300 hover:scale-110 text-xl">
                        Birds
                    </a>
                    <a href="{{ url('/map') }}"             class="text-gray-700 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-300 hover:scale-110 text-xl">
                        Map
                    </a>
                    <a href="{{ url('/conservation') }}"    class="text-gray-700 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-300 hover:scale-110 text-xl">
                        Conservation
                    </a>
                    <a href="{{ url('/taxonomy') }}"        class="text-gray-700 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-300 hover:scale-110 text-xl">
                        Taxonomy
                    </a>

                    <!-- Login/Register -->
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('admin/dashboard') }}" class="text-gray-700 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-300 hover:scale-110 text-xl">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="hidden text-gray-700 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-300 hover:scale-110 text-xl">
                                Log in
                            </a>
                        @endauth
                    @endif
                </div>
            <!-- Hamburger Menu (Mobile) -->
            <div class=" flex items-center sm:hidden">
                <button @click="open = ! open" type="button" :aria-expanded="open.toString()"
                aria-controls="mobile-menu"
                :aria-label="open ? 'Close menu' : 'Open menu'"
                aria-label="Toggle mobile navigation" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 dark:text-gray-100 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-label="Menu" aria-hidden="true">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Menu
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div id="mobile-menu"  :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ url('/') }}" class="block text-gray-700 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-300 px-4 py-2 text-base font-medium">
                Home
            </a>
            <a href="{{ url('/birds') }}" class="block text-gray-700 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-300 px-4 py-2 text-base font-medium">
                Birds
            </a>
            <a href="{{ url('/map') }}" class="block text-gray-700 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-300 px-4 py-2 text-base font-medium">
                Map
            </a>
            <a href="{{ url('/conservation') }}" class="block text-gray-700 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-300 px-4 py-2 text-base font-medium">
                Conservation
            </a>
            <a href="{{ url('/taxonomy') }}" class="block text-gray-700 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-300 px-4 py-2 text-base font-medium">
                Taxonomy
            </a>
        </div>

        @if (Route::has('login'))
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                @auth
                    <a href="{{ url('/admin/dashboard') }}" class="block text-gray-700 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-300 px-4 py-2 text-base font-medium">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block text-gray-700 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-300 px-4 py-2 text-base font-medium">
                        Log in
                    </a>
                @endauth
            </div>
        @endif
    </div>
</nav>

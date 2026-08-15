<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-300" aria-label="Primary site navigation">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="flex items-center space-x-2 group hover:scale-105 transition-transform duration-200">
                    <x-application-logo class="w-12 h-12 " />
                </a>
            </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:items-center sm:ml-6 sm:flex">
                    <x-nav-link 
                        :href="route('birds.index')"    
                        :active="request()->routeIs('birds.index')">
                        {{ __('Birds') }}
                    </x-nav-link>
                    <x-nav-link
                        :href="route('map')"
                        :active="request()->routeIs('map')">
                        {{ __('Map') }}
                    </x-nav-link>
                    <x-nav-link 
                        :href="route('conservation')"   
                        :active="request()->routeIs('conservation')">
                        {{ __('Conservation') }}
                    </x-nav-link>
                    <x-nav-link 
                        :href="route('taxonomy')"
                        :active="request()->routeIs('taxonomy')">
                        {{ __('Taxonomy') }}
                    </x-nav-link>
                    <x-nav-link 
                        :href="route('about')"
                        :active="request()->routeIs('about')">
                        {{ __('About') }}
                    </x-nav-link>
                    <!-- Login/Register -->
                    @if (Route::has('login'))
                        @auth
                            <x-nav-link 
                                :href="route('admin.dashboard')"
                                :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @else
                            <!--
                            <x-nav-link 
                                :href="route('login')"
                                :active="request()->routeIs('login')">
                                {{ __('Login') }}
                            </x-nav-link>
                            -->
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
            <x-responsive-nav-link 
                :href="route('home')"
                :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link 
                :href="route('birds.index')"
                :active="request()->routeIs('birds.index')">
                {{ __('Birds') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link 
                :href="route('map')"
                :active="request()->routeIs('map')">
                {{ __('Map') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link 
                :href="route('conservation')"   
                :active="request()->routeIs('conservation')">
                {{ __('Conservation') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link 
                :href="route('taxonomy')"
                :active="request()->routeIs('taxonomy')">
                {{ __('Taxonomy') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link 
                :href="route('about')"
                :active="request()->routeIs('about')">
                {{ __('About') }}
            </x-responsive-nav-link>
        </div>

        @if (Route::has('login'))
            
                @auth
                <div class="py-2 border-t border-gray-200 dark:border-gray-600">
                    <x-responsive-nav-link 
                        :href="route('admin.dashboard')"
                        :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                </div>
                @else
                <!--div class="py-2 border-t border-gray-200 dark:border-gray-600">
                    <x-responsive-nav-link 
                        :href="route('login')"
                        :active="request()->routeIs('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                </div-->
                @endauth
            </div>
        @endif
    </div>
</nav>

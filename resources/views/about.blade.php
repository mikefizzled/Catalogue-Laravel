<x-public-app-layout>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @section('title', 'The Bird Project')

    <div class="text-white">
        <div class="bg-black/70 p-5 text-center">
            <h1 class="text-4xl font-semibold md:text-5xl">
                About The Project
            </h1>
        </div>

        {{-- Intro section --}}
        <section class="relative flex min-h-[60vh] items-center overflow-hidden py-8">
            <img src="{{ Storage::disk('s3')->url('site/images/kingfisher.webp') }}" alt="Kingfisher sat above the water"
                class="absolute inset-0 z-0 h-full w-full object-cover object-[8%] md:object-center">

            <div class="absolute inset-0 z-10 bg-black/20"></div>

            <div class="relative z-20 flex w-full justify-end px-4 md:px-8">
                <div class="w-full space-y-4 rounded bg-black/80 p-6 shadow-2xl lg:w-[60vw] lg:p-8">
                    <p class="text-xl font-semibold md:text-3xl">
                        Hello! I'm Mike, a full-stack developer based in Sheffield.
                    </p>

                    <p class="text-lg font-light text-gray-200 md:text-2xl">
                        This project was developed as part of my final year dissertation while studying Computer Science at
                        Sheffield Hallam University, where I graduated with First Class Honours.
                    </p>

                    <p class="text-lg font-light text-gray-200 md:text-2xl">
                        Using data from the British Birds journal, the aim was to bridge the gap between their reports
                        and mainstream wildlife platforms such as the RSPB and BirdGuides. One of the main reasons for
                        this is that conservation can be narrative, with success stories and declines often being
                        reduced to singular assessments that lack historical context or criteria.
                    </p>

                    <p class="text-lg font-light text-gray-200 md:text-2xl">
                        I also explored other areas of data visualisation, such as mapping and interactive taxonomy. All
                        media was collected or created by myself - for better or worse!
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 py-2">
                        {{-- GitHub Button --}}
                        <!-- GitHub SVG from https://www.svgrepo.com/svg/512317/github-142 -->
                    
                        <a href="https://github.com/mikefizzled/Catalogue-Laravel" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-neutral-800 hover:bg-neutral-700 hover:scale-105 text-white font-medium rounded-lg border border-gray-700 transition duration-150 shadow-lg">
                            <!-- Githhub SVG --> 
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 291.32 291.32">
                                <path style="fill:#FFFFFF;" d="M145.66 0C65.219 0 0 65.219 0 145.66c0 80.45 65.219 145.66 145.66 145.66s145.66-65.21 145.66-145.66C291.319 65.219 226.1 0 145.66 0zm40.802 256.625c-.838-11.398-1.775-25.518-1.83-31.235-.364-4.388-.838-15.549-11.434-22.677 42.068-3.523 62.087-26.774 63.526-57.499 1.202-17.497-5.754-32.883-18.107-45.3.628-13.282-.401-29.023-1.256-35.941-9.486-2.731-31.608 8.949-37.79 13.947-13.037-5.062-44.945-6.837-64.336 0-13.747-9.668-29.396-15.64-37.926-13.974-7.875 17.452-2.813 33.948-1.275 35.914-10.142 9.268-24.289 20.675-20.447 44.572 6.163 35.04 30.816 53.94 70.508 58.564-8.466 1.73-9.896 8.048-10.606 10.788-26.656 10.997-34.275-6.791-37.644-11.425-11.188-13.847-21.23-9.832-21.849-9.614-.601.218-1.056 1.092-.992 1.511.564 2.986 6.655 6.018 6.955 6.263 8.257 6.154 11.316 17.27 13.2 20.438 11.844 19.473 39.374 11.398 39.638 11.562.018 1.702-.191 16.032-.355 27.184C64.245 245.992 27.311 200.2 27.311 145.66c0-65.365 52.984-118.348 118.348-118.348S264.008 80.295 264.008 145.66c0 51.008-32.318 94.332-77.546 110.965z"/>                    </svg>
                            View Source on GitHub
                        </a>

                        {{-- LinkedIn Button --}}
                        <!-- LinkedIn SVG from https://www.svgrepo.com/svg/28145/linkedin-round -->
                        <a href="https://www.linkedin.com/in/michael-reaney/" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-neutral-800 hover:bg-neutral-700 hover:scale-105 text-white font-medium rounded-lg transition duration-150 shadow-lg">
                            <svg class="w-6 h-6" viewBox="0 0 291.319 291.319">
                                <g>
                                    <path style="fill:#0a66c2;" d="M145.659,0c80.45,0,145.66,65.219,145.66,145.66s-65.21,145.659-145.66,145.659S0,226.1,0,145.66
                                        S65.21,0,145.659,0z"/>
                                    <path style="fill:#FFFFFF;" d="M82.079,200.136h27.275v-90.91H82.079V200.136z M188.338,106.077
                                        c-13.237,0-25.081,4.834-33.483,15.504v-12.654H127.48v91.21h27.375v-49.324c0-10.424,9.55-20.593,21.512-20.593
                                        s14.912,10.169,14.912,20.338v49.57h27.275v-51.6C218.553,112.686,201.584,106.077,188.338,106.077z M95.589,100.141
                                        c7.538,0,13.656-6.118,13.656-13.656S103.127,72.83,95.589,72.83s-13.656,6.118-13.656,13.656S88.051,100.141,95.589,100.141z"/>
                                </g>
                            </svg>
                            Connect on LinkedIn
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- Technical section --}}
        <section class="relative flex min-h-[70vh] items-center overflow-hidden py-8">
            <img src="{{ Storage::disk('s3')->url('site/images/starling.webp') }}" alt="A Starling sat in a cherry tree"
                class="absolute inset-0 z-0 h-full w-full object-cover object-[80%] md:object-center">

            <div class="absolute inset-0 z-10 bg-black/20"></div>

            <div class="relative z-20 flex w-full justify-start px-4 md:px-8">
                <div class="w-full space-y-4 rounded bg-black/80 p-6 shadow-2xl lg:w-[60vw] lg:p-8">
                    <div>
                        <h2 class="text-2xl font-semibold tracking-tight md:text-4xl">
                            Documenting UK Bird Species and Conservation Status
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 gap-8 text-left text-sm lg:grid-cols-2 md:text-base">
                        <div class="space-y-3">
                            <h3 class="border-b border-gray-600 pb-1 text-xl md:text-2xl space-y-2">
                                Tech Stack
                            </h3>

                            <ul class="font-light text-gray-200 text-lg md:text-xl space-y-4">
                                <li>
                                    <strong>Backend Framework:</strong>
                                    Laravel (PHP)
                                </li>

                                <li>
                                    <strong>Database Engine:</strong>
                                    MySQL
                                </li>
                                <li>
                                    <strong>Frontend Architecture:</strong>
                                    Blade templates, Tailwind CSS, Leaflet.js for interactive mapping, and a D3.js
                                    cluster tree for the taxonomical graph.
                                </li>
                                <li>
                                    <strong>Deployed via Laravel Forge</strong>
                                </li>
                            </ul>
                        </div>

                        <div class="space-y-3">
                            <h3 class="border-b border-gray-600 pb-1 text-xl md:text-2xl space-y-2">
                                Key Engineering Features
                            </h3>

                            <ul class="font-light text-gray-200 text-lg md:text-xl space-y-4">
                                <li>
                                    <strong>Relational Architecture:</strong>
                                    A full relational database of taxonomy, species, conservation data and criteria. Controlled via 
                                    an admin CRUD system.
                                </li>

                                <li>
                                    <strong>Content Pipeline</strong>
                                    An automated CLI media pipeline that manages thumbnail creation and image compression via jpegoptim and cwebp,
                                    as well as handling uploads and delivery of Amazon S3 hosted media.
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="rounded-r border-t-2 border-grey-500 bg-white/5 p-4 font-light text-gray-200 text-lg md:text-xl space-y-2">
                        <span class="mb-1 block font-semibold">
                            Bird Safety & Privacy Architecture
                        </span>

                        <p class="text-gray-300">
                            During image processing, location telemetry is stripped to protect vulnerable nesting sites, while camera EXIF data is preserved for technical context. 
                            Ethical guidelines are followed but not automatically enforced, instead I will not upload media of protected UK species during critical nesting windows.
                        </p>
                    </div>
                </div>
            </div>
        
        </section>
    </div>
</x-public-app-layout>

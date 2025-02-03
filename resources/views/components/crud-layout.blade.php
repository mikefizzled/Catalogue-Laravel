<div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            {{$outside ?? ''}}
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 overflow-hidden shadow-sm sm:rounded-lg">
            {{ $inside ?? '' }}
        </div>
    </div>
</div>
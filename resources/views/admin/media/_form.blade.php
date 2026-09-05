<form action="{{ route('admin.media.update', $media) }}" method="POST" enctype="multipart/form-data"
    class="space-y-6 px-2">
    @csrf
    @method('PUT')


    {{-- Media Preview --}}
    @if ($media->media_type === 'image')
        <div class="flex justify-center w-full">
            <img src="{{ $media->media_url }}" alt="{{ $media->caption }}"
                class="max-h-96 w-auto object-contain rounded-lg shadow-sm">
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Media Info Table --}}
        <table
            class="w-full border-collapse dark:text-gray-100 text-left border border-gray-300 dark:border-gray-700 rounded-md">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700">
                    <th colspan="2" class="p-2 text-left font-bold">Media Info</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="p-2 w-1/3">Bird:</th>
                    <td class="p-2">
                        <x-form.table-select name="animal_id" id="animal_id" :options="$animals->pluck('common_name', 'id')->toArray()" :selected="old('animal_id', $media->animal_id ?? '')"
                            required />
                    </td>
                </tr>
                <tr>
                    <th class="p-2">Location:</th>
                    <td class="p-2">
                        <x-form.table-select name="location_id" id="location_id" :options="$locations->pluck('name', 'id')->toArray()" :selected="old('location_id', $media->location_id ?? '')"
                            required />
                    </td>
                </tr>
                <tr>
                    <th class="p-2">Date Taken:</th>
                    <td class="p-2"><x-form.table-text type="datetime-local" name="date_taken" id="date_taken"
                            :value="old(
                                'date_taken',
                                $media->date_taken
                                    ? \Carbon\Carbon::parse($media->date_taken)->format('F j, Y g:i A')
                                    : '',
                            )" />
                    </td>
                </tr>
                <tr>
                    <th class="p-2">Caption:</th>
                    <td class="p-2">
                        <x-form.table-text 
                            name="caption" id="caption" label="Caption" 
                            placeholder="Enter a caption"
                            :value="old('caption', $media->caption ?? '')" required />
                    </td>
                </tr>
                <tr>
                    <th class="p-2">Rating:</th>
                    <td class="p-2">
                        <x-form.table-select 
                            name="rating" id="rating" 
                            :options="collect(range(1, 10))->mapWithKeys(fn($i) => [$i => $i])->all()" 
                            :selected="old('rating', $media->rating ?? '')"
                            required />
                    </td>
                </tr>
                <tr>
                    <th class="p-2">Gender:</th>
                    <td class="p-2">
                        <x-form.table-select 
                            name="gender" 
                            id="gender" 
                            :options="collect($genders)
                            ->mapWithKeys(fn($g) => [strtolower($g['id']) => ucfirst($g['label'])])->all()" 
                            :selected="old('gender', strtolower($media->gender ?? ''))"
                            required />
                    </td>
                </tr>
                <tr>
                    <th class="p-2">Age:</th>
                    <td class="p-2">
                        <x-form.table-select name="age" id="age" :options="collect($ages)
                            ->mapWithKeys(fn($a) => [strtolower($a['id']) => ucfirst($a['label'])])
                            ->all()" :selected="old('age', strtolower($media->age ?? ''))"
                            required />
                    </td>
                </tr>
                <tr>
                    <th class="p-2">SHA-256:</th>
                    <td class="p-2 break-all font-mono text-sm">
                        <x-form.table-text name="hash" id="hash" label="SHA-256 Hash"
                            placeholder="Enter the sha-256 hash" :value="old('hash', $media->hash ?? '')" required />
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Metadata Table --}}
        <table
            class="w-full border-collapse dark:text-gray-100 text-left border border-gray-300 dark:border-gray-700 rounded-md">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700">
                    <th class="p-2 text-left w-5/12">Key</th>
                    <th class="p-2 text-left w-6/12">Value</th>
                    <th class="p-2 text-center w-1/12">
                        <button type="button" id="add-metadata-row"
                            class="px-2 py-0.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded text-sm"
                            title="Add new metadata field">
                            +
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody id="metadata-tbody">
                @forelse ($metadata as $key => $value)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="p-1.5">
                            <x-form.table-text name="meta_keys[]" :value="$key" placeholder="Key" />
                        </td>
                        <td class="p-1.5">
                            <x-form.table-text name="meta_values[]" :value="$value" placeholder="Value" />
                        </td>
                        <td class="p-1.5 text-center">
                            <button type="button"
                                class="remove-metadata-row inline-flex items-center justify-center w-7 h-7 bg-red-500/10 hover:bg-red-500 text-red-600 hover:text-white rounded transition-colors font-bold text-sm"
                                aria-label="Remove metadata row" title="Remove row">
                                ✕
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr id="no-metadata-row">
                        <td colspan="3" class="p-4 text-center text-sm text-gray-500 dark:text-gray-400">
                            No metadata entries. Click <strong class="text-blue-500">+</strong> to add one.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Form Buttons --}}
    <div class="flex gap-4 justify-center pt-4">
        <x-primary-button>{{ 'Update Media' }}</x-primary-button>
        <x-link-button :href="route('admin.media.index')">Go Back</x-link-button>
    </div>
</form>


<script>
const metadataTbody = document.getElementById('metadata-tbody');
const addMetadataButton = document.getElementById('add-metadata-row');

addMetadataButton.addEventListener('click', function () {
    const newRow = document.createElement('tr');

    newRow.classList.add(
        'border-t',
        'border-gray-200',
        'dark:border-gray-700'
    );

const inputClasses = `
    mt-1 w-full px-3 py-1 text-md rounded-md
    text-gray-900 dark:text-gray-100
    border-gray-300 dark:border-gray-700
    bg-white dark:bg-gray-800
    focus:border-indigo-500 focus:ring-indigo-500
    shadow-sm
`;

const removeButtonClasses = `
    remove-metadata-row inline-flex items-center justify-center w-7 h-7 
    bg-red-500/10 hover:bg-red-500 text-red-600 
    hover:text-white rounded transition-colors font-bold text-sm`;

    newRow.innerHTML = `
        <td class="p-1.5">
            <input type="text" name="meta_keys[]" placeholder="Key" class="${inputClasses}">
        </td>
        <td class="p-1.5">
            <input type="text" name="meta_values[]" placeholder="Value" class="${inputClasses}">
        </td>
        <td class="p-1.5 text-center">
            <button
                type="button"
                class="${removeButtonClasses}">
                ✕
            </button>
        </td>
    `;

    metadataTbody.appendChild(newRow);
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-metadata-row')) {
        e.target.closest('tr').remove();
    }
});

</script>
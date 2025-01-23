<x-app-layout>
    <x-slot name="header">
        <x-h2>
            Create Genera
        </x-h2>
        @section('title', 'Create Genera')
    </x-slot>
    <x-crud-layout>
        <x-slot name="inside">
            <form action="{{ route('admin.genera.store') }}" method="post">
                @csrf
                <div class="py-2">
                    <x-h3>Genera Name</x-h3>
                    <x-text-input name="genera_name" class="w-full mt-2" placeholder="Genera Name" value=""></x-text-input>
                    
                    @error('genera_name')
                        <x-update-error class="mt-2"> {{ $message }}</x-update-error>
                    @enderror
                </div>
                <div class="py-2 my-2 flex gap-4">
                    <x-primary-button>Save Genera</x-primary-button>
                    <x-link-button href="{{ route('admin.genera.index')}}">Go Back</x-link-button>
                </div>
            </form>
        </x-slot>
    </x-crud-layout>
</x-app-layout>

<x-admin-resource-show
  heading="Family – {{ $family->family_name }}"
  pageTitle="{{ $family->family_name }}"
>
<x-slot name="actions">
    <x-action-buttons
      :edit-url="route('admin.families.edit',  $family)"
      :delete-url="route('admin.families.destroy', $family)"
      resource-name="family"
    />
</x-slot>
  <div class="flex flex-col sm:flex-row sm:justify-between text-sm text-gray-600 dark:text-gray-400">
    <div class="space-x-4">
      <span><strong>Created:</strong> {{ $family->created_at->diffForHumans() }}</span>
      <span><strong>Updated:</strong> {{ $family->updated_at->diffForHumans() }}</span>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2">
    <div class="space-y-2 text-gray-900 dark:text-white">
        <h2 class="text-lg font-semibold">Details</h2>
        <p><strong>Class:</strong> Aves</p>
        <p><strong>Parent Order: </strong> <a href="{{route('admin.orders.show', $family->order)}}" class="hover:underline">{{ $family->order->order_name  }}</a>
        <p><strong>Family Name: </strong> {{ $family->family_name }}</p>
        <p><strong>Family Common Names: </strong> {{ $family->common_name }}</p>
    </div>

    <div class="space-y-2">
      <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Genera in this Order</h2>
      <ul class="list-disc list-inside text-gray-700 dark:text-gray-300">
        @forelse($family->genera as $genus) 
          <li>
            <a href="{{ route('admin.genera.show',$genus) }}" class="hover:underline">
              {{ $genus->genus_name }}
            </a>
          </li>
        @empty
          <li>No genera yet.</li>
        @endforelse
      </ul>
    </div>
  </div>
</x-admin-resource-show>

<x-admin-resource-show
  heading="Genus – {{ $genus->genus_name }}"
  pageTitle="{{ $genus->genus_name }}"
>
<x-slot name="actions">
    <x-action-buttons
      :edit-url="route('admin.genera.edit',  $genus)"
      :delete-url="route('admin.genera.destroy', $genus)"
      resource-name="genus"
    />
</x-slot>
  <div class="flex flex-col sm:flex-row sm:justify-between text-sm text-gray-600 dark:text-gray-400">
    <div class="space-x-4">
      <span><strong>Created:</strong> {{ $genus->created_at->diffForHumans() }}</span>
      <span><strong>Updated:</strong> {{ $genus->updated_at->diffForHumans() }}</span>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2">
    <div class="space-y-2 text-gray-900 dark:text-white">
        <h2 class="text-lg font-semibold">Details</h2>
        <p><strong>Class:</strong> Aves</p>
        <p><strong>Parent Order: </strong> <a href="{{route('admin.orders.show', $genus->family->order)}}" class="hover:underline">{{  $genus->family->order->order_name  }}</a></p>
        <p><strong>Parent Family: </strong><a href="{{route('admin.families.show', $genus->family->family_name)}}" class="hover:underline">{{  $genus->family->family_name  }}</a> </p>
        <p><strong>Genus Name: </strong> {{ $genus->genus_name }} </p>
    </div>

    <div class="space-y-2">
      <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Species in this Order</h2>
      <ul class="list-disc list-inside text-gray-700 dark:text-gray-300">
        @forelse($genus->animals as $animal) 
          <li>
            <a href="{{ route('admin.animals.show',$animal) }}" class="hover:underline">
              {{ $animal->common_name }}
            </a>
          </li>
        @empty
          <li>No species yet.</li>
        @endforelse
      </ul>
    </div>
  </div>
</x-admin-resource-show>
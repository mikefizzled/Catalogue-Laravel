<x-admin-resource-show
  heading="Order – {{ $order->order_name }}"
  pageTitle="{{ $order->order_name }}"
>
<x-slot name="actions">
    <x-action-buttons
      :edit-url="route('admin.orders.edit',  $order)"
      :delete-url="route('admin.orders.destroy', $order)"
      resource-name="order"
    />
</x-slot>
  <div class="flex flex-col sm:flex-row sm:justify-between text-sm text-gray-600 dark:text-gray-400">
    <div class="space-x-4">
      <span><strong>Created:</strong> {{ $order->created_at->diffForHumans() }}</span>
      <span><strong>Updated:</strong> {{ $order->updated_at->diffForHumans() }}</span>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2">
    <div class="space-y-2 text-gray-900 dark:text-white">
      <h2 class="text-lg font-semibold">Details</h2>
      <p><strong>Class:</strong> Aves</p>
      <p><strong>Order Name:</strong> {{ $order->order_name }}</p>
    </div>

    <div class="space-y-2">
      <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Families in this Order</h2>
      <ul class="list-disc list-inside text-gray-700 dark:text-gray-300">
        @forelse($order->families as $family)
          <li>
            <a href="{{ route('admin.families.show',$family) }}" class="hover:underline">
              {{ $family->family_name }}
            </a>
          </li>
        @empty
          <li>No families yet.</li>
        @endforelse
      </ul>
    </div>
  </div>
</x-admin-resource-show>

@extends('admin.layouts.master'){{-- আপনার layout --}}
@section('admin')

<div class="max-w-5xl p-6 mx-auto space-y-6">
  <div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold">Edit Menu: {{ $menu->name }}</h1>
  </div>

  <div class="grid gap-6 md:grid-cols-2">
    {{-- Left: Existing items --}}
    <div class="p-4 bg-white border rounded-xl">
      <h2 class="mb-3 font-medium">Menu Items</h2>

      <ul class="space-y-2">
        @foreach($menu->items()->whereNull('parent_id')->orderBy('sort_order')->get() as $it)
          <li class="p-2 border rounded-lg">
            <div class="flex justify-between">
              <span>{{ $it->label }}</span>
              <span class="text-xs text-gray-500">#{{ $it->sort_order }}</span>
            </div>
          </li>
        @endforeach
      </ul>
    </div>

    {{-- Right: Add new item form --}}
    <div class="p-4 bg-white border rounded-xl">
      <h2 class="mb-3 font-medium">Add Item</h2>

      {{-- আপনার ফর্ম এখানে --}}
      <form method="POST" action="{{ route('admin.menu-items.store') }}" class="space-y-3">
        @csrf
        <input type="hidden" name="menu_id" value="{{ $menu->id }}">

        <div>
          <label class="text-sm">Label</label>
          <input name="label" class="w-full px-3 py-2 border rounded-lg">
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="text-sm">URL</label>
            <input name="url" class="w-full px-3 py-2 border rounded-lg" placeholder="/about">
          </div>
          <div>
            <label class="text-sm">Route name</label>
            <input name="route_name" class="w-full px-3 py-2 border rounded-lg" placeholder="dashboard">
          </div>
        </div>

        <div class="grid grid-cols-3 gap-3">
          <div>
            <label class="text-sm">Parent</label>
            <select name="parent_id" class="w-full px-3 py-2 border rounded-lg">
              <option value="">None</option>
              @foreach($menu->items()->whereNull('parent_id')->get() as $p)
                <option value="{{ $p->id }}">{{ $p->label }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="text-sm">Sort</label>
            <input type="number" name="sort_order" value="0" class="w-full px-3 py-2 border rounded-lg">
          </div>
          <div class="flex items-end gap-2">
            <input type="checkbox" name="is_active" value="1" checked>
            <label class="text-sm">Active</label>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="text-sm">Role (optional)</label>
            <input name="role" class="w-full px-3 py-2 border rounded-lg" placeholder="admin">
          </div>
          <div>
            <label class="text-sm">Permission (optional)</label>
            <input name="permission" class="w-full px-3 py-2 border rounded-lg" placeholder="view dashboard">
          </div>
        </div>

        <button class="px-4 py-2 text-white bg-black rounded-lg">Save</button>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
document.querySelectorAll('.sortable').forEach(list => {
  new Sortable(list, {
    group: 'menus',
    animation: 150,
    onEnd: function () {
      let items = [];
      document.querySelectorAll('[data-id]').forEach((el, index) => {
        items.push({
          id: el.dataset.id,
          parent_id: el.dataset.parent ?? null,
        });
      });

      fetch('{{ route('admin.menu-items.reorder') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ items })
      });
    }
  });
});
</script>
@endsection


<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::latest()
            ->with(['items' => function ($q) {
                $q->whereNull('parent_id')
                    ->orderBy('sort_order')
                    ->with(['children' => function ($c) {
                        $c->orderBy('sort_order');
                    }]);
            }])
            ->first();

        return view('admin.menus.index', compact('menu'));
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'menu_id'      => 'required|integer',
            'label'        => 'required|string|max:255',
            'parent_id'    => 'nullable|integer',
            'url'          => 'nullable|string|max:255',
            'route_name'   => 'nullable|string|max:255',
            'route_params' => 'nullable|array',
            'icon'         => 'nullable|string|max:255',
            'is_active'    => 'nullable|boolean',
        ]);

        $parentId = $request->parent_id ?: null;

        $nextOrder = MenuItem::where('menu_id', $request->menu_id)
            ->where('parent_id', $parentId)
            ->max('sort_order');

        $nextOrder = ($nextOrder ?? 0) + 1;

        MenuItem::create([
            'menu_id'      => $request->menu_id,
            'parent_id'    => $parentId,
            'label'        => $request->label,
            'url'          => $request->url ?: null,
            'route_name'   => $request->route_name ?: null,
            'route_params' => $request->route_params ?: null,
            'icon'         => $request->icon ?: null,
            'sort_order'   => $nextOrder,
            'is_active'    => $request->is_active ?? 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Created']);
    }


    public function updateItem(Request $request)
    {
         //dd($request->all());
        $request->validate([
            'id'         => 'required|integer',
            'label'      => 'required|string|max:255',
            'url'        => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
        ]);

        $item = MenuItem::findOrFail($request->id);

        $item->label = $request->label;
        $item->url = $request->url ?: null;
        $item->route_name = $request->route_name ?: null;

        $item->save();

        return response()->json(['success' => true]);
    }


    public function deleteItem(Request $request)
    {
        $request->validate(['id' => 'required|integer']);

        $item = MenuItem::findOrFail($request->id);
        $item->children()->delete();
        $item->delete();

        return response()->json(['success' => true, 'message' => 'Deleted']);
    }

    public function saveOrder(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
        ]);

        foreach ($request->items as $row) {
            MenuItem::where('id', $row['id'])->update([
                'parent_id'  => $row['parent_id'] ?? null,
                'sort_order' => $row['sort_order'] ?? 0,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Order saved']);
    }
}

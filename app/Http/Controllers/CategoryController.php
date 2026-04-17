<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('parent')->get();
        $parent_cats = Category::whereNull('parent_id')->get();

        return view('admin.category.index', compact('categories', 'parent_cats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'slug'              => ['nullable', 'string', 'max:255'],
            'bg_color'          => ['nullable', 'string', 'max:20'],
            'text_color'        => ['nullable', 'string', 'max:20'],
            'active_bg_color'   => ['nullable', 'string', 'max:20'],
            'active_text_color' => ['nullable', 'string', 'max:20'],
            'order'             => ['nullable', 'integer'],
            'status'            => ['required', 'in:0,1'],
            'parent_id'         => ['nullable', 'exists:categories,id'],
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->bg_color = $request->bg_color;
        $category->text_color = $request->text_color;
        $category->active_bg_color = $request->active_bg_color ?: $request->bg_color;
        $category->active_text_color = $request->active_text_color ?: '#ffffff';
        $category->order = $request->order;
        $category->status = $request->status;
        $category->slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : Str::slug($request->name);
        $category->parent_id = $request->parent_id ?: null;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'slug'              => ['nullable', 'string', 'max:255'],
            'bg_color'          => ['nullable', 'string', 'max:20'],
            'text_color'        => ['nullable', 'string', 'max:20'],
            'active_bg_color'   => ['nullable', 'string', 'max:20'],
            'active_text_color' => ['nullable', 'string', 'max:20'],
            'order'             => ['nullable', 'integer'],
            'status'            => ['required', 'in:0,1'],
            'parent_id'         => ['nullable', 'exists:categories,id'],
        ]);

        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->bg_color = $request->bg_color;
        $category->text_color = $request->text_color;
        $category->active_bg_color = $request->active_bg_color ?: $request->bg_color;
        $category->active_text_color = $request->active_text_color ?: '#ffffff';
        $category->order = $request->order;
        $category->status = $request->status;
        $category->parent_id = $request->parent_id ?: null;
        $category->slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : Str::slug($request->name);

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function categoriesDestroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
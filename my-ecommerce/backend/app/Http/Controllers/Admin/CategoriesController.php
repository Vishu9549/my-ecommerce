<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Product;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Categories::whereNull('parent_id')->get(); // For parent dropdown
        $products = Product::all(); // If you need to show related products
        return view('admin.categories.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|integer|exists:categories,id',
            'name'               => 'required|string|max:255',
            'status'             => 'nullable|integer',
            'show_in_menu'       => 'nullable|integer',
            'short_description'  => 'nullable|string',
            'description'        => 'nullable|string',
            'url_key'            => 'nullable|string|max:255|unique:categories,url_key',
            'meta_tag'           => 'nullable|string|max:255',
            'meta_title'         => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string',
            'products'           => 'nullable|array',
            'products.*'         => 'exists:products,id',
        ]);

       $category = Categories::create($validated);

         if ($request->has('products')) {
        $category->products()->attach($request->products);
    }

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show($id)
    {
        $category = Categories::findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Categories::findOrFail($id);
        $categories = Categories::whereNull('parent_id')->where('id', '!=', $id)->get();
        $products = Product::all();
         $categoryProductIds = $category->products->pluck('id')->toArray();

        return view('admin.categories.edit', compact('category', 'categories', 'products','categoryProductIds'));
    }

    public function update(Request $request, $id)
    {
        $category = Categories::findOrFail($id);

        $validated = $request->validate([
            'parent_id' => 'nullable|integer|exists:categories,id',
            'name'               => 'required|string|max:255',
            'status'             => 'nullable|integer',
            'show_in_menu'       => 'nullable|integer',
            'short_description'  => 'nullable|string',
            'description'        => 'nullable|string',
            'url_key'            => 'nullable|string|max:255|unique:categories,url_key,' . $category->id,
            'meta_tag'           => 'nullable|string|max:255',
            'meta_title'         => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string',
            'products'     => 'nullable|array',
            'products.*'   => 'exists:products,id',
        ]);

        $category->update($validated);
        $category->products()->sync($request->products ?? []);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Categories::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}

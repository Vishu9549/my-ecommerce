<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Categories;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Categories::all();
        $attributes = Attribute::with('values')->get();
        $allProducts = Product::all();
        return view('admin.products.create', compact('categories', 'attributes', 'allProducts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string',
            'is_featured' => 'nullable|boolean',
            'sku' => 'required|string',
            'qty' => 'required|integer',
            'stock_status' => 'required|string',
            'weight' => 'required|numeric',
            'price' => 'required|numeric',
            'special_price' => 'nullable|numeric',
            'special_price_from' => 'nullable|date',
            'special_price_to' => 'nullable|date',
            'url_key' => 'required|string',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_tag' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'categories' => 'nullable|array',
            'attribute_values' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/product'), $filename);
            $data['image'] = $filename;
        }

        if ($request->hasFile('thumbnail_image')) {
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('products', 'public');
        }
        $product = Product::create($data);
        $product->relatedProducts()->sync($request->input('related_products', []));

        if ($request->has('categories')) {
            $product->categories()->attach($request->categories);
        }

        if ($request->has('attribute_values')) {
            $product->attributeValues()->attach($request->attribute_values);
        }
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Categories::all();
        $attributes = Attribute::with('values')->get();
        $allProducts = Product::all();

        $selectedCategories = $product->categories->pluck('id')->toArray();
        $selectedAttributes = $product->attributeValues->pluck('id')->toArray();

        return view('admin.products.edit', compact('product', 'categories', 'attributes', 'selectedCategories', 'selectedAttributes', 'allProducts'));
    }

    public function show($id)
    {
        $product = Product::with([
            'categories',
            'attributeValues.attribute',
            'relatedProducts'
        ])->findOrFail($id);

        return view('admin.products.show', compact('product'));
    }


    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string',
            'is_featured' => 'nullable|boolean',
            'sku' => 'required|string',
            'qty' => 'required|integer',
            'stock_status' => 'required|string',
            'weight' => 'required|numeric',
            'price' => 'required|numeric',
            'special_price' => 'nullable|numeric',
            'special_price_from' => 'nullable|date',
            'special_price_to' => 'nullable|date',
            'url_key' => 'required|string',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_tag' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'categories' => 'nullable|array',
            'attribute_values' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/product'), $filename);
            $data['image'] = $filename;
        }


        if ($request->hasFile('thumbnail_image')) {
            if ($product->thumbnail_image) {
                Storage::disk('public')->delete($product->thumbnail_image);
            }
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('products', 'public');
        }

        $product->update($data);
        $product->relatedProducts()->sync($request->input('related_products', []));

        $product->categories()->sync($request->categories ?? []);
        $product->attributeValues()->sync($request->attribute_values ?? []);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        if ($product->thumbnail_image) {
            Storage::disk('public')->delete($product->thumbnail_image);
        }

        $product->categories()->detach();
        $product->attributeValues()->detach();
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}

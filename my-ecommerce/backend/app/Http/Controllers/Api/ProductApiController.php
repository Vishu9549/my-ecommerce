<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\categories;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class ProductApiController extends Controller
{
    // 🔹 All Products
    public function index()
    {
        $products = Product::latest()->get();

        $products->transform(function ($product) {
            $product->image = $product->image
                ? URL::to('/uploads/product/' . $product->image)
                : null;
            return $product;
        });

        return response()->json($products);
    }

    // 🔹 Only Featured Products
   public function featured()
{
    $featured = Product::where('is_featured', true)
                                         ->latest()
                                          ->take(3)
                                           ->get();

    $featured->transform(function ($product) {
        $product->image = $product->image
            ? URL::to('/uploads/product/' . $product->image)
            : null;
        return $product;
    });

    return response()->json($featured);
}
    // 🔹 Show single product
    public function show($slug)
{
    $product = Product::where('slug', $slug)->first();

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    return response()->json($product);
}


    // 🔹 Products by Category Name






    public function productsByChildCategory($parentSlug, $childSlug)
{
    // Get parent category by slug
    $parent = Categories::where('slug', $parentSlug)->first();

    if (!$parent) {
        return response()->json(['error' => 'Parent category not found'], 404);
    }

    // Get child category by slug and parent_id
    $child = Categories::where('slug', $childSlug)
                     ->where('parent_id', $parent->id)
                     ->first();

    if (!$child) {
        return response()->json(['error' => 'Child category not found'], 404);
    }

    // Get products linked to child category (assuming many-to-many relationship)
    $products = $child->products()->where('status', 1)->get();
    

    return response()->json($products);
}

public function getBySlug($slug)
{
    $product = Product::where('slug', $slug)
        ->with(['categories', 'attributeValues.attribute', 'relatedProducts'])
        ->first();

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    // ✅ FIX: Group attribute values under the correct attribute_name
    $groupedAttributes = $product->attributeValues
        ->filter(fn ($item) => $item->attribute && $item->attribute->attribute_name && $item->value_name)
        ->groupBy(fn ($item) => $item->attribute->attribute_name)
        ->map(function ($values, $attributeName) {
            return [
                'name' => $attributeName,
                'values' => $values->pluck('value_name')->unique()->values(),
            ];
        })
        ->values();

    // Related products formatting
    $relatedProducts = $product->relatedProducts->map(function ($rel) {
        return [
            'id' => $rel->id,
            'name' => $rel->name,
            'slug' => $rel->slug,
            'price' => $rel->price,
            'special_price' => $rel->special_price,
            'image' => $rel->image,
        ];
    });

    // Add to response
    $product->attributes = $groupedAttributes;
    $product->related_products = $relatedProducts;

    unset($product->attributeValues); // optional cleanup

    return response()->json($product);
}





}








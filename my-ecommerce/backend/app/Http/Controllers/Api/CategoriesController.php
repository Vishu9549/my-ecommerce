<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\categories;

class CategoriesController extends Controller
{
    public function index()
{
    $categories = Categories::where('status', 1)
        ->where('show_in_menu', 1)
        ->whereNull('parent_id')
        ->with(['children' => function ($query) {
            $query->select('id', 'name', 'url_key', 'parent_id', 'slug')
                  ->where('status', 1)
                  ->where('show_in_menu', 1);
        }])
        ->select('id', 'name', 'url_key','slug')
        ->get();

    return response()->json($categories);
}
public function show($slug)
{
    $category = Categories::where('slug', $slug)
        ->where('status', 1)
        ->firstOrFail();

    $children = $category->children()
        ->where('status', 1)
        ->where('show_in_menu', 1)
        ->select('id', 'name', 'slug', 'parent_id')
        ->get();

    return response()->json($children);
}





}

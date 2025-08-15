<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::where('status', 1)
            
            ->select('id', 'title','url_key') // 👈 Change 'name' to 'title' or the correct column
            ->get();

        return response()->json($pages);
    }
}

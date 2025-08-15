<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WeHelpSection;

class WeHelpSectionApiController extends Controller
{
    // Get all WeHelpSection entries
    public function index()
    {
        $sections = WeHelpSection::all();
        return response()->json($sections);
    }

    // Optional: Get only the first WeHelpSection entry
    public function show()
    {
        $section = WeHelpSection::first();
        return response()->json($section);
    }
}

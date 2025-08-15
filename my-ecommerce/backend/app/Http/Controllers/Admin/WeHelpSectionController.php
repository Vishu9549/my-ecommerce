<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WeHelpSection;
use Illuminate\Support\Facades\Storage;

class WeHelpSectionController extends Controller
{
    public function index()
    {
        $sections = WeHelpSection::latest()->get();
        return view('admin.we_help_section.index', compact('sections'));
    }

    public function create()
    {
        return view('admin.we_help_section.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'required|array',
            'features.*' => 'required|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'image_1' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'image_2' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'image_3' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $section = new WeHelpSection();
        $section->heading = $request->heading;
        $section->description = $request->description;
        $section->features = json_encode($request->features);
        $section->button_text = $request->button_text;
        $section->button_link = $request->button_link;

        foreach (['image_1', 'image_2', 'image_3'] as $imageField) {
            if ($request->hasFile($imageField)) {
                $section->$imageField = $request->file($imageField)->store('wehelp', 'public');
            }
        }

        $section->save();

        return redirect()->route('we-help.index')->with('success', 'We Help Section created successfully.');
    }

    public function edit($id)
    {
        $section = WeHelpSection::findOrFail($id);
        return view('admin.we_help_section.edit', compact('section'));
    }

    public function update(Request $request, $id)
    {
        $section = WeHelpSection::findOrFail($id);

        $request->validate([
            'heading' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'required|array',
            'features.*' => 'required|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'image_1' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'image_2' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'image_3' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $section->heading = $request->heading;
        $section->description = $request->description;
        $section->features = json_encode($request->features);
        $section->button_text = $request->button_text;
        $section->button_link = $request->button_link;

        foreach (['image_1', 'image_2', 'image_3'] as $imageField) {
            if ($request->hasFile($imageField)) {
                if ($section->$imageField) {
                    Storage::disk('public')->delete($section->$imageField);
                }
                $section->$imageField = $request->file($imageField)->store('wehelp', 'public');
            }
        }

        $section->save();

        return redirect()->route('we-help.index')->with('success', 'We Help Section updated successfully.');
    }
}

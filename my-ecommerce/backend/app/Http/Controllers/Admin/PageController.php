<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'heading' => 'required|string|max:255',
            'ordering' => 'required|integer',
            'status' => 'required|boolean',
            'url_key' => 'required|string|max:255|unique:pages,url_key',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/pages'), $filename);
            $validated['image'] = $filename;
        }

        Page::create($validated);
        return redirect()->route('pages.index')->with('success', 'Page created successfully.');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => 'required',
            'heading' => 'required',
            'ordering' => 'required|integer',
            'status' => 'required|boolean',
            'url_key' => 'required|unique:pages,url_key,' . $page->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/pages'), $filename);
            $data['image'] = $filename;
        }

        $page->update($data);
        return redirect()->route('pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->back()->with('success', 'Page deleted successfully.');
    }
}

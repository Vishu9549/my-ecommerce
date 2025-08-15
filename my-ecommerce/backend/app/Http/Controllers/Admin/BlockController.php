<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Block;
use Illuminate\Support\Facades\File;

class BlockController extends Controller
{
    public function index()
    {
        $blocks = Block::latest()->paginate(10);
        return view('admin.blocks.index', compact('blocks'));
    }

    public function create()
    {
        return view('admin.blocks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'heading' => 'required|string|max:255',
            'ordering' => 'required|integer',
            'identifier' => 'nullable|string|max:255',
            'status' => 'required|integer',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/blocks'), $filename);
                $imagePaths[] = $filename;
            }
        }

        // Convert to JSON before inserting to DB
        $data['image'] = json_encode($imagePaths);
        $data['features'] = isset($data['features']) ? json_encode($data['features']) : null;

        Block::create($data);

        return redirect()->route('blocks.index')->with('success', 'Block created successfully.');
    }

    public function edit($id)
    {
        $block = Block::findOrFail($id);
        return view('admin.blocks.edit', compact('block'));
    }

    public function update(Request $request, $id)
    {
        $block = Block::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'heading' => 'required|string|max:255',
            'ordering' => 'required|integer',
            'identifier' => 'nullable|string|max:255',
            'status' => 'required|integer',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $existingImages = is_array($block->image) ? $block->image : json_decode($block->image, true);
        $newImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/blocks'), $filename);
                $newImages[] = $filename;
            }
        }

        $mergedImages = array_merge($existingImages ?? [], $newImages);
        $data['image'] = json_encode($mergedImages);
        $data['features'] = isset($data['features']) ? json_encode($data['features']) : null;

        $block->update($data);

        return redirect()->route('blocks.index')->with('success', 'Block updated successfully.');
    }

    public function destroy($id)
    {
        $block = Block::findOrFail($id);

        $images = is_array($block->image) ? $block->image : json_decode($block->image, true);

        if ($images && is_array($images)) {
            foreach ($images as $img) {
                $imagePath = public_path('uploads/blocks/' . $img);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
        }

        $block->delete();

        return redirect()->route('blocks.index')->with('success', 'Block deleted successfully.');
    }
}

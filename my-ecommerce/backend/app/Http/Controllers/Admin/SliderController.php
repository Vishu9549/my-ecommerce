<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{

    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/sliders'), $filename);
            $validated['image'] = $filename;
        }

        Slider::create($validated);

        return redirect()->route('slider.index')->with('success', 'Slider created successfully.');
    }

    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $slider = Slider::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($slider->image && file_exists(public_path('uploads/sliders/' . $slider->image))) {
                unlink(public_path('uploads/sliders/' . $slider->image));
            }

            $filename = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/sliders'), $filename);
            $validated['image'] = $filename;
        }

        $slider->update($validated);

        return redirect()->route('slider.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);

        if ($slider->image && file_exists(public_path('uploads/sliders/' . $slider->image))) {
            unlink(public_path('uploads/sliders/' . $slider->image));
        }

        $slider->delete();

        return redirect()->route('slider.index')->with('success', 'Slider deleted successfully.');
    }
}

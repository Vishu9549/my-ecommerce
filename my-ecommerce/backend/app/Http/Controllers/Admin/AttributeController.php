<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::latest()->paginate(10);
        return view('admin.attributes.index', compact('attributes'));
    }
    public function create()
    {
        return view('admin.attributes.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'attribute_name' => 'required|string|max:255',
            'name_key' => 'required|string|max:255|unique:attributes',
            'is_variant' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'values.*.value' => 'nullable|string|max:255',
            'values.*.status' => 'nullable|boolean',
            'attribute_values' => 'array',
            'attribute_values.*' => 'exists:attribute_values,id',
        ]);

        $validated['is_variant'] = $request->has('is_variant') ? $request->boolean('is_variant') : false;
        $validated['status'] = $request->has('status') ? $request->boolean('status') : false;

        $attribute = Attribute::create($validated);

        if ($request->has('values')) {
            foreach ($request->input('values') as $val) {
                if (!empty($val['value'])) {
                    AttributeValue::create([
                        'attribute_id' => $attribute->id,
                        'value_name' => $val['value'],
                        'status' => isset($val['status']) ? $val['status'] : 1,
                    ]);
                }
            }
        }

        return redirect()->route('attributes.index')->with('success', 'Attribute created successfully.');
    }

    public function show(Attribute $attribute)
    {
        $attribute->load('values');
        return view('admin.attributes.show', compact('attribute'));
    }

    public function edit(Attribute $attribute)
    {
        $attribute->load('values');
        return view('admin.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'attribute_name' => 'required|string|max:255',
            'name_key' => 'required|string|max:255|unique:attributes,name_key,' . $attribute->id,
            'is_variant' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'values.*.id' => 'nullable|integer|exists:attribute_values,id',
            'values.*.value' => 'nullable|string|max:255',
            'values.*.status' => 'nullable|boolean',
        ]);

        $validated['is_variant'] = $request->has('is_variant') ? $request->boolean('is_variant') : false;
        $validated['status'] = $request->has('status') ? $request->boolean('status') : false;

        $attribute->update($validated);

        $existingValueIds = $attribute->values()->pluck('id')->toArray();
        $submittedValues = $request->input('values', []);
        $processedIds = [];

        foreach ($submittedValues as $val) {
            if (!empty($val['value'])) {
                if (isset($val['id']) && in_array($val['id'], $existingValueIds)) {

                    AttributeValue::where('id', $val['id'])->update([
                        'value_name' => $val['value'],
                        'status' => isset($val['status']) ? $val['status'] : 1,
                    ]);
                    $processedIds[] = $val['id'];
                } else {
                    $new = AttributeValue::create([
                        'attribute_id' => $attribute->id,
                        'value_name' => $val['value'],
                        'status' => isset($val['status']) ? $val['status'] : 1,
                    ]);
                    $processedIds[] = $new->id;
                }
            }
        }
        $attribute->values()->whereNotIn('id', $processedIds)->delete();
        return redirect()->route('attributes.index')->with('success', 'Attribute updated successfully.');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('attributes.index')->with('success', 'Attribute deleted successfully.');
    }
}

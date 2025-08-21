<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;

class QuoteController extends Controller
{
    public function index()
    {
        return Quote::with('items')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cart_id' => 'required|string|max:255|unique:quotes,cart_id',
            'user_id' => 'nullable|integer|exists:users,id',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:255',
            'subtotal' => 'nullable|numeric|min:0',
            'coupon' => 'nullable|string|max:255',
            'coupon_discount' => 'nullable|numeric|min:0',
            'total' => 'nullable|numeric|min:0',
        ]);

        $quote = Quote::create($validated);

        return response()->json($quote, 201);
    }

    public function show($id)
    {
        $quote = Quote::with('items')->findOrFail($id);
        return response()->json($quote);
    }

    public function update(Request $request, $id)
    {
        $quote = Quote::findOrFail($id);

        $validated = $request->validate([
            'cart_id' => 'sometimes|string|max:255|unique:quotes,cart_id,' . $id,
            'user_id' => 'nullable|integer|exists:users,id',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:255',
            'subtotal' => 'nullable|numeric|min:0',
            'coupon' => 'nullable|string|max:255',
            'coupon_discount' => 'nullable|numeric|min:0',
            'total' => 'nullable|numeric|min:0',
        ]);

        $quote->update($validated);

        return response()->json($quote);
    }

    public function destroy($id)
    {
        Quote::destroy($id);
        return response()->json(['message' => 'Quote deleted']);
    }
}

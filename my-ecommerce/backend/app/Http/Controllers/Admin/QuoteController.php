<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quotes;

class QuoteController extends Controller
{
     public function index()
    {
        return Quote::with('items')->get();
    }

    // Store a new quote
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cart_id'           => 'required|string|max:255|unique:quotes,cart_id',
            'user_id'           => 'nullable|integer|exists:users,id',
            'name'              => 'nullable|string|max:255',
            'email'             => 'nullable|email|max:255',
            'phone'             => 'nullable|string|max:255',
            'address'           => 'nullable|string',
            'city'              => 'nullable|string|max:255',
            'state'             => 'nullable|string|max:255',
            'pincode'           => 'nullable|string|max:255',
            'subtotal'          => 'nullable|numeric|min:0',
            'coupon'            => 'nullable|string|max:255',
            'coupon_discount'   => 'nullable|numeric|min:0',
            'total'             => 'nullable|numeric|min:0',
        ]);

        $quote = Quote::create($validated);

        return response()->json($quote, 201);
    }

    // Show a quote by ID or cart_id
    public function show($id)
    {
        $quote = Quote::with('items')->findOrFail($id);
        return response()->json($quote);
    }

    // Update a quote (e.g., user info, address)
    public function update(Request $request, $id)
    {
        $quote = Quote::findOrFail($id);

        $validated = $request->validate([
            'cart_id'           => 'sometimes|string|max:255|unique:quotes,cart_id,' . $id,
            'user_id'           => 'nullable|integer|exists:users,id',
            'name'              => 'nullable|string|max:255',
            'email'             => 'nullable|email|max:255',
            'phone'             => 'nullable|string|max:255',
            'address'           => 'nullable|string',
            'city'              => 'nullable|string|max:255',
            'state'             => 'nullable|string|max:255',
            'pincode'           => 'nullable|string|max:255',
            'subtotal'          => 'nullable|numeric|min:0',
            'coupon'            => 'nullable|string|max:255',
            'coupon_discount'   => 'nullable|numeric|min:0',
            'total'             => 'nullable|numeric|min:0',
        ]);

        $quote->update($validated);

        return response()->json($quote);
    }


    // Delete a quote
    public function destroy($id)
    {
        Quote::destroy($id);
        return response()->json(['message' => 'Quote deleted']);
    }
}

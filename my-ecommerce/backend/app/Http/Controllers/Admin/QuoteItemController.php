<?php

namespace App\Http\Controllers\Admin;
use App\Models\Quotesitem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Quote;

class QuoteItemController extends Controller
{
    public function index()
    {
        return QuotesItem::with('quote')->get();
    }

    public function show($id)
    {
        return QuotesItem::with('quote')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_id' => 'sometimes|integer',
            'name' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'qty' => 'nullable|integer|min:1',
            'row_total' => 'nullable|numeric|min:0',
            'custom_option' => 'nullable|string|max:255',
        ]);

        $item = QuotesItem::findOrFail($id);
        $item->update($validated);

        return response()->json($item);
    }

    public function destroy($id)
    {
        QuotesItem::destroy($id);
        return response()->json(['message' => 'Item deleted']);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;

class OrderItemController extends Controller
{
    public function index(Request $request)
    {
        $query = OrderItem::with(['order', 'product']);

        if ($request->has('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'name' => 'nullable|string',
            'sku' => 'nullable|string',
            'price' => 'nullable|numeric',
            'qty' => 'nullable|integer',
            'row_total' => 'nullable|numeric',
            'custom_option' => 'nullable|string',
        ]);

        $item = OrderItem::create($validated);
        return response()->json(['message' => 'Order item created successfully', 'item' => $item], 201);
    }

    public function show($id)
    {
        $item = OrderItem::with(['order', 'product'])->findOrFail($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = OrderItem::findOrFail($id);

        $validated = $request->validate([
            'order_id' => 'sometimes|exists:orders,id',
            'product_id' => 'sometimes|exists:products,id',
            'name' => 'nullable|string',
            'sku' => 'nullable|string',
            'price' => 'nullable|numeric',
            'qty' => 'nullable|integer',
            'row_total' => 'nullable|numeric',
            'custom_option' => 'nullable|string',
        ]);

        $item->update($validated);
        return response()->json(['message' => 'Order item updated successfully', 'item' => $item]);
    }

    public function destroy($id)
    {
        $item = OrderItem::findOrFail($id);
        $item->delete();
        return response()->json(['message' => 'Order item deleted successfully']);
    }
}

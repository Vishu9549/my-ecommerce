<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Quote;
use App\Models\QuotesItem;

class QuoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        $cartId = Session::get('cart_id');
        $cart = Session::get('cart', []);

        $quote = Quote::with('items')->where('cart_id', $cartId)->first();

        if (!$quote) {
            return response()->json(['message' => 'Quote not found'], 400);
        }

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['qty'];
        });

        $quote->update([
            'user_id' => getAuthUserId(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'pincode' => $request->input('pincode'),

        ]);

        foreach ($cart as $item) {
            QuotesItem::create([
                'quote_id' => $quote->id,
                'product_id' => $item['product_id'],
                'name' => $item['name'],
                'sku' => $item['sku'],
                'price' => $item['price'],
                'qty' => $item['qty'],
                'custom_option' => $item['custom_option'] ?? null,
            ]);
        }

        return response()->json([
            'message' => 'Order placed successfully',
            'quote_id' => $quote->id
        ]);
    }

    public function index()
    {

        $cartId = Session::get('cart_id');
        $quote = Quote::with('items')->where('cart_id', $cartId)->first();

        if (!$quote) {
            return response()->json(['message' => 'Quote not found'], 400);
        }
        return response()->json([
            'message' => 'Quote fetched successfully',
            'quote' => $quote,
        ]);
    }


    public function update(Request $request, $id)
    {
        $quote = Quote::findOrFail($id);

        $quote->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
        ]);

        return response()->json([
            'message' => 'Quote updated successfully',
            'data' => $quote
        ]);
    }
}

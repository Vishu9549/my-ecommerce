<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\QuotesItem;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use Illuminate\Support\Facades\Auth; 

class QuoteItemController extends Controller
{
    // ✅ Add item to cart
    public function addToCart(Request $request)
    {
        $customOption = $request->input('custom_option', []);
        $qty = $request->input('qty', 1);
        $productId = $request->input('product_id');

        $productData = Product::find($productId);
        if (!$productData) {
            return response()->json(['status' => false, 'message' => 'Product not found'], 404);
        }

        $price = $productData->price;
        $cart_id = session('cart_id');

        if (!$cart_id) {
            $cart_id = uniqid('cart_');
            session()->put('cart_id', $cart_id);

            Quote::create([
                'cart_id' => $cart_id,
                'user_id' => getAuthUserId(),
                'name'    => Auth::user()->name ?? null,
                'email' => Auth::user()->email ?? request()->input('email') ?? null
            ]);
        } else {
            $quote = Quote::where('cart_id', $cart_id)->first();
            if (!$quote) {
                Quote::create([
                    'cart_id' => $cart_id,
                    'user_id' => getAuthUserId(), // tumhara helper
                    'name'    => Auth::user()->name ?? null,
                    'email'   => Auth::user()->email ?? null
                ]);
            }
        }

        $quote = Quote::where('cart_id', $cart_id)->first();
        $quoteId = $quote->id;

        $existingItem = QuotesItem::where('quote_id', $quoteId)
            ->where('product_id', $productId)
            ->first();

        if ($existingItem) {
            $existingItem->qty += $qty;
            $existingItem->row_total = $existingItem->qty * $price;
            $existingItem->save();
        } else {
            QuotesItem::create([
                'quote_id' => $quoteId,
                'name' => $productData->name,
                'sku' => $productData->sku,
                'price' => $price,
                'product_id' => $productId,
                'custom_option' => $customOption,
                'row_total' => $qty * $price,
                'qty' => $qty,
            ]);
        }

        $this->updateQuoteTotals($quoteId); // 🔁 using private method

        return response()->json([
            'status' => true,
            'message' => 'Item added to cart successfully',
            'cart_id' => $cart_id,
        ]);
    }

    // ✅ Get all cart items
    public function getCart()
    {
        $cart_id = Session::get('cart_id');

        if (!$cart_id) {
            return response()->json(['items' => []]);
        }

        $quote = Quote::where('cart_id', $cart_id)->first();

        if (!$quote) {
            return response()->json(['items' => []]);
        }

        $items = QuotesItem::with('product')->where('quote_id', $quote->id)->get();

        return response()->json(['items' => $items]);
    }

    // ✅ Remove item
    public function removeItem($id)
    {
        $cart_id = Session::get('cart_id');

        if (!$cart_id) {
            return response()->json(['message' => 'No active cart'], 400);
        }

        $quote = Quote::where('cart_id', $cart_id)->first();

        if (!$quote) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $item = QuotesItem::where('id', $id)
            ->where('quote_id', $quote->id)
            ->first();

        if ($item) {
            $item->delete();
            $this->updateQuoteTotals($quote->id); // 🔁 using private method
            return response()->json(['message' => 'Item removed']);
        }

        return response()->json(['message' => 'Item not found'], 404);
    }

    // 🔒 Private method to calculate totals
    private function updateQuoteTotals($quoteId)
    {
        $cartItems = QuotesItem::where('quote_id', $quoteId)->get();
        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->qty);

        $quote = Quote::find($quoteId);
        if (!$quote) return;

        $discount = floatval($quote->discount_amount ?? 0);
        $total = max($subtotal - $discount, 0);

        $quote->update([
            'subtotal' => number_format($subtotal, 2, '.', ''),
            'discount' => number_format($discount, 2, '.', ''),
            'total'    => number_format($total, 2, '.', ''),
        ]);
    }
}

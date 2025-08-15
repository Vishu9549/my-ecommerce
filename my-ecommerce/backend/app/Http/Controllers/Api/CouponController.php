<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Quote;
use App\Models\QuotesItem;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    // ✅ Show all active coupons
    public function index()
    {
        $coupons = Coupon::where('status', 1)->get();

        return response()->json([
            'coupons' => $coupons,
        ]);
    }

    // ✅ Apply coupon and update quote totals
   public function apply(Request $request)
{
    $request->validate([
        'coupon_code' => 'required',
    ]);

    $cartId = Session::get('cart_id');
    if (!$cartId) {
        return response()->json(['message' => 'No cart ID found in session'], 400);
    }

    $quote = Quote::where('cart_id', $cartId)->first();
    if (!$quote) {
        return response()->json(['message' => 'Quote not found'], 404);
    }

    // Fix: use coupon_code from request
    $coupon = Coupon::whereRaw('LOWER(coupon_code) = ?', [strtolower($request->coupon_code)])
        ->where('status', 1)
        ->whereDate('valid_from', '<=', now())
        ->whereDate('valid_to', '>=', now())
        ->first();

    if (!$coupon) {
        return response()->json(['message' => 'Invalid or expired coupon'], 404);
    }

    $cartItems = QuotesItem::where('quote_id', $quote->id)->get();
    $subtotal = $cartItems->sum(fn($item) => $item->price * $item->qty);
    $discount = $coupon->discount_amount;
    $total = max($subtotal - $discount, 0);

    $quote->update([
        'subtotal'        => $subtotal,
        'total'           => $total,
        'coupon'          => $coupon->coupon_code,
        'coupon_discount' => $discount,
    ]);

    Session::put('applied_coupon', $coupon->coupon_code);

    return response()->json([
        'message'  => 'Coupon applied successfully',
        'subtotal' => $subtotal,
        'discount' => $discount,
        'total'    => $total,
        'coupon'   => $coupon,
    ]);
}

    // ✅ Remove applied coupon and reset totals
    public function remove()
    {
        $cartId = Session::get('cart_id');
        if (!$cartId) {
            return response()->json(['message' => 'No cart ID found in session'], 400);
        }

        $quote = Quote::where('cart_id', $cartId)->first();
        if ($quote) {
            $cartItems = QuotesItem::where('quote_id', $quote->id)->get();
            $subtotal = $cartItems->sum(fn($item) => $item->price * $item->qty);

            $quote->update([
                'subtotal'         => $subtotal,
                'total'            => $subtotal,
                'coupon'           => null,  // ✅ fixed
                'coupon_discount'  => 0      // ✅ fixed
            ]);
        }

        Session::forget('applied_coupon');

        return response()->json(['message' => 'Coupon removed successfully']);
    }
}

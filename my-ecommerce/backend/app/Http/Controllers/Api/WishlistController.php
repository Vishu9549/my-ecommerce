<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Show all wishlist items for logged-in user
     */
    public function index()
    {
        $user = Auth::user();
        $wishlist = Wishlist::with('product')
            ->where('user_id', $user->id)
            ->get();

        return response()->json($wishlist);
    }

    /**
     * Add product to wishlist
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $user = Auth::user();

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Product already in wishlist'], 200);
        }

        $wishlist = Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'message' => 'Product added to wishlist',
            'wishlist' => $wishlist
        ], 201);
    }

    /**
     * Remove product from wishlist
     */
    public function destroy($productId)
    {
        $user = Auth::user();

        Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->delete();

        return response()->json(['message' => 'Product removed from wishlist']);
    }
}

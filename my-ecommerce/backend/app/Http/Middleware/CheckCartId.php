<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Quote;

class CheckCartId
{
   
       public function handle(Request $request, Closure $next)
{
    // if (!Session::has('cart_id')) {
    //     $cartId = \Str::uuid()->toString();

    //     $quote = Quote::create([
    //         'cart_id' => $cartId,
    //         'status' => 'pending',
    //     ]);

    //     Session::put('cart_id', $cartId);
    // }

    return $next($request);
}
}

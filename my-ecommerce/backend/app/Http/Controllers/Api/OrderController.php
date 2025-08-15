<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Quote;
use App\Models\Order;
use App\Models\OrderAddresse;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {

        $request->validate([
            'payment_method'    => 'required|string',
            'shipping_method'   => 'required|string',

            'shipping_name'     => 'required|string',
            'shipping_email'    => 'required|email',
            'shipping_phone'    => 'required|string',
            'shipping_address'  => 'required|string',
            'shipping_address_2'=> 'nullable|string',
            'shipping_city'     => 'required|string',
            'shipping_state'    => 'required|string',
            
            'shipping_pincode'  => 'required|string',
        ]);
        $cartId = Session::get('cart_id');

        // Quote with items
        $quote = Quote::with('items')->where('cart_id', $cartId)->first();

        if (!$quote || $quote->items->isEmpty()) {
            return response()->json(['error' => 'Cart is empty or quote not found.'], 422);
        }

        DB::beginTransaction();

        try {
            // 1️⃣ Create Order
            $order = Order::create([
                'order_increment_id' => str_pad((Quote::max('id') ?? 0) + 100000, 6, '0', STR_PAD_LEFT),
                'cart_id'         => $cartId,
                'user_id'         => $quote->user_id ?? null,
                'name'            => $quote->name,
                'email'           => $quote->email,
                'phone'           => $quote->phone,
                'address'         => $quote->address,
                'address_2'       => $quote->address_2,
                'city'            => $quote->city,
                'state'           => $quote->state,
                'country'         => $quote->country,
                'pincode'         => $quote->pincode,
                'subtotal'        => $quote->subtotal,
                'coupon'          => $quote->coupon ?? '',
                'coupon_discount' => $quote->coupon_discount ?? 0,
                'shipping_cost'   => $quote->shipping_cost ?? 0,
                'total'           => $quote->total,
                'payment_method'  => $request->payment_method ?? 'COD',
                'shipping_method' => $request->shipping_method ?? 'Standard',
                'status'          => 'pending',
            ]);

            // 2️⃣ Create Order Address (shipping)
            OrderAddresse::create([
                'order_id'     => $order->id,
                'user_id'      => $quote->user_id ?? null,
                'name'         => $quote->name,
                'email'        => $quote->email,
                'phone'        => $quote->phone,
                'address'      => $quote->address,
                'address_2'    => $quote->address_2,
                'city'         => $quote->city,
                'state'        => $quote->state,
                'country'      => $quote->country,
                'pincode'      => $quote->pincode,
                'address_type' => 'billing',
            ]);

             OrderAddresse::create([
        'order_id'     => $order->id,
        'user_id'      => $quote->user_id ?? null,
        'name'         => $request->input('shipping_name'),      // example field names
        'email'        => $request->input('shipping_email'),
        'phone'        => $request->input('shipping_phone'),
        'address'      => $request->input('shipping_address'),
        'address_2'    => $request->input('shipping_address_2'),
        'city'         => $request->input('shipping_city'),
        'state'        => $request->input('shipping_state'),
        'country'      => $request->input('shipping_country'),
        'pincode'      => $request->input('shipping_pincode'),
        'address_type' => 'shipping',
    ]);

            // 3️⃣ Create Order Items
            foreach ($quote->items as $item) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item->product_id,
                    'name'          => $item->name,
                    'sku'           => $item->sku,
                    'price'         => $item->price,
                    'qty'           => $item->qty,
                    'row_total'     => $item->price * $item->qty,
                    'custom_option' => is_array($item->custom_option) ? json_encode($item->custom_option) : ($item->custom_option ?? ''),
                ]);
            }

            // 4️⃣ Clear cart session
            Session::forget('cart');
            Session::forget('cart_id');

            DB::commit();

            Mail::to(auth()->user()->email)->send(new OrderPlacedMail($order));

            return response()->json([
                   'success' => true,
                   'message' => 'Order placed successfully.',
                   'order_id' => $order->id
                    ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Get all orders
    public function index()
    {
        $orders = Order::latest()->get();
        return response()->json($orders);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());

        return response()->json([
            'message' => 'Order updated successfully',
            'order'   => $order
        ]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }

    public function userOrders(Request $request) {
    $user = auth()->user();
    $orders = Order::where('user_id', $user->id)->get();
    return response()->json($orders);
}

public function generateInvoice($orderId)
{
    $order = Order::with('items.product')->findOrFail($orderId);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.order', compact('order'));
    
    return $pdf->download('invoice-'.$order->id.'.pdf');
}


}

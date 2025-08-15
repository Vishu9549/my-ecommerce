<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index()
{
    $orders = Order::orderBy('id', 'asc')->paginate(10);
    return view('admin.order.index', compact('orders'));
}

  public function show($id)
    {
        $order = Order::with('items.product','addresses')->findOrFail($id);
        $billingAddress = $order->addresses->where('address_type', 'billing')->first();
        $shippingAddress = $order->addresses->where('address_type', 'shipping')->first();
        return view('admin.order.show', compact('order', 'billingAddress', 'shippingAddress'));
    }

    public function generateInvoice($orderId)
{
    $order = Order::with('items.product')->findOrFail($orderId);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.order', compact('order'));
    
    return $pdf->download('invoice-'.$order->id.'.pdf');
}

}

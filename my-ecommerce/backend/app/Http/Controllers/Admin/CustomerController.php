<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
class CustomerController extends Controller
{
    public function index()
    {
        $customers = Order::orderBy('id', 'asc')->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = Order::findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }
}

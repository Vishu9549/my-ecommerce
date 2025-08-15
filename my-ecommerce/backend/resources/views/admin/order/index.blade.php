@extends('layouts.admin') {{-- Your admin layout --}}

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Manage Orders</h1>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Orders List</h3>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Address 2</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Pincode</th>
                        <th>Subtotal</th>
                        <th>Coupon</th>
                        <th>Coupon Discount</th>
                        <th>Shipping Cost</th>
                        <th>Total</th>
                        <th>Payment Method</th>
                        <th>Shipping Method</th>
                        <th>Date</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->order_increment_id }}</td>
                            <td>{{ $order->user_id ?? 'Guest' }}</td>
                            <td>{{ $order->name ?? 'Guest' }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->address }}</td>
                            <td>{{ $order->address_2 }}</td>
                            <td>{{ $order->city }}</td>
                            <td>{{ $order->state }}</td>
                            <td>{{ $order->pincode }}</td>
                            <td>₹{{ number_format($order->subtotal, 2) }}</td>
                            <td>{{ $order->coupon ?? '-' }}</td>
                            <td>₹{{ number_format($order->coupon_discount, 2) }}</td>
                            <td>₹{{ number_format($order->shipping_cost, 2) }}</td>
                            <td>₹{{ number_format($order->total, 2) }}</td>
                            <td>{{ $order->payment_method }}</td>
                            <td>{{ $order->shipping_method }}</td>
                            <td>{{ $order->created_at->format('d M, Y h:i A') }}</td>
                            <td>
                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-primary">
                                 View
                            </a>
                            <a href="{{ route('admin.orders.invoice', $order->id) }}" 
                             class="btn btn-sm btn-success mb-1" 
                             target="_blank">
                              Invoice
                            </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="22" class="text-center">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $orders->links() }} {{-- Pagination --}}
        </div>
    </div>
</div>
@endsection

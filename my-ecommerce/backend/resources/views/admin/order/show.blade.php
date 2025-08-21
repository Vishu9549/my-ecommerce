@extends('layouts.admin')

@section('content')
    <div class="container mt-4">

        <div class="card mb-4 shadow-sm border-primary">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Order Information</h3>
            </div>
            <div class="card-body">
                <p><strong>Order ID:</strong> {{ $order->id }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                <p><strong>Customer Name:</strong> {{ $order->name }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Phone:</strong> {{ $order->phone ?? '-' }}</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Billing Address</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Name:</strong> {{ $billingAddress->name ?? '-' }}</p>
                                <p><strong>Email:</strong> {{ $billingAddress->email ?? '-' }}</p>
                                <p><strong>Phone:</strong> {{ $billingAddress->phone ?? '-' }}</p>
                                <p><strong>Address:</strong> {{ $billingAddress->address ?? '-' }}</p>
                                <p><strong>Address 2:</strong> {{ $billingAddress->address_2 ?? '-' }}</p>
                                <p><strong>City:</strong> {{ $billingAddress->city ?? '-' }}</p>
                                <p><strong>State:</strong> {{ $billingAddress->state ?? '-' }}</p>
                                <p><strong>Country:</strong> {{ $billingAddress->country ?? '-' }}</p>
                                <p><strong>PIN Code:</strong> {{ $billingAddress->pincode ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Shipping Address</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Name:</strong> {{ $shippingAddress->name ?? '-' }}</p>
                                <p><strong>Email:</strong> {{ $shippingAddress->email ?? '-' }}</p>
                                <p><strong>Phone:</strong> {{ $shippingAddress->phone ?? '-' }}</p>
                                <p><strong>Address:</strong> {{ $shippingAddress->address ?? '-' }}</p>
                                <p><strong>Address 2:</strong> {{ $shippingAddress->address_2 ?? '-' }}</p>
                                <p><strong>City:</strong> {{ $shippingAddress->city ?? '-' }}</p>
                                <p><strong>State:</strong> {{ $shippingAddress->state ?? '-' }}</p>
                                <p><strong>Country:</strong> {{ $shippingAddress->country ?? '-' }}</p>
                                <p><strong>PIN Code:</strong> {{ $shippingAddress->pincode ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0">Payment Information</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0">Shipping Information</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Shipping Method:</strong> {{ $order->shipping_method }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <h3 class="mb-3">Items Ordered</h3>
        <div class="table-responsive mb-5">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Row Total</th>
                        <th>Custom Option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->sku }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>${{ number_format($item->price * $item->qty, 2) }}</td>
                            <td>
                                @php
                                    $options = json_decode($item->custom_option, true);
                                @endphp
                                @if($options)
                                    @foreach ($options as $key => $value)
                                        @if(is_array($value))
                                            {{ implode(' - ', $value) }}<br>
                                        @else
                                            {{ $value }}<br>
                                        @endif
                                    @endforeach
                                @else
                                    <em>None</em>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">

            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-success sticky-top" style="top: 20px;">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Coupon:</strong> {{ $order->coupon ?? 'N/A' }}</p>
                        <p><strong>Coupon Discount:</strong> ${{ number_format($order->coupon_discount, 2) }}</p>
                        <p><strong>Shipping Cost:</strong> ${{ number_format($order->shipping_cost, 2) }}</p>
                        <p><strong>SubTotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
                        <hr>
                        <h5><strong>Total: ${{ number_format($order->total, 2) }}</strong></h5>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
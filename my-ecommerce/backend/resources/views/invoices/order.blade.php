<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $order->order_increment_id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; margin: 0; padding: 20px; }
        h2, h3 { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
        .text-right { text-align: right; }
        .no-border { border: none !important; }
    </style>
</head>
<body>
    <h2>Invoice #{{ $order->order_increment_id }}</h2>
    <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
    <p><strong>Customer:</strong> {{ $order->name }}</p>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Phone:</strong> {{ $order->phone }}</p>
    <p><strong>Address:</strong> 
        {{ $order->address }},
        {{ $order->address_2 ? $order->address_2 . ',' : '' }}
        {{ $order->city }}, {{ $order->state }}, {{ $order->country }} - {{ $order->pincode }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Attributes</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>
                        @if($item->custom_option)
                            @foreach(json_decode($item->custom_option) as $opt)
                                <div><strong>{{ $opt->attribute }}:</strong> {{ $opt->value }}</div>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($item->price * $item->qty, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="margin-top: 20px;">
        <tr>
            <td class="no-border text-right"><strong>Subtotal:</strong></td>
            <td class="no-border text-right">{{ number_format($order->subtotal, 2) }}</td>
        </tr>
        @if($order->coupon)
        <tr>
            <td class="no-border text-right"><strong>Coupon ({{ $order->coupon }}):</strong></td>
            <td class="no-border text-right">{{ number_format($order->coupon_discount, 2) }}</td>
        </tr>
        @endif
        <tr>
            <td class="no-border text-right"><strong>Shipping:</strong></td>
            <td class="no-border text-right">{{ number_format($order->shipping_cost, 2) }}</td>
        </tr>
        <tr>
            <td class="no-border text-right"><strong>Grand Total:</strong></td>
            <td class="no-border text-right"><strong>{{ number_format($order->total, 2) }}</strong></td>
        </tr>
    </table>
</body>
</html>

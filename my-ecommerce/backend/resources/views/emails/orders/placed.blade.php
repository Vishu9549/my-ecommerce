@component('mail::message')
# Thank You for Your Order!

Your order **#{{ $order->id }}** has been successfully placed.

**Order Details:**
@foreach ($order->items as $item)
- {{ $item->product->name }} x {{ $item->quantity }} : ₹{{ $item->price }}
@endforeach

**Total:** ₹{{ $order->total }}

@component('mail::button', ['url' => url('/orders/'.$order->id)])
View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

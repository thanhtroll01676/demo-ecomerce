@component('mail::message')
@component('mail::panel')
<p>Cảm ơn bạn đã đặt hàng tại website của chúng tôi</p>
@endcomponent
<hr>
<div>Đơn hàng #{{ $order->id }} của bạn bao gồm các sản phẩm sau:</div>
@php
    $total = 0;
@endphp
@component('mail::table')
| Tên Sản Phẩm | Số Lượng | Giá Tiền | Thành Tiền |
|--------------|:--------:|:--------:|-----------:|
@foreach($products as $product)
    @php
        $tmp = $product->pivot->quantity * $product->sale_price;
        $total += $tmp;
    @endphp
    | {{ $product->name }} | {{ $product->pivot->quantity }} | {{ get_vnd($product->sale_price) }} | {{ get_vnd($tmp) }} |
@endforeach
@endcomponent
<div style="text-align: center;">
    <strong>Tổng tiền: </strong>{{ get_vnd($total) }}
</div>
@component('mail::button', ['url' => url('/'), 'color' => 'green'])
Ghé thăm website của chúng tôi
@endcomponent
@endcomponent
<h3 style="color: darkblue">Ngọc Thiên Shop</h3>
<p>Cảm ơn bạn đã đặt hàng tại website của chúng tôi</p>
<hr>
<div>Đơn hàng #{{ $order->id }} của bạn bao gồm các sản phẩm sau:</div>
<table style="width: 60%;">
    <tr>
        <th>Tên sản phẩm</th>
        <th>Số lượng</th>
        <th>Giá tiền</th>
        <th>Thành tiền</th>
    </tr>
    @php
    $total = 0;
    @endphp
    @foreach($products as $product)
        @php
            $tmp = $product->pivot->quantity * $product->sale_price;
            $total += $tmp;
        @endphp
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->pivot->quantity }}</td>
            <td>{{ $product->sale_price }}</td>
            <td>{{ $tmp }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="4"><strong style="color: red;">Tổng cộng: </strong>{{ $total }}</td>
    </tr>
</table>
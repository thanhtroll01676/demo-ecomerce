@extends('admin.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <a class="btn btn-primary" href="{{ route('admin.order.index') }}">Danh sách đơn hàng</a>
                </div>
                <br/>

                <div class="panel panel-success">
                    <div class="panel-heading text-center">Thông tin khách hàng</div>
                    <div class="panel-body">
                        <div class="row">
                            <label class="col-md-2">
                                Họ tên
                            </label>
                            <div class="col-md-10">
                                {{ $order->name }}
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2">
                                Số điện thoại
                            </label>
                            <div class="col-md-10">
                                {{ $order->phone }}
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2">
                                Email
                            </label>
                            <div class="col-md-10">
                                {{ $order->email }}
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2">
                                Địa chỉ
                            </label>
                            <div class="col-md-10">
                                {{ $order->address }}
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2">
                                Tài khoản
                            </label>
                            <div class="col-md-10">
                                @if($order->user !== null)
                                    {{ $order->user->name }} ({{ $order->user->email }})
                                @else
                                    Không
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <span>Thông tin sản phẩm</span>
                        <span class="pull-right">
                            {{ $order->updated_at }}
                        </span>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Giá tiền</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                $total = 0;
                                @endphp
                                @foreach($order->products as $product)
                                    @php
                                    $tmp = $product->sale_price * $product->pivot->quantity;
                                    $total += $tmp;
                                    @endphp
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                        <td>{{ get_vnd($product->sale_price) }}</td>
                                        <td>{{ get_vnd($tmp) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="text-right">
                                <strong>Tổng tiền:</strong> {{ get_vnd($total) }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
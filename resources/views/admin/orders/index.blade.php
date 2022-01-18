@extends('admin.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Danh sách đơn hàng</div>
                    <div class="panel-body">
                        @if(session('thongbao'))
                            <div class="alert alert-success">
                                {{ session('thongbao') }}
                            </div>
                        @endif
                        @if(session('loi'))
                            <div class="alert alert-danger">
                                {{ session('loi') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tên khách hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Tài khoản</th>
                                    <th>Số sản phẩm (khác nhau)</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td>{{ $order->phone }}</td>
                                        <td>
                                            @if($order->user !== null)
                                                <i class="glyphicon glyphicon-ok text-success"></i>
                                            @else
                                                <i class="glyphicon glyphicon-remove text-danger"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $order->products()->count() }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->updated_at }}</td>
                                        <td>
                                            <a class="btn btn-primary"
                                               href="{{ route('admin.order.show', ['id' => $order->id]) }}">Xem</a>
                                            <a class="btn btn-danger"
                                               href="{{ route('admin.order.delete', ['id' => $order->id]) }}"
                                               onclick="event.preventDefault();
                                                       window.confirm('Bạn có chắc là bạn muốn xoá đơn hàng ' + '{{ $order->name }}' + ' không?') ? document.getElementById('delete-order-{{ $order->id }}').submit() : false;">Xóa</a>
                                            <form action="{{ route('admin.order.delete', ['id' => $order->id]) }}"
                                                  method="post" id="delete-order-{{ $order->id }}" style="display: none;">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            no data
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
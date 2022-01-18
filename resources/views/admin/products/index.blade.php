@extends('admin.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <a class="btn btn-primary" href="{{ route('admin.product.create') }}">Tạo sản phẩm mới</a>
                </div>
                <br/>
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Danh sách sản phẩm</div>
                    <div class="panel-body">
                        @if(session('thongbao'))
                            <div class="alert alert-success">
                                {!! session('thongbao') !!}
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
                                    <th>Tên</th>
                                    <th>Code</th>
                                    <th>Giá bán</th>
                                    <th>Số lượng</th>
                                    <th>Hình ảnh</th>
                                    <th>Người đăng</th>
                                    <th>Ngày cập nhật</th>
                                    <th style="min-width: 150px">Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->code }}</td>
                                        <td>{{ $product->sale_price }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>
                                            @if($product->image != '' && file_exists(public_path(get_thumbnail("uploaded/$product->image"))))
                                                <img src="{{ asset(get_thumbnail("uploaded/$product->image")) }}"
                                                     alt="product image" class="img-responsive img-thumbnail">
                                            @else
                                                <img src="{{ asset('images/no_image_170-128.jpg') }}" alt="No image"
                                                     class="img-responsive img-thumbnail">
                                            @endif
                                        </td>
                                        <td>{{ $product->user->name }}</td>
                                        <td>{{ $product->updated_at }}</td>
                                        <td>
                                            {{--{{ dd($product->featured_product) }}--}}
                                            <a class="btn btn-{{ $product->featured_product ? 'success' : 'default' }}"
                                               href="{{ route('admin.product.setFeaturedProduct', ['id' => $product->id]) }}"
                                               onclick="event.preventDefault();
                                                       document.getElementById('featured-product-{{ $product->id }}').submit();">
                                                <i class="glyphicon glyphicon-eye-{{ $product->featured_product ? 'open' : 'close' }}"></i>
                                            </a>
                                            <a class="btn btn-primary"
                                               href="{{ route('admin.product.show', ['id' => $product->id]) }}"><i
                                                        class="glyphicon glyphicon-pencil"></i></a>
                                            <a class="btn btn-danger"
                                               href="{{ route('admin.product.delete', ['id' => $product->id]) }}"
                                               onclick="event.preventDefault();
                                                       window.confirm('Bạn có chắc là bạn muốn xoá sản phẩm ' + '{{ $product->name }}' + ' không?') ? document.getElementById('delete-product-{{ $product->id }}').submit() : false;"><i
                                                        class="glyphicon glyphicon-remove"></i></a>
                                            <form action="{{ route('admin.product.delete', ['id' => $product->id]) }}"
                                                  method="post" id="delete-product-{{ $product->id }}"
                                                  style="display: none;">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
                                            <form action="{{ route('admin.product.setFeaturedProduct', ['id' => $product->id]) }}"
                                                  method="post" id="featured-product-{{ $product->id }}"
                                                  style="display: none;">
                                                {{ csrf_field() }}
                                                {{ method_field('patch') }}
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9">
                                            Chưa có dữ liệu
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
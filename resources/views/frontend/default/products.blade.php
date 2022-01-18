@extends('frontend.default.master')
@section('content')
    <div class="container">
        <div class="row">
            <form style="width: 200px" id="orderBy-form" action="{{ route('frontend.home.indexProducts') }}" method="get">
                @if($search = Request::input('search'))
                    <input type="hidden" name="search" value="{{ $search }}">
                @endif
                @if($category = Request::input('category'))
                    <input type="hidden" name="category" value="{{ $category }}">
                @endif
                <select class="form-control" name="orderBy" onchange="document.getElementById('orderBy-form').submit();">
                    <option value="latest" {{ Request::input('orderBy') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="oldest" {{ Request::input('orderBy') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                    <option value="highest" {{ Request::input('orderBy') == 'highest' ? 'selected' : '' }}>Giá từ cao đến thấp</option>
                    <option value="lowest" {{ Request::input('orderBy') == 'lowest' ? 'selected' : '' }}>Giá từ thấp đến cao</option>
                </select>
            </form>
            <br>
            @if($search)
                <h3>Tìm kiếm theo sản phẩm có từ khóa "{{ $search }}"</h3>
                <br>
            @endif
            <div class="product-grid-holder">
                @forelse($products as $product)
                    <div class="col-sm-4 col-md-3  no-margin product-item-holder hover">
                        <div class="product-item">
                            {{--<div class="ribbon red"><span>sale</span></div>--}}
                            {{--<div class="ribbon green"><span>bestseller</span></div>--}}
                            {{--<div class="ribbon blue"><span>new</span></div>--}}

                            <div class="image">
                                @if ( ! empty($product->image) && file_exists(public_path(get_thumbnail("uploaded/$product->image"))))
                                    <img src="{{ asset('themes/default/assets/images/blank.gif') }}"
                                         data-echo="{{ asset(get_thumbnail("uploaded/$product->image")) }}"
                                         alt="Image">
                                @else
                                    <img src="{{ asset('themes/default/assets/images/blank.gif') }}"
                                         data-echo="{{ asset('images/no_image_170-128.jpg') }}"
                                         alt="No Image">
                                @endif
                            </div>
                            <div class="body">
                                {{--<div class="label-discount green">-50% sale</div>--}}
                                <div class="title">
                                    <a href="{{ route('frontend.home.show', ['slug' => str_slug($product->name), 'id' => $product->id]) }}">{{ $product->name }}</a>
                                </div>
                                <div class="brand">{{ $product->code }}</div>
                            </div>
                            <div class="prices">
                                <div class="price-prev">{{ number_format($product->regular_price, 0, ',', '.') }}
                                    VND
                                </div>
                                <div class="price-current pull-right">{{ number_format($product->sale_price, 0, ',', '.') }}
                                    VND
                                </div>
                            </div>

                            <div class="hover-area">
                                <div class="add-cart-button">
                                    <a href="#" class="le-button" v-on:click="addToCart({{ $product->id }}, $event)">Thêm giỏ hàng</a>
                                </div>
                                {{--<div class="wish-compare">--}}
                                {{--<a class="btn-add-to-wishlist" href="#">add to wishlist</a>--}}
                                {{--<a class="btn-add-to-compare" href="#">compare</a>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>
                @empty
                    <div>Chưa có dữ liệu</div>
                @endforelse
            </div>
        </div> {{-- hết row --}}
        <div class="row">
            <div class="text-center">
                @php
                $uriArr = [];
                if($orderBy = Request::input('orderBy')){
                    $uriArr['orderBy'] = $orderBy;
                }
                if($search = Request::input('search')){
                    $uriArr['search'] = $search;
                }
                if($category = Request::input('category')){
                    $uriArr['category'] = $category;
                }
                @endphp
                {{ $products->appends($uriArr)->links('vendor.pagination.custom_lai_pagination') }}
            </div>
        </div>
    </div>
@endsection
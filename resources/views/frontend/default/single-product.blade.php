@extends('frontend.default.master')
@section('content')
    <div id="single-product">
        <div class="container">

            <div class="no-margin col-xs-12 col-sm-6 col-md-5 gallery-holder">
                <div class="product-item-holder size-big single-product-gallery small-gallery">

                    <div id="owl-single-product">
                        @forelse($product->attachments as $k => $imageFile)
                            <div class="single-product-gallery-item" id="slide{{ $k + 1 }}">
                                @if(file_exists(public_path("uploaded/" . get_thumbnail($imageFile->path, '_450x337'))))
                                    <a data-rel="prettyphoto"
                                       href="{{ asset("uploaded/" . get_thumbnail($imageFile->path, '_450x337')) }}">
                                        <img class="img-responsive" alt=""
                                             src="{{ asset('themes/default/assets/images/blank.gif') }}"
                                             data-echo="{{ asset("uploaded/" . get_thumbnail($imageFile->path, '_450x337')) }}"/>
                                    </a>
                                @else
                                    <img src="{{ asset("images/no_image.jpg") }}" alt="no image" class="img-responsive">
                                @endif
                            </div><!-- /.single-product-gallery-item -->
                        @empty
                            <div class="single-product-gallery-item" id="slide0">
                                @if( ! empty($product->image) && file_exists(public_path("uploaded/" . get_thumbnail($product->image))))
                                    <a data-rel="prettyphoto"
                                       href="{{ asset("uploaded/" . get_thumbnail($product->image, '_450x337')) }}">
                                        <img class="img-responsive" alt=""
                                             src="{{ asset('themes/default/assets/images/blank.gif') }}"
                                             data-echo="{{ asset("uploaded/" . get_thumbnail($product->image, '_450x337')) }}"/>
                                    </a>
                                @else
                                    <img src="{{ asset("images/no_image.jpg") }}" alt="no image" class="img-responsive">
                                @endif
                            </div><!-- /.single-product-gallery-item -->
                        @endforelse
                        {{--<div class="single-product-gallery-item" id="slide1">--}}
                        {{--<a data-rel="prettyphoto" href="images/products/product-gallery-01.jpg">--}}
                        {{--<img class="img-responsive" alt=""--}}
                        {{--src="{{ asset('themes/default/assets/images/blank.gif') }}"--}}
                        {{--data-echo="{{ asset('themes/default/assets/images/products/product-gallery-01.jpg') }}"/>--}}
                        {{--</a>--}}
                        {{--</div><!-- /.single-product-gallery-item -->--}}
                    </div><!-- /.single-product-slider -->


                    <div class="single-product-gallery-thumbs gallery-thumbs">

                        <div id="owl-single-product-thumbnails">
                            @forelse($product->attachments as $k => $imageFile)
                                @if(file_exists(public_path("uploaded/" . get_thumbnail($imageFile->path, '_80x80'))))
                                    <a class="horizontal-thumb {{ $k == 0 ? 'active' : '' }}"
                                       data-target="#owl-single-product" data-slide="{{ $k }}"
                                       href="#slide{{ $k + 1 }}">
                                        <img width="67" alt=""
                                             src="{{ asset('themes/default/assets/images/blank.gif') }}"
                                             data-echo="{{ asset("uploaded/" . get_thumbnail($imageFile->path, '_80x80')) }}"/>
                                    </a>
                                @else
                                    <img src="{{ asset("images/no_image.jpg") }}" alt="no image" class="img-responsive">
                                @endif
                            @empty
                            @endforelse

                            {{--<a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="0"--}}
                            {{--href="#slide1">--}}
                            {{--<img width="67" alt="" src="{{ asset('themes/default/assets/images/blank.gif') }}"--}}
                            {{--data-echo="{{ asset('themes/default/assets/images/products/gallery-thumb-01.jpg') }}"/>--}}
                            {{--</a>--}}

                            {{--<a class="horizontal-thumb" data-target="#owl-single-product" data-slide="1" href="#slide2">--}}
                            {{--<img width="67" alt="" src="{{ asset('themes/default/assets/images/blank.gif') }}"--}}
                            {{--data-echo="{{ asset('themes/default/assets/images/products/gallery-thumb-01.jpg') }}"/>--}}
                            {{--</a>--}}

                            {{--<a class="horizontal-thumb" data-target="#owl-single-product" data-slide="2" href="#slide3">--}}
                            {{--<img width="67" alt="" src="{{ asset('themes/default/assets/images/blank.gif') }}"--}}
                            {{--data-echo="{{ asset('themes/default/assets/images/products/gallery-thumb-01.jpg') }}"/>--}}
                            {{--</a>--}}
                        </div><!-- /#owl-single-product-thumbnails -->

                        <div class="nav-holder left hidden-xs">
                            <a class="prev-btn slider-prev" data-target="#owl-single-product-thumbnails"
                               href="#prev"></a>
                        </div><!-- /.nav-holder -->

                        <div class="nav-holder right hidden-xs">
                            <a class="next-btn slider-next" data-target="#owl-single-product-thumbnails"
                               href="#next"></a>
                        </div><!-- /.nav-holder -->

                    </div><!-- /.gallery-thumbs -->

                </div><!-- /.single-product-gallery -->
            </div><!-- /.gallery-holder -->
            <div class="no-margin col-xs-12 col-sm-7 body-holder">
                <div class="body">
                    <div class="star-holder inline">
                        <div class="star" data-score="{{ floor($product->comments()->avg('rating')) }}"></div>
                    </div>
                    <div class="availability"><label>Tình trạng:</label><span class="{{ $product->quantity > 0 ? 'available' : 'not-available' }}"> {{ $product->quantity > 0 ? 'Còn hàng' : 'Hết hàng'}}</span>
                    </div>

                    <div class="title"><a href="#">{{ $product->name }}</a></div>
                    <div class="brand">{{ $product->code }}</div>

                    <div class="social-row">
                        <span class="st_facebook_hcount"></span>
                        <span class="st_twitter_hcount"></span>
                        <span class="st_pinterest_hcount"></span>
                    </div>

                    <div class="buttons-holder">
                        <a class="btn-add-to-wishlist" href="#">add to wishlist</a>
                        <a class="btn-add-to-compare" href="#">add to compare list</a>
                    </div>

                    {{--<div class="excerpt">--}}
                    {{--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ornare turpis non risus--}}
                    {{--semper dapibus. Quisque eu vehicula turpis. Donec sodales lacinia eros, sit amet auctor--}}
                    {{--tellus volutpat non.</p>--}}
                    {{--</div>--}}

                    <div class="prices">
                        <div class="price-current">{{ number_format($product->sale_price, 0, ',', '.') }} VND</div>
                        <div class="price-prev">{{ number_format($product->regular_price, 0, ',', '.') }} VND</div>
                    </div>

                    <div class="qnt-holder">
                        <div class="le-quantity">
                            <form>
                                <a class="minus" href="#reduce" v-on:click="subtractQuantity"></a>
                                <input name="quantity" readonly="readonly" type="text" value="1"/>
                                <a class="plus" href="#add" v-on:click="addQuantity"></a>
                            </form>
                        </div>
                        <a id="addto-cart" href="cart.html" class="le-button huge" v-on:click="addToCart({{ $product->id }}, $event, true)">Thêm vào giỏ hàng</a>
                    </div><!-- /.qnt-holder -->
                </div><!-- /.body -->

            </div><!-- /.body-holder -->
        </div><!-- /.container -->
    </div><!-- /.single-product -->

    <!-- ========================================= SINGLE PRODUCT TAB ========================================= -->
    <section id="single-product-tab">
        <div class="container">
            <div class="tab-holder">

                <ul class="nav nav-tabs simple">
                    <li class="active"><a href="#description" data-toggle="tab">Mô tả</a></li>
                    <li><a href="#additional-info" data-toggle="tab">Thông tin thêm</a></li>
                    <li><a href="#reviews" data-toggle="tab">Đánh giá ({{ $product->comments()->count() }})</a></li>
                </ul><!-- /.nav-tabs -->

                <div class="tab-content">
                    <div class="tab-pane active" id="description">
                        <p>{!! $product->content !!}}</p>

                        <div class="meta-row">
                            <div class="inline">
                                <label>CODE:</label>
                                <span>{{ $product->code }}</span>
                            </div><!-- /.inline -->

                            <span class="seperator">/</span>

                            <div class="inline">
                                <label>categories:</label>
                                <span><a href="#">{{ $product->category->name }}</a></span>
                            </div><!-- /.inline -->

                            <span class="seperator">/</span>

                            <div class="inline">
                                <label>tag:</label>
                                @forelse($product->tags as $tag)
                                    <span><a href="#">{{ $tag->name }}</a>,</span>
                                @empty
                                @endforelse
                            </div><!-- /.inline -->
                        </div><!-- /.meta-row -->
                    </div><!-- /.tab-pane #description -->

                    <div class="tab-pane" id="additional-info">
                        <ul class="tabled-data">
                            @php
                                $product->attributes = json_decode($product->attributes);
                                if( ! $product->attributes){
                                    $product->attributes = [];
                                }
                            @endphp
                            @forelse($product->attributes as $attribute)
                                <li>
                                    <label>{{ $attribute->name }}</label>
                                    <div class="value">{{ $attribute->value }}</div>
                                </li>
                            @empty
                            @endforelse
                            {{--<li>--}}
                            {{--<label>weight</label>--}}
                            {{--<div class="value">7.25 kg</div>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            {{--<label>dimensions</label>--}}
                            {{--<div class="value">90x60x90 cm</div>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            {{--<label>size</label>--}}
                            {{--<div class="value">one size fits all</div>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            {{--<label>color</label>--}}
                            {{--<div class="value">white</div>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            {{--<label>guarantee</label>--}}
                            {{--<div class="value">5 years</div>--}}
                            {{--</li>--}}
                        </ul><!-- /.tabled-data -->

                        <div class="meta-row">
                            <div class="inline">
                                <label>CODE:</label>
                                <span>{{ $product->code }}</span>
                            </div><!-- /.inline -->

                            <span class="seperator">/</span>

                            <div class="inline">
                                <label>categories:</label>
                                <span><a href="#">{{ $product->category->name }}</a></span>
                            </div><!-- /.inline -->

                            <span class="seperator">/</span>

                            <div class="inline">
                                <label>tag:</label>
                                @forelse($product->tags as $tag)
                                    <span><a href="#">{{ $tag->name }}</a>,</span>
                                @empty
                                @endforelse
                            </div><!-- /.inline -->
                        </div><!-- /.meta-row -->
                    </div><!-- /.tab-pane #additional-info -->


                    <div class="tab-pane" id="reviews">
                        {{--Phần hiện comment của người đánh giá--}}
                        <div class="comments">
                            @forelse($product->comments as $comment)
                                <div class="comment-item">
                                    <div class="row no-margin">
                                        <div class="col-lg-1 col-xs-12 col-sm-2 no-margin">
                                            <div class="avatar">
                                                <img alt="avatar"
                                                     src="{{ asset('themes/default/assets/images/default-avatar.jpg') }}">
                                            </div><!-- /.avatar -->
                                        </div><!-- /.col -->

                                        <div class="col-xs-12 col-lg-11 col-sm-10 no-margin">
                                            <div class="comment-body">
                                                <div class="meta-info">
                                                    <div class="author inline">
                                                        <a href="#" class="bold">{{ $comment->name }}</a>
                                                    </div>
                                                    <div class="star-holder inline">
                                                        <div class="star" data-score="{{ $comment->rating }}"></div>
                                                    </div>
                                                    <div class="date inline pull-right">
                                                        {{ $comment->created_at->diffForHumans() }}
                                                    </div>
                                                </div><!-- /.meta-info -->
                                                <p class="comment-text">
                                                    {{ $comment->content }}
                                                </p><!-- /.comment-text -->
                                            </div><!-- /.comment-body -->

                                        </div><!-- /.col -->

                                    </div><!-- /.row -->
                                </div><!-- /.comment-item -->
                            @empty
                                <div>Chưa có đánh giá nào</div>
                            @endforelse
                            {{--Mẫu
                            <div class="comment-item">
                                <div class="row no-margin">
                                    <div class="col-lg-1 col-xs-12 col-sm-2 no-margin">
                                        <div class="avatar">
                                            <img alt="avatar"
                                                 src="{{ asset('themes/default/assets/images/default-avatar.jpg') }}">
                                        </div><!-- /.avatar -->
                                    </div><!-- /.col -->

                                    <div class="col-xs-12 col-lg-11 col-sm-10 no-margin">
                                        <div class="comment-body">
                                            <div class="meta-info">
                                                <div class="author inline">
                                                    <a href="#" class="bold">John Smith</a>
                                                </div>
                                                <div class="star-holder inline">
                                                    <div class="star" data-score="4"></div>
                                                </div>
                                                <div class="date inline pull-right">
                                                    12.07.2013
                                                </div>
                                            </div><!-- /.meta-info -->
                                            <p class="comment-text">
                                                Integer id purus ultricies nunc tincidunt congue vitae nec felis.
                                                Vivamus sit amet nisl convallis, faucibus risus in, suscipit sapien.
                                                Vestibulum egestas interdum tellus id venenatis.
                                            </p><!-- /.comment-text -->
                                        </div><!-- /.comment-body -->

                                    </div><!-- /.col -->

                                </div><!-- /.row -->
                            </div><!-- /.comment-item -->
                            --}}
                        </div><!-- /.comments -->
                        {{--Phần cho ngta viết comment--}}
                        <div class="add-review row">
                            <div class="col-sm-8 col-xs-12">
                                <div class="new-review-form">
                                    <h2>Thêm lời bình</h2>
                                    @if(session('message'))
                                        <div class="alert alert-success">{{ session('message') }}</div>
                                    @endif
                                    <form id="contact-form" class="contact-form" method="post"
                                          action="{{ route('frontend.home.saveComment', ['id' => $product->id, 'slug' => str_slug($product->name)]) }}">
                                        {{ csrf_field() }}
                                        <div class="row field-row">
                                            <div class="col-xs-12 col-sm-6 {{ $errors->has('name') ? 'has-error' : '' }}">
                                                <label>tên*</label>
                                                <input class="le-input" name="name">
                                                <span class="help-block">{{ $errors->first('name') }}</span>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 {{ $errors->has('email') ? 'has-error' : '' }}">
                                                <label>email*</label>
                                                <input class="le-input" name="email">
                                                <span class="help-block">{{ $errors->first('email') }}</span>
                                            </div>
                                        </div><!-- /.field-row -->

                                        <div class="field-row star-row {{ $errors->has('score') ? 'has-error' : '' }}">
                                            <label>đánh giá</label>
                                            <div class="star-holder">
                                                <div class="star big" data-score="0"></div>
                                            </div>
                                            <span class="help-block">{{ $errors->first('score') }}</span>
                                        </div><!-- /.field-row -->

                                        <div class="field-row {{ $errors->has('content') ? 'has-error' : '' }}">
                                            <label>lời nhận xét</label>
                                            <textarea rows="8" class="le-input" name="content"></textarea>
                                            <span class="help-block">{{ $errors->first('content') }}</span>
                                        </div><!-- /.field-row -->

                                        <div class="buttons-holder">
                                            <button type="submit" class="le-button huge">gửi</button>
                                        </div><!-- /.buttons-holder -->
                                    </form><!-- /.contact-form -->
                                </div><!-- /.new-review-form -->
                            </div><!-- /.col -->
                        </div><!-- /.add-review -->

                    </div><!-- /.tab-pane #reviews -->
                </div><!-- /.tab-content -->

            </div><!-- /.tab-holder -->
        </div><!-- /.container -->
    </section><!-- /#single-product-tab -->
    <!-- ========================================= SINGLE PRODUCT TAB : END ========================================= -->
    <!-- ========================================= RECENTLY VIEWED ========================================= -->
    <section id="recently-reviewd" class="wow fadeInUp">
        <div class="container">
            <div class="carousel-holder hover">

                <div class="title-nav">
                    <h2 class="h1">Sản phẩm vừa xem</h2>
                    <div class="nav-holder">
                        <a href="#prev" data-target="#owl-recently-viewed"
                           class="slider-prev btn-prev fa fa-angle-left"></a>
                        <a href="#next" data-target="#owl-recently-viewed"
                           class="slider-next btn-next fa fa-angle-right"></a>
                    </div>
                </div><!-- /.title-nav -->

                <div id="owl-recently-viewed" class="owl-carousel product-grid-holder">
                    @foreach($recent_products as $product)
                        <div class="no-margin carousel-item product-item-holder size-small hover">
                            <div class="product-item">
                                {{--<div class="ribbon red"><span>sale</span></div>--}}
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
                            </div> {{-- End product-item --}}
                        </div><!-- /.product-item-holder -->
                    @endforeach
                    {{-- Mẫu
                    <div class="no-margin carousel-item product-item-holder size-small hover">
                        <div class="product-item">
                            <div class="ribbon red"><span>sale</span></div>
                            <div class="image">
                                <img alt="" src="{{ asset('themes/default/assets/images/blank.gif') }}"
                                     data-echo="{{ asset('themes/default/assets/images/products/product-11.jpg') }}"/>
                            </div>
                            <div class="body">
                                <div class="title">
                                    <a href="single-product.html">LC-70UD1U 70" class aquos 4K ultra HD</a>
                                </div>
                                <div class="brand">Sharp</div>
                            </div>
                            <div class="prices">
                                <div class="price-current text-right">$1199.00</div>
                            </div>
                            <div class="hover-area">
                                <div class="add-cart-button">
                                    <a href="single-product.html" class="le-button">Add to Cart</a>
                                </div>
                                <div class="wish-compare">
                                    <a class="btn-add-to-wishlist" href="#">Add to Wishlist</a>
                                    <a class="btn-add-to-compare" href="#">Compare</a>
                                </div>
                            </div>
                        </div><!-- /.product-item -->
                    </div><!-- /.product-item-holder -->
                    --}}
                </div><!-- /#recently-carousel -->

            </div><!-- /.carousel-holder -->
        </div><!-- /.container -->
    </section><!-- /#recently-reviewd -->
    <!-- ========================================= RECENTLY VIEWED : END ========================================= -->
@endsection
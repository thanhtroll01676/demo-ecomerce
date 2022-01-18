<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MediaCenter - Responsive eCommerce Template</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{ asset('themes/default/assets/css/bootstrap.min.css') }}">

    <!-- Customizable CSS -->
    <link rel="stylesheet" href="{{ asset('themes/default/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/default/assets/css/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/default/assets/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/default/assets/css/owl.transitions.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/default/assets/css/animate.min.css') }}">

    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="{{ asset('themes/default/assets/css/font-awesome.min.css') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('themes/default/assets/images/favicon.ico') }}">

{{-- Theme Styles --}}
@yield('styles')
<!-- HTML5 elements and media queries Support for IE8 : HTML5 shim and Respond.js -->
    <!--[if lt IE 9]>
    <script src="{{ asset('themes/default/assets/js/html5shiv.js') }}"></script>
    <script src="{{ asset('themes/default/assets/js/respond.min.js') }}"></script>
    <![endif]-->

    <script>
        window.henry = {
            csrf: '{{ csrf_token() }}',
            baseUrl: '{{ url('/') }}' // http://localhost/PHP_Laravel_QHO/shop/public
        };
    </script>
</head>
<body>

<div class="wrapper" id="app">
    {{--@{{ 8 + 4 }}--}}
    <!-- ============================================================= TOP NAVIGATION ============================================================= -->
    <nav class="top-bar animate-dropdown">
        <div class="container">
            <div class="col-xs-12 col-sm-6 no-margin">
                <ul>
                    <li><a href="{{ route('frontend.home.index') }}">Trang chủ</a></li>
                    {{--
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#change-colors">Change Colors</a>

                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation"><a role="menuitem" class="changecolor green-text" tabindex="-1"
                                                       href="#" title="Green color">Green</a></li>
                            <li role="presentation"><a role="menuitem" class="changecolor blue-text" tabindex="-1"
                                                       href="#" title="Blue color">Blue</a></li>
                            <li role="presentation"><a role="menuitem" class="changecolor red-text" tabindex="-1"
                                                       href="#" title="Red color">Red</a></li>
                            <li role="presentation"><a role="menuitem" class="changecolor orange-text" tabindex="-1"
                                                       href="#" title="Orange color">Orange</a></li>
                            <li role="presentation"><a role="menuitem" class="changecolor navy-text" tabindex="-1"
                                                       href="#" title="Navy color">Navy</a></li>
                            <li role="presentation"><a role="menuitem" class="changecolor dark-green-text" tabindex="-1"
                                                       href="#" title="Darkgreen color">Dark Green</a></li>
                        </ul>
                    </li>
                    <li><a href="blog.html">Blog</a></li>
                    <li><a href="faq.html">FAQ</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#pages">Pages</a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('frontend.home.index') }}">Home</a></li>
                            <li><a href="index-2.html">Home Alt</a></li>
                            <li><a href="category-grid.html">Category - Grid/List</a></li>
                            <li><a href="category-grid-2.html">Category 2 - Grid/List</a></li>
                            <li><a href="single-product.html">Single Product</a></li>
                            <li><a href="single-product-sidebar.html">Single Product with Sidebar</a></li>
                            <li><a href="cart.html">Shopping Cart</a></li>
                            <li><a href="{{ route('frontend.checkout.index') }}">Checkout</a></li>
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="contact.html">Contact Us</a></li>
                            <li><a href="blog.html">Blog</a></li>
                            <li><a href="blog-fullwidth.html">Blog Full Width</a></li>
                            <li><a href="blog-post.html">Blog Post</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="terms.html">Terms & Conditions</a></li>
                            <li><a href="authentication.html">Login/Register</a></li>
                        </ul>
                    </li>
                    --}}
                </ul>
            </div><!-- /.col -->

            <div class="col-xs-12 col-sm-6 no-margin">
                <ul class="right">
                    <!-- <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#change-language">English</a>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Turkish</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Tamil</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">French</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Russian</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#change-currency">Dollar (US)</a>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Euro (EU)</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Turkish Lira (TL)</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Indian Rupee (INR)</a>
                            </li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Dollar (US)</a></li>
                        </ul>
                    </li> -->
                    @if( ! auth()->check())
                        <li><a href="{{ route('frontend.register') }}">Đăng nhập</a></li>
                        <li><a href="{{ route('frontend.login') }}">Đăng ký</a></li>
                    @else
                        <li>Chào {{ auth()->user()->name }}!</li>
                        <li><a onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="#">Đăng Xuất</a></li>
                        <form id="logout-form" action="{{ route('frontend.logout') }}" method="post">
                            {{ csrf_field() }}
                        </form>
                    @endif
                </ul>
            </div><!-- /.col -->
        </div><!-- /.container -->
    </nav><!-- /.top-bar -->
    <!-- ============================================================= TOP NAVIGATION : END ============================================================= -->
    <!-- ============================================================= HEADER ============================================================= -->
    <header class="{{ Route::currentRouteName() !== 'frontend.home.index' ? 'no-padding-bottom header-alt' : '' }}">
        <div class="container no-padding">

            <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                <!-- ============================================================= LOGO ============================================================= -->
                <div class="logo">
                    <a href="{{ route('frontend.home.index') }}">
                    <!--<img alt="logo" src="{{ asset('themes/default/assets/images/logo.svg') }}" width="233" height="54"/>-->
                    <!--<object id="sp" type="image/svg+xml" data="{{ asset('themes/default/assets/images/logo.svg') }}" width="233" height="54"></object>-->
                    <img src="{{ asset('themes/default/assets/images/brands/logo.png') }}" width="auto" height="100"/>
                    </a>
                </div><!-- /.logo -->
                <!-- ============================================================= LOGO : END ============================================================= -->
            </div><!-- /.logo-holder -->

            <div class="col-xs-12 col-sm-12 col-md-6 top-search-holder no-margin">
                <div class="contact-row">
                    <div class="phone inline">
                        <i class="fa fa-phone"></i> (+800) 123 456 7890
                    </div>
                    <div class="contact inline">
                        <i class="fa fa-envelope"></i> ngocthienk61@<span class="le-color">gmail.com</span>
                    </div>
                </div><!-- /.contact-row -->
                <!-- ============================================================= SEARCH AREA ============================================================= -->
                <div class="search-area">
                    <form id="search-form" action="{{ route('frontend.home.indexProducts') }}" method="get">
                        <div class="control-group">
                            @if($orderBy = Request::input('orderBy'))
                                <input type="hidden" name="orderBy" value="{{ $orderBy }}">
                            @endif
                            @if($category = Request::input('category'))
                                <input type="hidden" name="category" value="{{ $category }}">
                            @endif
                            <input value="{{ ($search = Request::input('search')) ? $search : '' }}" name="search" class="search-field" placeholder="Tìm kiếm sản phẩm"/>

                            <!-- <ul class="categories-filter animate-dropdown">
                                <li class="dropdown">

                                    <a class="dropdown-toggle" data-toggle="dropdown" href="category-grid.html">all
                                        categories</a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li role="presentation"><a role="menuitem" tabindex="-1"
                                                                   href="category-grid.html">laptops</a></li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1"
                                                                   href="category-grid.html">tv & audio</a></li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1"
                                                                   href="category-grid.html">gadgets</a></li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1"
                                                                   href="category-grid.html">cameras</a></li>

                                    </ul>
                                </li>
                            </ul> -->

                            <a class="search-button" href="#" onclick="event.preventDefault();document.getElementById('search-form').submit();"></a>

                        </div>
                    </form>
                </div><!-- /.search-area -->
                <!-- ============================================================= SEARCH AREA : END ============================================================= -->
            </div><!-- /.top-search-holder -->

            <div class="col-xs-12 col-sm-12 col-md-3 top-cart-row no-margin">
                <div class="top-cart-row-container">
                    {{--
                    <div class="wishlist-compare-holder">
                        <div class="wishlist ">
                            <a href="#"><i class="fa fa-heart"></i> wishlist <span class="value">(21)</span> </a>
                        </div>
                        <div class="compare">
                            <a href="#"><i class="fa fa-exchange"></i> compare <span class="value">(2)</span> </a>
                        </div>
                    </div>
                    --}}

                    <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->
                    <div class="top-cart-holder dropdown animate-dropdown">

                        <div class="basket">

                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <div class="basket-item-count">
                                    <span class="count" v-text="total">0</span>
                                    <img src="{{ asset('themes/default/assets/images/icon-cart.png') }}" alt=""/>
                                </div>

                                <div class="total-price-basket">
                                    <span class="lbl">Giỏ hàng:</span>
                                    <span class="total-price">
                                        <span class="value" v-text="sumPrice">0</span>
                                        <span class="sign">Đ</span>
                                    </span>
                                </div>
                            </a>

                            <ul class="dropdown-menu">
                                <li v-for="(product, key) in cart">
                                    <div class="basket-item">
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 no-margin text-center">
                                                <div class="thumb">
                                                    <img alt=""
                                                         :src="product.image"/>
                                                </div>
                                            </div>
                                            <div class="col-xs-8 col-sm-8 no-margin">
                                                <div class="title" v-text="product.name"></div>
                                                <div class="price" v-text="product.price + ' (x' + product.quantity + ') Đ'"></div>
                                            </div>
                                        </div>
                                        <a class="close-btn" href="#"></a>
                                    </div>
                                </li>
                                {{--
                                <li>
                                    <div class="basket-item">
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 no-margin text-center">
                                                <div class="thumb">
                                                    <img alt=""
                                                         src="{{ asset('themes/default/assets/images/products/product-small-01.jpg') }}"/>
                                                </div>
                                            </div>
                                            <div class="col-xs-8 col-sm-8 no-margin">
                                                <div class="title">Blueberry</div>
                                                <div class="price">$270.00</div>
                                            </div>
                                        </div>
                                        <a class="close-btn" href="#"></a>
                                    </div>
                                </li>
                                --}}
                                <li class="checkout">
                                    <div class="basket-item">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6" style="padding-left:8px;padding-right:8px">
                                                <a href="{{ route('frontend.cart.index') }}" class="le-button inverse">Giỏ hàng</a>
                                            </div>
                                            <div class="col-xs-12 col-sm-6" style="padding-left:8px;padding-right:8px">
                                                <a href="{{ route('frontend.checkout.index') }}" class="le-button">Thanh toán</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div><!-- /.basket -->
                    </div><!-- /.top-cart-holder -->
                </div><!-- /.top-cart-row-container -->
                <!-- ============================================================= SHOPPING CART DROPDOWN : END ============================================================= -->
            </div><!-- /.top-cart-row -->


        </div><!-- /.container -->
        @if (Route::currentRouteName() !== 'frontend.home.index')
            <nav id="top-megamenu-nav" class="megamenu-vertical animate-dropdown">
                <div class="container">
                    <div class="yamm navbar">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                    data-target="#mc-horizontal-menu-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div><!-- /.navbar-header -->
                        <div class="collapse navbar-collapse" id="mc-horizontal-menu-collapse">
                            <ul class="nav navbar-nav">
                                @if(count($categories[0]) > 0)
                                    @foreach($categories[0] as $cate_dad)
                                        @if($cate_dad->id !== 1)
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">{{ $cate_dad->name }} <i class="caret"></i></a>
                                                @if(count($categories[$cate_dad->id]) > 0)
                                                    <ul class="dropdown-menu">
                                                        @foreach($categories[$cate_dad->id] as $cate_child)
                                                            <li><a href="{{ route('frontend.home.indexProducts', ['category' => $cate_child->id]) }}">{{ $cate_child->name }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                @endif

                            </ul><!-- /.navbar-nav -->
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.navbar -->
                </div><!-- /.container -->
            </nav>
            <br>
        @endif
    </header>
    <!-- ============================================================= HEADER : END ============================================================= -->

    {{-- Content --}}
    @yield('content')
    {{-- End Content --}}

    <footer id="footer" class="color-bg">

        <div class="link-list-row">
            <div class="container no-padding">
                <div class="col-xs-12 col-md-4 ">
                    <!-- ============================================================= CONTACT INFO ============================================================= -->
                    <div class="contact-info">
                        <div class="footer-logo">
                        <img src="{{ asset('themes/default/assets/images/brands/logo.png') }}" width="auto" height="auto"/>
                        </div><!-- /.footer-logo -->

                        <p class="regular-bold"> Sản phẩm đồ mỹ nghệ cao cấp mang thương hiệu Việt</p>

                        <p>
                            Địa chỉ số 256,ngách 156,Mai Dịch,Cầu Giấy,Hà Nội
                        </p>

                        <div class="social-icons">
                            <h3>Mạng xã hội</h3>
                            <ul>
                                <li><a href="http://facebook.com/transvelo" class="fa fa-facebook"></a></li>
                                <li><a href="#" class="fa fa-twitter"></a></li>
                                <li><a href="#" class="fa fa-pinterest"></a></li>
                                <li><a href="#" class="fa fa-linkedin"></a></li>
                                <li><a href="#" class="fa fa-stumbleupon"></a></li>
                                <li><a href="#" class="fa fa-dribbble"></a></li>
                                <li><a href="#" class="fa fa-vk"></a></li>
                            </ul>
                        </div><!-- /.social-icons -->

                    </div>
                    <!-- ============================================================= CONTACT INFO : END ============================================================= -->
                </div>

                <div class="col-xs-12 col-md-8 no-margin">
                    <!-- ============================================================= LINKS FOOTER ============================================================= -->
                    <div class="link-widget">
                        <div class="widget">
                            <h3>Hướng Dẫn</h3>
                            <ul>
                                <li><a href="category-grid.html">Hướng dẫn mua hàng</a></li>
                                <li><a href="category-grid.html">Vận chuyển - Thanh toán</a></li>
                                <li><a href="category-grid.html">Thông Tin Liên Hệ</a></li>
                            </ul>
                        </div><!-- /.widget -->
                    </div><!-- /.link-widget -->

                    <div class="link-widget">
                        <div class="widget">
                            <h3>Về với đồ gỗ mỹ nghệ</h3>
                            <ul>
                                <li><a href="category-grid.html">Giới Thiệu</a></li>
                                <li><a href="category-grid.html">Liên hệ</a></li>
                                <li><a href="category-grid.html">Các Điều Khoản Và Điều Kiện</a></li>
                                <li><a href="category-grid.html">Tìm Kiếm Nâng Cao</a></li>

                            </ul>
                        </div><!-- /.widget -->
                    </div><!-- /.link-widget -->

                    <!-- <div class="link-widget">
                        <div class="widget">
                            <h3>Information</h3>
                            <ul>
                                <li><a href="category-grid.html">My Account</a></li>
                                <li><a href="category-grid.html">Order Tracking</a></li>
                                <li><a href="category-grid.html">Wish List</a></li>
                                <li><a href="category-grid.html">Customer Service</a></li>
                                <li><a href="category-grid.html">Returns / Exchange</a></li>
                                <li><a href="category-grid.html">FAQs</a></li>
                                <li><a href="category-grid.html">Product Support</a></li>
                                <li><a href="category-grid.html">Extended Service Plans</a></li>
                            </ul>
                        </div>
                    </div> -->
                    <!-- /.link-widget -->
                    <!-- ============================================================= LINKS FOOTER : END ============================================================= -->
                </div>
            </div><!-- /.container -->
        </div><!-- /.link-list-row -->

        <div class="copyright-bar">
            <div class="container">
                <div class="col-xs-12 col-sm-6 no-margin">
                    <div class="copyright">
                        &copy; <a href="{{ route('frontend.home.index') }}">Đồ mỹ nghệ cao cấp</a> - all rights reserved
                    </div><!-- /.copyright -->
                </div>
                <div class="col-xs-12 col-sm-6 no-margin">
                    <div class="payment-methods ">
                        <ul>
                            <li><img alt="" src="{{ asset('themes/default/assets/images/payments/payment-visa.png') }}">
                            </li>
                            <li><img alt=""
                                     src="{{ asset('themes/default/assets/images/payments/payment-master.png') }}"></li>
                            <li><img alt=""
                                     src="{{ asset('themes/default/assets/images/payments/payment-paypal.png') }}"></li>
                            <li><img alt=""
                                     src="{{ asset('themes/default/assets/images/payments/payment-skrill.png') }}"></li>
                        </ul>
                    </div><!-- /.payment-methods -->
                </div>
            </div><!-- /.container -->
        </div><!-- /.copyright-bar -->

    </footer><!-- /#footer -->
    <!-- ============================================================= FOOTER : END ============================================================= -->
</div><!-- /.wrapper -->


<!-- JavaScripts placed at the end of the document so the pages load faster -->
<script src="{{ asset('themes/default/assets/js/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('themes/default/assets/js/jquery-migrate-1.2.1.js') }}"></script>
<script src="{{ asset('themes/default/assets/js/bootstrap.min.js') }}"></script>
{{--<script src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>--}}
{{--<script src="{{ asset('themes/default/assets/js/gmap3.min.js') }}"></script>--}}
<script src="{{ asset('themes/default/assets/js/bootstrap-hover-dropdown.min.js') }}"></script>
<script src="{{ asset('themes/default/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('themes/default/assets/js/css_browser_selector.min.js') }}"></script>
<script src="{{ asset('themes/default/assets/js/echo.min.js') }}"></script>
<script src="{{ asset('themes/default/assets/js/jquery.easing-1.3.min.js') }}"></script>
<script src="{{ asset('themes/default/assets/js/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('themes/default/assets/js/jquery.raty.min.js') }}"></script>
<script src="{{ asset('themes/default/assets/js/jquery.prettyPhoto.min.js') }}"></script>
<script src="{{ asset('themes/default/assets/js/jquery.customSelect.min.js') }}"></script>
<script src="{{ asset('themes/default/assets/js/wow.min.js') }}"></script>
<script src="{{ asset('themes/default/assets/js/scripts.js') }}"></script>

<script src="{{ asset('js/vue.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script>
    // Thiết lập để axios chạy được với laravel
    axios.defaults.headers.common = {
        'X-Requested-With': 'XMLHttpRequest'
    };

    /**
     * Test thử
     */
    // axios.get('trangnaodo.html');

    new Vue({
        el: '#app',
        data: {
            cart: {}, // vm.cart
            total: 0,
            sumPrice: 0,
            quantity: 1
        },
        methods: {
            addToCart: function (id, event, isSingleProductPage) {
                isSingleProductPage = isSingleProductPage || false;
                event.preventDefault(); // Để không bị load lại trang do thẻ a

                if( ! isSingleProductPage){
                    this.quantity = 1;
                }

                var vm = this;
                // alert(id);
                axios.post('{{ route('api.cart.addToCart') }}', {
                    id: id,
                    quantity: vm.quantity,
                }).then(function(response){
                    // console.log(response);
                    vm.cart = response && response.data && response.data.cart;
                    vm.total = response && response.data && response.data.total;
                    vm.sumPrice = response && response.data && response.data.sumPrice;
                });
            },
            getCart: function(){
                var vm = this;
                axios   .get('{{ route('api.cart.getCart') }}')
                    .then(function(response){
                        vm.cart = response && response.data && response.data.cart;
                        vm.total = response && response.data && response.data.total;
                        vm.sumPrice = response && response.data && response.data.sumPrice;
                    });
            },
            addQuantity: function(){
                this.quantity += 1;
            },
            subtractQuantity: function(){
                this.quantity -= 1;
            }
        },
        // Luôn chạy khi load vue này, ko cần sự kiện gì đặc biệt
        mounted: function(){
            this.getCart();
        }
    });
</script>

@yield('body_scripts')


</body>
</html>
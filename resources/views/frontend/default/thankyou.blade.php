@extends('frontend.default.master')
@section('content')
<section id="thankyou">
    <div class="container">
        <div class="col-md-12">
            <h3 class="page-header">
                Cảm ơn bạn đã đặt hàng tại website của chúng tôi!
            </h3>
            <div class="alert alert-success">
                Mã đơn hàng của bạn là #{{ session('orderID') }}.
            </div>
        </div>
    </div>
</section>
@endsection
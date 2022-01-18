@extends('frontend.default.master')
@section('content')
    <main id="authentication" class="inner-bottom-md">
        <div class="container">
            <div class="row">

                <div class="col-md-6 col-md-offset-3">
                    <section class="section sign-in inner-right-xs">
                        <h2 class="bordered">Lấy lại mật khẩu</h2>
                        <p>Vui lòng nhập email của bạn</p>

                        {{-- frontend.password.reset --> do trong web.php lôi auth vào group frontend. --}}
                        {{-- còn password.email là từ ban đầu (xem thư mục auth trong view) đã vậy rồi --}}
                        <form action="{{ route('frontend.password.request') }}" method="post" role="form"
                              class="login-form cf-style-1">
                            {{ csrf_field() }}
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="field-row {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label>Email</label>
                                <input type="text" class="le-input" name="email" value="{{ $email or old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div><!-- /.field-row -->

                            <div class="field-row {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label>Mật khẩu</label>
                                <input type="password" class="le-input" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div><!-- /.field-row -->

                            <div class="field-row {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label>Xác nhận mật khẩu</label>
                                <input type="password" class="le-input" name="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div><!-- /.field-row -->

                            <div class="buttons-holder">
                                <button type="submit" class="le-button huge">Lưu mật khẩu mới</button>
                            </div><!-- /.buttons-holder -->
                        </form><!-- /.cf-style-1 -->

                    </section><!-- /.sign-in -->
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container -->
    </main>
@endsection
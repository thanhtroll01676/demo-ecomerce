@extends('admin.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <a class="btn btn-primary" href="{{ route('admin.user.index') }}">Danh sách người dùng</a>
                </div>
                <br/>
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Thêm người dùng</div>
                    <div class="panel-body">
                        <form action="{{ route('admin.user.store') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Họ tên</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="ghi họ tên vào đây" value="{{ old('name') }}">
                                <span class="help-block">{{ $errors->first('name') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="ghi email vào đây" value="{{ old('email') }}">
                                <span class=" help-block">{{ $errors->first('email') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="ghi mật khẩu vào đây">
                                <span class="help-block">{{ $errors->first('password') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                       name="password_confirmation" placeholder="ghi mật khẩu như trên vào đây">
                            </div>
                            <button type="submit" class="btn btn-success">Tạo người dùng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<h1>Đây là trang myView1</h1>

<?php
    echo '<pre>';
    print_r($_GET);
    echo '</pre>';
?>

{{--<form action="" method="GET">--}}
    {{--<input type="text" name="txt">--}}
    {{--<input type="submit" name="ok" value="submit">--}}
{{--</form>--}}

{{--<form action="{{ url('/myRoute') }}" method="GET">--}}
    {{--<input type="text" name="txt">--}}
    {{--<input type="submit" name="ok" value="submit">--}}
{{--</form>--}}

@extends('layouts.app')

@section('content')
{{ $id }}
<form action="{{ route('user.update', ['id' => $id]) }}" method="POST">
    {{ csrf_field() }}

    {{ method_field('put') }}

    <input type="text" name="txt">
    <input type="submit" name="ok" value="submit">
</form>
@endsection

@section('title')
    show - @parent
@endsection
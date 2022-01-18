@extends('admin.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <a class="btn btn-primary" href="{{ route('admin.user.create') }}">Tạo thành viên mới</a>
                </div>
                <br/>
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Danh sách thành viên</div>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>{{ $user->updated_at }}</td>
                                        <td>
                                            <a class="btn btn-primary"
                                               href="{{ route('admin.user.show', ['id' => $user->id]) }}">Edit</a>
                                            <a class="btn btn-danger"
                                               href="{{ route('admin.user.delete', ['id' => $user->id]) }}"
                                               onclick="event.preventDefault();
                                                       window.confirm('Bạn có chắc là bạn muốn xoá người dùng: ' + '{{ $user->name }}' + ' không?') ? document.getElementById('delete-user-{{ $user->id }}').submit() : false;">Delete</a>
                                            <form action="{{ route('admin.user.delete', ['id' => $user->id]) }}"
                                                  method="post" id="delete-user-{{ $user->id }}" style="display: none;">
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
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
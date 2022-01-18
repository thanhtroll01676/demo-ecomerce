@extends('admin.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <a class="btn btn-primary" href="{{ route('admin.category.create') }}">Tạo chuyên mục mới</a>
                </div>
                <br/>
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Danh sách chuyên mục</div>
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
                                    <th>Slug</th>
                                    <th>Order</th>
                                    <th>Parent</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>{{ $category->order }}</td>
                                        <td>{{ $category->parent }}</td>
                                        <td>{{ $category->created_at }}</td>
                                        <td>{{ $category->updated_at }}</td>
                                        <td>
                                            <a class="btn btn-primary"
                                               href="{{ route('admin.category.show', ['id' => $category->id]) }}">Edit</a>
                                            <a class="btn btn-danger"
                                               href="{{ route('admin.category.delete', ['id' => $category->id]) }}"
                                               onclick="event.preventDefault();
                                                       window.confirm('Bạn có chắc là bạn muốn xoá chuyên mục ' + '{{ $category->name }}' + ' không?') ? document.getElementById('delete-category-{{ $category->id }}').submit() : false;">Delete</a>
                                            <form action="{{ route('admin.category.delete', ['id' => $category->id]) }}"
                                                  method="post" id="delete-category-{{ $category->id }}" style="display: none;">
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
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
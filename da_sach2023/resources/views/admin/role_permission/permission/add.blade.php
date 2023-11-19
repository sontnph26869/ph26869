@extends('layouts.admin')
@section('content')


<div class="container-fluid">

    <!-- Page Heading -->
    <a href="{{route('permission.list')}}" class="btn btn-success m-3">Danh sách quyền</a>
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="{{route('permission.add')}}" enctype="multipart/form-data">
                @csrf
                <h1 class="h3 mb-2 text-gray-800">Thêm mới quyền</h1>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên quyền</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên hiển thị </label>
                            <input type="text" class="form-control" name="display_name">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nhóm</label>
                            <input type="text" class="form-control" name="group">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Thêm mới</button>
                <button type="reset" class="btn btn-danger">Nhập lại</button>
            </form>
        </div>
    </div>

</div>
@endsection

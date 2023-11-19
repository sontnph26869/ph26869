@extends('layouts.admin')
@section('content')


<div class="container-fluid">
    <a href="{{route('role.list')}}" class="btn btn-success m-3">Danh sách vai trò</a>

    <!-- Page Heading -->
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
            <form method="post" action="{{route('role.update',['id'=>$role->id])}}" enctype="multipart/form-data">
                @csrf
                <h1 class="h3 mb-2 text-gray-800">Sửa vai trò</h1>

                <div class="row">
                    <div class="col-md-5">
                        <label for="" class="btn btn-success">Vai trò</label>
                        <hr>
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên vai trò</label>
                            <input type="text" class="form-control" name="name" value="{{$role->name}}">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên hiển thị</label>
                            <input type="text" class="form-control" name="display_name" value="{{$role->display_name}}">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nhóm</label>
                            <input type="text" class="form-control" name="group" value="{{$role->group}}">
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <button type="reset" class="btn btn-danger">Nhập lại</button>
                    </div>

                    <div class="col-md-7">
                        <label for="" class="btn btn-success mb-2">Quyền</label>
                        <hr>
                        <div class="form-check">
                            <input class="form-check-input select-all-checkbox" type="checkbox" id="selectAllAll">
                            <label class="form-check-label" for="selectAllAll">
                                Chọn tất cả
                            </label>
                        </div>
                        <!-- ... -->

                        <div class="row">
                            @foreach($permission as $groupName => $per)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <hr>
                                    <h4 class="mb-2 text-capitalize fw-bold">{{ $groupName }}</h4>
                                    <input class="form-check-input select-all-checkbox" type="checkbox" id="select-all">
                                    <label class="form-check-label" for="select-all">
                                        Chọn tất cả {{$groupName}}
                                    </label>
                                </div>
                                <hr>
                                @foreach($per as $item)
                                <div class="form-check">
                                    <input class="form-check-input permission-checkbox child-checkbox" @foreach($get_permission_via_role as $get) @if($get->id == $item->id)
                                    checked
                                    @endif
                                    @endforeach
                                    type="checkbox" value="{{$item->id}}" id="{{$item->id}}" name="permission[]">
                                    <label class="form-check-label" for="{{$item->id}}">
                                        {{$item->name}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    function selectAllCheckbox() {
        document.getElementById('selectAllAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.child-checkbox');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        let childCheckboxes = document.getElementsByClassName('child-checkbox');
        for (let checkbox of childCheckboxes) {
            checkbox.addEventListener('change', function() {
                document.getElementById('selectAllAll').checked = [...childCheckboxes].every(checkbox => checkbox.checked);
            });
        }
    }

    selectAllCheckbox();
</script>
@endpush

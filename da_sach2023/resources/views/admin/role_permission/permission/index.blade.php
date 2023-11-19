@extends('layouts.admin')
@push('styles')
<link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .dropdown-menu a:hover {
        background-color: aquamarine;
        /* Đổi màu khi đưa chuột vào */
        color: #0069d9;
        /* Đổi màu chữ khi đưa chuột vào */
    }
</style>
@endpush
@section('title')
Danh sách quyền
@endsection
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Danh sách quyền</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col">
                    <a href="{{ route('permission.form-add') }}" class="btn btn-success">
                        Thêm mới
                    </a>
                </div>
                <div class="col text-right">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            Hành động
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{route('bin.list-permission')}}">Thùng rác</a>
                            <a href="#" id="delete-selected" class="dropdown-item">Xoá đã chọn</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="dataTable_length"><label>Hiển thị <select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> Mục</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <form action="{{route('permission.list')}}" method="GET">
                                <div class="row">
                                    <div id="dataTable_filter" class="dataTables_filter">
                                        <label>
                                            <input type="search" name="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTable">
                                            <button class="btn btn-outline-success form-control-sm" type="submit">
                                                Tìm kiếm
                                            </button>
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered text-center mt-2" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="">
                                            <input type="checkbox" class="" id="select-all">
                                        </th>
                                        <th scope="col">Tên vai trò</th>
                                        <th scope="col">Tên hiển thị</th>
                                        <th scope="col">Nhóm</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($permission as $permission)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="child-checkbox" name="ids[]" value="{{ $permission->id }}">
                                        </td>
                                        <td>{{$permission->name}}</td>
                                        <td>{{$permission->display_name}}</td>
                                        <td>{{$permission->group}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn" type="button" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{route('permission.form-update',['id'=>$permission->id])}}">Cập nhật</a>
                                                    <a class="dropdown-item show_confirm" href="{{route('permission.delete',['id'=>$permission->id])}}">Xoá
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function() {
        var switches = Array.from(document.querySelectorAll('.switch1'));
        switches.forEach(function(elem) {
            new Switchery(elem);
        });
    });
</script>
<script type="text/javascript">
    function alertConfirmation() {
        $('.show_confirm').click(function(event) {
            var href = $(this).attr("href"); // Lấy URL từ thuộc tính href của thẻ <a>
            var name = $(this).data("name");
            event.preventDefault();

            Swal.fire({
                    title: 'Xác nhận xóa',
                    text: 'Bạn có chắc chắn muốn xóa các mục đã chọn?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        // Người dùng đã xác nhận xóa
                        // Chuyển hướng đến URL xóa
                        window.location.href = href;
                    } else {
                        // Người dùng đã bấm nút "Hủy"
                        // Không làm gì cả hoặc có thể xử lý khác nếu cần
                    }
                });
        });
    }


    alertConfirmation();

    function selectAllCheckbox() {
        document.getElementById('select-all').addEventListener('change', function() {
            let checkboxes = document.getElementsByClassName('child-checkbox');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        let childCheckboxes = document.getElementsByClassName('child-checkbox');
        for (let checkbox of childCheckboxes) {
            checkbox.addEventListener('change', function() {
                document.getElementById('select-all').checked = false;
            });
        }
    }
    selectAllCheckbox();

    function deleteSelected() {
        $(document).ready(function() {
            $('#delete-selected').click(function(e) {
                e.preventDefault();

                var selectedCheckboxes = $('.child-checkbox:checked');

                if (selectedCheckboxes.length > 0) {
                    var selectedIds = [];
                    selectedCheckboxes.each(function() {
                        selectedIds.push($(this).val());
                    });

                    Swal.fire({
                        title: 'Xác nhận xóa',
                        text: 'Bạn có chắc chắn muốn xóa các mục đã chọn?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: '/admin/permission/deleteAll', // Thay thế bằng tuyến đường xử lý xoá của bạn
                                data: {
                                    ids: selectedIds,
                                    _token: '{{ csrf_token() }}',
                                },
                                success: function(response) {
                                    // Xử lý phản hồi từ máy chủ nếu cần
                                    location.reload();
                                },
                                error: function() {
                                    location.reload();
                                }
                            });
                        }
                    });
                }
            });
        });
    }

    deleteSelected();
</script>
@endpush
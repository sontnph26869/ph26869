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
Thùng rác vai trò
@endsection
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Thùng rác vai trò</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col">
                    <a href="{{ route('role.list') }}" class="btn btn-success">
                        Danh sách vai trò
                    </a>
                </div>
                <div class="col text-right">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            Hành động
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" id="restore-selected">Khôi phục mục đã chọn</a>
                            <a href="#" id="delete-selected" class="dropdown-item">Xoá vĩnh viễn các mục đã chọn</a>
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
                            <form action="{{ route('bin.list-role') }}" method="get">
                                <div class="row">
                                    <div id="dataTable_filter" class="dataTables_filter"><label>
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
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th>
                                        <th>Tên vai trò</th>
                                        <th>Tên hiển thị</th>
                                        <th>Nhóm</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($softDeletedRoles as $softDeletedRoles)
                                    <tr class="">
                                        <td>
                                            <input type="checkbox" class="child-checkbox" value="{{ $softDeletedRoles->id }}" name="id">
                                        </td>
                                        <td>{{$softDeletedRoles->name}}</td>
                                        <td>{{$softDeletedRoles->display_name}}</td>
                                        <td>{{$softDeletedRoles->group}}</td>
                                        <td class="col-1">
                                            <div class="dropdown">
                                                <button class="btn" type="button" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('bin.restore-role', ['id' => $softDeletedRoles->id]) }}">Khôi phục mục đã chọn</a>

                                                    <a class="dropdown-item show_confirm" href="{{ route('bin.delete-role', ['id' => $softDeletedRoles->id]) }}">Xoá vĩnh viễn
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
                    Swal.fire({
                        title: 'Xác nhận xóa',
                        text: 'Bạn có chắc chắn muốn xóa vĩnh viễn các mục đã chọn?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var selectedIds = [];
                            selectedCheckboxes.each(function() {
                                selectedIds.push($(this).val());
                            });

                            $.ajax({
                                type: 'POST',
                                url: '/admin/role/permanentlyDeleteSelected', // Thay thế bằng tuyến đường xử lý xoá của bạn
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

    function restoreSelected() {
        $(document).ready(function() {
            $('#restore-selected').click(function(e) {
                e.preventDefault();

                var selectedCheckboxes = $('.child-checkbox:checked');

                if (selectedCheckboxes.length > 0) {
                    Swal.fire({
                        title: 'Xác nhận khôi phục',
                        text: 'Bạn có chắc chắn muốn khôi phục các mục đã chọn?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Khôi phục',
                        cancelButtonText: 'Hủy',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var selectedIds = [];
                            selectedCheckboxes.each(function() {
                                selectedIds.push($(this).val());
                            });

                            $.ajax({
                                type: 'POST',
                                url: '/admin/role/restoreSelected',
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
    restoreSelected();
</script>
@endpush
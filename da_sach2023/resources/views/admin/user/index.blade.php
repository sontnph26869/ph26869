@extends('layouts.admin')
@push('styles')
<link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
@endpush
@section('title')
Danh sách người dùng
@endsection
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Danh sách người dùng</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col">
                    <a href="{{ route('user.add') }}" class="btn btn-success">
                        Thêm mới
                    </a>
                </div>
                <div class="col text-right">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            Hành động
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('user.trash') }}">Thùng rác</a>
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
                        <div class="col-sm-12 col-md-6">
                            <form action="{{ route('user.index') }}" method="get" >
                                <div class="row">
                                    <div class="dataTables_length mr-2" id="dataTable_length"><label>Lọc
                                            <select name="status" aria-controls="dataTable" class="custom-select custom-select-sm form-control ">
                                                <option value="">Vui lòng chọn</option>
                                                <option value="1">Hoạt động</option>
                                                <option value="2">Không hoạt động</option>
                                                <option value="3">Hết hạn</option>
                                                <option value="4">Hết số lượng</option>
                                            </select>
                                        </label>
                                    </div>
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
                            <table class="table table-bordered text-center mt-2" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="">
                                            <input type="checkbox" class="" id="select-all">
                                        </th>
                                        <th scope="col">Tên người dùng</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Vai trò</th>
                                        <th scope="col">Số điện thoại</th>
                                        <th scope="col">Địa chỉ</th>
                                        <th scope="col">Giới tính</th>
                                        <th scope="col">Hình ảnh</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($user1 as $user)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="child-checkbox" name="ids[]" value="{{ $user->id }}">
                                        </td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                            <span class="badge badge-info">{{$role->name}}</span>
                                            @endforeach
                                        </td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->address}}</td>
                                        <td>{{$user->gender == '0' ? 'Nam' : 'Nữ'}}</td>
                                        <td>
                                            <img alt="Avatar" width="60" src="{{ $user->avatar ? Storage::url($user->avatar) : asset('images/image-not-found.jpg') }}" alt="Image">
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                @if ($user->status == 3)
                                                Hết hạn
                                                @elseif($user->status == 4)
                                                Hết số lượng
                                                @elseif($user->status == 1 || $user->status == 2)
                                                <input type="checkbox" value="{{ $user->status }}" name="status" data-item-id="{{ $user->id }}" class="switch1 switch-status switchery-small" {{ $user->status == 1 ? 'checked' : '' }} />
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn " type="button" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('user.edit', ['id' => $user->id]) }}">Sửa</a>
                                                    <a class="dropdown-item show_confirm" href="{{ route('user.destroy', ['id' => $user->id]) }}">Xoá
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
                    <div class="row">
                        <div class="col-sm-12 col-md-5 mb-3
                            ">
                            <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
                                Hiển thị {{ $user1->firstItem() }} đến {{ $user1->lastItem() }}
                                của {{ $user1->total() }} mục
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                <ul class="pagination">
                                    {{ $user1->links('pagination::bootstrap-4') }}
                                </ul>
                            </div>
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

    function updateStatus() {

        $(document).ready(function() {
            $('.switch-status').change(function() {
                const itemId = $(this).data('item-id');
                const status = this.checked ? 1 : 2;

                $.ajax({
                    method: 'POST',
                    url: '/admin/user/update-status/' + itemId,
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(data) {
                        // Xử lý phản hồi thành công (nếu cần)
                    },
                    error: function(error) {
                        // Xử lý lỗi (nếu có)
                    }
                });
            });
        });
    }
    updateStatus();

    function deleteSelected() {
        $(document).ready(function() {
            $('#delete-selected').click(function(e) {
                e.preventDefault();

                var selectedCheckboxes = $('.child-checkbox:checked');

                if (selectedCheckboxes.length > 0) {
                    Swal.fire({
                        title: 'Xác nhận xóa',
                        text: 'Bạn có chắc chắn muốn xóa các mục đã chọn?',
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
                                url: '/admin/user/deleteAll', // Thay thế bằng tuyến đường xử lý xoá của bạn
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

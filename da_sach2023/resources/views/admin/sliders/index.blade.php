@extends('layouts.admin')
@push('styles')
<link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
@endpush
@section('title')
Danh sách slider
@endsection
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Danh sách Slider</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col">
                    <a href="{{ route('slider.add') }}" class="btn btn-success">
                        Thêm mới
                    </a>
                </div>
                <div class="col text-right">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            Hành động
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{route('slider.trash')}}">Thùng rác</a>
                            <a class="dropdown-item" href="#" id="delete-selected">Xoá tất cả</a>
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

                        <form action="{{ route('slider.index') }}" method="get">
                                    <div class="row">
                                        <div class="dataTables_length mr-2" id="dataTable_length"><label>Lọc
                                                <select name="status" aria-controls="dataTable"
                                                    class="custom-select custom-select-sm form-control ">
                                                    <option value="">Vui lòng chọn</option>
                                                    <option value="1">Hoạt động</option>
                                                    <option value="2">Không hoạt động</option>
                                                </select>
                                            </label>
                                        </div>
                                        <div id="dataTable_filter" class="dataTables_filter"><label>
                                                <input type="search" name="search" class="form-control form-control-sm"
                                                    placeholder="" aria-controls="dataTable">
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
                                        <th scope="col">Đường dẫn ảnh</th>
                                        <th scope="col">Mô tả</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($slider1 as $slider)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="child-checkbox" value="{{$slider->id}}" name="ids[]">
                                        </td>
                                        <td>
                                            @if ($slider->image_url)
                                            @php
                                            $imageURLs = json_decode($slider->image_url, true); // Decode the JSON to an array
                                            @endphp
                                            <ul>
                                                @foreach ($imageURLs as $url)
                                                <li><a href="{{ route('admin.sliders.images.show', ['filename' => $url]) }}">admin/{{ $url }}</a></li>
                                                @endforeach
                                            </ul>
                                            @else
                                            No image URLs available
                                            @endif
                                        </td>
                                        <td class="alt_text" name="alt_text">
                                            <ul>
                                                <li>
                                                    <a href="{{route('slider.show',$slider->id)}}" style="text-decoration: none;">{{$slider->alt_text}}</a>
                                                </li>
                                            </ul>

                                        </td>
                                        <td>
                                        <div class="form-check form-switch">
                                <input type="checkbox" value="{{ $slider->status }}"
                                                                name="status" data-item-id="{{ $slider->id }}"
                                                                class="switch1 switch-status switchery-small"
                                                                {{ $slider->status == 1 ? 'checked' : '' }}
                                                                />
                                </div>

                                        </td>

                                        <td>

                                            <div class="dropdown">
                                                <button class="btn " type="button" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('slider.edit', ['id' => $slider->id]) }}">Sửa</a>
                                                    <a class="dropdown-item show_confirm" href="{{ route('slider.destroy', ['id' => $slider->id]) }}">Xoá
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
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
                                Hiển thị
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                <ul class="pagination">
                                    {{ $slider1->links('pagination::bootstrap-4') }}
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
@push('styles')


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    td {
        border: 1px solid #ccc;
        /* Add a border to the <td> element */
        padding: 10px;
        /* Add some padding to the content inside the <td> */
    }

    ul {
        list-style-type: none;
        /* Remove bullet points from the <ul> */
        padding: 0;
        /* Remove default padding from the <ul> */
    }

    li {
        margin-bottom: 5px;
        /* Add some space between list items */
    }

    a {
        text-decoration: none;
        /* Remove underlines from links */
        color: #007bff;
        /* Set link text color to blue */
    }
</style>


<style>
    /* Tùy chỉnh bảng */
    table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #e0e0e0;
    }

    /* Tùy chỉnh header bảng */
    th {
        background-color: #f2f2f2;
        text-align: center;
    }

    /* Tùy chỉnh ô dữ liệu */
    td {
        text-align: center;
    }

    /* Tùy chỉnh hàng chẵn của bảng */
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Tùy chỉnh nút hoạt động */
    .btn-primary {
        background-color: #007bff;
        color: #fff;
    }

    .fa-trash {
        color: red;
        /* Đổi màu biểu tượng thành màu đỏ */
        font-size: 18px;
        /* Đặt kích thước biểu tượng */
    }
</style>


@endpush
@push('scripts')
<!--tìm kiếm theo tên  -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {
        $('#searchInput').on('input', function() {
            var searchText = $(this).val().toLowerCase();
            $('#dataTable tbody tr').each(function() {
                var text = $(this).find('.alt_text').text().toLowerCase(); // Tìm kiếm theo cột tên
                if (text.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<!-- Page level plugins -->
<script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>
<!-- Page level custom scripts -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
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

            swal({
                    title: `Bạn có muốn xóa danh mục này không ?`,
                    text: "Nếu bạn xóa, Nó sẽ biến mất mãi mãi.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        // Chuyển hướng đến URL xóa khi người dùng xác nhận
                        window.location.href = href;
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
            url: '/admin/slider/status/' + itemId,
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
                                    url: '/admin/slider/deleteAll', // Thay thế bằng tuyến đường xử lý xoá của bạn
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
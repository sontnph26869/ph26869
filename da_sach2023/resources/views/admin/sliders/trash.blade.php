@extends('layouts.admin')

@section('content')


    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Thùng Rác</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col">
                  
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
                    <table class="table table-bordered responsive-table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                       
                            <td class="pr-2 " tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="id: activate to sort column descending" style="width: 50px;">
                                            <label>
                                                <input type="checkbox" id="select-all">
                                            </label>
                            </td>
                                <th>id</th>
                                <th>mô tả</th>
                                <th>hành động</th>
                               
                            
                        </thead>

                        <tbody>

@foreach($trashedPosts as $slider)
    <tr>
        
    
    <td class="sorting_1 text-center">
                <label>
                    <input type="checkbox" class="child-checkbox" value="{{$slider->id}}" name="ids[]">
             </label>
     </td>
        <td>{{ $slider->id }}</td>
        <td>{{ $slider->alt_text }}</td>

        
        <td>
            <a href="{{ route('slider.restore', $slider->id) }}" class="btn btn-success">Khôi phục</a>
            <a href="{{ route('slider.forceDelete', ['id' => $slider->id]) }}" class="btn btn-danger
                                    show_confirm" data-name="Xoá thẻ a">Xóa vĩnh viễn </a>
            <!-- <button type="submit" class="btn btn-danger show_confirm" >Xóa vĩnh viễn</button> -->
            <form action="{{ route('slider.forceDelete', $slider->id) }}" method="post" style="display:inline;" id="delete" >
                @csrf
            </form>
            
        </td>
    </tr>
@endforeach

                    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <a href="{{route('slider.index')}}"> <button class="btn btn-primary" type="button">Danh Sách</button></a>


    </div>
@endsection


@push('styles')



    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

   
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
</style>
    

@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    <!-- Page level custom scripts -->

    <script type="text/javascript">
             function alertConfirmation() {
    $('.show_confirm').click(function (event) {
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
                // document.getElementById('delete').submit();
            }
        });
    });
}

alertConfirmation();
       

        function selectAllCheckbox() {
            document.getElementById('select-all').addEventListener('change', function () {
                let checkboxes = document.getElementsByClassName('child-checkbox');
                for (let checkbox of checkboxes) {
                    checkbox.checked = this.checked;
                }
            });

            let childCheckboxes = document.getElementsByClassName('child-checkbox');
            for (let checkbox of childCheckboxes) {
                checkbox.addEventListener('change', function () {
                    document.getElementById('select-all').checked = false;
                });
            }
        }

        selectAllCheckbox();

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
                                    url: '/admin/slider/restoreSelected',
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
                                    url: '/admin/slider/permanentlyDeleteSelected', // Thay thế bằng tuyến đường xử lý xoá của bạn
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

<script src="{{ asset('admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Page level custom scripts -->
<script src="{{ asset('admin/js/demo/datatables-demo.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="{{ asset('admin/js/demo/datatables-demo.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@endpush

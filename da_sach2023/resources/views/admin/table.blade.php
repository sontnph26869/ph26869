@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                DataTables documentation</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="">
                    <button class="btn btn-primary">thêm</button>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Name</th>
                            <th>gender</th>
                            <th>total</th>
                            <th>email</th>
                            <th>ảnh</th>
                            <th>date</th>
                            <th>action</th>
                        </tr>
                        </thead>

                        <tbody>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>

                                <a href="">
                                    <button class="btn btn-primary ">edit</button>

                                </a>

                                <button class="btn btn-danger"
                                        onclick="
                                if(confirm('bạn muốn xóa k ?')){
                            document.getElementById('delete').submit();
                                     }
                                ">xóa
                                </button>
                                <form action="" method="post" id="delete">

                                </form>
                            </td>
                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('admin/js/demo/datatables-demo.js') }}"></script>
@endpush

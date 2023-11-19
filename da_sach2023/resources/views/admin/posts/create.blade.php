@extends('layouts.admin')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Thêm Mới Bài Viết</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form</h6>
            </div>
            <div class="card-body">

                <!-- form_Post -->
                <form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tiêu Đề</label>
                                <input type="text" class="form-control" name="title" id="title">
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                            <label for="name" class="form-label">Đường dẫn</label>
                            <input type="text" class="form-control" name="slug" id="slug">
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Trạng Thái</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">--Chọn--</option>
                                    <option value="1">duyệt</option>
                                    <option value="2"> Chưa duyệt</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="image">Ảnh</label> <br>
                                <input name="image" type="file" id="image_url" style="display: none">
                                <img src="{{ asset('images/image-not-found.jpg') }}" width="150" height="130"
                                    id="image_preview" class="mt-1" alt="">
                            </div>
                        </div>

                        <div class="col-md-9">

                            <div class="bs-example" data-example-id="embedded-scrollspy">
                                <div class="scrollspy-example" data-spy="scroll" data-target="#navbar-example2"
                                    data-offset="0">
                                    <h5>Danh mục</h5>
                                    <div class="post_type">
                                        @foreach ($data1 as $category)
                                            @if ($category->parent_id == 0)
                                                <ul id="div1">
                                                    <li>
                                                        <input type="checkbox" id="post_type{{ $category->id }}"
                                                            name="post_type[]" value="{{ $category->id }}">
                                                        <label
                                                            for="post_type{{ $category->id }}">{{ $category->name }}</label>
                                                        <ul>
                                                            @foreach ($data1 as $child)
                                                                @if ($child->parent_id == $category->id)
                                                                    <li>
                                                                        <input type="checkbox"
                                                                            id="post_type{{ $child->id }}"
                                                                            name="post_type[]" value="{{ $child->id }}">
                                                                        <label
                                                                            for="post_type{{ $child->id }}">{{ $child->name }}</label>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                </ul>
                                            @endif
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--  -->
                    </div>
                    <label for="image">Nội Dung</label> <br>
                    <div class="">
                        <div class="row_content ">
                            <textarea name="content" id="content123" cols="30" rows="10" width="100%" height="1000px"></textarea>
                        </div>
                    </div>
                    <div class="col submit-button-container">
                        <button type="submit" class="btn btn-success">Thêm mới</button>
                        <a href="{{ route('post.index') }}"> <button class="btn btn-primary" type="button">Danh
                                Sách</button></a>
                        <button type="reset" class="btn btn-danger">Làm Lại</button>
                    </div>
                </form>


                <!-- end_form -->
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            .navbar-default {
                background-color: #f8f8f8;
                border-color: #e7e7e7;
                float: left;
                width: 30%;
            }

            .navbar-default .navbar-collapse,
            .navbar-default .navbar-form {
                clear: both;
            }

            .navbar-nav {
                float: none;
                margin: 0;
            }

            .navbar-nav>li {
                float: none;
                display: block;
            }

            .navbar-nav>li>a {
                padding-top: 15px;
                padding-bottom: 15px;
            }

            .navbar-default .navbar-nav>.active>a {
                color: #555;
                background-color: #e7e7e7;
            }

            .scrollspy-example {
                position: relative;
                height: 200px;
                margin-top: 0;
                overflow: auto;
                width: 66%;
                float: right;
                border: 1px solid #ddd;
                box-sizing: border-box;
                padding: 10px;
            }
        </style>
        <style>
            .submit-button-container {
                margin-top: 20px;
                /* Đặt khoảng cách 20px giữa nút và cột */
            }

            /* Định dạng cơ bản cho danh mục */
            .post_type {
                margin: 20px;
            }

            /* Định dạng danh mục cha */
            .post_type ul {
                list-style: none;
                padding: 0;
            }

            .post_type ul li {
                margin-bottom: 10px;
            }

            /* Định dạng danh mục con */
            .post_type ul ul {
                margin-left: 20px;

            }

            /* Hiển thị danh mục con khi checkbox được kiểm tra */
            .post_type input[type="checkbox"]:checked+label+ul {
                display: block;
            }

            /* Tùy chỉnh màu và kiểu hiển thị của liên kết */
            .post_type label {
                cursor: pointer;
                color: #333;
            }

            .post_type label:hover {
                color: #007bff;
            }

            .scrollable-container {
                max-height: 400px;
                /* Adjust the maximum height as needed */
                overflow: auto;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="{{ asset('node_modules/ckeditor4/ckeditor.js') }}"></script>
        <script>
            var editor = CKEDITOR.replace('content123');
            CKFinder.setupCKEditor(editor);
        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script>
            $('[data-spy="scroll"]').each(function() {
                var $spy = $(this).scrollspy('refresh')
            })
        </script>
        <script src="{{ asset('upload_file/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('upload_file/input-mask/jquery.inputmask.js') }}"></script>
        <script src="{{ asset('upload_file/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
        <!-- check đường dẫn -->
        <script>
            function removeVietnameseSigns(str) {
                str = str.toLowerCase();
                str = str.replace(/đ/g, 'd'); // Thay thế ký tự "đ" thành "d"
                str = str.normalize('NFD').replace(/[\u0300-\u036f]/g, ''); // Loại bỏ dấu thanh
                return str;
            }

            document.getElementById('title').addEventListener('input', function() {
                let nameValue = this.value;
                let slugValue = removeVietnameseSigns(nameValue)
                    .replace(/[^\w\s-]/g, '') // Loại bỏ các ký tự đặc biệt, chỉ giữ lại khoảng trắng và dấu gạch ngang
                    .replace(/\s+/g, '-') // Thay thế khoảng trắng bằng dấu gạch ngang
                    .replace(/-+/g, '-'); // Loại bỏ các dấu gạch ngang liên tiếp

    document.getElementById('slug').value = slugValue;
});
        </script>


        <script>
            const imagePreview = document.getElementById('image_preview');
            const imageUrlInput = document.getElementById('image_url');

            $(function() {
                function readURL(input, selector) {
                    if (input.files && input.files[0]) {
                        let reader = new FileReader();

                        reader.onload = function(e) {
                            $(selector).attr('src', e.target.result);
                        };

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $("#image_url").change(function() {
                    readURL(this, '#image_preview');
                });

            });
            imagePreview.addEventListener('click', function() {
                imageUrlInput.click();
            });

            imageUrlInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpush
@endsection

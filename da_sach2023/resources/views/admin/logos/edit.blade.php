@extends('layouts.admin')
@section('content')
@if($errors ->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>

        </div>
@endif
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Cập Nhật Logo</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form</h6>
    </div>
    <div class="card-body">
        <!-- form sửa bài viết -->
        <form method="post" action="{{route('logo.update',$data->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
  
           
                <div class="col-md-6">
                    <div class="mb-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Nội dung</label>
                        <input target="_blank" class="form-control" name="alt_text" id="alt_text" value="{{$data->alt_text}}" >
                 </div>

                    </div>
                    <div class="form-group">
                        <label for="image_url">Ảnh</label> <br>
                        <input name="image_url" type="file" id="image_url" style="display: none">
                        <!-- check giữ ảnh không có ảnh -->
                        <img src="{{ (isset($data->image_url) && !empty($data->image_url)) ? url($data->image_url) : asset('images/image-not-found.jpg') }}" width="150" height="130" id="image_preview" class="mt-1" alt="{{$data->alt_text}}">
                    </div> 
                </div>
            </div>
            <div class="col submit-button-container ">
            <button type="submit" class="btn btn-success">Cập Nhật</button>
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
    .navbar-default .navbar-collapse, .navbar-default .navbar-form {
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
    margin-top: 20px; /* Đặt khoảng cách 20px giữa nút và cột */
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
    display: none;
}

/* Hiển thị danh mục con khi checkbox được kiểm tra */
.post_type input[type="checkbox"]:checked + label + ul {
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

#post_typeall{
          
            overflow-x:hidden;
            overflow-y:auto;

}
.scrollable-container {
    max-height: 400px; /* Adjust the maximum height as needed */
    overflow: auto;
}

</style>    

@endpush



@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
    $('[data-spy="scroll"]').each(function () {
        var $spy = $(this).scrollspy('refresh')
      })
      
</script>
    <script src="{{ asset('upload_file/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('upload_file/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('upload_file/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script>
        const imagePreview = document.getElementById('image_preview');
        const imageUrlInput = document.getElementById('image_url');

        $(function () {
            function readURL(input, selector) {
                if (input.files && input.files[0]) {
                    let reader = new FileReader();

                    reader.onload = function (e) {
                        $(selector).attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image_url").change(function () {
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

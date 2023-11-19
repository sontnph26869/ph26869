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
<h1 class="h3 mb-2 text-gray-800">Sửa Slider</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form</h6>
    </div>
    <div class="card-body">

    <!-- form_Post -->
        <form method="post" action="{{route('slider.update',$data->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
            <div class="col-md-6">
          
                <div class="mb-3">
                    <!-- thêm nhiều ảnh -->
                    <div class="form-group">
                        <label for="images" class="col-sm-2 col-form-label">Ảnh</label>
                        <div class="col-sm-10 image-container">
                            <input type="file" name="images_url[]" id="image_url" class="form-control" value="{{ old('images') }}" style="display: none" multiple>
                            <div class="image-preview-container">
                            <img src="{{ asset('images/image-not-found.jpg') }}" width="150" height="130" id="image_preview" class="mt-1" alt="" >
                                <button id="remove_image" class="remove-button" ></button>
                            </div>
                        </div>
                    </div>
                    <!--  -->
            </div>


              

           </div>
                <div class="col-md-6">
                <div class="mb-3">
                        <label for="email" class="form-label">Mô tả</label>
                        <input target="_blank" class="form-control" name="alt_text" id="alt_text" value="{{$data->alt_text}}">
                 </div>
                    <div class="mb-3">
                    <label for="type" class="form-label">Trạng Thái</label>

                        <select class="form-control" id="status" name="status">
                            <option value="{{$data->status}}">
                                <!--check trạng thái   -->
                                    @if($data->status == 1)
                                        Duyệt
                                    @elseif($data->status == 0)
                                        Chờ duyệt
                                    @else
                                        Không duyệt
                                    @endif
                            </option>
                            <option value="1">duyệt</option>
                            <option value="0">chưa duyệt</option>
                           

                        </select>
                    </div>
                </div>
               
          
        <!--  -->
         </div>
         <div class="row">
         @if ($data->image_url)
                            <div class="mb-12">
                            <div class="form-group">
                                <label for="existing_images">Ảnh hiện có</label>
                                <ul class="image-list-horizontal">
                                    @php
                                        $imageURLs = json_decode($data->image_url, true); // Decode the JSON to an array
                                    @endphp
                                    @foreach ($imageURLs as $url)
                                        <li>
                                            <img src="{{ asset($url) }}" width="60px" height="auto" alt="">
                                            <span class="image-label"></span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            </div>
                        @endif
         </div>

         <div class="col submit-button-container">
            <button type="submit" class="btn btn-success">Cập Nhật</button>
            <a href="{{route('slider.index')}}"> <button class="btn btn-primary" type="button">Danh Sách</button></a>
            <button type="reset" class="btn btn-danger">Làm Lại</button>
        </div>
        </form>

        
    <!-- end_form -->
    </div>
</div>

</div>

@push('styles')

<!-- ảnh css -->
<style>
    .remove-button {
    position: absolute;
    top: 5px;
    right: 5px;
    background-color: white;
    color: gray;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 14px;
    cursor: pointer;
}
.remove-button {
    display: none; /* Hide the button by default */
}

.image-preview-container:hover .remove-button {
    display: block; /* Show the button on image hover */
}

/* Style for the image container */
.image-preview {
    position: relative;
    display: inline-block; /* Ensure images are displayed in a line */
}

/* Show the "X" button on image hover */
.image-preview:hover .remove-button {
    display: block;
}


    #image_preview {
    display: inline-block; /* or display: inline; */
    margin-right: 10px;
     /* You can adjust the margin as needed */
}
   .image-list-horizontal {
    list-style: none;
    padding: 0;
    display: flex;
    flex-direction: row; /* Hiển thị danh sách theo chiều ngang */
    gap: 10px; /* Khoảng cách giữa các ảnh */
}

.image-list-horizontal li {
    display: inline-block; /* Hiển thị các mục trong danh sách trên cùng một dòng */
}

.image-list-horizontal img {
    width: 100px; /* Điều chỉnh chiều rộng của ảnh */
    height: 100px; /* Chiều cao tự động theo tỷ lệ */
}

/* Tùy chỉnh các kiểu dáng khác nếu cần */

    
</style>

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
.scrollable-container {
    max-height: 400px; /* Adjust the maximum height as needed */
    overflow: auto;
}
</style>    

@endpush
@push('scripts')
<script>
$(document).ready(function() {
    $('#image_url').change(function() {
        $('.image-preview').remove();
        var files = $('#image_url')[0].files;
        for (var i = 0; i < files.length; i++) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imageSrc = e.target.result;
                var isDefaultImage = imageSrc.includes(' ./asset/images/image-not-found.jpg');
                var imagePreview = $('<div class="image-preview"> \
                    <img style="max-width: 50px; border-radius: 5px; height: 50px; margin: 10px" src="' + imageSrc + '"> \
                </div>');

                // Only add the "X" button if it's not the default image
                if (!isDefaultImage) {
                    imagePreview.append('<button class="remove-button">X</button>');
                }

                $('.image-container').append(imagePreview);

                if (!isDefaultImage) {
                    imagePreview.find('.remove-button').click(function() {
                        imagePreview.remove();
                    });
                }
            }
            reader.readAsDataURL(files[i]);
        }
    });
});
</script>


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

    // This code allows you to open the file dialog when the image preview is clicked.
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

   



    <script>
var editor = CKEDITOR.replace('contents');
CKFinder.setupCKEditor(editor);
</script>


@endpush
@endsection

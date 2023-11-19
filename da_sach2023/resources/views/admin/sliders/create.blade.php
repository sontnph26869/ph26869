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
<h1 class="h3 mb-2 text-gray-800">Thêm Mới Slider</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form</h6>
    </div>
    <div class="card-body">

    <!-- form_Post -->
    <form method="post" action="{{ route('slider.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <div class="form-group">
                    <label for="images" class="col-sm-2 col-form-label">Ảnh</label>
                    <div class="col-sm-10 image-container">
                        <input type="file" name="images_url[]" id="image_url" class="form-control" value="{{ old('images') }}" style="display: none" multiple>
                        <div class="image-preview-container">
                            <img src="{{ asset('images/image-not-found.jpg') }}" width="150" height="130" id="image_preview" class="mt-1" alt="">
                            <button id="remove_image" class="remove-button"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="email" class="form-label">Mô tả</label>
                <input target="_blank" class="form-control" name="alt_text" id="alt_text">
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Trạng Thái</label>
                <select class="form-control" id="status" name="status">
                    <option value="">--choose--</option>
                    <option value="1">duyệt</option>
              
                    <option value="2">chưa  duyệt</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col submit-button-container">
        <button type="submit" class="btn btn-success">Thêm mới</button>
        <a href="{{ route('slider.index') }}"> <button class="btn btn-primary" type="button">Danh Sách</button></a>
        <button type="reset" class="btn btn-danger">Làm Lại</button>
    </div>
</form>

        
    <!-- end_form -->
    </div>
</div>

</div>

@push('styles')
<style>
    /* Default style for the "X" button */
    /* Default style for the "X" button */
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
    var image_url = []; // Mảng để lưu trữ các URL của ảnh

    $('#image_url').change(function() {
        var files = $('#image_url')[0].files;
        for (var i = 0; i < files.length; i++) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imageSrc = e.target.result;
                var imagePreview = $('<div class="image-preview" data-image-src="' + imageSrc + '"> \
                    <img style="max-width: 150px; border-radius: 5px; height: 130px; margin: 10px" src="' + imageSrc + '" value="'+imageSrc+'"> \
                    <button class="remove-button">X</button>\
                </div>');

                $('.image-container').append(imagePreview);

                imagePreview.find('.remove-button').click(function() {
                    var storageImg;
                    var deletedImageSrc = imagePreview.data('image-src');
                    var index = image_url.indexOf(deletedImageSrc);
                    if (index !== -1) {
                        image_url.splice(index, 1);
                         // Xóa URL của ảnh khỏi mảng
                        imagePreview.remove();
                    }

                });
                image_url.push(imageSrc);
              
            
            }
            reader.readAsDataURL(files[i]);
        }
    });

    // // Xử lý sự kiện khi form được gửi
    // $('form').submit(function(e) {
    //     e.preventDefault();
        
    //     // Ngăn chặn việc gửi form mặc định

    //     // Gửi chỉ 2 ảnh đầu tiên
    //     var imagesToUpload = image_url.slice(0, 2);

    //     // Gửi các URL của ảnh lên máy chủ bằng cách sử dụng AJAX...
    //     $.ajax({
    //         url: '/admin/slider/store', // Thay thế bằng đường dẫn tới máy chủ của bạn
    //         type: 'POST',
    //         data: {  _token: '{{ csrf_token() }}',images: imagesToUpload },

    //         success: function(response) {
    //             // Xử lý phản hồi từ máy chủ (nếu cần)
    //         },
    //         error: function(error) {
    //             // Xử lý lỗi (nếu có)
    //         }
    //     });
    // });
});




</script>







<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
    $(document).ready(function() {
        $('#image_url').on('change', function(e) {
            var files = e.target.files; // Danh sách các tệp đã chọn
            var selectedImages = $('#selected_images'); // Phần tử để hiển thị các ảnh đã chọn

            selectedImages.empty(); // Xóa các ảnh đã chọn trước đó

            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();
                var imageDiv = $('<div><img src="" alt=""></div>');

                reader.onload = function(e) {
                    imageDiv.find('img').attr('src', e.target.result);
                }

                reader.readAsDataURL(files[i]);
                selectedImages.append(imageDiv);
            }

            // Khởi tạo Owl Carousel để tạo slideshow
            selectedImages.owlCarousel({
                items: 1,
                loop: true,
                nav: true,
                dots: true,
            });
        });
    });
</script> -->




<!-- <script>
    const imagePreview = document.getElementById('image_preview');
    const fileInput = document.querySelector('input[type="file"]');

    fileInput.addEventListener('change', function () {
        imagePreview.innerHTML = ''; // Clear previous previews

        for (let i = 0; i < fileInput.files.length; i++) {
            const file = fileInput.files[i];
            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.width = 150;
                img.height = 130;
                imagePreview.appendChild(img);
            }
        }
    });
</script> -->




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



@endpush
@endsection

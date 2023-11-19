@extends('layouts.admin')
@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Sửa Slider</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chạy Thử</h6>
        </div>
        <div class="card-body">
            <div class="row">
            <div class="image-slider mx-auto" style="margin-bottom: 20px;">
                <div class="slideshow-container">
                    @php
                    $imageURLs = json_decode($data->image_url, true); // Decode the JSON to an array
                    @endphp
                    @foreach ($imageURLs as $url)
                    <div class="mySlides fade">
                        <img src="{{ asset($url) }}" alt="">
                    </div>
                    @endforeach
                </div>
            </div>
                 
            </div>
   

            <div class="col submit-button-container">
                <a href="{{route('slider.index')}}"> <button class="btn btn-primary" type="button">Danh Sách</button></a>
            </div>
    


            <!-- end_form -->
        </div>
    </div>

</div>

@push('styles')
<!-- css slider -->
<style>
    .slideshow-container {
    position: relative;
    max-width: 100%;
    overflow: hidden;
}

.mySlides {
    display: none;
}

.mySlides img {
    width: 100%;
}

/* Thêm CSS tùy chỉnh cho hiệu ứng chuyển đổi (ví dụ: fade) */
.fade {
    animation-name: fade;
    animation-duration: 2s;
}

@keyframes fade {
    0% {
        opacity: 0.4;
    }
    25% {
        opacity: 0.6;
    }
    50% {
        opacity: 0.8;
    }
    75% {
        opacity: 1;
    }
    100% {
        opacity: 0.4;
    }
}

</style>


<!-- ảnh css -->


<style>
    .navbar-default {
        background-color: #f8f8f8;
        border-color: #e7e7e7;
        float: left;
        width: 60%;
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
        padding-bottom: 50px;
    }

    .navbar-default .navbar-nav>.active>a {
        color: #555;
        background-color: #e7e7e7;
    }

    .scrollspy-example {
        position: relative;
        height: 100px;
        margin-top: 0;
        overflow: auto;
        width: 60%;
        float: right;
        border: 1px solid #ddd;
        box-sizing: border-box;
        padding: 20px;
    }
</style>


@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<!-- js Slider -->
<script>
let slideIndex = 0;

function showSlides() {
    let slides = document.getElementsByClassName("mySlides");
    
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    
    slideIndex++;
    
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }
    
    slides[slideIndex - 1].style.display = "block";
    setTimeout(showSlides, 2000); // Thay đổi hình ảnh sau mỗi 2 giây (2000 milliseconds)
}

showSlides(); // Bắt đầu hiển thị slideshow tự động

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
    $('[data-spy="scroll"]').each(function() {
        var $spy = $(this).scrollspy('refresh')
    })
</script>
@endpush
@endsection
@extends('layouts.client')
@section('content')
<style>
    .button2{
        background-color: #001232;
        border:none;
    }
    .select-bar {
        margin-top:5px;
    }
    .button3 {
        background-color: #032055;
        border:none;
    }
    .abcc {
        margin-left: 40px;

    }
    .button4 {
        background-color: #001232;
        border:none;

    }

    @media (max-width: 576px) {
        .abcc {
            margin-left: 0px;

    }
    }
</style>
<section class="banner-section">
    <div class="banner-bg bg_img bg-fixed" data-background="./assets/images/banner/banner02.jpg"></div>
    <div class="container">
        <div class="banner-content">
            <h1 class="title bold">get <span class="color-theme">movie</span> tickets</h1>
            <p>Buy movie tickets in advance, find movie times watch trailers, read movie reviews and much more</p>
        </div>
    </div>
</section>
<!-- ==========Banner-Section========== -->

<!-- ==========Ticket-Search========== -->
@include('client.ticket')
<!-- ==========Ticket-Search========== -->

<!-- ==========Movie-Section========== -->
<section class="movie-section padding-top padding-bottom">
    <div class="container">
        <div class="row flex-wrap-reverse justify-content-center">
            <div class="col-sm-10 col-md-8 col-lg-3">
                <div class="widget-1 widget-banner">
                    <div class="widget-1-body">

                    </div>
                </div>
                <div class="widget-1 widget-check">
                    <div class="widget-header">
                        <h5 class="m-title"><a href="{{route('home.favorite.list')}}">Lọc Theo Danh Mục</a></h5>

                    </div>
                </div>
                <div class="widget-1 widget-check">
                    <div class="widget-1-body">
                        <form action="{{route('home.favorite.list')}}">
                        <div class="check-area">

                           @foreach ($genres as $genre )
                           <div class="form-group">

                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-plus-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm6.5-11a.5.5 0 0 0-1 0V6H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V7H10a.5.5 0 0 0 0-1H8.5V4.5z"/>
                              </svg>    <button type="submit" name="danhmuc" value="{{$genre->id}}" class="col-md-10 button3">  {{$genre->name}}</button>
                        </div>
                           @endforeach




                        </div>
                    </form>
                    </div>
                </div>





            </div>
            <div class="col-lg-9 mb-50 mb-lg-0">
                <form action="{{route ('home.favorite.list')}}">
                    <div class="filter-tab tab">
                        <div class="filter-area">
                            <div class="filter-main">
                                <div class="left">
                                    <div class="item">
                                        <div class="row">
                                            <button type="submit" class="col-md-7 col-7  button2">Sắp Xếp Theo :</button>
                                            <select class="select-bar col-md-5  col-5" name="trangthai">
                                                <option value="">Mới Nhất</option>
                                                <option value="sapchieu">Sắp Chiếu</option>
                                                <option value="dangchieu">Đang Chiếu</option>
                                            </select>
                                        </div>
                                    </div>
                                {{-- </form> --}}
                                {{-- <form action="{{route ('home.favorite.list')}}"> --}}
                                    <div class="row abcc">
                                        <div class="col-md-4 col-5 adadada"> <button type="submit" class="button4" for="search-input">Tìm Kiếm </button></div>
                                        <div class="col-md-8 col-7 ">  <input type="search" id="search-input" name="search"></div>

                                    </div>
                                </div>

                                <ul class="grid-button tab-menu">
                                    <li class="active">
                                        <i class="fas fa-th"></i>
                                    </li>

                                </ul>
                            </div>
                        </form>
                    </div>
                    <div class="tab-area">

                            <div class="row mb-10 justify-content-center">
                                @foreach($favoriteMovies as $movie)
                                @if($movie->status != 0)
                                <div class="col-sm-6 col-lg-4">
                                    <div class="movie-grid">
                                        <div class="movie-thumb c-thumb">
                                            <a href="{{route('movie.detail',['id' => $movie->id])}}">
                                                <img src="{{ $movie->poster ? Storage::url($movie->poster) : asset('images/image-not-found.jpg') }}" alt="movie">
                                            </a>
                                        </div>
                                        <div class="movie-content bg-one">
                                            <h5 class="title m-0">
                                                <a href="{{route('movie.detail',['id' => $movie->id])}}">
                                                    <span class="content">{{$movie->name}} </span>
                                                </a>
                                            </h5>

                                            <div class="content">
                                                Thời Lượng:
                                                <?php
                                                $duration = $movie->duration;
                                                if ($duration !== null) {
                                                    $duration = (int)$duration; // Convert to an integer
                                                    if ($duration >= 60) {
                                                        $hours = floor($duration / 60);
                                                        $minutes = $duration % 60;
                                                        echo $hours . "h " . $minutes . "p";
                                                    } else {
                                                        echo $duration . "p";
                                                    }
                                                } else {
                                                    echo "Unknown";
                                                }
                                                ?>
                                            </div>
                                            @foreach($movie->genres as $genre)
                                            <div class="content">
                                               Thể Loại : {{ $genre->name }}
                                            </div>
                                            @endforeach
                                            <div class="content">
                                                Ngày Chiếu : <?php echo date("d-m-Y", strtotime($movie->start_date)); ?>
                                            </div>


                                            <ul class="movie-rating-percent">
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset('client/assets/images/movie/tomato.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                                <li>
                                                    <div class="thumb">
                                                        <img src="{{ asset('client/assets/images/movie/cake.png') }}" alt="movie">
                                                    </div>
                                                    <span class="content">88%</span>
                                                </li>
                                                <li>
                                                    <div class="thumb1">
                                                        @if(auth()->check())
                                                            <a href="{{route('home.favorite.add',['id'=>$movie->id])}}" id="favorite-link" style="color: white" data-movie-id="{{ $movie->id }}">
                                                                <i id="heart-icon" class="fas fa-heart {{ $user->favoriteMovies->contains($movie) ? 'text-danger' : '' }}"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{route('home.favorite.add',['id'=>$movie->id])}}" style="color: white">
                                                                <i id="heart-icon" class="fas fa-heart"></i>
                                                            </a>
                                                        @endif

                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                            </div>

                    </div>
                    <div class="pagination-area text-center">

                       {{ $favoriteMovies->links('pagination::bootstrap-4') }}


                    </div>
        </div>
    </div>
</section>
@endsection
<script>
    // Bắt đầu bằng việc lấy tham chiếu đến nút "Xóa Tất Cả"
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
</script>
<script>

    // Lấy đối tượng biểu tượng trái tim
    const heartIcon = document.getElementById("heart-icon");

 // Bắt đầu với trạng thái không được yêu thích
 let isFavorite = false;

 // Định nghĩa hàm để thay đổi trạng thái trái tim
 function toggleFavorite(event) {
    event.preventDefault();
    isFavorite = !isFavorite;
    if (isFavorite) {
        heartIcon.classList.add("text-danger");
    } else {
        heartIcon.classList.remove("text-danger");
    }

    // Gửi trạng thái yêu thích lên máy chủ
    sendFavoriteStatus();
}

heartIcon.addEventListener("click", toggleFavorite);


 // Gắn sự kiện click để gọi hàm toggleFavorite khi người dùng click vào biểu tượng
 heartIcon.addEventListener("click", toggleFavorite);

 // Bắt đầu với biểu tượng màu trắng
 heartIcon.classList.remove("text-danger");
 </script>

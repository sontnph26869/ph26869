@extends('layouts.client')
@section('content')
    <style>
        .seat-plan-wrapper li .movie-schedule .item {
            color: #ffffff;
            padding: 5px;
            width: 70px;
            background: #162f5f;
            position: relative;
            mask-position: center center;
            -webkit-mask-position: center center;
            text-align: center;
            mask-image: url({{ asset('client/assets/images/ticket/movie-seat.png') }});
            -webkit-mask-image: url({{ asset('client/assets/images/ticket/movie-seat.png') }});
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
            cursor: pointer;
            -webkit-transition: all ease 0.3s;
            transition: all ease 0.3s;
            margin: 5px;
        }
    </style>
<style>
    .province {
        width: 120px;
        background: none;
        outline: none;
        border: none;
        margin-left: 5px;
    }

    .cinema {
        width: 150px;
        background: none;
        outline: none;
        border: none;
        margin-left: 5px;
    }

    .province option {
        background: white;
        color: black;
    }

    .cinema option {
        background: white;
        color: black;
    }
</style>

    <!-- ==========Banner-Section========== -->
    <section class="details-banner hero-area bg_img"
        data-background="{{ Storage::url($movie->poster) }}">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-content">
                    <h3 class="title">{{ $movie->name }}</h3>
                    <div class="tags">
                        <a href="#0">{{ $movie->language }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Book-Section========== -->
    <section class="book-section bg-one">
        <div class="container">
            <div class="tab-area">

                <div class="tab-item active">

                    <form class="ticket-search-form" action="{{ route('lich-chieu',['id'=>$movie->id,'slug'=>$movie->slug]) }}">

                        <div class="form-group">
                            <div class="item md-order-1">
                                <a href="{{ route('movie.detail',['slug'=>$movie->slug,'id'=>$movie->id]) }}" class="custom-button back-button" >
                                    Quay lại </a>
                            </div>
                        </div>

                         <div class="form-group">
                            <div class="thumb">
                                <img src="{{ asset('client/assets/images/ticket/city.png') }}" alt="ticket">
                            </div>
                            <span class="type">Tỉnh</span>
                            <select class="province" name="province_id" id="province_id">
                                <option value="">Vui lòng chọn</option>
                               
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src="{{ asset('client/assets/images/ticket/cinema.png') }}" alt="ticket">
                            </div>
                            <span class="type">thư viện</span>
                            <select class="cinema" name="cinema_id" id="cinema_id">
                                <option value="">Vui lòng chọn</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src="{{ asset('client/assets/images/ticket/date.png') }}" alt="ticket">
                            </div>
                            <span class="type">Ngày</span>
                            <select class="select-bar" name="selected_date" id="selected_date">
                                <option value="">Chọn ngày</option>
                                @for ($i = 0; $i < 7; $i++)
                                    @php
                                        $date = now()->addDays($i);
                                    @endphp
                                    <option value="{{ $date->format('Y-m-d') }}">{{ $date->format('d/m/Y') }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group large">
                            <input type="text" placeholder="Tìm kiếm ">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
    <!-- ==========Book-Section========== -->




    <style>
        .accordion-child {
            display: none !important;
        }

        .accordion-child.active {
            display: block !important;

        }
    </style>

    <!-- ==========Movie-Section========== -->
    <div class="ticket-plan-section padding-bottom padding-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 mb-5 mb-lg-0">
                    <ul class="seat-plan-wrapper bg-five">
                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                      
                            <li class="accordion-parent">
                                <div class="movie-name">
                                    <a href="#0" class a="name text-white">Không có lịch chiếu nào cho phim này tại các
                                        rạp.</a>
                                </div>
                                <div class="movie-schedule">
                                    <a href="#0" class a="name text-white">Phim sẽ có lịch chiếu trong thời gian sắp tới!</a>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========Movie-Section========== -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".accordion-parent").click(function() {
                var $accordionChild = $(this).find(".accordion-child");
                $accordionChild.toggleClass("active");
                var $toggleAccordion = $(this).find(".toggle-accordion");
                var $icon = $toggleAccordion.find("i");
                $icon.toggleClass("fa-plus fa-minus");
            });
        });
    </script>

<script>
    $(document).ready(function() {
        $('#province_id').change(function() {
            var provinceId = $(this).val();
            if (provinceId) {
                $.ajax({
                    type: 'GET',
                    url: '/get-cinemas/' + provinceId,
                    success: function(data) {
                        // Xóa danh sách rạp hiện tại
                        $('#cinema_id').empty();

                        // Thêm danh sách rạp mới
                        $.each(data, function(key, value) {
                            $('#cinema_id').append('<option value="' + key + '">' + value + '</option>');
                        });

                        // Sau khi thêm danh sách rạp mới, thêm option "Vui lòng chọn"
                        $('#cinema_id').prepend('<option value="">Vui lòng chọn</option>');
                    }
                });
            } else {
                // Nếu không chọn tỉnh, xóa danh sách rạp và thêm lại option "Vui lòng chọn"
                $('#cinema_id').empty().append('<option value="">Vui lòng chọn</option>');
            }
        });
    });
</script>

@endsection

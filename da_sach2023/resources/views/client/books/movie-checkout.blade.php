@extends('layouts.client')
@section('content')
    <style>
        .checkout-widget .payment-option li.active a::after {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            top: -15px;
            right: -15px;
            background: url({{ asset('client/assets/images/payment/check.png') }}) no-repeat center center;
            background-size: cover;
        }

        .checkout-widget.checkout-card .payment-card-form .form-group.check-group label::after {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            top: 7px;
            left: 0;
            background: url(./img/check.png ) no-repeat center center;
            background-size: cover;
            display: none;
        }
    </style>
    <!-- ==========Banner-Section========== -->
    <section class="details-banner hero-area bg_img seat-plan-banner" data-background="./assets/images/banner/banner04.jpg">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-content style-two">
                    <h3 class="title">Thanh toán</h3>
                    <div class="tags">
                        {{-- <a href="#0">City Walk</a>
                        <a href="#0">English - 2D</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Page-Title========== -->
    <section class="page-title bg-one">
        <div class="container">
            <div class="page-title-area">
                <div class="item md-order-1">
                    <a 
                        class="custom-button back-button">
                        Quay lại</a>
                </div>

                <div class="item text-white ">
                    <div class="tags ">
            
                    </div>
                </div>
                <div class="item">
                    {{-- <h5 class="title">05:00</h5>
                    <p>Mins Left</p> --}}
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Page-Title========== -->

    <!-- ==========Movie-Section========== -->
    <div class="movie-facility padding-bottom padding-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-widget checkout-contact">
                        <h5 class="title">Mã giảm giá </h5>
                        <form class="checkout-contact-form" action="{{ route('home.voucher.apllyVouchers') }}"
                            method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" placeholder="Nhập mã giảm giá tại đây!" name="code"
                                    id="discount-code-input">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Nhập" class="custom-button" id="submit-button" disabled>
                            </div>

                            @php
                                $totalPriceFood = session('totalPriceFood') ?? 0;
                                // dd($totalPriceFood);
                                // dd($totalPriceTicket);
                                $totalPrice = $totalPriceFood + $totalPriceTicket;
                                // dd($totalPrice);
                            @endphp
                            <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">

                        </form>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    <form
                        action=""
                        class="" method="post">
                        @csrf
                        <div class="checkout-widget checkout-contact">
                            <h5 class="title">Thông tin liên hệ</h5>

                            <div class="form-group">
                                <input type="text" placeholder="Họ và tên" name="name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Email" name="email" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Số điện thoại" name="phone"
                                    value="{{ old('phone') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Địa chỉ" name="address" value="{{ old('address') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Ghi chú" name="note" value="{{ old('note') }}">
                            </div>


                        </div>
                        <div class="checkout-widget checkout-card mb-0">
                            <h5 class="title">Phương thức thanh toán </h5>
                            <ul class="payment-option">
                                <li class="active" onclick="selectPayment(1)">
                                    <a href="#0">
                                        <img src="{{ asset('client/assets/images/payment/card.png') }}" alt="payment">
                                        <span>VNPay</span>
                                    </a>
                                    <input type="radio" name="payment" value="1" checked hidden>
                                </li>
                                <li onclick="selectPayment(2)">
                                    <a href="#0">
                                        <img src="{{ asset('client/assets/images/payment/card.png') }}" alt="payment">
                                        <span>PayPal</span>
                                    </a>
                                    <input type="radio" name="payment" value="2" hidden>
                                </li>
                            </ul>

                            <script>
                                function selectPayment(value) {
                                    // Lấy danh sách tất cả các phần tử li
                                    var paymentOptions = document.querySelectorAll('.payment-option li');

                                    // Bỏ chọn tất cả các input radio
                                    var paymentRadios = document.querySelectorAll('input[name="payment"]');
                                    for (var i = 0; i < paymentRadios.length; i++) {
                                        paymentRadios[i].checked = false;
                                    }

                                    // Tìm li tương ứng và chọn input radio trong li đó
                                    for (var i = 0; i < paymentOptions.length; i++) {
                                        paymentOptions[i].classList.remove('active'); // Loại bỏ class "active" khỏi tất cả các li
                                    }
                                    paymentOptions[value - 1].classList.add('active'); // Thêm class "active" cho li đã chọn
                                    paymentRadios[value - 1].checked = true; // Chọn input radio tương ứng
                                }
                            </script>
                            <p class="notice">
                                Bằng cách nhấp vào "Thanh toán", bạn đồng ý với các <a href="#0">Điều khoản và điều
                                    kiện</a>
                            </p>
                        </div>
                </div>
                <div class="col-lg-4">
                    <div class="booking-summery bg-one">
                        <h4 class="title">Chi tiết hoá đơn</h4>
                        <ul>
                           
                          
                            <li>
                                <h6 class="subtitle"><span>Phòng: {{ $room->name }}</span></h6>
                             
                            </li>
                            <li>
                                <h6 class="subtitle"><span>giá: 
                                    </span><span>{{ $room->price}}</span></h6>
                                <div class="info">
                                    <span>số lượng:
                                        {{$room->quantily}}
                                    </span>
                                </div>
                            </li>

                            <li>
                                <h6 class="subtitle mb-0"><span>Tiền vé </span><span>
                                        {{ number_format($totalPriceTicket, 0, ',', '.') }} VNĐ
                                    </span></h6>
                                <input type="hidden" name="totalPriceTicket" value="{{ $totalPriceTicket }}">
                            </li>
                        </ul>

                        @php
                            $totalPriceFood = session('totalPriceFood') ?? 0;
                            // dd($totalPriceFood);
                            $totalPrice = $totalPriceFood + $totalPriceTicket;
                            // dd($totalPrice);
                        @endphp
                        <ul class="side-shape">
                            @if (session('selectedProducts'))
                                <li>
                                    <h6 class="subtitle"><span>Đồ ăn</span> </h6>
                                    @foreach (session('selectedProducts') as $product)
                                        <span
                                            class="info"><span>{{ $product['name'] }}</span><span>{{ $product['quantity'] }}</span><span>{{ number_format($product['price'], 0, ',', '.') }}
                                                VNĐ</span></span>
                                    @endforeach
                                </li>
                                <li>
                                    <h6 class="subtitle mb-0"><span>Tổng tiền đồ ăn </span><span>
                                            {{ number_format(session('totalPriceFood'), 0, ',', '.') }} VNĐ
                                        </span></h6>
                                    <input type="hidden" name="totalPriceFood" value="{{ $totalPriceFood }}">

                                </li>
                            @endif
                            @if (session('voucher'))
                                <li>
                                    <h6 class="subtitle mb-0"><span>Giảm giá </span><span>
                                            {{ number_format(session('voucher.discount'), 0, ',', '.') }} VNĐ
                                        </span></h6>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="proceed-area  text-center">
                        @if (session('voucher'))
                            <h6 class="subtitle"><span>Tổng tiền</span><span>
                                    {{ number_format(session('voucher.totalPriceVoucher'), 0, ',', '.') }} VNĐ
                                </span></h6>
                            <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">
                        @else
                            <h6 class="subtitle"><span>Tổng tiền</span><span>
                                    {{ number_format($totalPrice, 0, ',', '.') }} VNĐ
                                </span></h6>
                            <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">
                        @endif
                        <button type="submit" class="custom-button back-button" name="redirect">Thanh toán</button>
                    </div>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- ==========Movie-Section========== -->
    <script>
        // Lấy danh sách tất cả các phần tử li trong ul.payment-option
        var paymentOptions = document.querySelectorAll('.payment-option li');

        // Lặp qua danh sách và thêm sự kiện click vào mỗi phần tử li
        for (var i = 0; i < paymentOptions.length; i++) {
            paymentOptions[i].addEventListener('click', function() {
                // Loại bỏ class "active" khỏi tất cả các phần tử li
                for (var j = 0; j < paymentOptions.length; j++) {
                    paymentOptions[j].classList.remove('active');
                }

                // Thêm class "active" vào phần tử li hiện tại (đã được nhấp vào)
                this.classList.add('active');
            });
        }
    </script>

    {{-- disbale nút submit khi chưa nhập mã giảm giá  --}}
    <script>
        document.getElementById("discount-code-input").addEventListener("input", function() {
            var codeInput = this.value.trim();
            var submitButton = document.getElementById("submit-button");

            if (codeInput !== "") {
                submitButton.removeAttribute("disabled");
            } else {
                submitButton.setAttribute("disabled", "disabled");
            }
        });
    </script>
@endsection

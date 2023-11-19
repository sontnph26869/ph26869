@extends('layouts.client')
@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="details-banner hero-area bg_img seat-plan-banner" data-background="./assets/images/banner/banner04.jpg">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-content style-two">
                    <h3 class="title">{{ $showTime->movie->name }}</h3>
                    <div class="tags">
                        <a href="#0">Rạp: {{ $showTime->room->cinema->name }}</a>
                        <a href="#0">Phòng: {{ $showTime->room->name }}</a>
                        <a href="#0">Thời gian: {{ date('H:i', strtotime($showTime->start_date)) }} ~
                            {{ date('H:i', strtotime($showTime->start_end)) }}</a>

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
                    <a href="{{ route('lich-chieu', ['id' => $showTime->movie->id, 'slug' => $showTime->movie->slug]) }}"
                        class="custom-button back-button">
                        Quay lại </a>
                </div>
                <div class="item text-white ">
                    <div class="tags ">
                        <a href="#0" class="text-white">Rạp: {{ $showTime->room->cinema->name }}</a> -
                        <a href="#0" class="text-white">Phòng: {{ $showTime->room->name }}</a> -
                        <a href="#0" class="text-white">Thời gian: {{ date('H:i', strtotime($showTime->start_date)) }}
                            ~ {{ date('H:i', strtotime($showTime->start_end)) }}</a>
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
    <style>
        .seat-type1 {
            margin-right: 10px;
            /* Điều chỉnh khoảng cách giữa các ghế loại 1 trên cùng một hàng */
        }

        /* Điều chỉnh khoảng cách giữa các ghế */
        .seat-area {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            justify-content: center;
            /* Để căn giữa theo chiều ngang */
            align-items: center;
            /* Để căn giữa theo chiều dọc */
        }

        /* Điều chỉnh khoảng cách giữa các ghế trên cùng một hàng */
        .seat-line {
            display: flex;
            gap: 5px;
        }


        .sit-num {
            text-align: center;
        }

        .not-allowed {
            cursor: not-allowed;
        }

        .modal-dialog {
            max-width: 800px;
        }

        .modal-content {
            height: 600px;
        }

        .quantity-input {
            display: flex;
            align-items: center;
            color: black;
        }

        .quantity-input button {
            background: none;
            border: none;
            outline: none;
            cursor: pointer;
            color: black;
        }

        .quantity-input input {
            text-align: center;
            width: 50px;
            color: black;

        }
    </style>


    <!-- ==========Movie-Section========== -->
    <div class="seat-plan-section padding-bottom padding-top">
        <div class="container">
            <div class="screen-area">
                <h4 class="screen">Màn hình</h4>
                <div class="screen-thumb">
                    <img src="{{ asset('client/assets/images/movie/screen-thumb.png') }}" alt="movie">
                </div>

                <h5 class="subtitle">Ghế thường</h5>
                <div class="screen-wrapper">
                    <ul class="seat-area">
                        @php
                            $currentRow = null;
                        @endphp
                        @foreach ($seatsThuong as $thuong)
                            @php
                                $seatNumber = $thuong->row . $thuong->column;
                                $isBooked = in_array($seatNumber, $bookedSeats);
                            @endphp
                            @if ($currentRow != $thuong->row)
                                @if ($currentRow !== null)
                    </ul>
                    </li>
                    @endif
                    <li class="seat-line">
                        <span>{{ $thuong->row }}</span>
                        <ul class="seat--area">
                            @endif
                            <li class="front-seat">
                                <ul>
                                    <li
                                        class="single-seat seat-type1 {{ $isBooked ? 'not-allowed' : 'single-seat1 seat-click ' }} ">
                                        <img src="{{ $isBooked ? asset('client/assets/images/movie/seat01-free.png') : asset('client/assets/images/movie/seat01.png') }}"
                                            alt="seat">
                                        <span class="sit-num">{{ $thuong->row }}{{ $thuong->column }}</span>

                                    </li>
                                </ul>
                            </li>
                            @php
                                $currentRow = $thuong->row;
                            @endphp
                            @endforeach
                        </ul>
                    </li>
                    </ul>
                </div>

                <h5 class="subtitle">Ghế VIP</h5>
                <div class="screen-wrapper">
                    <ul class="seat-area">
                        @php
                            $currentRow = null;
                        @endphp
                        @foreach ($seatsVip as $vip)
                            @php
                                $seatNumber = $vip->row . $vip->column;
                                $isBooked = in_array($seatNumber, $bookedSeats);
                            @endphp
                            @if ($currentRow != $vip->row)
                                @if ($currentRow !== null)
                    </ul>
                    </li>
                    @endif
                    <li class="seat-line">
                        <span>{{ $vip->row }}</span>
                        <ul class="seat--area">
                            @endif
                            <li class="front-seat">
                                <ul>
                                    <li
                                        class="single-seat seat-type1 {{ $isBooked ? 'not-allowed' : 'single-seat1 seat-click ' }} ">
                                        <img src="{{ $isBooked ? asset('client/assets/images/movie/seat01-free.png') : asset('client/assets/images/movie/seat01.png') }}"
                                            alt="seat">
                                        <span class="sit-num">{{ $vip->row }}{{ $vip->column }}</span>

                                    </li>
                                </ul>
                            </li>
                            @php
                                $currentRow = $vip->row;
                            @endphp
                            @endforeach
                        </ul>
                    </li>
                    </ul>
                </div>

                <h5 class="subtitle">Ghế đôi</h5>
                <div class="screen-wrapper">
                    <ul class="seat-area">
                        @php
                            $currentRow = null;
                        @endphp
                        @foreach ($seatsDoi as $doi)
                            @php
                                $seatNumber = $doi->row . $doi->column;
                                $isBooked = in_array($seatNumber, $bookedSeats);
                            @endphp
                            @if ($currentRow != $doi->row)
                                @if ($currentRow !== null)
                    </ul>
                    </li>
                    @endif
                    <li class="seat-line">
                        <span>{{ $doi->row }}</span>
                        <ul class="seat--area">
                            @endif
                            <li class="front-seat">
                                <ul>
                                    <li
                                        class="single-seat seat-type1 {{ $isBooked ? 'not-allowed' : 'single-seat1 seat-click ' }} ">
                                        <img src="{{ $isBooked ? asset('client/assets/images/movie/seat01-free.png') : asset('client/assets/images/movie/seat01.png') }}"
                                            alt="seat">
                                        <span class="sit-num">{{ $doi->row }}{{ $doi->column }}</span>

                                    </li>

                                </ul>
                            </li>
                            @php
                                $currentRow = $doi->row;
                            @endphp
                            @endforeach
                        </ul>
                    </li>
                    </ul>
                </div>
            </div>
            <div class="row text-center ">
                <div class="status mx-auto d-flex">
                    <ul class="m-2">
                        <li><img src="{{ asset('client/assets/images/movie/seat01-booked.png') }}" alt=""></li>
                        <li>Đang chọn</li>

                    </ul>
                    <ul class="m-2">
                        <li><img src="{{ asset('client/assets/images/movie/seat01-free.png') }}" alt=""></li>
                        <li>Đã chọn</li>
                    </ul>
                    <ul class="m-2">
                        <li><img src="{{ asset('client/assets/images/movie/seat01.png') }}" alt=""></li>
                        <li>Ghế trống</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="proceed-book bg_img mb-3"
            data-background="{{ asset('client/assets/images/movie/movie-bg-proceed.jpg') }}">
            <div class="proceed-to-book">
                <div class="book-item">
                    <span>Số ghế bạn chọn</span>
                    <h3 class="title"></h3>
                </div>
                <div class="book-item">
                    <button type="button" class="custom-button" data-toggle="modal" data-target="#exampleModal">
                        Đặt đồ ăn
                    </button>
                </div>

                <div class="book-item">
                    <a href="#" class="custom-button " id="thanh-toan-button">Thanh toán</a>
                </div>
            </div>
        </div>

    </div>
    </div>


    <!-- ==========Movie-Section========== -->
    <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" style="color: black" id="exampleModalLabel">Danh sách đồ ăn</h5>
                </div>
                <div class="modal-body">
                    <table class="table text-center">
                        <thead class="">
                            <tr>
                                <th scope="col">
                                    <input type="checkbox" class="select-control " style="width:15px;" id="select-all">
                                </th>
                                <th>Tên</th>
                                <th>Ảnh</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($food as $value)
                                <tr>
                                    <td scope="row">
                                        <input type="checkbox" class="child-checkbox" style="width:15px" name="ids[]"
                                            value="{{ $value->id }}">
                                    </td>
                                    <td scope="row">{{ $value->name }}</td>
                                    <td><img src="{{ Storage::url($value->image) }}" width="50" alt=""></td>
                                    <td>
                                        <div class="quantity-input">
                                            <button class="decrease" data-productid="{{ $value->id }}">-</button>
                                            <input type="number" name="quantity" min="1" max="20"
                                                value="1" id="quantity-input-{{ $value->id }}">
                                            <button class="increase" data-productid="{{ $value->id }}">+</button>
                                        </div>
                                    </td>

                                    <td id="price-{{ $value->id }}" data-price="{{ $value->price }}">
                                        {{ number_format($value->price, 0, ',', '.') }} VNĐ</td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div id="total-price" class="text-danger">Tổng tiền: 0 VNĐ</div>
                    <div>
                        <i class="text-dark">Với những sản phẩm được chọn</i>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">Thanh toán</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- kiểm tra người dùng đã chon ghế hay chưa  --}}
    <script>
        // Sử dụng jQuery để chọn tất cả các ghế có class 'seat-click'
        const $seats = $('.seat-click');

        // Bắt đầu bằng việc vô hiệu hóa nút thanh toán
        $('#thanh-toan-button').prop('disabled', true);

        // Đặt sự kiện click cho nút thanh toán
        $('#thanh-toan-button').on('click', function(event) {
            // Kiểm tra xem có bất kỳ ghế nào đã được chọn
            const selectedSeats = $seats.filter('.seat-click.selected');
            if (selectedSeats.length === 0) {
                // Nếu không có ghế nào được chọn, hiển thị thông báo và ngừng xử lý sự kiện
                event.preventDefault(); // Ngừng chuyển hướng đến trang thanh toán
                alert('Vui lòng chọn ghế trước khi thanh toán.');
            }
        });

        // Đặt sự kiện click cho tất cả ghế
        $seats.on('click', function() {
            $(this).toggleClass('selected'); // Chuyển trạng thái chọn ghế

            // Kiểm tra xem có bất kỳ ghế nào đã được chọn
            const selectedSeats = $seats.filter('.seat-click.selected');
            if (selectedSeats.length > 0) {
                // Nếu có ghế được chọn, cập nhật thuộc tính href của nút thanh toán
                $('#thanh-toan-button').attr('href',
                    '{{ route('thanh-toan', ['room_id' => $room->id, 'slug' => $showTime->movie->slug, 'showtime_id' => $showTime->id]) }}'
                );
            } else {
                // Nếu không có ghế nào được chọn, đặt lại thuộc tính href về trống hoặc href="#"
                $('#thanh-toan-button').attr('href', '#');
            }
        });
    </script>

    {{-- kiểm tra ghế và lưu danh sách ghế vào session  --}}
    <script>
        var chosenSeats1 = @json(Session::get('selectedSeats', [])); // Sử dụng một mảng rỗng mặc định nếu session không tồn tại

        document.addEventListener("DOMContentLoaded", function() {
            var seatElements = document.querySelectorAll(".single-seat1");
            // if (!Array.isArray(chosenSeats1)) {
            //     chosenSeats1 = [];
            // }

            // Hàm hiển thị danh sách ghế đã chọn
            function updateChosenSeatsDisplay() {
                var chosenSeats1Text = chosenSeats1.join(", ");
                document.querySelector(".proceed-book .title").textContent = chosenSeats1Text;
            }

            seatElements.forEach(function(seat) {
                seat.addEventListener("click", function() {
                    var seatNum = seat.querySelector(".sit-num").textContent;

                    if (!chosenSeats1.includes(seatNum)) {
                        chosenSeats1.push(seatNum);
                        seat.classList.add("seat-selected");
                    } else {
                        chosenSeats1 = chosenSeats1.filter(function(seat) {
                            return seat !== seatNum;
                        });
                        seat.classList.remove("seat-selected");
                    }

                    // Lưu danh sách ghế đã chọn vào session
                    fetch('/save-selected-seats', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                selectedSeats: chosenSeats1
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data.message);
                            // Sau khi lưu vào session, cập nhật hiển thị danh sách ghế đã chọn
                            updateChosenSeatsDisplay();
                        });
                });
            });

            // Ban đầu, cập nhật hiển thị danh sách ghế đã chọn
            updateChosenSeatsDisplay();
        });
    </script>

    {{-- thay đổi ảnh khi chọn ghế --}}
    <script>
        var chosenSeats = @json(Session::get('selectedSeats'));

        document.addEventListener("DOMContentLoaded", function() {
            var seatElements = document.querySelectorAll(".seat-click");

            seatElements.forEach(function(seat) {
                var imgElement = seat.querySelector("img");
                var originalImageSrc = imgElement.src;
                var newImageSrc = "{{ asset('client/assets/images/movie/seat01-booked.png') }}";
                var seatNum = seat.querySelector(".sit-num").textContent;

                // Kiểm tra xem ghế có trong danh sách đã chọn hay không và cập nhật trạng thái của ghế
                if (chosenSeats.includes(seatNum)) {
                    imgElement.src = newImageSrc;
                    seat.classList.add("seat-selected");
                }

                seat.addEventListener("click", function() {
                    if (imgElement.src === originalImageSrc) {
                        imgElement.src = newImageSrc;
                        chosenSeats.push(seatNum); // Thêm ghế vào danh sách đã chọn
                        seat.classList.add("seat-selected");
                    } else {
                        imgElement.src = originalImageSrc;
                        chosenSeats = chosenSeats.filter(function(seat) {
                            return seat !== seatNum;
                        });
                        seat.classList.remove("seat-selected");
                    }
                });
            });
        });
    </script>

    {{-- checkAll selectbox --}}
    <script>
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

    {{-- tăng giảm số lượng cập nhật giá --}}
    <script>
        // Hàm cập nhật tổng tiền dựa trên các checkbox đã chọn và giá của từng sản phẩm
        function updateTotalPrice() {
            var total = 0;
            $("input.child-checkbox:checked").each(function() {
                var productId = $(this).val();
                var quantity = parseInt($("#quantity-input-" + productId).val());
                var price = parseFloat($("#price-" + productId).data("price"));
                var productTotal = quantity * price;
                total += productTotal;
                // Cập nhật giá của từng sản phẩm trong bảng
                $("#price-" + productId).text(productTotal.toLocaleString("vi-VN") + " VNĐ");
            });

            $("#total-price").text("Tổng tiền: " + total.toLocaleString("vi-VN") + " VNĐ");
        }

        // Hàm cập nhật giá sản phẩm khi số lượng thay đổi
        function updateProductPrice(productId) {
            var quantity = parseInt($("#quantity-input-" + productId).val());
            var price = parseFloat($("#price-" + productId).data("price"));
            var productTotal = quantity * price;

            // Cập nhật giá của từng sản phẩm trong bảng
            $("#price-" + productId).text(productTotal.toLocaleString("vi-VN") + " VNĐ");
        }

        // Gắn các trình xử lý sự kiện cho các nút tăng/giảm số lượng
        $(".quantity-input").on("click", ".increase, .decrease", function() {
            var productId = $(this).data("productid");
            var quantityInput = $("#quantity-input-" + productId);
            var quantity = parseInt(quantityInput.val());

            if ($(this).hasClass("increase")) {
                quantity += 1;
            } else {
                quantity -= 1;
                if (quantity < 1) {
                    quantity = 1;
                }
            }

            quantityInput.val(quantity);
            updateProductPrice(productId); // Cập nhật giá sản phẩm
            updateTotalPrice(); // Cập nhật tổng tiền
        });
        // Gắn trình xử lý sự kiện cho các checkbox để cập nhật tổng tiền khi chọn hoặc bỏ chọn
        $(".child-checkbox").on("change", function() {
            updateTotalPrice();
        });

        // Gắn trình xử lý sự kiện cho checkbox "Chọn tất cả"
        $("#select-all").on("change", function() {
            $(".child-checkbox").prop("checked", this.checked);
            updateTotalPrice();
        });

        // Tính toán ban đầu tổng tiền
        updateTotalPrice();
    </script>

    {{-- lưu thông tin đồ ăn  --}}
    <script type="text/javascript">
        document.querySelector("button.btn-primary").addEventListener("click", function() {
            // Thu thập thông tin các sản phẩm được chọn
            const selectedProducts = [];
            let totalPriceFood = 0;
            const checkboxes = document.querySelectorAll("input.child-checkbox:checked");

            if (checkboxes.length === 0) {
                alert("Vui lòng chọn ít nhất một sản phẩm trước khi thanh toán.");
                return; // Không thực hiện gửi dữ liệu nếu không có checkbox nào được chọn.
            }

            checkboxes.forEach(checkbox => {
                const productId = checkbox.value;
                const productName = checkbox.parentElement.nextElementSibling.textContent;
                const quantity = document.querySelector(`#quantity-input-${productId}`).value;
                const priceText = document.querySelector(`#price-${productId}`)
                    .textContent; // Lấy giá từ nội dung văn bản
                const priceParts = priceText.split(' '); // Tách giá và đơn vị tiền tệ
                const priceValue = parseFloat(priceParts[0].replace('.', '').replace(',',
                    '')); // Loại bỏ dấu "." và "," và chuyển thành số

                // Cộng giá tiền của sản phẩm vào tổng giá tiền
                totalPriceFood += priceValue;

                selectedProducts.push({
                    id: productId,
                    name: productName,
                    quantity,
                    price: priceValue,
                });
            });

            // Gửi dữ liệu lên server bằng Ajax hoặc fetch API và lưu vào session
            fetch('/luu-thong-tin-san-pham', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        selectedProducts,
                        totalPriceFood
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Thông báo hoặc chuyển hướng đến trang thanh toán
                        // Đóng modal bằng cách sử dụng Bootstrap 4
                        $('#exampleModal').modal('hide');
                    } else {
                        // Xử lý lỗi nếu cần
                    }
                });
        });
    </script>
@endsection

    <!-- ==========Preloader========== -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ==========Preloader========== -->
    <!-- ==========Overlay========== -->
    <div class="overlay"></div>
    <a href="#0" class="scrollToTop">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- ==========Overlay========== -->

    <!-- ==========Header-Section========== -->
    <header class="header-section">
        <div class="container">
            <div class="header-wrapper">
                <div class="logo">
                    <a href="{{ route('index') }}">
                        <img src=" {{asset('client/assets/images/logo/logo.png')}}" alt="logo">
                    </a>
                </div>
                <ul class="menu">
                    <li>
                        <a href="#0" class="active">Trang chủ</a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('index') }}">Trang chủ</a>
                            </li>

                        </ul>
                    </li>
                    <li>
                        <a href="#0">Sách</a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('book.danh-sach') }}">Sách </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#0">Mã Giảm Giá</a>
                        <ul class="submenu">
                            <li>
                                <a href="{{route('home.voucher.list')}}">Danh Sách Mã Giảm Giá</a>
                            </li>

                        </ul>
                    </li>
                    <li>
                        <a href="#0">Bài Viết</a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('blog') }}">Bài Viết</a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}">Liên hệ</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#0">giỏ hàng</a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('cart.view') }}">giỏ hàng</a>
                            </li>
                        </ul>
                    </li>
                    @guest
                    <li class="header-button ">
                        <a class="" style="padding: 10px 20px;" href="{{ route('login') }}">Đăng nhập</a>
                    </li>
                    @else

                    <li>
                        <a class="nav-link dropdown-toggle" style="margin-top: 3px; " href="" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img width="50px" class="img-profile rounded-circle" src="{{ (Auth::user()->avatar == null) ? asset('admin/img/undraw_profile_1.svg') : Storage::url(Auth::user()->avatar) }}">
                        </a>
                        <!-- Dropdown - User Information -->
                        <ul class="submenu">
                            <li><a href="">Thông tin cá nhân</a></li>
                            <li><a href="">Đổi mật khẩu</a></li>
                            <li><a href="{{route('logout')}}">Đăng xuất</a></li>
                        </ul>
                    </li>

                    @endif
                </ul>
                <div class="header-bar d-lg-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </header>
    <!-- ==========Header-Section========== -->
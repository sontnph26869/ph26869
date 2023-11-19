@extends('layouts.client')
@section('content')
<!-- ==========Sign-In-Section========== -->
<section class="account-section bg_img" data-background="./assets/images/account/account-bg.jpg">
    <div class="container">
        <div class="padding-top padding-bottom">
            <div class="account-area">
                <div class="section-header-3">
                    <span class="cate">Chào mừng</span>
                    <h2 class="title">Đăng nhập</h2>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                <form class="account-form" action="{{route('login')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email2">Email<span>*</span></label>
                        <input type="text" placeholder="Nhập email của bạn" id="email2" name="email" value="{{old('email')}}">
                    </div>
                    <div class="form-group">
                        <label for="pass3">Password<span>*</span></label>
                        <input type="password" placeholder="Mật khẩu" id="pass3" name="password">
                    </div>
                    <div class="form-group checkgroup">
                        <input type="checkbox" id="bal2" required checked>
                        <label for="bal2">Nhớ mật khẩu</label>
                        <a href="{{route('forgotPassword')}}" class="forget-pass">Quên mật khẩu</a>
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" value="Đăng nhập">
                    </div>
                </form>
                <div class="option">
                    Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
                </div>
                <div class="or"><span>Hoặc</span></div>
                <ul class="social-icons">
                    <li>
                        <a href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#0" class="active">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login_google')}}">
                            <i class="fab fa-google"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- ==========Sign-In-Section========== -->
@endsection

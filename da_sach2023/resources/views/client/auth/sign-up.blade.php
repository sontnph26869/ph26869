@extends('layouts.client')
@section('content')
<!-- ==========Sign-In-Section========== -->
<section class="account-section bg_img" data-background="./assets/images/account/account-bg.jpg">
    <div class="container">
        <div class="padding-top padding-bottom">
            <div class="account-area">
                <div class="section-header-3">
                    <span class="cate">Chào mừng</span>
                    <h2 class="title">Đăng ký </h2>
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
                <form class="account-form" method="post" action="{{route('register')}}">
                    @csrf
                    <div class="form-group">
                        <label for="email1">Email<span>*</span></label>
                        <input type="text" placeholder="Nhập email" id="email1" name="email">
                    </div>
                    <div class="form-group">
                        <label for="email1">Họ tên<span>*</span></label>
                        <input type="text" placeholder="Nhập tên của bạn" id="username" name="name">
                    </div>
                    <div class="form-group">
                        <label for="email1">Số điện thoại<span>*</span></label>
                        <input type="text" placeholder="Số điện thoại" id="username" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="pass1">Mật khẩu<span>*</span></label>
                        <input type="password" placeholder="Mật khẩu" id="pass1" name="password">
                    </div>
                    <div class="form-group">
                        <label for="pass2">Nhập lại mật khẩu<span>*</span></label>
                        <input type="password" placeholder="Password" id="pass2" name="password_confirmation">
                    </div>
                    <div class="form-group checkgroup">
                        <input type="checkbox" id="bal" checked>
                        <label for="bal">Tôi đồng ý với <a href="#0">Điều khoản, Chính sách</a> và <a href="#0">Chi phí</a></label>
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" value="Đăng ký">
                    </div>
                </form>
                <div class="option">
                    Bạn đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
                </div>
                <div class="or"><span>Hoặc</span></div>
                <ul class="social-icons">
                    <li>
                        <a href="#0">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#0" class="active">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="">
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
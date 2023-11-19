@extends('layouts.client')
@section('content')
<!-- ==========Sign-In-Section========== -->
<section class="account-section bg_img" data-background="./assets/images/account/account-bg.jpg">
    <div class="container">
        <div class="padding-top padding-bottom">
            <div class="account-area">
                <div class="section-header-3">

                    <h2 class="title">forgot password ?</h2>
                    <span class="cate">enter your email</span>
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
                <form class="account-form" action="{{route('forgotPassword')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email2">Email<span>*</span></label>
                        <input type="email" placeholder="Nhập email của bạn" id="email2" name="email">
                    </div>

                    <div class="form-group text-center">
                        <input type="submit" value="Send Request">
                    </div>
                </form>
                <div class="option">
                    Chưa có tài khoản? <a href="{{ route('register') }}">đăng ký ngay</a>
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
                        <a href="#0">
                            <i class="fab fa-google"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

@endsection
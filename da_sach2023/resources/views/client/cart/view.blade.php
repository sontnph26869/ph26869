<!-- resources/views/client/cart/view.blade.php -->

@extends('layouts.client')
@section('content')

<head>
    <link rel="stylesheet" href=" {{asset('/theme_shop/theme_shop/assets/css/plugins.css')}}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href=" {{asset('/theme_shop/theme_shop/assets/css/style.css')}}">

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>

<!-- ==========Banner-Section========== -->
<section class="main-page-header speaker-banner bg_img" data-background="./assets/images/banner/banner07.jpg">
    <div class="container">

    </div>
</section>
<!-- ==========Banner-Section========== -->
@include('client.ticket')
<!-- shopping cart area start -->
<section>
    <div class="shopping_cart_area">
        <div class="container">
            <div class="row">
                <form id="updateCartForm" action="{{ route('checkout') }}" method="post">
                    <div class="col-12">
                        <div class="table_desc">
                            <div class="cart_page table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product_remove">Delete</th>
                                            <th class="product_thumb">Image</th>
                                            <th class="product_name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product_quantily">Quantity</th>
                                            <th class="product_total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <form action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            @foreach($cartItems as $cartItem)
                                            <tr>
                                                <td class="product_remove">
                                                    <a href="">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </td>
                                                <td class="product_thumb">
                                                    <a href="#">
                                                        <img src="{{ asset($cartItem->book->poster) }}" alt="{{ $cartItem->book->name }}">
                                                    </a>
                                                </td>
                                                <td class="product_name">
                                                    <a href="">
                                                        {{ $cartItem->book->name }}
                                                    </a>
                                                </td>
                                                <td class="product-price">£{{ $cartItem->book->price }}</td>
                                                <td class="product_quantity">
                                                    <input name="quantities[{{ $cartItem->id }}]" class="quantity-input" min="1" max="100" value="{{ $cartItem->quantily }}" type="number" class="text-dark">
                                                </td>
                                                <td class="product_total">£{{ $cartItem->book->price * $cartItem->quantily }}</td>
                                            </tr>
                                            @endforeach
                                            <div class="cart_submit">
                                                <button type="submit">Update Cart</button>
                                            </div>
                                        </form>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--coupon code area start-->
                    <div class="coupon_area">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="coupon_code left">
                                    <h3>Coupon</h3>
                                    <div class="coupon_inner">
                                        <p>Enter your coupon code if you have one.</p>
                                        <input placeholder="Coupon code" type="text">
                                        <button type="submit">Apply coupon</button>
                                    </div>
                                </div>
                            </div>
                            @php
                            $subtotal = 0;
                            foreach($cartItems as $cartItem) {
                            $subtotal += $cartItem->book->price * $cartItem->quantily;
                            }
                            $total = $subtotal
                            @endphp

                            <div class="col-lg-6 col-md-6">
                                <div class="coupon_code right">
                                    <h3>Cart Totals</h3>
                                    <div class="coupon_inner">
                                        <div class="cart_subtotal">
                                            <p>Subtotal</p>
                                            <p class="cart_amount">£{{ number_format($subtotal, 2) }}</p>
                                        </div>
                                        <a href="#">Calculate shipping</a>
                                        <div class="cart_subtotal">
                                            <p>Total</p>
                                            <p class="cart_amount">£{{ number_format($total, 2) }}</p>
                                        </div>
                                        <div class="checkout_btn">
                                            <button class="w-25" >Thanh toán</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection


@push('scripts')
<!-- Plugins JS -->

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdWLY_Y6FL7QGW5vcO3zajUEsrKfQPNzI"></script>
<script src="https://www.google.com/jsapi"></script>
<script src=" asset('/theme_shop/theme_shop/assets/js/map.js')}} "></script>
<!-- Plugins JS -->
<script src=" asset('/theme_shop/theme_shop/assets/js/plugins.js')}}"></script>
<!-- Main JS -->
<script src=" asset('/theme_shop/theme_shop/assets/js/main.js')}}"></script>

@endpush
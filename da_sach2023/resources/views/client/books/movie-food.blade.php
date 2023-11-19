@extends('layouts.client')
@section('content')
 <!-- ==========Banner-Section========== -->
 <section class="details-banner hero-area bg_img seat-plan-banner" data-background="{{asset('client/assets/images/banner/banner04.jpg')}}">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-content style-two">
                    <h3 class="title">Venus</h3>
                    <div class="tags">
                        <a href="#0">City Walk</a>
                        <a href="#0">English - 2D</a>
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
                    <a href="movie-ticket-plan.html" class="custom-button back-button">
                        << back
                    </a>
                </div>
                <div class="item date-item">
                    <span class="date">MON, SEP 09 2020</span>
                    <select class="select-bar">
                        <option value="sc1">09:40</option>
                        <option value="sc2">13:45</option>
                        <option value="sc3">15:45</option>
                        <option value="sc4">19:50</option>
                    </select>
                </div>
                <div class="item">
                    <h5 class="title">05:00</h5>
                    <p>Mins Left</p>
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
                    <div class="c-thumb padding-bottom">
                        <img src="./assets/images/sidebar/banner/banner04.jpg" alt="sidebar/banner">
                    </div>
                    <div class="section-header-3">
                        <span class="cate">You're hungry</span>
                        <h2 class="title">we have food</h2>
                        <p>Prebook Your Meal and Save More!</p>
                    </div>
                    <div class="grid--area">
                        <ul class="filter">
                            <li data-filter="*" class="active">all</li>
                            <li data-filter=".combos">combos</li>
                            <li data-filter=".bevarage">bevarage</li>
                            <li data-filter=".popcorn">popcorn</li>
                        </ul>
                        <div class="grid-area">
                            <div class="grid-item combos popcorn">
                                <div class="grid-inner">
                                    <div class="grid-thumb">
                                        <img src="./assets/images/movie/popcorn/pop1.png" alt="movie/popcorn">
                                        <div class="offer-tag">
                                            $57
                                        </div>
                                        <div class="offer-remainder">
                                            <h6 class="o-title mt-0">24%</h6>
                                            <span>off</span>
                                        </div>
                                    </div>
                                    <div class="grid-content">
                                        <h5 class="subtitle">
                                            <a href="#0">
                                                Muchaco, Crispy Taco, Bean Burrito
                                            </a>
                                        </h5>
                                        <form class="cart-button">
											<div class="cart-plus-minus">
			                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="2">
			                            	</div>
			                            	<button type="submit" class="custom-button">
			                            		add
			                            	</button>
			                            </form>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-item bevarage">
                                <div class="grid-inner">
                                    <div class="grid-thumb">
                                        <img src="./assets/images/movie/popcorn/pop2.png" alt="movie/popcorn">
                                        <div class="offer-tag">
                                            $57
                                        </div>
                                        <div class="offer-remainder">
                                            <h6 class="o-title mt-0">24%</h6>
                                            <span>off</span>
                                        </div>
                                    </div>
                                    <div class="grid-content">
                                        <h5 class="subtitle">
                                            <a href="#0">
                                                Crispy Beef Taco, Beef Mucho Nachos
                                            </a>
                                        </h5>
                                        <form class="cart-button">
											<div class="cart-plus-minus">
			                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="2">
			                            	</div>
			                            	<button type="submit" class="custom-button">
			                            		add
			                            	</button>
			                            </form>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-item combos">
                                <div class="grid-inner">
                                    <div class="grid-thumb">
                                        <img src="./assets/images/movie/popcorn/pop3.png" alt="movie/popcorn">
                                        <div class="offer-tag">
                                            $57
                                        </div>
                                        <div class="offer-remainder">
                                            <h6 class="o-title mt-0">24%</h6>
                                            <span>off</span>
                                        </div>
                                    </div>
                                    <div class="grid-content">
                                        <h5 class="subtitle">
                                            <a href="#0">
                                                Chicken Quesadilla Crispy Beef Taco
                                            </a>
                                        </h5>
                                        <form class="cart-button">
											<div class="cart-plus-minus">
			                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="2">
			                            	</div>
			                            	<button type="submit" class="custom-button">
			                            		add
			                            	</button>
			                            </form>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-item bevarage popcorn">
                                <div class="grid-inner">
                                    <div class="grid-thumb">
                                        <img src="./assets/images/movie/popcorn/pop4.png" alt="movie/popcorn">
                                        <div class="offer-tag">
                                            $57
                                        </div>
                                        <div class="offer-remainder">
                                            <h6 class="o-title mt-0">24%</h6>
                                            <span>off</span>
                                        </div>
                                    </div>
                                    <div class="grid-content">
                                        <h5 class="subtitle">
                                            <a href="#0">
                                                MexiDips & Chips, Beef Muchaco
                                            </a>
                                        </h5>
                                        <form class="cart-button">
											<div class="cart-plus-minus">
			                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="2">
			                            	</div>
			                            	<button type="submit" class="custom-button">
			                            		add
			                            	</button>
			                            </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="booking-summery bg-one">
                        <h4 class="title">booking summery</h4>
                        <ul>
                            <li>
                                <h6 class="subtitle">Venus</h6>
                                <span class="info">English-2d</span>
                            </li>
                            <li>
                                <h6 class="subtitle"><span>City Walk</span><span>02</span></h6>
                                <div class="info"><span>10 SEP TUE, 11:00 PM</span> <span>Tickets</span></div>
                            </li>
                            <li>
                                <h6 class="subtitle mb-0"><span>Tickets  Price</span><span>$150</span></h6>
                            </li>
                        </ul>
                        <ul class="side-shape">
                            <li>
                                <h6 class="subtitle"><span>combos</span><span>$57</span></h6>
                                <span class="info"><span>2 Nachos Combo</span></span>
                            </li>
                            <li>
                                <h6 class="subtitle"><span>food & bevarage</span></h6>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <span class="info"><span>price</span><span>$207</span></span>
                                <span class="info"><span>vat</span><span>$15</span></span>
                            </li>
                        </ul>
                    </div>
                    <div class="proceed-area  text-center">
                        <h6 class="subtitle"><span>Amount Payable</span><span>$222</span></h6>
                        <a href="#0" class="custom-button back-button">proceed</a>
                    </div>
                    <div class="note">
                        <h5 class="title">Note :</h5>
                        <p>Please give us 15 minutes for F& B preparation  once you're at the cinema</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========Movie-Section========== -->

@endsection
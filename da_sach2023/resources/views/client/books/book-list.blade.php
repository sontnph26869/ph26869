@extends('layouts.client')
   @section('content')

   <!-- ==========Banner-Section========== -->
   <section class="banner-section">
       <div class="banner-bg bg_img bg-fixed" data-background="{{asset('client/assets/images/banner/banner02.jpg')}}"></div>
       <div class="container">
           <div class="banner-content">
               <h1 class="title bold">get <span class="color-theme">movie</span> tickets</h1>
               <p>Buy movie tickets in advance, find movie times watch trailer, read movie reviews and much more</p>
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
                           <a href="#0">
                               <img src="{{asset('client/assets/images/sidebar/banner/banner01.jpg')}}" alt="banner">
                           </a>
                       </div>
                   </div>
                   <div class="widget-1 widget-check">
                       <div class="widget-header">
                           <h5 class="m-title">Lọc theo</h5> <a href="#0" class="clear-check">Xóa tất cả</a>
                       </div>
                       <div class="widget-1-body">
                           <h6 class="subtitle">Ngôn ngữ</h6>
                           <div class="check-area">
                               <div class="form-group">
                                   <input type="checkbox" name="lang" id="lang1"><label for="lang1">Tamil</label>
                               </div>
                               <div class="form-group">
                                   <input type="checkbox" name="lang" id="lang2"><label for="lang2">Telegu</label>
                               </div>
                               <div class="form-group">
                                   <input type="checkbox" name="lang" id="lang3"><label for="lang3">Hindi</label>
                               </div>
                               <div class="form-group">
                                   <input type="checkbox" name="lang" id="lang4"><label for="lang4">English</label>
                               </div>
                               <div class="form-group">
                                   <input type="checkbox" name="lang" id="lang5"><label for="lang5">Multiple Language</label>
                               </div>
                               <div class="form-group">
                                   <input type="checkbox" name="lang" id="lang6"><label for="lang6">Gujrati</label>
                               </div>
                               <div class="form-group">
                                   <input type="checkbox" name="lang" id="lang7"><label for="lang7">Bangla</label>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="widget-1 widget-check">
                       <div class="widget-1-body">
                           <h6 class="subtitle">Trải nghiệm</h6>
                           <div class="check-area">
                               <div class="form-group">
                                   <input type="checkbox" name="mode" id="mode1"><label for="mode1">2d</label>
                               </div>
                               <div class="form-group">
                                   <input type="checkbox" name="mode" id="mode2"><label for="mode2">3d</label>
                               </div>
                           </div>
                           <div class="add-check-area">
                               <a href="#0">Xem thêm <i class="plus"></i></a>
                           </div>
                       </div>
                   </div>
                   <div class="widget-1 widget-check">
                       <div class="widget-1-body">
                           <h6 class="subtitle">Thể loại</h6>
                           <div class="check-area">
                               @foreach ($genres as $genre)
                               <div class="form-group">
                                   <input type="checkbox" name="genre" id="genre{{$genre->id}}" data-genre-id="{{$genre->id}}"><label for="genre{{$genre->id}}">{{$genre->name}}</label>
                               </div>
                               @endforeach
                           </div>
                           <div class="add-check-area">
                               <a href="#0">Xem thêm <i class="plus"></i></a>
                           </div>
                       </div>
                   </div>
                   <div class="widget-1 widget-banner">
                       <div class="widget-1-body">
                           <a href="#0">
                               <img src="{{asset('client/assets/images/sidebar/banner/banner02.jpg')}}" alt="banner">
                           </a>
                       </div>
                   </div>
               </div>
               <div class="col-lg-9 mb-50 mb-lg-0">
                   <div class="filter-tab tab">
                       <div class="filter-area">
                           <div class="filter-main">
                               <div class="left">
                                   <div class="item">
                                       <span class="show">Xem :</span>
                                       <select class="select-bar">
                                           <option value="12">12</option>
                                           <option value="15">15</option>
                                           <option value="18">18</option>
                                           <option value="21">21</option>
                                           <option value="24">24</option>
                                           <option value="27">27</option>
                                           <option value="30">30</option>
                                       </select>
                                   </div>
                                   <div class="item">
                                       <span class="show">Sắp xếp theo :</span>
                                       <select class="select-bar">
                                           <option value="showing">Đang chiếu</option>
                                           <option value="exclusive">exclusive</option>
                                           <option value="trending">trending</option>
                                           <option value="most-view">Lượt xem</option>
                                       </select>
                                   </div>
                               </div>
                               <ul class="grid-button tab-menu">
                                   <li class="active">
                                       <i class="fas fa-th "></i>
                                   </li>
                                   <li class="">
                                       <i class="fas fa-bars"></i>
                                   </li>
                               </ul>
                           </div>
                       </div>
                       <div class="tab-area">
                           <div class="tab-item active">
                               <div class="row mb-10 justify-content-center" id="movie-list">
                                   @include("client.books.partial-books")
                               </div>
                           </div>
                       </div>
                       <div class="pagination-area text-center">
                           <a href="#0"><i class="fas fa-angle-double-left"></i><span>Prev</span></a>
                           <a href="#0">1</a>
                           <a href="#0">2</a>
                           <a href="#0" class="active">3</a>
                           <a href="#0">4</a>
                           <a href="#0">5</a>
                           <a href="#0"><span>Next</span><i class="fas fa-angle-double-right"></i></a>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </section>
   <!-- ==========Movie-Section========== -->


   @endsection


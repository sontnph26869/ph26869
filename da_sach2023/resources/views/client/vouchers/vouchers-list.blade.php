@extends('layouts.client')
@section('content')
<style>
    .button2{
        background-color: #001232;
        border:none;
    }
    .select-bar {
        margin-top:5px; 
    }
    .button3 {
        background-color: #032055;
        border:none;
    }   
</style>
<section class="banner-section">
    <div class="banner-bg bg_img bg-fixed" data-background="./assets/images/banner/banner02.jpg"></div>
    <div class="container">
        <div class="banner-content">
            <h1 class="title bold">get <span class="color-theme">movie</span> tickets</h1>
            <p>Buy movie tickets in advance, find movie times watch trailers, read movie reviews and much more</p>
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
                        
                    </div>
                </div>
                <div class="widget-1 widget-check">
                    <div class="widget-header">
                        <h5 class="m-title">Lọc Theo</h5>
                       
                    </div>
                </div>
                <div class="widget-1 widget-check">
                    <div class="widget-1-body">
                        <form action="{{route ('home.voucher.list')}}">
                       
                        <div class="check-area">
                            <div class="form-group">
                                <button type="submit" name="giamgia" value="theophantram" class="col-md-10 button3">Giảm Giá Theo %</button>   
                            </div>
                            <div class="form-group">
                                <button type="submit" name="giamgia" value="theogia" class="col-md-10 button3">Giảm Giá Theo giá</button>   
                            </div>
                              
                        </div>
                    </form>
                    </div>
                </div>
                
                
                
               
              
            </div>
            <div class="col-lg-9 mb-50 mb-lg-0">
                <form action="{{route ('home.voucher.list')}}">
                <div class="filter-tab tab">
                    <div class="filter-area">
                        <div class="filter-main">
                            <div class="left">
                              
                                <div class="item"><div class="row">
                              <button type="submit" class="col-md-7 button2">Sắp Xếp Theo :</button>    
                                    <select class="select-bar col-md-5" name="trangthai">
                                        <option value="moi">Mới Nhất</option>
                                        <option value="saphethan">Sắp hết hạn</option>
                                       
                                    </select>
                                   
                                </div>
                            </div>
                                     
                            </div>
                            
                            <ul class="grid-button tab-menu">
                                <li class="active">
                                    <i class="fas fa-th"></i>
                                </li>                            
                                    
                            </ul>
                        </div>
                    </form>
                    </div>
                    <div class="tab-area">
                        <div class="tab-item active">
                            <div class="row mb-10 justify-content-center">
                                @foreach ($vouchers1 as  $voucher)
                                @php
                                $now = now();
                                $end_date = $voucher->end_date;
                                $interval = $now->diff($end_date);
                            
                                $hoursRemaining = $interval->h;
                                $minutesRemaining = $interval->i;
                            @endphp
                                    @if($voucher->status != 2)
                                  
                                <div class="col-sm-6 col-lg-4">
                                    <div class="movie-grid">
                                       
                                        <div class="movie-content bg-one">
                                            <h5 class="title m-0">
                                                <a href="{{ route('home.voucher.detail',['id'=>$voucher->id])}}">{{$voucher->code}}</a>
                                            </h5>
                                            <ul class="movie-rating-percent">
                                                <li>
                                                    <span class="content">Đơn Tối Thiểu {{number_format($voucher->min_order_amount, 0, ',', '.')}}VND đến {{number_format($voucher->max_order_amount,  0, ',', '.')}}VND</span>
                                                </li>
                                                <li>
                                                   
                                                    <span class="content">Được Giảm : 
                                                        @if ($voucher->type == 1)
                                                        <td>{{ $voucher->value }}%</td>
                                                        @else
                                                        <td> {{ number_format($voucher->value, 0, ',', '.') }} VNĐ
                                                        </td>
                                                        @endif
                                                    </span>
                                                   
                                                </li>
                                                <li>
                                                    @if($voucher->status == 3 ) 
                                                        Hết Hạn
                                                        @elseif($voucher->status == 4  ) 
                                                        Hết mã khuyến mãi
                                                    @elseif ($hoursRemaining < 1)
                    <span class="content">Sắp hết hạn còn {{ $minutesRemaining }} phút</span>
                @elseif ($hoursRemaining < 24)
                    <span class="content">Sắp hết hạn còn {{ $hoursRemaining }} giờ {{ $minutesRemaining }} phút</span>
                @else
                    <span class="content">Hạn sử dụng đến {{ \Carbon\Carbon::parse($vouchers1->end_date)->format('d/m/Y') }}</span>
                @endif
                                                   
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                             
                              @endif
                                @endforeach
                              
                              
                              
                              
                               
                                
                               
                               
                               
                            </div>
                        </div>
                        <div class="tab-item">
                            <div class="movie-area mb-10">
                                <div class="movie-list">
                                    <div class="movie-thumb c-thumb">
                                        <a href="movie-details.html" class="w-100 bg_img h-100" data-background="./assets/images/movie/movie01.jpg">
                                            <img class="d-sm-none" src="./assets/images/movie/movie01.jpg" alt="movie">
                                        </a>
                                    </div>
                                    <div class="row mb-10 justify-content-center">
                                        @foreach ($vouchers1 as  $voucher)
                                        @php
                                        $now = now();
                                        $end_date = $voucher->end_date;
                                        $interval = $now->diff($end_date);
                                    
                                        $hoursRemaining = $interval->h;
                                        $minutesRemaining = $interval->i;
                                    @endphp
                                            
                                          
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="movie-grid">
                                               
                                                <div class="movie-content bg-one">
                                                    <h5 class="title m-0">
                                                        <a href="{{ route('home.voucher.detail',['id'=>$voucher->id])}}">{{$voucher->code}}</a>
                                                    </h5>
                                                    <ul class="movie-rating-percent">
                                                        <li>
                                                            <span class="content">Đơn Tối Thiểu {{number_format($voucher->min_order_amount / 1000, 0)}}k đến {{number_format($voucher->max_order_amount / 1000, 0)}}k</span>
                                                        </li>
                                                        <li>
                                                           
                                                            <span class="content">Được Giảm : {{$voucher->value}}</span>
                                                        </li>
                                                        <li>
                                                            @if($voucher->status == 3 ) 
                                                                Hết Hạn
                                                                @elseif($voucher->status == 4  ) 
                                                                Hết mã khuyến mãi
                                                            @elseif ($hoursRemaining < 1)
                            <span class="content">Sắp hết hạn còn {{ $minutesRemaining }} phút</span>
                        @elseif ($hoursRemaining < 24)
                            <span class="content">Sắp hết hạn còn {{ $hoursRemaining }} giờ {{ $minutesRemaining }} phút</span>
                        @else
                            <span class="content">Hạn sử dụng đến {{ \Carbon\Carbon::parse($vouchers1->end_date)->format('d/m/Y') }}</span>
                        @endif
                                                           
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                     
                                      
                                        @endforeach
                                      
                                      
                                      
                                      
                                       
                                        
                                       
                                       
                                       
                                    </div>
                                </div>
                              
                    
                    <div class="pagination-area text-center">
                        <a href="#0"><i class="fas fa-angle-double-left"></i><span>Prev</span></a>
                        <a href="#0"> {{ $vouchers1->links('pagination::bootstrap-4') }}</a>
                       
                        <a href="#0"><span>Next</span><i class="fas fa-angle-double-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<script>
    // Bắt đầu bằng việc lấy tham chiếu đến nút "Xóa Tất Cả"
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
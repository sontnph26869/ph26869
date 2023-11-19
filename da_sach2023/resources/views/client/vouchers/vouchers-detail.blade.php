@extends('layouts.client')
@section('content')
<style>
    #copy-button {
        background-color: #4CAF50;
       
    color: white;
    border: none;
   
    cursor: pointer;
}
.button11 {
    margin-top: 20px;   
    width: 500px;
}body{
-moz-user-select: none !important;
-webkit-touch-callout: none!important;
-webkit-user-select: none!important;
-khtml-user-select: none!important;
-moz-user-select: none!important;
-ms-user-select: none!important;
user-select: none!important;
}
.{
    padding-top: 20px;
}


</style>
    <!-- ==========Banner-Section========== -->
    <section class="details-banner bg_img" data-background="./assets/images/banner/banner03.jpg">
        <div class="container">
            <div class="details-banner-wrapper">
                @php
    $now = now();
    $end_date = $vouchers1->end_date;
    $interval = $now->diff($end_date);

    $hoursRemaining = $interval->h;
    $minutesRemaining = $interval->i;
@endphp
            
                <div class="details-banner-content offset-lg-3">
                    <div class="row">
                      
                      <div class="col-md-8">
        <div class="row">
            <pre>
                <h3 class="title your-code">Mã Code : </h3>
            </pre>
            <pre id="code">
            <h3 class="title your-code">{{$vouchers1->code}}</h3>
        </pre>

        </div>
    </div>

                        <div class="col-md-4 button11">
                            @if($vouchers1->status != 3 && $vouchers1->status != 4)
                                <button id="copy-button" style="background-image: -webkit-linear-gradient(169deg, #5560ff 17%, #aa52a1 63%, #ff4343 100%);" onclick="copyCode()">Sao chép mã</button>
                            @else
                                <button id="copy-button" style="background-image: -webkit-linear-gradient(169deg, #5560ff 17%, #aa52a1 63%, #ff4343 100%); display : none" >Sao chép mã</button>
                            @endif
                        </div>
                        </div>
                        
                    
                   
                    <a href="#0" class="button"> Loại :  @if ($vouchers1->type == 1)
                        Giảm theo giá
                    @elseif($vouchers1->type == 2)  
                    Giảm theo %
                @endif</a>
                <li>
                    @if($vouchers1->status == 3 ) 
                    Hết Hạn
                    @elseif($vouchers1->status == 4) 
                    Hết mã khuyến mãi
                @elseif ($hoursRemaining < 1)
<span class="content">Sắp hết hạn còn {{ $minutesRemaining }} phút</span>
@elseif ($hoursRemaining < 24)
<span class="content">Sắp hết hạn còn {{ $hoursRemaining }} giờ {{ $minutesRemaining }} phút</span>
@else
<span class="content">Hạn sử dụng đến {{ \Carbon\Carbon::parse($vouchers1->end_date)->format('d/m/Y') }}</span>
@endif
                   
                </li>
                    <div class="social-and-duration">
                        <div class="duration-area">
                            
                            <div class="item">
                                <span>Hạn sử dụng mã <br> </span>
                                <i class="fas fa-calendar-alt"></i><span>{{($vouchers1->start_date)}} - {{($vouchers1->end_date)}}</span>
                            </div>
                           
                        </div>
                        <div class="duration-area">
                            
                            <div class="item">
                                <span>Số Lượng<br> </span>
                                <span>{{($vouchers1->quantity)}} </span>
                            </div>
                           
                        </div>
                        
                        <ul class="social-share">
                            <li><a href="#0"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#0"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#0"><i class="fab fa-pinterest-p"></i></a></li>
                            <li><a href="#0"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#0"><i class="fab fa-google-plus-g"></i></a></li>
                        </ul>
                    </div>
                    <div class="social-and-duration">
                        <div class="duration-area">
                            
                            <div class="item">
                                <span>Ưu đãi <br> </span>
                               <span>Lượt sử dụng có hạn. Nhanh tay kẻo lỡ bạn nhé ! Giảm {{$vouchers1->value}} Đơn Tối Thiểu {{$vouchers1->min_order_amount}} Giảm tối đa {{$vouchers1->max_order_amount}}</span>
                            </div>
                           
                        </div>
                        
                      
                    </div>
                    <div class="social-and-duration">
                        <div class="duration-area">
                            
                            <div class="item">
                                <span>Áp dụng cho sản phẩm<br> </span>
                               <span>Áp dụng cho một số sản phẩm và người dùng nhất định trên Boleto.
                                Những sản phẩm bị hạn chế chạy khuyến mại theo quy định của Nhà nước sẽ không được hiển thị nếu nằm trong danh sách sản phẩm đã chọn.Tìm hiểu thêm.</span>
                            </div>
                           
                        </div>
                        
                      
                    </div>
                    <div class="social-and-duration">
                        <div class="duration-area">
                            
                            <div class="item">
                                <span>Thanh Toán<br> </span>
                               <span>Tất cả các hình thức thanh toán</span>
                            </div>
                           
                        </div>
                        
                      
                    </div>
                    
                </div>
            </div>

        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Book-Section========== -->
  
    <!-- ==========Book-Section========== -->
<section class="movie-details-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center flex-wrap-reverse mb--50 text-center">
                <div class="col-lg-3 col-sm-10 col-md-6 mb-50">
                    <div class="widget-1 widget-tags">
                        <ul>
                            <li>
                                <div class=" button11">
                                    @if($vouchers1->status == 3 ) 
                                    <button style="background-image: -webkit-linear-gradient(169deg, #5560ff 17%, #aa52a1 63%, #ff4343 100%);
                                    " >Hết Hạn</button>
                    @elseif($vouchers1->status == 4) 
                    <button style="background-image: -webkit-linear-gradient(169deg, #5560ff 17%, #aa52a1 63%, #ff4343 100%);
                                   " >Hết Mã Khuyến Mãi</button>
                    @else
                                    <button style="background-image: -webkit-linear-gradient(169deg, #5560ff 17%, #aa52a1 63%, #ff4343 100%);
                                   " >Dùng Ngay</button>
                                   @endif
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
              
            </div>
        </div>
    </section>
@endsection
<Script>
    function copyCode() {
        var status = {{$vouchers1->status}};
        if (status === 3) {
            return; // Không cho phép sao chép nếu status là 3
        }
    // Lấy nội dung của phần tử pre (mã HTML và CSS)
    var code = document.getElementById("code");

    // Tạo một textarea tạm thời để chứa mã
    var textArea = document.createElement("textarea");
    textArea.value = code.innerText;

    // Đặt kích thước textarea để làm cho nó nhỏ nhất có thể
    textArea.style.position = "fixed";
    textArea.style.top = 0;
    textArea.style.left = 0;

    // Thêm textarea vào trang
    document.body.appendChild(textArea);

    // Chọn toàn bộ nội dung trong textarea
    textArea.select();

    // Sao chép nội dung vào clipboard
    document.execCommand('copy');

    // Xóa textarea tạm thời
    document.body.removeChild(textArea);

    // Hiển thị thông báo hoặc thực hiện các hành động khác (tuỳ chọn)
    alert("Mã đã được sao chép!");
}
</Script>
@extends('layouts.client')
@section('content')
<html>
<head>
    <title>Cảm ơn bạn đã thanh toán!</title>
    <style>
        /* CSS để căn giữa nội dung */

        .content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 70vh;
    margin: 0;
}
 h1 {
    padding-bottom: 40px;
 }
    </style>
</head>
<body>
    <div class="content">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>{{ $message }}</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if ($message = Session::get('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif

        <h1>{{$thongbao}}</h1>
        <p>Thanh toán của bạn đã được xác nhận.</p>
        <img src="{{ asset('client/assets/images/logo/tich.png') }}" alt="Dấu tích" width="100">
    </div>
</body>
</html>
@endsection

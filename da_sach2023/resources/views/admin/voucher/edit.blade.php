@extends('layouts.admin')
@section('title')
  Cập nhật mã giảm giá
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Cập nhật mã giảm giá </h1>
        @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('voucher.update',['id'=>$voucher->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3 mt-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Mã giảm giá:</label>
                    <div class="col-sm-10">
                        <input type="text" name="code" placeholder="Vui lòng nhập giá trị giảm giá" class="form-control" value="{{ $voucher->code }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Loại giảm giá</label>
                    <div class="col-sm-10">
                        <select name="type" id="" class="custom-select">
                            <option value="">Vui lòng chọn loại giảm giá</option>
                            <option value="1" {{ $voucher->type==1? "selected" : "" }} >Giảm giá theo phần trăm</option>
                            <option value="2" {{ $voucher->type==2? "selected" : "" }}>Giảm giá theo giá</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Giá trị giảm giá (Số tiền, số %)</label>
                    <div class="col-sm-10">
                        <input type="text" name="value" placeholder="Vui lòng nhập giá trị giảm giá" class="form-control" value="{{ $voucher->value }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Số lượng</label>
                    <div class="col-sm-10">
                        <input type="text" name="quantity" placeholder="Vui lòng nhập số lượng" class="form-control" value="{{ $voucher->quantity }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Giá trị tối thiểu</label>
                    <div class="col-sm-10">
                        <input type="text" name="min_order_amount" class="form-control"
                            value="{{ $voucher->min_order_amount }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Giá trị tối đa</label>
                    <div class="col-sm-10">
                        <input type="text" name="max_order_amount" class="form-control"
                            value="{{ $voucher->max_order_amount }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Ngày bắt đầu</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" placeholder="Vui lòng nhập ngày bắt đầu" name="start_date" class="form-control" value="{{ $voucher->start_date }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Ngày kết thúc</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" placeholder="Vui lòng nhập ngày kết thúc" name="end_date" class="form-control" value="{{$voucher->end_date}}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Mô tả</label>
                    <div class="col-sm-10">
                        <textarea id="description" name="description" class="form-control" rows="4">{{ $voucher->description }}</textarea>

                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('voucher.index') }}" class="btn btn-success text-white">Danh sách</a>
                    </div>
                </div>

            </form>

    </div>
@endsection
@push('scripts')


@endpush

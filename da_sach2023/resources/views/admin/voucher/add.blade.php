@extends('layouts.admin')
@section('title')
  Thêm mới mã giảm giá
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Thêm mới mã giảm giá </h1>
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

        <form action="{{ route('voucher.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3 mt-3">
                <label for="inputText" class="col-sm-2 col-form-label">Mã giảm giá <span class="text-danger">(*)</span></label>

                <div class="col-sm-10">
                    <input type="text" name="code" placeholder="Vui lòng nhập mã giảm giá" class="form-control" value="{{ old('code') }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Loại giảm giá <span class="text-danger">(*)</span></label>
                <div class="col-sm-10">
                    <select name="type" id="type" class="custom-select">
                        <option value="">Vui lòng chọn loại giảm giá</option>
                        <option value="1" @if(old('type') == '1') selected @endif>Giảm giá theo phần trăm</option>
                        <option value="2" @if(old('type') == '2') selected @endif>Giảm giá theo giá</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Giá trị giảm giá (Số tiền, số %) <span class="text-danger">(*)</span></label>
                <div class="col-sm-10">
                    <input type="text" name="value" placeholder="Vui lòng nhập giá trị giảm giá" class="form-control" value="{{ old('value') }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Số lượng <span class="text-danger">(*)</span></label>
                <div class="col-sm-10">
                    <input type="text" name="quantity" placeholder="Vui lòng nhập số lượng" class="form-control" value="{{ old('quantity') }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Giá trị tối thiểu</label>
                <div class="col-sm-10">
                    <input type="text" name="min_order_amount" class="form-control"
                        value="{{ old('min_order_amount') }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Giá trị tối đa</label>
                <div class="col-sm-10">
                    <input type="text" name="max_order_amount" class="form-control"
                        value="{{ old('max_order_amount') }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Ngày bắt đầu <span class="text-danger">(*)</span></label>
                <div class="col-sm-10">
                    <input type="datetime-local" name="start_date" placeholder="Vui lòng nhập ngày bắt đầu" class="form-control" value="{{ old('start_date') }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Ngày kết thúc <span class="text-danger">(*)</span></label>
                <div class="col-sm-10">
                    <input type="datetime-local" name="end_date" placeholder="Vui lòng nhập ngày kết thúc" class="form-control" value="{{ old('end_date') }}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Mô tả</label>
                <div class="col-sm-10">
                    <textarea id="description" name="description" class="form-control" rows="4"></textarea>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                    <a href="{{ route('voucher.index') }}" class="btn btn-success text-white">Danh sách</a>
                    <button type="reset" class="btn btn-danger">Nhập lại</button>

                </div>
            </div>

        </form>

    </div>
@endsection
@push('scripts')
   
@endpush

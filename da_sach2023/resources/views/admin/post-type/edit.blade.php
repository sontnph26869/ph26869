@extends('layouts.admin')
@section('title')
    Cập nhập danh mục
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Cập nhập danh mục bài viết</h1>
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        @endif

        <!-- DataTales Example -->
        <form action="{{ route('post-type.update',['id' => $postType->id]) }}" method="post"
              enctype="multipart/form-data">
            @csrf
            <div class="card card-primary">

                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Tên danh mục<span class="text-danger">(*)</span></label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $postType->name }}">
                    </div>
                    <div class="form-group">
                        <label for="slug">Đường dẫn</label>
                        <input name="slug" type="text" id="slug" class="form-control" value="{{ $postType->slug }}">
                    </div>
                    <div class="form-group">
                        <label for="parent_id">Danh mục cha</label>
                        <select id="parent_id" class="form-control custom-select" name="parent_id">
                            <option selected="" value="none">Chưa có danh mục cha</option>
                            @foreach($postTypes as $value)
                                @if($postType->id !== $value->id)  {{-- Kiểm tra nếu không phải danh mục đang cập nhật --}}
                                <option
                                    value="{{ $value->id }}" {{ ($postType->parent_id == $value->id) ? 'selected' : '' }}>
                                    {{ $value->name }}
                                </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select id="status" class="form-control custom-select" name="status">
                            <option selected="" disabled="">Chọn một</option>
                            <option value="1" {{ ($postType->status == 1 ? 'selected' : '') }}>Kích hoạt</option>
                            <option value="0" {{ ($postType->status == 0 ? 'selected' : '') }}>Không kích hoạt</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Ảnh</label> <br>
                        <input class="form-control" name="image" type="file" id="image_url" style="display: none">
                        <img src="{{ ($postType->image == null) ? asset('images/image-not-found.jpg') : Storage::url($postType->image) }}" width="130" id="image_preview" class="mt-2"
                             alt="">
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea id="description" name="description" class="form-control"
                                  rows="4">{{ $postType->description }}</textarea>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cập nhập</button>
                    <a href="{{ route('post-type.index') }}" class="btn btn-info">Danh sách</a>
                    <button type="reset" class="btn btn-secondary">Nhập lại</button>
                </div>
            </div>
        </form>

    </div>
@endsection
@push('scripts')
    <script src="{{ asset('upload_file/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('upload_file/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('upload_file/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script>
        const imagePreview = document.getElementById('image_preview');
        const imageUrlInput = document.getElementById('image_url');
        $(function () {
            function readURL(input, selector) {
                if (input.files && input.files[0]) {
                    let reader = new FileReader();

                    reader.onload = function (e) {
                        $(selector).attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image_url").change(function () {
                readURL(this, '#image_preview');
            });

        });
        imagePreview.addEventListener('click', function () {
            imageUrlInput.click();
        });

        imageUrlInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush

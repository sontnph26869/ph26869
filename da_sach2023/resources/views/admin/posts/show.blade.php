@extends('layouts.admin')
@section('content')
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Chi Tiết Bài Viết</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form</h6>
    </div>
    <div class="card-body">
    

            <div class="row">
            <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tiêu Đề : {{$data->title}}</label>
                        
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Người Dùng : {{$data->user->name}}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Đường Dẫn : {{$data->slug}}</label>
                    </div>
                    <div class="mb-3">
               
                    <label for="type" class="form-label">Trạng Thái :          
            @if($data->status == 1)
                Duyệt
            @elseif($data->status == 0)
                Chờ duyệt
            @else
                Không duyệt
            @endif</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-6">
                   
                    </div>
                    <div class="form-group">
                        <label for="image">Ảnh</label> <br>
                        <input name="image" type="file" id="image_url" style="display: none">
    <img src="{{ (isset($data->image) && !empty($data->image)) ? url($data->image) : asset('images/image-not-found.jpg') }}" width="150" height="130" id="image_preview" class="mt-1" alt="">

                    </div>
                    <div class="mb-6">
                    <label for="image">Nội Dung</label> <br>
                          <textarea name="content" id="contents" cols="30" rows="10" value="{{$data->content}}">
                              {{$data->content}}
                          </textarea>

                    </div>
                </div>
                <div class="col">
                <div class="post_type">

                    
                        @foreach($post_type as $post_type1 )

                        @if($post_type1->parent_id %2==0)
                        <ul>
                        <li>
                                <input type="checkbox" id="post_type{{ $post_type1->id }}" name="post_type[]" value="{{$post_type1->id}}" 
                                @if(in_array($post_type1->id,$post_type_posts->pluck('post_type')->toArray()))
                                checked  @endif >
                            
                                <label for="category1">{{$post_type1->name}}</label>
                                    <ul>
                                        @foreach ($post_type as $post_type2) 
                                        @if($post_type2->parent_id - $post_type1->parent_id==1)
                                        <li>
                                            <input type="checkbox" id="post_type{{ $post_type2->id }}" name="post_type[]" value="{{ $post_type2->id }}"
                                            @if(in_array($post_type2->id,$post_type_posts->pluck('post_type')->toArray()))
                                          checked     @endif   >                                                                    
                                          <label for="post_type{{ $post_type2->id }}">{{ $post_type2->name }}</label>
                                     </li> 
                                        @endif                                                                                         
                                        @endforeach   
                                </ul>
                        </li>
                        </ul>
                        @endif  
                        @endforeach
                        </div>
                </div>
            </div>

            <div class="col submit-button-container">
            <a href="{{route('post.index')}}"> <button class="btn btn-primary" type="button">Danh Sách</button></a>
        </div>
    </div>
</div>

</div>



@push('styles')
<style>
    .submit-button-container {
    margin-top: 20px; /* Đặt khoảng cách 20px giữa nút và cột */
}
/* Định dạng cơ bản cho danh mục */
.post_type {
    margin: 20px;
}

/* Định dạng danh mục cha */
.post_type ul {
    list-style: none;
    padding: 0;
}

.post_type ul li {
    margin-bottom: 10px;
}

/* Định dạng danh mục con */
.post_type ul ul {
    margin-left: 20px;
    display: none;
}

/* Hiển thị danh mục con khi checkbox được kiểm tra */
.post_type input[type="checkbox"]:checked + label + ul {
    display: block;
}

/* Tùy chỉnh màu và kiểu hiển thị của liên kết */
.post_type label {
    cursor: pointer;
    color: #333;
}

.post_type label:hover {
    color: #007bff;
}


</style>    

@endpush



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
        imagePreview.addEventListener('click', function() {
            imageUrlInput.click();
        });

        imageUrlInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    
    <script>
var editor = CKEDITOR.replace('contents');
CKFinder.setupCKEditor(editor);
</script>
@endpush
@endsection

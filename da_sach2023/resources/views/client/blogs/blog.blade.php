@extends('layouts.client')
@section('content')
   <!-- ==========Banner-Section========== -->
   <section class="main-page-header speaker-banner bg_img" data-background="./assets/images/banner/banner07.jpg">
        <div class="container">
            <div class="speaker-banner-content">
                <h2 class="title">Bài Viết</h2>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('index') }}">
                            Trang Chủ
                        </a>
                    </li>
                    <li>
                        Bài Viết
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Blog-Section========== -->
    <section class="blog-section padding-top padding-bottom">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 mb-50 mb-lg-0">
                    <article>
                        @foreach($data1 as $post)
                        @if($post->status === 1)
                        <div class="post-item">
                            <div class="post-thumb">
                                <a href="blog-details.html">
                                    <img src=" {{asset($post->image)}}" alt="blog">
                                </a>
                            </div>
                            <div class="post-content">
                                <div class="post-header">
                                    <h4 class="title" >
                                        <a href="{{route('blog-detail',[ $post->slug, 'id' => $post->id])}}" >
                                        {{$post->title}}
                                        </a>
                                    </h4>
                                    <div class="meta-post">
                                        <a href="#0" class="mr-4"><i class="fa-regular fa-comment"></i> {{ countCommentsAndReplies($post->comments) }} Bình Luận</a>
                                        <a href="#0"><i class="fa-regular fa-eye"></i> {{ $post->view}}   Lượt Xem</a>
                                    </div>
                                    <p>
                                    {!! \Illuminate\Support\Str::limit(strip_tags($post->content), 100) !!}
                                    </p>
                                 </div>
                                <div class="entry-content">
                                    <div class="left">
                                    <span class="date">
                                        {{ $post->created_at->diffForHumans() }}
                                    </span>
                                        <div class="authors">
                                            <div class="thumb">
                                                <a href="#0"><img src="{{$post->user->avatar}}" alt="#0"></a>
                                            </div>
                                            <h6 class="title"><a href="#0">{{$post->user->name}}</a></h6>
                                        </div>
                                    </div>
                                    <a href="{{route('blog-detail',[ $post->slug, 'id' => $post->id])}}" class="buttons">Đọc thêm...<i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                  
                    </article>
                    <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                    <ul class="pagination">
                                        {{ $data1->links('pagination::bootstrap-4') }}
                                    </ul>
                                </div>
                            </div>
                </div>
                <div class="col-lg-4 col-sm-10 col-md-8">
                    <aside>
                        <div class="widget widget-search">
                            <h5 class="title">Tìm Kiếm</h5>
                            <form class="search-form">
                            <input type="search" name="search" id="search" placeholder="Tìm kiếm theo tên" >

                                <!-- <button type="submit"><i class="fa-solid fa-magnifying-glass"></i>Search</button> -->
                            </form>
                        </div>
                        <div class="widget widget-post">
                            <h5 class="title">Tin Mới Nhất</h5>
                            <div class="slider-nav">
                                <span class="fa-solid fa-arrow-left widget-prev"></span>
                                <span class="fa-solid fa-arrow-right widget-next active"></span>
                            </div>
                            <div class="widget-slider owl-carousel owl-theme">
                               
                                @foreach($data1->take(3) as $postNew)
                                 @if($postNew->status === 1)

                                <div class="item">
                                    <div class="thumb">
                                        <a href="">
                                            <img src="{{$postNew -> image}}" alt="blog">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h6 class="p-title">
                                            <a href="#0">{{$postNew->title}}</a>
                                        </h6>
                                        <div class="meta-post">
                                            <a href="#0" class="mr-4"><i class="fa-regular fa-comment"></i>{{ countCommentsAndReplies($postNew->comments) }} Bình Luận</a>
                                            <a href="#0"><i class="fa-regular fa-eye"></i>{{ $postNew->view }}  Lượt Xem</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="widget widget-follow">
                            <h5 class="title">Theo Dõi</h5>
                            <ul class="social-icons">
                                <li>
                                    <a href="#0" class="">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0" class="active">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0" class="">
                                        <i class="fab fa-pinterest-p"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <i class="fab fa-google"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="widget widget-categories">
                        <h5 class="title">Danh Mục</h5>
                                <ul>
                                    @foreach($postTypes as $post_type)
                                 @if($post_type->status === 1)
                                    @if ($post_type->parent_id == 0)
                                        <li>
                                            <a href="#0" onclick="submitForm(this)">
                                                <span class="post-type" data-value="{{$post_type->id}}">{{$post_type->name}}</span>
                                            </a>
                                            <ul>
                                            @foreach ($postTypes as $child)
                                             @if($child->status === 1)

                                                @if ($child->parent_id == $post_type->id)
                                                    <li>
                                                    <a href="#0" onclick="submitForm(this)">
                                                    <span class="post-type" data-value="{{$child->id}}">-{{$child->name}}</span>
                                                    </a>
                                                    </li>
                                                @endif
                                                @endif
                                            @endforeach
                                        </ul>
                                        </li>
                                        @endif
                                        @endif

                                    @endforeach
                                    <form action="{{ route('blog')}}" method="get" id="postTypeSearch">
                                    </form>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Blog-Section========== -->
@endsection
@push('style')
<link rel="stylesheet" type="text/css" href="styles.css">
<style>

.date {
  font-size: 16px;
  font-weight: bold;
  color: blue;
}

/* Giới hạn nội dung trong 2 dòng */



    /* Tùy chỉnh CSS cho số trang trong phân trang */
.pagination li {
    display: inline-block;
    margin: 0 5px; /* Khoảng cách giữa các số trang */
    padding: 5px 10px; /* Định dạng kích thước và khoảng cách xung quanh số trang */
    border: 1px solid #ccc;
    background-color: #fff;
    color: #333;
    cursor: pointer;
    border-radius: 3px;
    text-align: center;
}

/* CSS cho số trang hiện tại */
.pagination .active {
    background-color: #007BFF;
    color: #fff;
    border: 1px solid #007BFF;
}

</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/momentjs/2.29.1/moment.min.js"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var titles = $('.post-item'); // Select all the <h4> elements initially
        $('#search').on('input', function() {
            var searchText = $(this).val().toLowerCase();
            titles.each(function() {
                var text = $(this).text().toLowerCase();
                if (text.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });
    });
</script>

<script>
    function submitForm(element) {
        var postType = element.querySelector('.post-type').getAttribute('data-value');
        var form = document.getElementById('postTypeSearch');
        var hiddenField = document.createElement('input');
        hiddenField.type = 'hidden';
        hiddenField.name = 'postTypes';
        hiddenField.value = postType;
        form.appendChild(hiddenField);
        form.submit();
    }
</script>



@endpush
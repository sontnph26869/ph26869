@extends('layouts.client')
@section('content')

<!-- ==========Banner-Section========== -->
<section class="main-page-header speaker-banner bg_img" data-background="">
    <div class="container">
        <div class="speaker-banner-content">
            <h2 class="title">Bài Viết Chi Tiết</h2>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('index') }}">
                        Trang Chủ
                    </a>
                </li>
                <li>
                    <a href="{{route('blog')}}">
                        Bài Viết
                    </a>
                </li>
                <li>
                    Bài Viết Chi tiết
                </li>
            </ul>
        </div>
    </div>
</section>
<!-- ==========Banner-Section========== -->

<!-- ==========Blog-Section========== -->
<section class="blog-section padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-lg-8 mb-50 mb-lg-0">
                <article>
                    <div class="post-item post-details">
                        <div class="post-thumb">
                            <img src=" {{asset($data->image)}}" alt="blog">
                        </div>
                        <div class="post-content">
                            <div class="post-meta text-center">

                            </div>
                            <div class="content">
                                <div class="entry-content p-0">
                                    <div class="left">

                                        <span class="date">{{ $data->created_at}}
                                        </span>
                                    </div>
                                </div>
                                <div class="entry-content p-0">
                                    <div class="left">
                                        @if ($post_type_one)
                                        <span>{{ $post_type_one->name }} </span>
                                        @else
                                        <span> </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="post-header">
                                    <h4 class="m-title">
                                        {{$data->title}}
                                    </h4>
                                    <div id="textContainer">
                                        {!! $data->content !!}
                                    </div>


                                </div>
                                <div class="tags-area">
                                    <ul class="social-icons">
                                        <li>
                                            <a href="#0">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#0" class="active">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#0">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#0">
                                                <i class="fab fa-pinterest"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#0">
                                                <i class="fab fa-google"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blog-author">
                        <div class="author-thumb">
                            <a href="#0">
                                <img src="{{asset($data->user->avatar)}}" alt="blog">
                            </a>
                        </div>
                        <div class="author-content">
                            <h5 class="title">
                                <a href="#0">
                                    {{$data->user->name}}
                                </a>
                            </h5>
                        </div>
                    </div>
                    <div class="blog-comment">
                    <h5 class="title">Bình Luận</h5>
@foreach ($comments as $comment)
    <ul class="comment-area">
        <li> 
            <div class="">
            <h6 class="title mb-6">
            <span class="user-title" data-comment-id="{{ $comment->id }}">
                {{$comment->user->name}}
            </span>
             </h6>
            </div>
            <div class="blog-thumb-info">
                <span> {{ $comment->created_at->diffForHumans() }}</</span>
            </div>
            <div class="blog-content">
                <p>{{ $comment->message }}</p>
            </div>
            <div>
                <button class="btn btn-link reply-button" onclick="showReplyForm({{$comment->id}},'{{$comment->user->name}}')">Phản hồi</button>
            </div>
            <div id="reply-form-container-{{ $comment->id }}" class="reply-form-container">
                <!-- Đây là nơi để form trả lời -->
            </div>
        </li>
    </ul>
    <div id="replies-container-{{ $comment->id }}" class="replies-container">
           @foreach ($reply_id as $reply)
           @if($reply->comment_id == $comment->id)
    <ul class="comment-area1 ">
        <li>
        <h6 class="title mb-3">
            <span  class="user-reply" data-comment-id="{{ $reply->id }}">
                {{$reply->user->name}}
            </span>
          </h6>
          <div class="blog-thumb-info mb-3">
                <span>    {{ $reply->created_at->diffForHumans() }}</span>
            </div>
               <!-- Đây là nơi để hiển thị các phản hồi -->
               <div class="blog-content col-9">
                        <p>{{ $reply->message }}</p>
                </div>
                <div >
                <button class="btn btn-link reply-button col-3" onclick="showReplyForm2({{ $reply->id }},{{$reply->comment_id}},'{{$reply->user->name}}')">Phản hồi</button>
            </div>
            <div id="reply-form2-container-{{$reply->id, $reply->comment_id}}" class="reply-form2-container">
                <!-- Đây là nơi để form trả lời -->
            </div>
            <!-- comment child -->
        </li>
    </ul>
    @endif
    @endforeach
    </div>
@endforeach

                        <div class="leave-comment">
                            <h5 class="title">Bình Luận Bài viết</h5>
                            <form class="blog-form" method="post" action="{{route('blog-cmt.store')}}">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $data->id }}">
                                <div class="form-group">
                                    <textarea placeholder="Nội Dung" required name="message"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Gửi">
                                </div>
                            </form>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-lg-4 col-sm-10 col-md-8">
                <aside>
                    <div class="widget widget-search">
                        <h5 class="title">Tìm Kiếm</h5>
                        <input type="text" id="search" placeholder="Enter your Search Content" required>
                    </div>
                    <div class="widget widget-post">
                        <h5 class="title">Bài Viết Liên Quan</h5>
                        <div class="slider-nav">
                            <span class="fa-solid fa-arrow-left widget-prev"></span>
                            <span class="fa-solid fa-arrow-right widget-next active"></span>
                        </div>
                        <div class="widget-slider owl-carousel owl-theme">
                            @foreach($related_posts as $related_posts)
                            <div class="item">
                                <div class="thumb">
                                    <a href="#0">
                                        <img src="{{asset($related_posts->post->image)}}" alt="blog">
                                    </a>
                                </div>
                                <div class="content">
                                    <h6 class="p-title">
                                        <a href="{{route('blog-detail',[ $related_posts->post->slug, 'id' => $related_posts->id])}}">{{$related_posts->post->title}}</a>
                                    </h6>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="widget widget-follow">
                        <h5 class="title">Theo dõi</h5>
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
                            @foreach($post_type as $post_type1)
                            @if($post_type1->status === 1)
                            @if ($post_type1->parent_id == 0)

                            <li>
                                <a href="#0" onclick="submitForm(this)">
                                    <span class="post-type" data-value="{{$post_type1->id}}"
                                        @if(in_array($post_type1->id,$post_type_posts->pluck('post_type')->toArray()))
                                        checked
                                        @else
                                        style="display: none;"
                                        @endif >
                                        {{$post_type1->name}}</span>
                                </a>
                                <ul>
                                    @foreach ($post_type as $child)
                                    @if($child->status === 1)
                                    @if ($child->parent_id == $post_type1->id)
                                    <li>
                                        <a href="#0" onclick="submitForm(this)">
                                            <span class="post-type" data-value="{{$child->id}}"
                                                @if(in_array($post_type1->id,$post_type_posts->pluck('post_type')->toArray()))
                                                checked
                                                @else
                                                style="display: none;"
                                                @endif >-{{$child->name}}</span>
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
<style>
       .comment-area1   {
        margin-left: 30px; /* Điều chỉnh giá trị này để thay đổi mức độ lùi */
    }
    .comment-area12   {
        margin-left: 30px; /* Điều chỉnh giá trị này để thay đổi mức độ lùi */
    }

    .my-list {
    list-style: none;
    padding: 0;
}
.my-list{
    width: 1000px;
    margin-bottom: 10px;
    /* Thêm các thuộc tính CSS khác theo nhu cầu của bạn */
}

    /* Ẩn ban đầu phần replies */
.replies-container {
    display: none;
}

/* Định dạng cho tiêu đề người dùng để làm cho nó giống một liên kết */
.user-title {
    cursor: pointer;
    text-decoration: underline;
}


</style>
<style>
    .highlight {
        background-color: yellow; /* Highlight background color */
        font-weight: bold; /* Highlight text weight */
    }
</style>



@endsection
@push('styles')
<link rel="stylesheet" type="text/css" href="styles.css">
<style>
.date {
    font-size: 16px;
    font-weight: bold;
    color: blue;
}
</style>
@endpush

@push('scripts')

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
<script>
document.addEventListener("click", function(e) {

    if (e.target.classList.contains("reply-button")) {
        // Tìm phần tử chứa form trả lời (có thể thay đổi tùy theo cấu trúc HTML của bạn)
        var replyForm = e.target.parentNode.querySelector(".reply-form");
        if (replyForm) {
            // Kiểm tra xem replyForm tồn tại trước khi thao tác với nó
            if (replyForm.style.display === "none" || replyForm.style.display === "") {
                replyForm.style.display = "block";
            } else {
                replyForm.style.display = "none";
            }
        }
    }
});
</script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#search').on('input', function() {
        var searchText = $(this).val();
        var textContainer = $('#textContainer p');
        var text = textContainer.text();
        var highlightedText = text.replace(new RegExp(searchText, "ig"), function(match) {
            return '<span class="highlight ">' + match + '</span>';
        });
        textContainer.html(highlightedText);
    });
});
</script> -->




<script>
    
// Hàm để hiển thị/ẩn replies
function toggleReplies(commentId) {
    const repliesContainer = document.getElementById('replies-container-' + commentId);
    if (repliesContainer.style.display === 'none' || repliesContainer.style.display === '') {
        repliesContainer.style.display = 'block';
    } else {
        repliesContainer.style.display = 'none';
    }
}

// Sử dụng event delegation để theo dõi sự kiện click trên tiêu đề người dùng
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("user-title")) {
        const commentId = e.target.getAttribute('data-comment-id');
        toggleReplies(commentId);
    }
});



// Hàm để hiển thị form phản hồi
function showReplyForm(commentId, user) {
    // alert(user)
    // Tạo một form để trả lời bình luận với một định danh duy nhất cho mỗi bình luận
    
   
    const replyForm = `
        <form id="reply-form-${commentId}" action="{{route('replie.repStore')}}" method="post">
        @csrf
            <input type="hidden" name="commentId" value="${commentId}">
            <div class="d-flex" >
                <input type="text" name="message" placeholder="Phản hồi" class="col-12" value="${user}">
                <button type="submit" class="form-group col-3"><i class="fa-regular fa-paper-plane"></i></button>
                <button type="button" onclick="closeCommentReplyForm(${commentId})" class="col-3">x</button>
            </div>
        </form>
    `;
    // Hiển thị form tạo phản hồi trong container của bình luận tương ứng
    document.getElementById(`reply-form-container-${commentId}`).innerHTML = replyForm;
}
function showReplyForm2(repId,commentId ,user) {
    // alert(commentId)
    // alert(repId)

    // Tạo một form để trả lời bình luận với một định danh duy nhất cho mỗi bình luận
    const replyForm = `
        <form id="reply-form2-${repId}" action="{{route('replie.repStore')}}" method="post">
        @csrf
        
            <input type="hidden" name="commentId" value="${commentId}">
            <input type="hidden" name="parentId" value="${repId}">
            <div class="d-flex" >
                <input type="text" name="message" placeholder="Phản hồi bình luận " class="col-6" value="${user}">
                <button type="submit" class="form-group col-1"><i class="fa-regular fa-paper-plane"></i></button>
                <button type="button" onclick="closeCommentReplyForm(${repId})" class="col-1">x</button>
            </div>
        </form>
    `;
    // Hiển thị form tạo phản hồi trong container của bình luận tương ứng
    document.getElementById(`reply-form2-container-${repId}`).innerHTML = replyForm;
}


function closeCommentReplyForm(commentId) {
    const replyFormContainer = document.getElementById(`reply-form-container-${commentId}`);
    if (replyFormContainer) {
        // Check if the element exists
        replyFormContainer.innerHTML = '';
    }
}
function closeCommentReplyForm(repId) {
    const replyFormContainer = document.getElementById(`reply-form2-container-${repId}`);
    // Xóa nội dung của container
    replyFormContainer.innerHTML = '';
}


</script>




@endpush
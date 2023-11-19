@if($books->isNotEmpty())
@foreach($books as $book)
<div class="col-sm-6 col-lg-4">
    <div class="movie-grid">
        <div class="movie-thumb c-thumb">
            <a href="movie-details.html">
                <img src="{{ asset($book->poster)}}" alt="movie">
            </a>
        </div>
        <div class="movie-content bg-one">
            <h5 class="title m-0">
                <a href="{{ route('book.detail', ['slug' => Str::slug($book->name), 'id' => $book->id]) }}">
                    {{$book->name}}
                </a>

            </h5>
            <ul class="movie-rating-percent">
                <li>
                    <div class="thumb">
                        <img src="{{asset('client/assets/images/movie/tomato.png')}}" alt="movie">
                    </div>
                    <span class="content">88%</span>
                </li>
                <li>
                    <div class="thumb">
                        <img src="{{asset('client/assets/images/movie/cake.png')}}" alt="movie">
                    </div>
                    <span class="content">88%</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endforeach

@else
<p>Không có kết quả phim phù hợp với yêu cầu của bạn.</p>
@endif

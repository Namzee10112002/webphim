@extends('user.layout')
@push('styles')
    <style>
        body {
            background-color: #121212;
            color: #f8f9fa;
        }
    </style>
@endpush
@section('content')
    <div class="container my-4">
        <div class="row">
            <!-- Article -->
            <div class="col-md-9">
                <h2>{{ $movie->name_movie }} - Tập {{ $currentEpisode->orders }}</h2>

                <!-- Player -->
                <div class="ratio ratio-16x9 mb-3">
                    <iframe src="{{ $currentEpisode->link }}" frameborder="0" allowfullscreen></iframe>
                </div>

                <!-- Danh sách tập -->
                @if($episodes->count() > 1)
                    <div class="d-flex flex-wrap mb-3">
                        @foreach($episodes as $ep)
                            <a href="{{ route('movies.watch', [$movie->id, $ep->id]) }}"
                                class="btn btn-outline-warning m-1 {{ $ep->id == $currentEpisode->id ? 'active' : '' }}">
                                Tập {{ $ep->orders }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <!-- Comment -->
                <h5>Bình luận</h5>
                <textarea class="form-control" id="comment-content"></textarea>
                @if(!Auth::check()) 
                
                    <a href="/auth" class="text-white btn btn-primary mt-2">Đăng nhập để bình luận</a>
                @else 
                    <button class="btn btn-primary mt-2" id="btn-comment" data-id="{{ $currentEpisode->id }}">Gửi</button>
                @endif
                <div class="comment-list mt-5">
                    @foreach($comments as $comment)
                        <div class="border p-2 mb-2">
                            <strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Aside -->
            <div class="col-md-3">
                <div class="p-3 bg-dark text-white rounded">
                    <h5>Thông tin phim</h5>
                    <p><strong>Thể loại:</strong> {{ $movie->genres->pluck('name_genre')->unique()->join(', ') }}</p>
                    <p><strong>Quốc gia:</strong> {{ $movie->countries->pluck('name_country')->unique()->join(', ') }}</p>
                    <p><strong>Năm:</strong> {{ $movie->year_release }}</p>
                    <p><strong>Đạo diễn:</strong> {{ $movie->director }}</p>
                    <p><strong>Diễn viên:</strong> {{ $movie->actor }}</p>
                    <p><strong>Thời lượng:</strong> {{ $movie->duration }}</p>
                    <p><strong>Lượt xem:</strong> {{ $movie->clicks }}</p>
                    @if(Auth::check())
                    <button id="btn-like" data-id="{{ $movie->id }}">
                        @if($userCheckLike)
                            ❤️ Đã thích (<span id="like-count">{{ $movie->movie_likes_count }}</span>)
                        @else
                            ❤️ Thích (<span id="like-count">{{ $movie->movie_likes_count }}</span>)
                        @endif
                    </button>

                    <!-- Xem sau (từng tập) -->
                    <button id="btn-watchlater" data-id="{{ $currentEpisode->id }}">
                        @if ($userCheckWatchList)
                            ✅ Đã lưu vào xem sau
                        @else
                            📌 Xem sau
                        @endif
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#btn-like').click(function () {
            var movieId = $(this).data('id');

            $.ajax({
                url: '/movie/' + movieId + '/like',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {
                    if (res.clear==1) {
                        $('#btn-like').html('❤️ Thích (<span id="like-count">' + res.movie_likes_count + '</span>)');
                    } else {
                        $('#btn-like').html('❤️ Đã thích (<span id="like-count">' + res.movie_likes_count + '</span>)');
                    }
                }
            });
        });
        $('#btn-watchlater').click(function () {
            var detailId = $(this).data('id');

            $.ajax({
                url: '/movie-detail/' + detailId + '/watch-list',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {
                    alert(res.message);
                    if (res.clear==1) {
                        $('#btn-watchlater').text('📌 Xem sau');
                    } else {
                        $('#btn-watchlater').text('✅ Đã lưu vào xem sau');
                    }
                }
            });
        });
$('#btn-comment').click(function () {
    var detailId = $(this).data('id');
    var content = $('#comment-content').val();

    $.ajax({
        url: '/movie-detail/' + detailId + '/comment',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            content: content
        },
        success: function (res) {
            $('.comment-list').empty(); // Xóa danh sách bình luận hiện tại
            res.comments.forEach(element => {
                $('.comment-list').append(`
                    <div class="border p-2 mb-2">
                        <strong>${element.user.name}</strong>: ${element.content}
                    </div>
                `);
            });
            $('#comment-content').val(''); // Xóa nội dung textarea
        }
    });
});

    </script>
@endpush
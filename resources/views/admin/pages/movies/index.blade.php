@extends('admin.layout')

@section('content')
<h2>Danh sách phim</h2>
<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>Ảnh</th>
            <th>Tên</th>
            <th>Thể loại</th>
            <th>Quốc gia</th>
            <th>Lượt xem</th>
            <th>Like</th>
            <th>Loại</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($movies as $movie)
        <tr>
            <td><img src="{{ $movie->image_movie }}" width="80"></td>
            <td>{{ $movie->name_movie }}</td>
            <td>{{ $movie->genres->pluck('name_genre')->unique()->join(', ') }}</td>
            <td>{{ $movie->countries->pluck('name_country')->unique()->join(', ') }}</td>
            <td>{{ $movie->clicks }}</td>
            <td>{{ $movie->movie_likes_count }}</td>
            <td>{{ $movie->is_series ? 'Phim bộ' : 'Phim lẻ' }}</td>
            <td>
                <button class="btn btn-sm toggle-status {{ $movie->status_movie ? 'btn-danger' : 'btn-success' }}"
                    data-id="{{ $movie->id }}">
                    {{ $movie->status_movie ? 'Đang ẩn' : 'Hiển thị' }}
                </button>
            </td>
            <td>
                <a href="{{ route('admin.movies.show', $movie->id) }}" class="btn btn-primary btn-sm">Chi tiết</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
    $('.toggle-status').click(function(){
        let btn = $(this);
        let id = btn.data('id');
        $.post(`/admin/movies/toggle-status/${id}`, {_token: '{{ csrf_token() }}'}, function(res){
            if(res.status == 0) {
                btn.removeClass('btn-danger').addClass('btn-success').text('Hiển thị');
            } else {
                btn.removeClass('btn-success').addClass('btn-danger').text('Đang ẩn');
            }
        });
    });
});
</script>
@endpush

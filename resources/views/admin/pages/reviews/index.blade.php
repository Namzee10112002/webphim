@extends('admin.layout')

@section('content')
<h3>Quản lý đánh giá</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên phim</th>
            <th>Số bình luận</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($movies as $movie)
        <tr>
            <td>{{ $movie->id }}</td>
            <td>{{ $movie->name_movie }}</td>
            <td>{{ $movie->comments_count }}</td>
            <td>
                <a href="{{ route('admin.reviews.show', $movie->id) }}" class="btn btn-primary btn-sm">Xem chi tiết</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

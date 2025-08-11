@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Quản lý thể loại phim</h3>

    {{-- Form thêm thể loại --}}
    <form action="{{ route('admin.genres.store') }}" method="POST" class="mb-4 d-flex">
        @csrf
        <input type="text" name="name_genre" class="form-control me-2" placeholder="Tên thể loại" required>
        <button type="submit" class="btn btn-primary">Thêm</button>
    </form>

    {{-- Danh sách thể loại --}}
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Tên thể loại</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($genres as $index => $genre)
            <tr id="genre-row-{{ $genre->id }}">
                <td>{{ $index + 1 }}</td>
                <td>
                    <form action="{{ route('admin.genres.update', $genre->id) }}" method="POST" class="d-flex">
                        @csrf
                        <input type="text" name="name_genre" value="{{ $genre->name_genre }}" class="form-control me-2" required>
                        <button type="submit" class="btn btn-sm btn-warning">Sửa</button>
                    </form>
                </td>
                <td>
                    <span class="badge {{ $genre->status_genre == 0 ? 'bg-success' : 'bg-secondary' }}">
                        {{ $genre->status_genre == 0 ? 'Hiển thị' : 'Ẩn' }}
                    </span>
                </td>
                <td>
                    <button 
                        class="btn btn-sm toggle-status-btn {{ $genre->status_genre == 0 ? 'btn-danger' : 'btn-success' }}"
                        data-id="{{ $genre->id }}">
                        {{ $genre->status_genre == 0 ? 'Ẩn' : 'Hiện' }}
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.toggle-status-btn').click(function() {
        let btn = $(this);
        let genreId = btn.data('id');

        $.ajax({
            url: '{{ url("admin/genres/toggle-status") }}/' + genreId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                if(res.success) {
                    let row = $('#genre-row-' + genreId);
                    let badge = row.find('span.badge');

                    if(res.status_genre == 0) {
                        badge.removeClass('bg-secondary').addClass('bg-success').text('Hiển thị');
                        btn.removeClass('btn-success').addClass('btn-danger').text('Ẩn');
                    } else {
                        badge.removeClass('bg-success').addClass('bg-secondary').text('Ẩn');
                        btn.removeClass('btn-danger').addClass('btn-success').text('Hiện');
                    }
                }
            }
        });
    });
});
</script>
@endpush

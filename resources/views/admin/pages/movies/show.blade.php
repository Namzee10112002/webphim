@extends('admin.layout')

@section('content')
    <div class="row">
        {{-- Cột trái: Thông tin phim --}}
        <div class="col-md-8">
            <h3>Thông tin phim</h3>
            <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Tên phim</label>
                    <input type="text" name="name_movie" value="{{ $movie->name_movie }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="4">{{ $movie->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Thumbnail</label>
                    <input type="text" name="thumbnail" value="{{ $movie->image_movie }}" class="form-control">
                    <img src="{{ $movie->image_movie }}" alt="" width="100px" class="mt-2">
                </div>
                <button class="btn btn-primary">Cập nhật phim</button>
            </form>
            <div class="mb-3">
                <h5>Thể loại</h5>
                @foreach($allGenres as $genre)
                    <label class="d-block">
                        <input type="checkbox" class="variant-checkbox" data-movie-id="{{ $movie->id }}" data-type="genre"
                            data-id="{{ $genre->id }}" {{ $movie->genres->contains($genre->id) ? 'checked' : '' }}>
                        {{ $genre->name_genre }}
                    </label>
                @endforeach

            </div>
            <div class="mb-3">
                <h5 class="mt-4">Quốc gia</h5>
                @foreach($allCountries as $country)
                    <label class="d-block">
                        <input type="checkbox" class="variant-checkbox" data-movie-id="{{ $movie->id }}" data-type="country"
                            data-id="{{ $country->id }}" {{ $movie->countries->contains($country->id) ? 'checked' : '' }}>
                        {{ $country->name_country }}
                    </label>
                @endforeach
            </div>

            <hr>

            {{-- Quản lý tập phim --}}
            @if($movie->is_series)
                <h4>Danh sách tập phim</h4>
                <table class="table table-bordered table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">STT</th>
                            <th width="20%">Tên tập</th>
                            <th>Link</th>
                            <th width="10%">Thứ tự</th>
                            <th width="20%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movie->movieDetails as $index => $ep)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <input type="text" form="update-ep-{{ $ep->id }}" name="name_detail"
                                        value="{{ $ep->name_detail }}" class="form-control form-control-sm">
                                </td>
                                <td>
                                    <input type="text" form="update-ep-{{ $ep->id }}" name="link"
                                        value="{{ $ep->link }}" class="form-control form-control-sm">
                                </td>
                                <td>
                                    <input type="number" min="1" step="1" form="update-ep-{{ $ep->id }}" name="orders" value="{{ $ep->orders }}"
                                        class="form-control form-control-sm">
                                </td>
                                <td>
                                    <form id="update-ep-{{ $ep->id }}" action="{{ route('admin.movies.details.update', $ep->id) }}"
                                        method="POST" style="display:inline">
                                        @csrf
                                        <button class="btn btn-primary btn-sm">Sửa</button>
                                    </form>
                                    <form action="{{ route('admin.movies.details.delete', $ep->id) }}" method="POST"
                                        style="display:inline">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h5 class="mt-3">Thêm tập mới</h5>
                <form action="{{ route('admin.movies.details.store', $movie->id) }}" method="POST">
                    @csrf
                    <input type="text" name="name_detail" placeholder="Tên tập" class="form-control mb-2">
                    <input type="text" name="link" placeholder="Link" class="form-control mb-2">
                    <button class="btn btn-success btn-sm">Thêm tập</button>
                </form>
            @else
                <h4>Thông tin tập phim</h4>
                @if($movie->movieDetails->count())
                    @php $ep = $movie->movieDetails->first(); @endphp
                    <form action="{{ route('admin.movies.details.update', $ep->id) }}" method="POST">
                        @csrf
                        <input type="text" name="name_detail" value="{{ $ep->name_detail }}" class="form-control mb-2">
                        <input type="text" name="link" value="{{ $ep->link }}" class="form-control mb-2">
                        <button class="btn btn-primary btn-sm">Cập nhật</button>
                    </form>
                @else
                    <p>Chưa có tập phim nào</p>
                @endif
            @endif
        </div>

        {{-- Cột phải: Thông tin nhanh --}}
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Thông tin nhanh</h5>
                <p><strong>Lượt xem:</strong> {{ $movie->view_count }}</p>
                <p><strong>Like:</strong> {{ $movie->movieLikes->count() }}</p>
                <p><strong>Trạng thái:</strong> {{ $movie->status_movie ? 'Ẩn' : 'Hiển thị' }}</p>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).on('change', '.variant-checkbox', function () {
            const el = $(this);
            const movieId = el.data('movie-id');
            const type = el.data('type');
            const typeId = el.data('id');
            const checked = el.is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("admin.movies.variants.toggle") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    movie_id: movieId,
                    type: type,
                    type_id: typeId,
                    checked: checked
                },
                success: function (res) {
                    if (res.success) {
                        console.log('OK', res);
                    } else {
                        alert(res.message);
                        // revert checkbox nếu thất bại
                        el.prop('checked', !el.is(':checked'));
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON?.message) {
                        alert(xhr.responseJSON.message);
                    } else {
                        alert('Có lỗi xảy ra khi cập nhật.');
                    }
                    // revert checkbox
                    el.prop('checked', !el.is(':checked'));
                }
            });
        });

    </script>
@endpush
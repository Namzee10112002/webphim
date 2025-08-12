@extends('admin.layout')

@section('content')
<h3>Bình luận cho phim: {{ $movie->name_movie }}</h3>
<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Người comment</th>
            <th>Nội dung</th>
            <th>Tập phim</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($comments as $c)
        <tr>
            <td>{{ $c->user->name ?? 'Khách' }}</td>
            <td>{{ $c->content }}</td>
            <td>{{ $c->movieDetail->name_detail ?? '' }}</td>
            <td>{{ $c->status_comment ? 'Ẩn' : 'Hiển thị' }}</td>
            <td>
                <button class="btn btn-warning btn-sm toggle-comment" data-id="{{ $c->id }}">
                    {{ $c->status_comment ? 'Mở lại' : 'Ẩn' }}
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@push('scripts')
<script>
$(document).on('click', '.toggle-comment', function(){
    let id = $(this).data('id');
    $.post('{{ url("admin/reviews/toggle-status") }}/' + id, {
        _token: '{{ csrf_token() }}'
    }, function(res){
        if(res.success){
            location.reload();
        }
    });
});
</script>
@endpush

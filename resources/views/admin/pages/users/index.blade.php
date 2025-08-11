@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Quản lý người dùng</h3>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Số phim đã thích</th>
                <th>Số bình luận</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr id="user-row-{{ $user->id }}">
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->likes_count }}</td>
                <td>{{ $user->comments_count }}</td>
                <td>
                    <span class="badge {{ $user->status_user == 0 ? 'bg-success' : 'bg-danger' }}">
                        {{ $user->status_user == 0 ? 'Khả dụng' : 'Bị khóa' }}
                    </span>
                </td>
                <td>
                    <button 
                        class="btn btn-sm toggle-status-btn {{ $user->status_user == 0 ? 'btn-danger' : 'btn-success' }}"
                        data-id="{{ $user->id }}">
                        {{ $user->status_user == 0 ? 'Khóa' : 'Mở khóa' }}
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
        let userId = btn.data('id');

        $.ajax({
            url: '{{ url("admin/users/toggle-status") }}/' + userId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                if(res.success) {
                    let row = $('#user-row-' + userId);
                    let badge = row.find('span.badge');

                    if(res.status_user == 0) {
                        badge.removeClass('bg-danger').addClass('bg-success').text('Khả dụng');
                        btn.removeClass('btn-success').addClass('btn-danger').text('Khóa');
                    } else {
                        badge.removeClass('bg-success').addClass('bg-danger').text('Bị khóa');
                        btn.removeClass('btn-danger').addClass('btn-success').text('Mở khóa');
                    }
                }
            }
        });
    });
});
</script>
@endpush

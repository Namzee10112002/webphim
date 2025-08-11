@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Quản lý quốc gia</h3>

    {{-- Form thêm quốc gia --}}
    <form action="{{ route('admin.countries.store') }}" method="POST" class="mb-4 d-flex">
        @csrf
        <input type="text" name="name_country" class="form-control me-2" placeholder="Tên quốc gia" required>
        <button type="submit" class="btn btn-primary">Thêm</button>
    </form>

    {{-- Danh sách quốc gia --}}
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Tên quốc gia</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($countries as $index => $country)
            <tr id="country-row-{{ $country->id }}">
                <td>{{ $index + 1 }}</td>
                <td>
                    <form action="{{ route('admin.countries.update', $country->id) }}" method="POST" class="d-flex">
                        @csrf
                        <input type="text" name="name_country" value="{{ $country->name_country }}" class="form-control me-2" required>
                        <button type="submit" class="btn btn-sm btn-warning">Sửa</button>
                    </form>
                </td>
                <td>
                    <span class="badge {{ $country->status_country == 0 ? 'bg-success' : 'bg-secondary' }}">
                        {{ $country->status_country == 0 ? 'Hiển thị' : 'Ẩn' }}
                    </span>
                </td>
                <td>
                    <button 
                        class="btn btn-sm toggle-status-btn {{ $country->status_country == 0 ? 'btn-danger' : 'btn-success' }}"
                        data-id="{{ $country->id }}">
                        {{ $country->status_country == 0 ? 'Ẩn' : 'Hiện' }}
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
        let countryId = btn.data('id');

        $.ajax({
            url: '{{ url("admin/countries/toggle-status") }}/' + countryId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                if(res.success) {
                    let row = $('#country-row-' + countryId);
                    let badge = row.find('span.badge');

                    if(res.status_country == 0) {
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

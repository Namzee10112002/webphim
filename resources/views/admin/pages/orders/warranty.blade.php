@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h2>Quản lý Bảo hành</h2>
    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>Mã đơn hàng</th>
                <th>Sản phẩm</th>
                <th>Trạng thái</th>
                <th>Phản hồi</th>
                <th>Cập nhật trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderDetails as $detail)
            <tr id="detail-{{ $detail->id }}">
                <td>#{{ $detail->order->id }}</td>
                <td>
                    <img src="{{ $detail->product->image_product }}" width="60" class="me-2">
                    {{ $detail->product->name_product }}
                </td>
                <td>
                    <select class="form-select status-detail-select" data-id="{{ $detail->id }}">
                        <option value="0" {{ $detail->status_detail == 0 ? 'selected' : '' }}>Sản phẩm bình thường</option>
                        <option value="1" {{ $detail->status_detail == 1 ? 'selected' : '' }}>Sản phẩm lỗi chờ thu hồi</option>
                        <option value="2" {{ $detail->status_detail == 2 ? 'selected' : '' }}>Đã thu hồi sản phẩm</option>
                        <option value="3" {{ $detail->status_detail == 3 ? 'selected' : '' }}>Đã xử lý xong</option>
                    </select>
                </td>
                <td>
                    <a href="{{ route('admin.chat', $detail->order->id) }}" class="btn btn-warning btn-sm">Phản hồi</a>
                </td>
                <td>
                    <button class="btn btn-success btn-sm update-status-btn" data-id="{{ $detail->id }}">Cập nhật</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.update-status-btn').forEach(button => {
        button.addEventListener('click', function() {
            const detailId = this.dataset.id;
            const statusDetail = document.querySelector(`.status-detail-select[data-id='${detailId}']`).value;

            fetch('/admin/warranty/update-status/' + detailId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status_detail: statusDetail })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Cập nhật thành công');
                }
            });
        });
    });
</script>
@endpush

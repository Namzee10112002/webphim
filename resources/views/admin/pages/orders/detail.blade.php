@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>
    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá mua</th>
                <th>Số lượng</th>
                <th>Tổng tiền mặt hàng</th>
                <th>Trạng thái</th>
                <th>Cập nhật</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderDetails as $detail)
            <tr id="detail-{{ $detail->id }}">
                <td><img src="{{ $detail->product->image_product }}" width="60"></td>
                <td>{{ $detail->product->name_product }}</td>
                <td>{{ number_format($detail->total_detail/$detail->quantity) }} VNĐ</td>
                <td>{{ $detail->quantity }}</td>
                <td>{{ number_format($detail->total_detail) }} VNĐ</td>
                <td>
                    <select class="form-select status-detail-select" data-id="{{ $detail->id }}">
                        <option value="0" {{ $detail->status_detail == 0 ? 'selected' : '' }}>Sản phẩm bình thường</option>
                        <option value="1" {{ $detail->status_detail == 1 ? 'selected' : '' }}>Sản phẩm lỗi chờ thu hồi</option>
                        <option value="2" {{ $detail->status_detail == 2 ? 'selected' : '' }}>Đã thu hồi sản phẩm</option>
                        <option value="3" {{ $detail->status_detail == 3 ? 'selected' : '' }}>Đã xử lý xong</option>
                    </select>
                </td>
                <td>
                    <button class="btn btn-success btn-sm update-detail-btn" data-id="{{ $detail->id }}">Cập nhật</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.update-detail-btn').forEach(button => {
        button.addEventListener('click', function() {
            const detailId = this.dataset.id;
            const statusDetail = document.querySelector(`.status-detail-select[data-id='${detailId}']`).value;

            fetch(`/admin/orders/${detailId}/update-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status_detail: statusDetail })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    alert('Cập nhật trạng thái chi tiết thành công');
                }
            });
        });
    });
</script>
@endpush

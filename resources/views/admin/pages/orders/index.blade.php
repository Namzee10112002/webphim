@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Danh sách đơn hàng</h2>
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Mã đơn hàng</th>
                <th>Người nhận</th>
                <th>SĐT</th>
                <th>Địa chỉ</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Ghi chú</th>
                <th>PT Thanh toán</th>
                <th>Trạng thái</th>
                <th>Phản hồi</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr id="order-{{ $order->id }}">
                <td>{{ $order->id }}</td>
                <td>{{ $order->name_order }}</td>
                <td>{{ $order->phone_order }}</td>
                <td>{{ $order->address_order }}</td>
                <td>{{ $order->date_order }}</td>
                <td>{{ number_format($order->total_order) }} VNĐ</td>
                <td>{{ $order->note_order }}</td>
                <td>
                    <select class="form-select method-pay-select" data-id="{{ $order->id }}">
                        <option value="0" {{ $order->method_pay == 0 ? 'selected' : '' }}>COD</option>
                        <option value="1" {{ $order->method_pay == 1 ? 'selected' : '' }}>Bank</option>
                        <option value="2" {{ $order->method_pay == 2 ? 'selected' : '' }}>MOMO</option>
                    </select>
                </td>
                <td>
                    <select class="form-select status-order-select" data-id="{{ $order->id }}">
                        <option value="0" {{ $order->status_order == 0 ? 'selected' : '' }}>Chờ xác nhận</option>
                        <option value="1" {{ $order->status_order == 1 ? 'selected' : '' }}>Đang giao</option>
                        <option value="2" {{ $order->status_order == 2 ? 'selected' : '' }}>Hoàn thành</option>
                        <option value="3" {{ $order->status_order == 3 ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </td>
                <td>
                    @if($order->feedbacks->where('user.role', 0)->count() > 0)
                    <a href="{{ route('admin.chat', $order->id) }}" class="btn btn-warning btn-sm">Phản hồi</a>
                    @endif
                </td>

                <td>
                    <a href="{{ route('admin.orders.detail', $order->id) }}" class="btn btn-primary btn-sm">Chi tiết</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.method-pay-select, .status-order-select').forEach(select => {
        select.addEventListener('change', function() {
            const orderId = this.dataset.id;
            const statusOrder = document.querySelector(`.status-order-select[data-id='${orderId}']`).value;
            const methodPay = document.querySelector(`.method-pay-select[data-id='${orderId}']`).value;

            fetch(`/admin/orders/${orderId}/update`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        status_order: statusOrder,
                        method_pay: methodPay
                    })
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
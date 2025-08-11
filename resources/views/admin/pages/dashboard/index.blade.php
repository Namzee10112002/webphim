@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h2>Báo cáo - Thống kê</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Đơn hàng</h5>
                    <p class="card-text fs-4">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Sản phẩm</h5>
                    <p class="card-text fs-4">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Tồn kho</h5>
                    <p class="card-text fs-4">{{ $totalStock }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Đổi trả</h5>
                    <p class="card-text fs-4">{{ $totalReturns }}</p>
                </div>
            </div>
        </div>
    </div>

    <h4>Doanh thu</h4>
    <div class="row mb-3">
        <div class="col-md-6">
            <label>Doanh thu hôm nay:</label>
            <p class="fs-5">{{ number_format($revenueToday) }} VNĐ</p>
        </div>
        <div class="col-md-6">
            <label>Doanh thu tháng này:</label>
            <p class="fs-5">{{ number_format($revenueThisMonth) }} VNĐ</p>
        </div>
    </div>

    <h4>Lọc doanh thu</h4>
    <div class="row mb-4">
        <div class="col-md-4">
            <input type="date" id="filter-day" class="form-control">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" onclick="filterRevenue('day')">Lọc ngày</button>
        </div>
        <div class="col-md-2">
            <select id="filter-month" class="form-select">
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">Tháng {{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" onclick="filterRevenue('month')">Lọc tháng</button>
        </div>
        <div class="col-md-2">
            <p id="revenue-result" class="fs-5 fw-bold"></p>
        </div>
    </div>

    <h4>Chương trình khuyến mãi</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên khuyến mãi</th>
                <th>Giảm (%)</th>
                <th>Số sản phẩm áp dụng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activePromotions as $promo)
            <tr>
                <td>{{ $promo->name_promotion }}</td>
                <td>{{ $promo->value }}%</td>
                <td>{{ $promo->products_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Phản hồi khách hàng</h4>
    <p>Tổng số phản hồi: <strong>{{ $totalFeedbacks }}</strong></p>
</div>
@endsection

@push('scripts')
<script>
    function filterRevenue(type) {
        let value = '';
        if (type === 'day') {
            value = document.getElementById('filter-day').value;
        } else {
            value = document.getElementById('filter-month').value;
        }

        fetch('/admin/dashboard/filter-revenue', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ type: type, value: value })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('revenue-result').innerText = 'Doanh thu: ' + new Intl.NumberFormat().format(data.revenue) + ' VNĐ';
        });
    }
</script>
@endpush

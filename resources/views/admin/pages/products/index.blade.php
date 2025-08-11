@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Danh sách sản phẩm</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success mb-3">Tạo sản phẩm</a>
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Mã sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Giá bán hiện tại</th>
                <th>Số lượng</th>
                <th>Trạng thái</th>
                <th>Lượt bán</th>
                <th>Doanh thu</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr id="product-{{ $product->id }}">
                <td>{{ $product->code_product }}</td>
                <td><img src="{{ $product->image_product }}" alt="" width="60"></td>
                <td>{{ $product->name_product }}</td>
                <td>{{ number_format($product->price) }} VNĐ</td>
                @if($product->status_product == 0 && $product->promotion_id == null)
                    <td>{{ number_format($product->price) }} VNĐ</td>
                @elseif($product->status_product == 1)
                    <td>Đang không bán</td>
                @else
                    <td>{{ number_format($product->price*((100-$product->promotion->value)/100)) }} VNĐ</td>
                @endif    
                <td>{{ $product->quantity }} {{ $product->unit }} </td>
                <td>
                    @if($product->status_product == 0 && $product->promotion_id == null)
                        <span class="badge bg-success">Hiển thị</span>
                    @elseif($product->status_product == 1)
                        <span class="badge bg-secondary">Ẩn</span>
                    @elseif($product->status_product == 0 && $product->promotion_id != null)
                        <span class="badge bg-warning">Đang Sale ({{ $product->promotion->value ?? 0 }}%)</span>
                    @endif
                </td>
                <td>{{ $product->sold }}</td>
                <td>{{ number_format($product->order_details_sum_total_detail ?? 0) }} VNĐ</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                    <button class="btn btn-sm btn-{{ $product->status_product == 0 ? 'danger' : 'success' }} toggle-status-btn" data-id="{{ $product->id }}">
                        {{ $product->status_product == 0 ? 'Ẩn' : 'Hiện' }}
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
    document.querySelectorAll('.toggle-status-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            fetch(`/admin/products/${productId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // reload lại để update status hiển thị
                }
            });
        });
    });
</script>
@endpush

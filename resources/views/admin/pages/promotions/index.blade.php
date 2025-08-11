@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Quản lý Promotion</h2>
    <a href="{{ route('admin.promotions.create') }}" class="btn btn-success mb-3">Tạo Promotion</a>
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Tên Promotion</th>
                <th>Giá trị (%)</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($promotions as $promotion)
            <tr id="promotion-{{ $promotion->id }}">
                <td>{{ $promotion->name_promotion }}</td>
                <td>{{ $promotion->value }}%</td>
                <td>
                    <a href="{{ route('admin.promotions.products', $promotion->id) }}" class="btn btn-primary btn-sm">Xem sản phẩm</a>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $promotion->id }}">Xóa</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (!confirm('Bạn có chắc muốn xóa promotion này?')) return;
            const promotionId = this.dataset.id;
            fetch(`/admin/promotions/${promotionId}/delete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('promotion-' + promotionId).remove();
                }
            });
        });
    });
</script>
@endpush

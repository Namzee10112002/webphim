@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Danh sách sản phẩm gắn Promotion: {{ $promotion->name_promotion }}</h2>

    <h4>Sản phẩm đang sử dụng Promotion</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productsUsing as $product)
            <tr id="product-{{ $product->id }}">
                <td>{{ $product->name_product }}</td>
                <td>
                    <button class="btn btn-danger btn-sm remove-btn" data-id="{{ $product->id }}">Gỡ Promotion</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Gán sản phẩm vào Promotion</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productsNotUsing as $product)
            <tr id="assign-product-{{ $product->id }}">
                <td>{{ $product->name_product }}</td>
                <td>
                    <button class="btn btn-success btn-sm assign-btn" data-id="{{ $product->id }}">Gán vào Promotion</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.remove-btn').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.dataset.id;
        fetch(`/admin/promotions/{{ $promotion->id }}/remove-product/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = document.getElementById('product-' + productId);
                // Remove from "đang sử dụng" table
                row.remove();

                // Add to "chưa gán" table
                const tbodyAssign = document.querySelector('table:nth-of-type(2) tbody');
                const newRow = document.createElement('tr');
                newRow.id = 'assign-product-' + productId;
                newRow.innerHTML = `
                    <td>${row.children[0].innerText}</td>
                    <td>
                        <button class="btn btn-success btn-sm assign-btn" data-id="${productId}">Gán vào Promotion</button>
                    </td>
                `;
                tbodyAssign.appendChild(newRow);

                // Gắn lại sự kiện click cho nút mới
                newRow.querySelector('.assign-btn').addEventListener('click', assignProductHandler);
            }
        });
    });
});

document.querySelectorAll('.assign-btn').forEach(button => {
    button.addEventListener('click', assignProductHandler);
});

function assignProductHandler() {
    const productId = this.dataset.id;
    fetch(`/admin/promotions/{{ $promotion->id }}/assign-product`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = document.getElementById('assign-product-' + productId);
            // Remove from "chưa gán" table
            row.remove();

            // Add to "đang sử dụng" table
            const tbodyUsing = document.querySelector('table:nth-of-type(1) tbody');
            const newRow = document.createElement('tr');
            newRow.id = 'product-' + productId;
            newRow.innerHTML = `
                <td>${row.children[0].innerText}</td>
                <td>
                    <button class="btn btn-danger btn-sm remove-btn" data-id="${productId}">Gỡ Promotion</button>
                </td>
            `;
            tbodyUsing.appendChild(newRow);

            // Gắn lại sự kiện click cho nút mới
            newRow.querySelector('.remove-btn').addEventListener('click', function() {
                const productId = this.dataset.id;
                fetch(`/admin/promotions/{{ $promotion->id }}/remove-product/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.getElementById('product-' + productId);
                        // Remove from "đang sử dụng" table
                        row.remove();

                        // Add back to "chưa gán" table
                        const tbodyAssign = document.querySelector('table:nth-of-type(2) tbody');
                        const newRow = document.createElement('tr');
                        newRow.id = 'assign-product-' + productId;
                        newRow.innerHTML = `
                            <td>${row.children[0].innerText}</td>
                            <td>
                                <button class="btn btn-success btn-sm assign-btn" data-id="${productId}">Gán vào Promotion</button>
                            </td>
                        `;
                        tbodyAssign.appendChild(newRow);
                        newRow.querySelector('.assign-btn').addEventListener('click', assignProductHandler);
                    }
                });
            });
        }
    });
}

</script>
@endpush

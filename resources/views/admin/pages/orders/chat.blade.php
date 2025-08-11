@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h2>Phản hồi đơn hàng #{{ $orderId }}</h2>
    <div id="chat-box" class="border rounded p-3 mb-3" style="height: 400px; overflow-y: auto; background: #f8f9fa;">
        <!-- Tin nhắn sẽ được load ở đây -->
    </div>

    <form id="chat-form">
        <input type="hidden" name="order_id" value="{{ $orderId }}">
        <div class="input-group">
            <input type="text" name="message" class="form-control" placeholder="Nhập tin nhắn..." required>
            <button type="submit" class="btn btn-primary">Gửi</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function loadMessages() {
        fetch('/admin/chat/fetch/{{ $orderId }}', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('chat-box').innerHTML = data;
            document.getElementById('chat-box').scrollTop = document.getElementById('chat-box').scrollHeight;
        })
        .catch(error => console.error('Error loading messages:', error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        setInterval(loadMessages, 3000);
        loadMessages();

        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const orderId = document.querySelector('input[name="order_id"]').value;
            const message = document.querySelector('input[name="message"]').value;

            fetch('/admin/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    order_id: orderId,
                    message: message
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                document.querySelector('input[name="message"]').value = '';
                loadMessages();
            })
            .catch(error => console.error('Error sending message:', error));
        });
    });
</script>
@endpush

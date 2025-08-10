<!-- Icon ChatBot nổi góc dưới -->
<div id="chatbot-icon" style="position: fixed; bottom: 20px; right: 20px; cursor: pointer; z-index: 1000;">
    <img src="https://png.pngtree.com/png-clipart/20230401/original/pngtree-smart-chatbot-cartoon-clipart-png-image_9015126.png" alt="ChatBot" width="60" height="60" style="border-radius: 50%; box-shadow: 0 0 10px rgba(0,0,0,0.3);">
</div>

<!-- Chat Popup (ẩn ban đầu) -->
<div id="chat-popup" style="position: fixed; bottom: 90px; right: 20px; width: 300px; display: none; z-index: 999;">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <strong>Hỗ trợ AI</strong>
            <button id="close-chat" class="btn btn-sm btn-light">&times;</button>
        </div>
        <div class="card-body" style="height: 300px; overflow-y: auto; background: #f8f9fa;" id="chat-box">
            <!-- Nội dung chat sẽ load ở đây -->
        </div>
        <div class="card-footer">
            <form id="chat-form">
                @csrf
                <div class="input-group">
                    <input type="text" name="message" class="form-control" placeholder="Nhập tin nhắn..." required>
                    <button class="btn btn-primary" type="submit">Gửi</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const csrfToken = '{{ csrf_token() }}';

    document.getElementById('chatbot-icon').addEventListener('click', function() {
        document.getElementById('chat-popup').style.display = 'block';
        loadChatHistory();
    });

    document.getElementById('close-chat').addEventListener('click', function() {
        document.getElementById('chat-popup').style.display = 'none';
    });

    // Load lịch sử chat từ session
    function loadChatHistory() {
        fetch('{{ route("chatbot.history") }}')
            .then(response => response.json())
            .then(history => {
                const chatBox = document.getElementById('chat-box');
                chatBox.innerHTML = ''; // Clear old messages
                history.forEach(msg => {
                    appendMessage(msg.message, msg.role === 'user' ? 'self' : 'bot');
                });
                chatBox.scrollTop = chatBox.scrollHeight;
            });
    }

    // Gửi tin nhắn
    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const messageInput = document.querySelector('input[name="message"]');
        const message = messageInput.value.trim();
        if (message === '') return;

        appendMessage(message, 'self'); // Hiển thị ngay tin nhắn user

        fetch('{{ route("chatbot.message") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            appendMessage(data.reply, 'bot');
        });

        messageInput.value = '';
    });

    function appendMessage(message, type) {
        const chatBox = document.getElementById('chat-box');
        const msgDiv = document.createElement('div');
        msgDiv.className = (type === 'self') ? 'text-end mb-2' : 'text-start mb-2';
        msgDiv.innerHTML = `<span class="badge ${type === 'self' ? 'bg-primary' : 'bg-secondary'}">${message}</span>`;
        chatBox.appendChild(msgDiv);
        chatBox.scrollTop = chatBox.scrollHeight;
    }
</script>


{{-- Simple chat component for easy integration --}}
<div class="simple-chat-widget" id="simpleChatWidget">
    <div class="card shadow">
        {{-- Chat Header --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-chat-dots-fill me-2"></i> 
                <span id="chat-title">{{ $title ?? 'Chat' }}</span>
            </div>
            <div>
                <span id="chat-status-indicator" class="status-dot offline" title="Offline"></span>
                <button type="button" class="btn-close btn-close-white ms-2" aria-label="Close"></button>
            </div>
        </div>
        
        {{-- Messages Area --}}
        <div class="card-body p-0">
            <div id="simple-chat-messages" class="chat-messages p-3" style="height: 300px; overflow-y: auto;">
                {{-- Messages will be inserted here by JavaScript --}}
                <div class="text-center text-muted p-3">
                    <small>Start a conversation...</small>
                </div>
            </div>
            
            {{-- Typing Indicator --}}
            <div id="simple-typing-indicator" class="typing-indicator px-3 pb-1 d-none">
                <small class="text-muted"><span>Someone</span> is typing<span class="dots">...</span></small>
            </div>
        </div>
        
        {{-- Message Input --}}
        <div class="card-footer p-2">
            <form id="simple-chat-form">
                <div class="input-group">
                    <input type="text" id="simple-chat-input" class="form-control" placeholder="Type a message...">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    {{-- Notification Sound --}}
    <audio id="chat-notification-sound" preload="auto">
        <source src="{{ asset('sounds/notification.mp3') }}" type="audio/mpeg">
    </audio>
</div>

<style>
    /* Simple styles for chat widget */
    .simple-chat-widget {
        max-width: 350px;
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1050;
    }
    
    .status-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }
    
    .status-dot.online {
        background-color: #28a745;
        box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
    }
    
    .status-dot.offline {
        background-color: #dc3545;
    }
    
    .status-dot.typing {
        background-color: #ffc107;
        animation: pulse 1s infinite;
    }
    
    .message-bubble {
        max-width: 80%;
        border-radius: 16px;
        padding: 8px 12px;
        margin-bottom: 8px;
        word-break: break-word;
    }
    
    .message-outgoing {
        background-color: #dcf8c6;
        margin-left: auto;
    }
    
    .message-incoming {
        background-color: #f1f1f1;
    }
    
    .typing-indicator .dots {
        display: inline-block;
        width: 12px;
    }
    
    @keyframes pulse {
        0% { opacity: 0.5; }
        50% { opacity: 1; }
        100% { opacity: 0.5; }
    }
    
    @keyframes blink {
        0% { opacity: 0.2; }
        20% { opacity: 1; }
        100% { opacity: 0.2; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Simple Chat
    initializeSimpleChat({
        userId: {{ auth()->id() }},
        userName: "{{ auth()->user()->name }}",
        roomId: {{ $roomId ?? 'null' }},
        token: "{{ csrf_token() }}",
        sendUrl: "{{ route('chat.sendMessage') }}",
        messagesUrl: "{{ $roomId ? route('chat.getMessages', $roomId) : '' }}"
    });
});

function initializeSimpleChat(config) {
    const chatForm = document.getElementById('simple-chat-form');
    const chatInput = document.getElementById('simple-chat-input');
    const messagesContainer = document.getElementById('simple-chat-messages');
    const typingIndicator = document.getElementById('simple-typing-indicator');
    const statusIndicator = document.getElementById('chat-status-indicator');
    const notificationSound = document.getElementById('chat-notification-sound');
    
    // Clear messages container
    messagesContainer.innerHTML = '';
    
    // Load existing messages if room ID is provided
    if (config.roomId && config.messagesUrl) {
        fetch(config.messagesUrl)
            .then(response => response.json())
            .then(data => {
                if (data.messages && data.messages.length > 0) {
                    data.messages.forEach(message => {
                        addMessageToChatSimple(message, config.userId);
                    });
                    scrollToBottomSimple();
                } else {
                    messagesContainer.innerHTML = '<div class="text-center text-muted p-3"><small>No messages yet</small></div>';
                }
            })
            .catch(error => {
                console.error('Error loading messages:', error);
                messagesContainer.innerHTML = '<div class="text-center text-danger p-3"><small>Failed to load messages</small></div>';
            });
    }
    
    // Connect to WebSocket
    if (typeof window.Echo !== 'undefined') {
        // Listen for private user notifications
        window.Echo.private(`App.Models.User.${config.userId}`)
            .notification((notification) => {
                if (notification.type === 'App\\Notifications\\NewChatMessage') {
                    // Show notification
                    showBrowserNotification('New Message', notification.message);
                    
                    // Play sound
                    if (notificationSound) {
                        notificationSound.play().catch(e => console.log('Sound play error:', e));
                    }
                }
            });
            
        // If in a chat room, listen for messages
        if (config.roomId) {
            window.Echo.private(`chat.room.${config.roomId}`)
                .listen('.new.message', (e) => {
                    addMessageToChatSimple(e.message, config.userId);
                    scrollToBottomSimple();
                    
                    // Play sound for incoming messages
                    if (e.message.user_id != config.userId && notificationSound) {
                        notificationSound.play().catch(e => console.log('Sound play error:', e));
                    }
                })
                .listen('.typing', (e) => {
                    if (e.user.id != config.userId) {
                        showTypingIndicatorSimple(e.user.name);
                    }
                });
        }
        
        // Listen for user status changes
        window.Echo.channel('user.status')
            .listen('.status.update', (e) => {
                updateStatusIndicatorSimple(e.status);
            });
    }
    
    // Handle form submission
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const message = chatInput.value.trim();
        if (!message || !config.roomId) return;
        
        // Send message
        fetch(config.sendUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': config.token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                room_id: config.roomId,
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                chatInput.value = '';
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
        });
    });
    
    // Typing indicator
    let typingTimer;
    chatInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        
        // Send typing status if room ID exists
        if (config.roomId) {
            fetch('/chat/status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': config.token
                },
                body: JSON.stringify({
                    status: 'typing',
                    room_id: config.roomId
                })
            }).catch(error => console.error('Error sending typing status:', error));
        }
        
        // Clear typing status after delay
        typingTimer = setTimeout(function() {
            if (config.roomId) {
                fetch('/chat/status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': config.token
                    },
                    body: JSON.stringify({
                        status: 'online',
                        room_id: config.roomId
                    })
                }).catch(error => console.error('Error sending online status:', error));
            }
        }, 1000);
    });
    
    // Helper functions
    function addMessageToChatSimple(message, currentUserId) {
        const isOutgoing = message.user_id == currentUserId;
        
        const messageDiv = document.createElement('div');
        messageDiv.className = 'd-flex ' + (isOutgoing ? 'justify-content-end' : 'justify-content-start');
        
        messageDiv.innerHTML = `
            <div class="message-bubble ${isOutgoing ? 'message-outgoing' : 'message-incoming'}">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="fw-bold">${message.user ? message.user.name : 'User'}</small>
                    <small class="text-muted ms-2">${formatTimeSimple(message.created_at)}</small>
                </div>
                <div>${message.message}</div>
            </div>
        `;
        
        messagesContainer.appendChild(messageDiv);
    }
    
    function showTypingIndicatorSimple(userName) {
        typingIndicator.querySelector('span').textContent = userName || 'Someone';
        typingIndicator.classList.remove('d-none');
        
        // Hide after 3 seconds
        clearTimeout(window.typingTimerSimple);
        window.typingTimerSimple = setTimeout(() => {
            typingIndicator.classList.add('d-none');
        }, 3000);
    }
    
    function updateStatusIndicatorSimple(status) {
        statusIndicator.className = 'status-dot ' + status;
        statusIndicator.title = status.charAt(0).toUpperCase() + status.slice(1);
    }
    
    function scrollToBottomSimple() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
    
    function formatTimeSimple(timestamp) {
        const date = new Date(timestamp);
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }
    
    function showBrowserNotification(title, message) {
        if ('Notification' in window && Notification.permission === 'granted') {
            const notification = new Notification(title, {
                body: message,
                icon: '/favicon.ico'
            });
            
            notification.onclick = function() {
                window.focus();
                this.close();
            };
            
            setTimeout(notification.close.bind(notification), 5000);
        }
    }
    
    // Request notification permission
    if ('Notification' in window && Notification.permission !== 'granted' && Notification.permission !== 'denied') {
        Notification.requestPermission();
    }
}
</script>

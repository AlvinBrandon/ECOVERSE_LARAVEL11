/**
 * EcoVerse Chat Functions
 * Simple methods to handle real-time chat with notifications
 */

// Initialize chat functionality
function initializeChat(userId, roomId) {
    console.log('Initializing chat for user:', userId, 'in room:', roomId);
    
    // Connect to WebSocket and listen for messages
    listenForMessages(userId, roomId);
    
    // Request notification permission
    requestNotificationPermission();
    
    // Setup message form submission
    setupMessageForm();
    
    // Mark messages as read when chat is opened
    markMessagesAsRead(roomId);
}

// Request permission for browser notifications
function requestNotificationPermission() {
    if ('Notification' in window) {
        if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
            Notification.requestPermission().then(function(permission) {
                if (permission === 'granted') {
                    console.log('Notification permission granted!');
                }
            });
        }
    }
}

// Listen for new messages via WebSockets
function listenForMessages(userId, roomId) {
    if (typeof window.Echo !== 'undefined') {
        // Listen for notifications to the user (for all rooms)
        window.Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                if (notification.type === 'App\\Notifications\\NewChatMessage') {
                    // Update the chat notification count in the navbar
                    updateChatNotificationCount(1);
                    
                    // Show browser notification if not in the same room
                    if (notification.room_id != roomId) {
                        const title = notification.title || '🔔 New Message';
                        const message = notification.message || 'You have a new message';
                        showBrowserNotification(title, message);
                    }
                }
            });
        
        // Listen for messages in the current room
        if (roomId) {
            window.Echo.private(`chat.room.${roomId}`)
                .listen('.new.message', (e) => {
                    // Add the message to the chat
                    appendMessage(e.message);
                    
                    // Play sound for new message
                    playMessageSound(e.message.user_id == userId);
                    
                    // Scroll to the bottom
                    scrollToBottom();
                })
                .listen('.typing', (e) => {
                    // Show typing indicator
                    if (e.user.id != userId) {
                        showTypingIndicator(e.user);
                    }
                });
        }
        
        // Listen for user status updates
        window.Echo.channel('user.status')
            .listen('.status.update', (e) => {
                updateUserStatus(e.user.id, e.status);
            });
    }
}

// Display browser notification
function showBrowserNotification(title, message) {
    if ('Notification' in window && Notification.permission === 'granted') {
        const notification = new Notification('🔔 ' + title, {
            body: '💬 ' + message,
            icon: '/favicon.ico'
        });
        
        notification.onclick = function() {
            window.focus();
            this.close();
        };
        
        // Auto close after 5 seconds
        setTimeout(notification.close.bind(notification), 5000);
    }
}

// Add a message to the chat
function appendMessage(message) {
    const messagesContainer = document.getElementById('messages-list');
    if (!messagesContainer) return;
    
    const userId = document.body.dataset.userId;
    const isOutgoing = message.user_id == userId;
    
    // Create message element
    const messageDiv = document.createElement('div');
    messageDiv.className = isOutgoing ? 'message outgoing text-end mb-3' : 'message incoming mb-3';
    messageDiv.id = `message-${message.id}`;
    
    // Determine background color based on user role
    let bgClass = 'bg-light';
    let textClass = '';
    
    if (isOutgoing) {
        bgClass = 'bg-primary';
        textClass = 'text-white';
    } else if (message.user && message.user.role === 'admin') {
        bgClass = 'bg-success';
        textClass = 'text-white';
    }
    
    // Format the message HTML
    messageDiv.innerHTML = `
        <div class="message-content d-inline-block ${bgClass} ${textClass} p-2 rounded">
            <div class="message-header">
                <strong>${message.user ? message.user.name : 'User'}</strong>
                <small class="ms-2">${formatTime(message.created_at || new Date())}</small>
            </div>
            <div class="message-body">
                ${message.message}
            </div>
        </div>
    `;
    
    // Add to container
    messagesContainer.appendChild(messageDiv);
    
    // Highlight new message with animation
    messageDiv.style.animation = 'fadeIn 0.5s';
}

// Show typing indicator
function showTypingIndicator(user) {
    const typingIndicator = document.getElementById('typing-indicator');
    if (!typingIndicator) return;
    
    // Set typing text
    typingIndicator.innerHTML = `<strong>${user.name}</strong> is typing...`;
    typingIndicator.classList.remove('d-none');
    
    // Hide after 3 seconds
    clearTimeout(window.typingTimeout);
    window.typingTimeout = setTimeout(() => {
        typingIndicator.classList.add('d-none');
    }, 3000);
}

// Play sound when message received/sent
function playMessageSound(isSent) {
    const soundId = isSent ? 'message-sent-sound' : 'message-received-sound';
    const sound = document.getElementById(soundId);
    
    if (sound) {
        sound.play().catch(e => console.log('Sound play prevented by browser policy'));
    }
}

// Setup message form submission with AJAX
function setupMessageForm() {
    const messageForm = document.getElementById('message-form');
    if (!messageForm) return;
    
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const messageInput = this.querySelector('input[name="message"]');
        const message = messageInput.value.trim();
        
        if (!message) return;
        
        // Get CSRF token
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Send with fetch API
        fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                message: message,
                parent_id: document.getElementById('parent-id')?.value || null,
                is_feedback: document.getElementById('is-feedback')?.value || '0'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear input
                messageInput.value = '';
                
                // Clear reply info if present
                if (document.getElementById('reply-container')) {
                    document.getElementById('reply-container').classList.add('d-none');
                    document.getElementById('parent-id').value = '';
                }
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
        });
    });
    
    // Handle typing indicator
    const messageInput = messageForm.querySelector('input[name="message"]');
    let typingTimer;
    const roomId = document.body.dataset.roomId;
    
    messageInput.addEventListener('input', function() {
        // Clear previous timeout
        clearTimeout(typingTimer);
        
        // Send typing status
        sendTypingStatus(roomId, true);
        
        // Set timeout to clear typing status
        typingTimer = setTimeout(function() {
            sendTypingStatus(roomId, false);
        }, 1000);
    });
}

// Send typing status to server
function sendTypingStatus(roomId, isTyping) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/chat/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            status: isTyping ? 'typing' : 'online',
            room_id: roomId
        })
    }).catch(error => {
        console.error('Error sending typing status:', error);
    });
}

// Mark messages as read when chat is opened
function markMessagesAsRead(roomId) {
    if (!roomId) return;
    
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/chat/messages/${roomId}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        }
    }).then(() => {
        // Reset notification count
        document.querySelectorAll('.chat-badge').forEach(badge => {
            badge.textContent = '0';
            badge.classList.add('d-none');
        });
    }).catch(error => {
        console.error('Error marking messages as read:', error);
    });
}

// Update chat notification count in navbar
function updateChatNotificationCount(increment = 1) {
    const chatBadge = document.querySelector('#chatMenuButton .badge');
    
    if (chatBadge) {
        const currentCount = parseInt(chatBadge.textContent.trim()) || 0;
        chatBadge.textContent = currentCount + increment;
        chatBadge.classList.remove('d-none');
    } else {
        // Create new badge if it doesn't exist
        const chatButton = document.querySelector('#chatMenuButton');
        if (chatButton) {
            const badge = document.createElement('span');
            badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
            badge.textContent = increment;
            
            const visually_hidden = document.createElement('span');
            visually_hidden.className = 'visually-hidden';
            visually_hidden.textContent = 'unread messages';
            
            badge.appendChild(visually_hidden);
            chatButton.appendChild(badge);
        }
    }
}

// Update user online status in UI
function updateUserStatus(userId, status) {
    const statusIndicators = document.querySelectorAll(`.user-status-${userId}`);
    statusIndicators.forEach(indicator => {
        indicator.className = `user-status user-status-${userId} ${status}`;
        indicator.title = status === 'online' ? 'Online' : 'Offline';
    });
}

// Scroll chat to bottom
function scrollToBottom() {
    const chatMessages = document.getElementById('chat-messages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}

// Format time for display
function formatTime(timestamp) {
    const date = new Date(timestamp);
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

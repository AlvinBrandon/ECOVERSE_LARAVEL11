/**
 * EcoVerse Chat Polling System
 * 
 * This script implements polling for chat messages, online status,
 * typing indicators, and unread messages count.
 */

class EcoVerseChat {
    /**
     * Initialize the chat system
     * 
     * @param {Object} options Configuration options
     */
    constructor(options = {}) {
        // Default configuration
        this.config = {
            messagesPollInterval: 3000,
            usersPollInterval: 10000,
            typingPollInterval: 2000,
            unreadPollInterval: 15000,
            messagesEndpoint: '/chat/poll/messages',
            sendMessageEndpoint: '/chat/poll/send',
            onlineUsersEndpoint: '/chat/poll/online-users',
            typingEndpoint: '/chat/poll/typing',
            typingUsersEndpoint: '/chat/poll/typing-users',
            unreadCountEndpoint: '/chat/poll/unread-count',
            markReadEndpoint: '/chat/poll/mark-read',
            messageContainer: '#messages-list',
            messageForm: '#message-form',
            messageInput: '#message-input',
            sendButton: '#send-button',
            onlineUsersContainer: '#online-users',
            typingIndicator: '#typing-indicator',
            unreadBadge: '#unread-badge',
            notificationSound: '/sounds/notification.mp3',
            ...options
        };

        // Initialize properties
        this.currentRoomId = null;
        this.lastMessageId = 0;
        this.userId = null;
        this.typingTimeout = null;
        this.isTyping = false;
        this.messagesPollInterval = null;
        this.usersPollInterval = null;
        this.typingPollInterval = null;
        this.unreadPollInterval = null;
        this.unreadMessages = [];
        this.audio = new Audio(this.config.notificationSound);
        
        // Initialize the chat if we have a room ID
        const roomIdElement = document.querySelector('[data-room-id]');
        if (roomIdElement) {
            this.currentRoomId = roomIdElement.dataset.roomId;
            this.userId = document.querySelector('[data-user-id]')?.dataset.userId || 
                          document.body.getAttribute('data-user-id');
            this.init();
        }
    }
    
    /**
     * Initialize the chat polling system
     */
    init() {
        if (!this.currentRoomId) return;
        
        // Setup message form
        const form = document.querySelector(this.config.messageForm);
        if (form) {
            form.addEventListener('submit', (e) => this.handleSubmit(e));
        }
        
        // Setup typing indicator
        const input = document.querySelector(this.config.messageInput);
        if (input) {
            input.addEventListener('input', () => this.handleTyping());
        }
        
        // Start polling for messages
        this.startMessagePolling();
        
        // Start polling for online users
        this.startOnlineUsersPolling();
        
        // Start polling for typing users
        this.startTypingPolling();
        
        // Start polling for unread count
        this.startUnreadCountPolling();
    }
    
    /**
     * Start polling for new messages
     */
    startMessagePolling() {
        this.fetchMessages(); // Fetch immediately
        
        // Then poll at intervals
        this.messagesPollInterval = setInterval(() => {
            this.fetchMessages();
        }, this.config.messagesPollInterval);
    }
    
    /**
     * Start polling for online users
     */
    startOnlineUsersPolling() {
        this.fetchOnlineUsers(); // Fetch immediately
        
        // Then poll at intervals
        this.usersPollInterval = setInterval(() => {
            this.fetchOnlineUsers();
        }, this.config.usersPollInterval);
    }
    
    /**
     * Start polling for typing users
     */
    startTypingPolling() {
        this.fetchTypingUsers(); // Fetch immediately
        
        // Then poll at intervals
        this.typingPollInterval = setInterval(() => {
            this.fetchTypingUsers();
        }, this.config.typingPollInterval);
    }
    
    /**
     * Start polling for unread message count
     */
    startUnreadCountPolling() {
        this.fetchUnreadCount(); // Fetch immediately
        
        // Then poll at intervals
        this.unreadPollInterval = setInterval(() => {
            this.fetchUnreadCount();
        }, this.config.unreadPollInterval);
    }
    
    /**
     * Fetch messages from the server
     */
    async fetchMessages() {
        if (!this.currentRoomId) return;
        
        try {
            const response = await fetch(`${this.config.messagesEndpoint}?room_id=${this.currentRoomId}&last_id=${this.lastMessageId}`);
            const data = await response.json();
            
            if (data.messages && data.messages.length > 0) {
                this.appendMessages(data.messages);
                this.lastMessageId = data.last_id || this.lastMessageId;
                
                // Play notification sound for new messages that aren't mine
                const newMessages = data.messages.filter(msg => !msg.is_mine);
                if (newMessages.length > 0) {
                    this.playNotification();
                }
            }
        } catch (error) {
            console.error('Error fetching messages:', error);
        }
    }
    
    /**
     * Fetch online users from the server
     */
    async fetchOnlineUsers() {
        try {
            const response = await fetch(this.config.onlineUsersEndpoint);
            const data = await response.json();
            
            if (data.users) {
                this.updateOnlineUsers(data.users);
            }
        } catch (error) {
            console.error('Error fetching online users:', error);
        }
    }
    
    /**
     * Fetch typing users from the server
     */
    async fetchTypingUsers() {
        if (!this.currentRoomId) return;
        
        try {
            const response = await fetch(`${this.config.typingUsersEndpoint}?room_id=${this.currentRoomId}`);
            const data = await response.json();
            
            if (data.typing_users) {
                this.updateTypingIndicator(data.typing_users);
            }
        } catch (error) {
            console.error('Error fetching typing users:', error);
        }
    }
    
    /**
     * Fetch unread message count from the server
     */
    async fetchUnreadCount() {
        try {
            const response = await fetch(this.config.unreadCountEndpoint);
            const data = await response.json();
            
            if (data.unread_count !== undefined) {
                this.updateUnreadBadge(data.unread_count);
            }
        } catch (error) {
            console.error('Error fetching unread count:', error);
        }
    }
    
    /**
     * Handle form submission for sending a message
     * 
     * @param {Event} e Submit event
     */
    async handleSubmit(e) {
        e.preventDefault();
        
        const form = e.target;
        const input = form.querySelector(this.config.messageInput);
        const message = input.value.trim();
        
        if (!message || !this.currentRoomId) return;
        
        try {
            const formData = new FormData();
            formData.append('room_id', this.currentRoomId);
            formData.append('message', message);
            
            const response = await fetch(this.config.sendMessageEndpoint, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Clear input field
                input.value = '';
                
                // Reset typing status
                this.updateTypingStatus(false);
                
                // Optionally, you can add the message immediately without waiting for polling
                if (data.message) {
                    this.appendMessages([data.message]);
                    this.lastMessageId = data.message.id;
                }
            }
        } catch (error) {
            console.error('Error sending message:', error);
        }
    }
    
    /**
     * Handle typing event in the message input
     */
    handleTyping() {
        if (!this.isTyping) {
            this.isTyping = true;
            this.updateTypingStatus(true);
        }
        
        // Clear existing timeout
        if (this.typingTimeout) {
            clearTimeout(this.typingTimeout);
        }
        
        // Set a new timeout
        this.typingTimeout = setTimeout(() => {
            this.isTyping = false;
            this.updateTypingStatus(false);
        }, 3000);
    }
    
    /**
     * Update typing status on the server
     * 
     * @param {boolean} isTyping Whether the user is typing or not
     */
    async updateTypingStatus(isTyping) {
        if (!this.currentRoomId) return;
        
        try {
            const formData = new FormData();
            formData.append('room_id', this.currentRoomId);
            formData.append('is_typing', isTyping ? '1' : '0');
            
            await fetch(this.config.typingEndpoint, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
        } catch (error) {
            console.error('Error updating typing status:', error);
        }
    }
    
    /**
     * Append messages to the message container
     * 
     * @param {Array} messages Array of message objects
     */
    appendMessages(messages) {
        const container = document.querySelector(this.config.messageContainer);
        if (!container) return;
        
        messages.forEach(message => {
            // Check if message is already in the container
            if (document.getElementById(`message-${message.id}`)) {
                return;
            }
            
            const messageElement = document.createElement('div');
            messageElement.id = `message-${message.id}`;
            messageElement.classList.add('message', 'mb-3');
            
            // Determine message styling based on properties
            let messageClass = 'bg-light';
            let textClass = '';
            
            if (message.is_mine) {
                messageElement.classList.add('text-end');
                messageClass = 'bg-primary';
                textClass = 'text-white';
            } else if (message.role === 'admin' && message.is_feedback) {
                messageClass = 'bg-warning';
            } else if (message.role === 'admin') {
                messageClass = 'bg-success';
                textClass = 'text-white';
            }
            
            // Build parent message reply content if exists
            let replyHtml = '';
            if (message.parent) {
                replyHtml = `
                <div class="replied-message border-start border-3 ps-2 my-2 small">
                    <div class="fw-bold">
                        Replying to ${this.escapeHtml(message.parent.username)}:
                    </div>
                    <div class="text-muted">
                        "${this.escapeHtml(message.parent.message.substring(0, 100))}"
                    </div>
                </div>`;
            }
            
            // Admin action buttons
            let actionButtons = '';
            if (this.userId && document.body.getAttribute('data-user-role') === 'admin') {
                actionButtons = `
                <div class="message-actions mt-2">
                    <button class="btn btn-sm btn-light reply-btn" 
                        onclick="replyToMessage('${message.id}', '${this.escapeHtml(message.username)}')">
                        <i class="bi bi-reply"></i> Reply
                    </button>
                    
                    ${message.role !== 'admin' ? `
                    <button class="btn btn-sm btn-light feedback-btn" 
                        onclick="provideFeedback('${message.id}', '${this.escapeHtml(message.username)}')">
                        <i class="bi bi-chat-square-text"></i> Give Feedback
                    </button>` : ''}
                </div>`;
            }
            
            // Build badge content
            let badgeHtml = '';
            if (message.role === 'admin') {
                badgeHtml += `<span class="badge bg-warning text-dark ms-1">Admin</span>`;
            }
            if (message.is_feedback) {
                badgeHtml += `<span class="badge bg-info text-dark ms-1">Feedback</span>`;
            }
            
            messageElement.innerHTML = `
                <div class="message-content d-inline-block ${messageClass} ${textClass} p-2 rounded">
                    <div class="message-header">
                        <strong>${this.escapeHtml(message.username)}</strong>
                        ${badgeHtml}
                        <small class="ms-2">${message.created_at}</small>
                    </div>
                    
                    ${replyHtml}
                    
                    <div class="message-body">
                        ${this.escapeHtml(message.message)}
                    </div>
                    
                    ${actionButtons}
                </div>
            `;
            
            container.appendChild(messageElement);
        });
        
        // Scroll to bottom
        container.scrollTop = container.scrollHeight;
    }
    
    /**
     * Update the online users list
     * 
     * @param {Array} users Array of online user objects
     */
    updateOnlineUsers(users) {
        const container = document.querySelector(this.config.onlineUsersContainer);
        if (!container) return;
        
        // Clear existing content
        container.innerHTML = '';
        
        users.forEach(user => {
            const userElement = document.createElement('div');
            userElement.classList.add('online-user');
            userElement.dataset.userId = user.id;
            
            userElement.innerHTML = `
                <div class="online-user-avatar">
                    <span class="avatar-text">${this.getInitials(user.name)}</span>
                    <span class="status-indicator ${user.online ? 'online' : 'offline'}"></span>
                </div>
                <div class="online-user-info">
                    <div class="online-user-name">${this.escapeHtml(user.name)}</div>
                    <div class="online-user-status">${user.online ? 'Online' : 'Last seen ' + user.last_seen}</div>
                </div>
            `;
            
            container.appendChild(userElement);
        });
    }
    
    /**
     * Update the typing indicator
     * 
     * @param {Array} typingUsers Array of user IDs who are typing
     */
    updateTypingIndicator(typingUsers) {
        const indicator = document.querySelector(this.config.typingIndicator);
        if (!indicator) return;
        
        // Filter out current user
        typingUsers = typingUsers.filter(userId => userId !== this.userId);
        
        if (typingUsers.length > 0) {
            indicator.style.display = 'block';
            
            if (typingUsers.length === 1) {
                indicator.textContent = 'Someone is typing...';
            } else {
                indicator.textContent = 'Several people are typing...';
            }
        } else {
            indicator.style.display = 'none';
        }
    }
    
    /**
     * Update the unread message badge
     * 
     * @param {number} count Number of unread messages
     */
    updateUnreadBadge(count) {
        const badge = document.querySelector(this.config.unreadBadge);
        if (!badge) return;
        
        if (count > 0) {
            badge.style.display = 'block';
            badge.textContent = count > 99 ? '99+' : count;
        } else {
            badge.style.display = 'none';
        }
    }
    
    /**
     * Play notification sound
     */
    playNotification() {
        if (this.audio) {
            this.audio.currentTime = 0;
            this.audio.play().catch(error => {
                console.error('Error playing notification sound:', error);
            });
        }
    }
    
    /**
     * Get initials from a name
     * 
     * @param {string} name Full name
     * @returns {string} Initials (up to 2 characters)
     */
    getInitials(name) {
        if (!name) return '?';
        
        return name
            .split(' ')
            .map(word => word[0])
            .join('')
            .toUpperCase()
            .substr(0, 2);
    }
    
    /**
     * Escape HTML to prevent XSS
     * 
     * @param {string} html HTML string to escape
     * @returns {string} Escaped HTML
     */
    escapeHtml(html) {
        const div = document.createElement('div');
        div.textContent = html;
        return div.innerHTML;
    }
    
    /**
     * Clean up resources when closing the chat
     */
    destroy() {
        // Clear all intervals
        if (this.messagesPollInterval) clearInterval(this.messagesPollInterval);
        if (this.usersPollInterval) clearInterval(this.usersPollInterval);
        if (this.typingPollInterval) clearInterval(this.typingPollInterval);
        if (this.unreadPollInterval) clearInterval(this.unreadPollInterval);
        
        // Clear typing timeout
        if (this.typingTimeout) clearTimeout(this.typingTimeout);
        
        // Reset properties
        this.currentRoomId = null;
        this.lastMessageId = 0;
        this.isTyping = false;
    }
}

// Initialize the chat when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.ecoVerseChat = new EcoVerseChat();
});

// Global function for sending messages
function sendMessage() {
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const roomIdInput = document.querySelector('input[name="room_id"]');
    // Prevent sending if already disabled
    const sendButton = document.getElementById('send-button');
    if (sendButton.disabled || messageInput.disabled) {
        return;
    }
    
    // Try to get room ID from multiple sources
    let roomId = null;
    
    if (roomIdInput) {
        roomId = roomIdInput.value;
        console.log('Room ID from input:', roomId);
    }
    
    // If not found, try getting it from chat container
    if (!roomId) {
        const chatContainer = document.querySelector('#chat-container');
        if (chatContainer && chatContainer.dataset.roomId) {
            roomId = chatContainer.dataset.roomId;
            console.log('Room ID from container:', roomId);
        }
    }
    
    const message = messageInput.value.trim();
    const parentId = document.getElementById('parent-id')?.value || '';
    const isFeedback = document.getElementById('is-feedback')?.value || '0';
    
    console.log('Debug info:', { roomId, message, parentId, isFeedback });
    
    if (!message) {
        console.error('Missing message');
        return;
    }
    
    if (!roomId) {
        console.error('Missing room ID');
        alert('Could not determine chat room. Please refresh the page and try again.');
        return;
    }
    
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    if (!csrfMeta) {
        console.error('CSRF token meta tag not found');
        alert('Security token missing. Please refresh the page.');
        return;
    }
    const csrfToken = csrfMeta.content;
    
    // Use FormData to match controller expectations
    const formData = new FormData();
    formData.append('room_id', roomId);
    formData.append('message', message);
    formData.append('parent_id', parentId);
    formData.append('is_feedback', isFeedback);
    
    // Debug info
    console.log('Form data:', {
        room_id: roomId,
        message: message,
        parent_id: parentId,
        is_feedback: isFeedback
    });
    
    // Add loading indicator
    const originalButtonHTML = sendButton.innerHTML;
    sendButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...';
    sendButton.disabled = true;
    messageInput.disabled = true;
    
    fetch('/chat/poll/send', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            console.log('Message sent successfully:', data);
            
            // Clear input field
            messageInput.value = '';
            
            // Reset parent message and feedback state
            if (document.getElementById('parent-id')) document.getElementById('parent-id').value = '';
            if (document.getElementById('is-feedback')) document.getElementById('is-feedback').value = '0';
            
            // Hide reply/feedback containers if they're visible
            const replyContainer = document.getElementById('reply-container');
            const feedbackContainer = document.getElementById('feedback-container');
            if (replyContainer) replyContainer.classList.add('d-none');
            if (feedbackContainer) feedbackContainer.classList.add('d-none');
            
            // Add the message to the UI immediately for better UX
            if (data.message) {
                // Check if we have an ecoVerseChat instance
                if (window.ecoVerseChat) {
                    window.ecoVerseChat.appendMessages([data.message]);
                    window.ecoVerseChat.lastMessageId = data.message.id;
                } else {
                    // Manually append the message
                    const messagesContainer = document.querySelector('#messages-list');
                    if (messagesContainer) {
                        const messageElement = document.createElement('div');
                        messageElement.id = `message-${data.message.id}`;
                        messageElement.classList.add('message', 'text-end', 'mb-3');
                        
                        messageElement.innerHTML = `
                            <div class="message-content d-inline-block bg-primary text-white p-2 rounded">
                                <div class="message-header">
                                    <strong>${data.message.username}</strong>
                                    ${data.message.role === 'admin' ? '<span class="badge bg-warning text-dark ms-1">Admin</span>' : ''}
                                    ${data.message.is_feedback ? '<span class="badge bg-info text-dark ms-1">Feedback</span>' : ''}
                                    <small class="ms-2">${data.message.created_at}</small>
                                </div>
                                
                                <div class="message-body">
                                    ${data.message.message}
                                </div>
                            </div>
                        `;
                        
                        messagesContainer.appendChild(messageElement);
                    }
                }
                
                // Scroll to bottom
                const chatContainer = document.querySelector('#chat-container');
                if (chatContainer) {
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
            }
        } else {
            console.error('Error sending message:', data);
            alert('Failed to send your message. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error sending message:', error);
        alert('An error occurred while sending your message. Please try again.');
    })
    .finally(() => {
        // Restore button and input state
        sendButton.innerHTML = originalButtonHTML;
        sendButton.disabled = false;
        messageInput.disabled = false;
    });
}

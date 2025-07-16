/**
 * Helper function to mark messages as read
 * This should be called by the frontend when user is viewing messages
 */
function markMessagesAsRead() {
    const chatContainer = document.querySelector('#chat-container') || document.querySelector('[data-room-id]');
    if (!chatContainer) return;
    
    const roomId = chatContainer.dataset.roomId;
    if (!roomId) return;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }
    
    fetch('/chat/poll/mark-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            room_id: roomId
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Messages marked as read:', data.marked_count);
        
        // Update any UI that shows unread counts
        const unreadBadge = document.querySelector('#unread-badge');
        if (unreadBadge) {
            unreadBadge.style.display = 'none';
        }
    })
    .catch(error => {
        console.error('Error marking messages as read:', error);
    });
}

// Update the window.onload to include marking messages as read
document.addEventListener('DOMContentLoaded', () => {
    // Existing code to initialize chat
    window.ecoVerseChat = new EcoVerseChat();
    
    // Mark messages as read when opening a chat room
    const chatContainer = document.querySelector('#chat-container');
    if (chatContainer) {
        markMessagesAsRead();
        
        // Also mark as read when user scrolls or interacts with the chat
        chatContainer.addEventListener('scroll', debounce(markMessagesAsRead, 1000));
        chatContainer.addEventListener('click', debounce(markMessagesAsRead, 1000));
    }
});

// Utility debounce function to prevent too many API calls
function debounce(func, wait) {
    let timeout;
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            func.apply(context, args);
        }, wait);
    };
}

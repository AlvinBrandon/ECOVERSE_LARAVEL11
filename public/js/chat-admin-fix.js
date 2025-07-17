/**
 * Admin Chat Send Button Fix
 * This script ensures the admin chat send button works correctly
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin chat send button fix loaded');
    
    // Check if we're on the chat admin page
    const messageForm = document.getElementById('message-form');
    if (!messageForm) {
        console.log('Not on a chat page with message form');
        return;
    }
    
    console.log('Message form found:', messageForm);
    
    // Find the send button
    const sendButton = document.getElementById('send-button');
    console.log('Send button found:', sendButton);
    
    // Add a direct click handler to the button
    if (sendButton) {
        console.log('Adding click handler to send button');
        
        sendButton.onclick = function(e) {
            e.preventDefault();
            console.log('Send button clicked directly');
            
            // Check if global sendMessage function exists
            if (typeof sendMessage === 'function') {
                sendMessage();
            } else {
                console.error('sendMessage function not found');
                alert('Error: Message sending function not available');
            }
            
            return false;
        };
    }
    
    // Add form submit handler
    messageForm.onsubmit = function(e) {
        e.preventDefault();
        console.log('Form submitted directly');
        
        const messageInput = document.getElementById('message-input');
        if (!messageInput || messageInput.value.trim() === '') {
            console.log('No message to send');
            return false;
        }
        
        // Check if global sendMessage function exists
        if (typeof sendMessage === 'function') {
            sendMessage();
        } else {
            console.error('sendMessage function not found');
            // Try to send manually if the function doesn't exist
            sendMessageManually();
        }
        
        return false;
    };
    
    // Backup function in case the main one isn't available
    function sendMessageManually() {
        const messageInput = document.getElementById('message-input');
        const message = messageInput.value.trim();
        const parentId = document.getElementById('parent-id')?.value || '';
        const isFeedback = document.getElementById('is-feedback')?.value || '0';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        if (!message || !csrfToken) return;
        
        // Get room ID from the form or data attribute
        let roomId;
        const roomIdInput = document.querySelector('input[name="room_id"]');
        if (roomIdInput) {
            roomId = roomIdInput.value;
        } else {
            // Try to get from URL path
            const pathSegments = window.location.pathname.split('/');
            roomId = pathSegments[pathSegments.length - 1];
        }
        
        if (!roomId || isNaN(parseInt(roomId))) {
            console.error('Could not determine room ID');
            alert('Error: Could not determine chat room ID');
            return;
        }
        
        console.log('Manually sending message to room:', roomId);
        
        fetch('/chat/message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                room_id: parseInt(roomId),
                message: message,
                parent_id: parentId || null,
                is_feedback: isFeedback === '1'
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Message sent manually:', data);
            messageInput.value = '';
            
            // Refresh page to see the new message
            window.location.reload();
        })
        .catch(error => {
            console.error('Error sending message manually:', error);
            alert('Failed to send message. Please try again.');
        });
    }
});

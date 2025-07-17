import './bootstrap';

// Initialize other JavaScript functionality for the app
document.addEventListener('DOMContentLoaded', function() {
    console.log('EcoVerse Chat System initialized');
    
    // Initialize chat notifications if user is logged in
    initializeChatNotifications();
});

/**
 * Initialize chat notifications using polling
 */
function initializeChatNotifications() {
    // Check if user is authenticated
    if (document.body && document.body.dataset.userId) {
        // Set up polling for unread messages if we're on a page with user data
        setInterval(() => {
            checkForUnreadMessages();
        }, 15000); // Check every 15 seconds
        
        // Do an immediate check
        checkForUnreadMessages();
    }
}

/**
 * Poll for unread messages
 */
function checkForUnreadMessages() {
    fetch('/chat/poll/unread-count')
        .then(response => response.json())
        .then(data => {
            if (data.unread_count > 0) {
                updateChatNotificationCount(data.unread_count, true);
                
                // Display a notification if browser supports it
                if ('Notification' in window && Notification.permission === 'granted') {
                    new Notification('New Message', {
                        body: `You have ${data.unread_count} unread message(s)`,
                        icon: '/favicon.ico'
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error checking unread messages:', error);
        });
}

/**
 * Update the chat notification count in the UI
 * @param {number} count - The new count to display
 * @param {boolean} set - Whether to set the count (true) or increment it (false)
 */
function updateChatNotificationCount(count, set = false) {
    const chatBadge = document.querySelector('#chatMenuButton .badge');
    
    if (chatBadge) {
        const currentCount = parseInt(chatBadge.textContent.trim()) || 0;
        chatBadge.textContent = set ? count : currentCount + count;
        chatBadge.classList.remove('d-none');
    } else {
        // Create new badge if it doesn't exist
        const chatButton = document.querySelector('#chatMenuButton');
        if (chatButton) {
            const badge = document.createElement('span');
            badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
            badge.textContent = count;
            
            const visually_hidden = document.createElement('span');
            visually_hidden.className = 'visually-hidden';
            visually_hidden.textContent = 'unread messages';
            
            badge.appendChild(visually_hidden);
            chatButton.appendChild(badge);
        }
    }
}

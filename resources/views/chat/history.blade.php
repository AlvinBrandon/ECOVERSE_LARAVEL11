@extends('layouts.app')

@push('scripts')
<!-- Removed chat-admin-fix.js which used WebSockets -->
<script src="{{ asset('js/chat-polling.js') }}"></script>
<script src="{{ asset('js/chat-read-helper.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ensure all elements have the proper IDs and data attributes for the polling system
        @if($currentRoom)
            // Add room ID to chat container
            const chatContainer = document.querySelector('#chat-container');
            if (chatContainer) {
                chatContainer.setAttribute('data-room-id', '{{ $currentRoom->id }}');
                
                // Also make sure the hidden input has the same room ID
                const roomIdInput = document.querySelector('input[name="room_id"]');
                if (roomIdInput) {
                    roomIdInput.value = '{{ $currentRoom->id }}';
                }
            }
            
            // Add current user ID
            const userElement = document.querySelector('[data-user-id]');
            if (!userElement) {
                document.body.setAttribute('data-user-id', '{{ $user->id }}');
                document.body.setAttribute('data-user-role', '{{ $user->role }}');
            }
            
            // Scroll chat to bottom initially
            const messagesContainer = document.querySelector('#chat-container');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
            
            console.log('Chat initialized with room ID: {{ $currentRoom->id }}');
        @endif
    });
</script>
@endpush

<!-- Add CSRF token meta tag for AJAX requests -->
@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('styles')
<style>
    .chat-messages {
        height: 400px;
        overflow-y: auto;
        background-color: #f8f9fa;
        border-radius: 0.25rem;
        padding: 1rem;
        position: relative;
    }
    
    .message {
        margin-bottom: 15px;
    }
    
    .message-content {
        max-width: 80%;
        border-radius: 10px;
        padding: 8px 12px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    
    .message-header {
        font-size: 0.8rem;
        margin-bottom: 3px;
    }
    
    .message-body {
        word-break: break-word;
    }
    
    .text-end .message-content {
        float: right;
    }
    
    .user-status {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 5px;
    }
    
    .user-status.online {
        background-color: #28a745;
    }
    
    .user-status.offline {
        background-color: #dc3545;
    }
    
    /* Typing indicator animation */
    .typing-indicator {
        display: inline-flex;
        align-items: center;
    }
    
    .typing-indicator span {
        height: 8px;
        width: 8px;
        margin: 0 2px;
        border-radius: 50%;
        background-color: #888;
        display: inline-block;
        animation: bounce 1.5s infinite ease-in-out;
    }
    
    .typing-indicator span:nth-child(1) {
        animation-delay: 0s;
    }
    
    .typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    .typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
    }
    
    @keyframes bounce {
        0%, 80%, 100% { 
            transform: translateY(0);
        }
        40% { 
            transform: translateY(-6px);
        }
    }
    
    /* New message notification */
    .new-message-alert {
        position: absolute;
        bottom: 70px;
        left: 50%;
        transform: translateX(-50%);
        padding: 5px 15px;
        background-color: rgba(40, 167, 69, 0.8);
        color: white;
        border-radius: 20px;
        cursor: pointer;
        z-index: 100;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: all 0.3s;
    }
    
    .new-message-alert:hover {
        background-color: rgba(40, 167, 69, 1);
    }
    
    /* For message status indicators */
    .message-status {
        font-size: 0.7rem;
        margin-top: 3px;
    }
    
    /* For emoji picker */
    .emoji-picker-container {
        position: absolute;
        bottom: 40px;
        right: 10px;
        z-index: 1000;
    }
    
    /* Button enhancements */
    .btn-send {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        min-width: 80px;
    }
    
    .btn-emoji {
        border-radius: 0;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center mb-2">
                        <img id="chat-notification-icon" src="{{ asset('images/chat-notification.svg') }}" width="32" height="32" style="transition: filter 0.3s;" alt="Chat Notification">
                        <span id="chat-notification-badge" class="badge bg-danger ms-1 d-none">New</span>
                        <h4 class="mb-0 ms-2">
                            @if($currentRoom)
                                {{ $currentRoom->name }}
                            @else
                                Chat History
                            @endif
                        </h4>
                    </div>
                    @if($currentRoom && auth()->user()->role === 'admin')
                        <div>
                            <span class="badge bg-warning text-dark">Admin View</span>
                            @php
                                $wasOriginalMember = $currentRoom->users()
                                    ->where('users.id', auth()->id())
                                    ->where('chat_room_user.created_at', '<=', $currentRoom->created_at->addMinutes(1))
                                    ->exists();
                            @endphp
                            @if(!$wasOriginalMember)
                                <span class="badge bg-info ms-1" title="You were added to this room because you're an admin">Added as Admin</span>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="chat-sidebar p-3 border-end">
                                @if(isset($allChats) && $allChats && auth()->user()->role === 'admin')
                                    <div class="alert alert-info mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-shield-check fs-4 me-2"></i>
                                            <div>
                                                <strong>Admin Access</strong><br>
                                                <small>You can view and respond to all conversations</small>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <h5 class="border-bottom pb-2">Chat Options</h5>
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('chat.start') }}" class="nav-link px-0">
                                            <i class="bi bi-plus-circle me-2"></i> Start New Chat
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('chat.history') }}" class="nav-link px-0 active">
                                            <i class="bi bi-clock-history me-2"></i> Chat History
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('chat.index') }}" class="nav-link px-0">
                                            <i class="bi bi-chat me-2"></i> Chat Dashboard
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard') }}" class="nav-link px-0">
                                            <i class="bi bi-house me-2"></i> Back to Dashboard
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="chat-history">
                                <h4>
                                    @if($currentRoom)
                                        Conversation: {{ $currentRoom->name }}
                                    @else
                                        Past Conversations
                                    @endif
                                </h4>
                                
                                @if($currentRoom)
                                    <div id="chat-container" class="chat-messages mt-3 p-3 border rounded d-flex flex-column" style="height: 400px; overflow-y: auto;" data-room-id="{{ $currentRoom->id }}" data-user-id="{{ $user->id }}">
                                        <div id="messages-list" class="w-100">
                                            @foreach($messages->sortBy('created_at') as $message)
                                                <div class="message w-100 {{ $message->user_id === $user->id ? 'text-end' : '' }} mb-3" id="message-{{ $message->id }}">
                                                    <div class="message-content d-inline-block w-100"
                                                        @if($message->user_id === $user->id)
                                                            style="background-color: #0d6efd; color: #fff;"
                                                        @elseif($message->user->role === 'admin' && $message->is_feedback)
                                                            style="background-color: #ffc107;"
                                                        @elseif($message->user->role === 'admin')
                                                            style="background-color: #198754; color: #fff;"
                                                        @else
                                                            style="background-color: #f8f9fa;"
                                                        @endif
                                                    >
                                                        <div class="message-header">
                                                            <strong>{{ $message->user->name }}</strong>
                                                            @if($message->user->role === 'admin')
                                                                <span class="badge bg-warning text-dark ms-1">Admin</span>
                                                            @endif
                                                            @if($message->is_feedback)
                                                                <span class="badge bg-info text-dark ms-1">Feedback</span>
                                                            @endif
                                                            <small class="ms-2">{{ $message->created_at->format('M d, h:i A') }}</small>
                                                        </div>
                                                        @if($message->parent)
                                                        <div class="replied-message border-start border-3 ps-2 my-2 small">
                                                            <div class="fw-bold">
                                                                @if($message->parent->user)
                                                                    Replying to {{ $message->parent->user->name }}:
                                                                @else
                                                                    Replying to message:
                                                                @endif
                                                            </div>
                                                            <div class="text-muted">
                                                                "{{ \Illuminate\Support\Str::limit($message->parent->message, 100) }}"
                                                            </div>
                                                        </div>
                                                        @endif
                                                        <div class="message-body">
                                                            {{ $message->message }}
                                                        </div>
                                                        @if(auth()->user()->role === 'admin')
                                                        <div class="message-actions mt-2">
                                                            <button class="btn btn-sm btn-light reply-btn" 
                                                                onclick="replyToMessage('{{ $message->id }}', '{{ $message->user->name }}')">
                                                                <i class="bi bi-reply"></i> Reply
                                                            </button>
                                                            @if($message->user->role !== 'admin')
                                                            <button class="btn btn-sm btn-light feedback-btn" 
                                                                onclick="provideFeedback('{{ $message->id }}', '{{ $message->user->name }}')">
                                                                <i class="bi bi-chat-square-text"></i> Give Feedback
                                                            </button>
                                                            @endif
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <div id="reply-container" class="mt-2 mb-2 d-none">
                                        <div class="alert alert-info d-flex justify-content-between align-items-center py-2">
                                            <span>
                                                <i class="bi bi-reply"></i> 
                                                Replying to <strong id="reply-to-name"></strong>
                                            </span>
                                            <button type="button" class="btn-close" onclick="cancelReply()"></button>
                                        </div>
                                    </div>
                                    
                                    <div id="feedback-container" class="mt-2 mb-2 d-none">
                                        <div class="alert alert-warning d-flex justify-content-between align-items-center py-2">
                                            <span>
                                                <i class="bi bi-chat-square-text"></i> 
                                                Giving feedback to <strong id="feedback-to-name"></strong>
                                            </span>
                                            <button type="button" class="btn-close" onclick="cancelFeedback()"></button>
                                        </div>
                                    </div>
                                    
                                    <!-- New message notification indicator -->
                                    <div id="new-message-alert" class="new-message-alert d-none" onclick="scrollToBottom()">
                                        <i class="bi bi-arrow-down-circle"></i> New messages
                                    </div>
                                    
                                    <form action="#" method="POST" class="mt-3" id="message-form" onsubmit="event.preventDefault(); sendMessage();">
                                        @csrf
                                        <input type="hidden" name="room_id" value="{{ $currentRoom->id }}">
                                        <input type="hidden" name="parent_id" id="parent-id" value="">
                                        <input type="hidden" name="is_feedback" id="is-feedback" value="0">
                                        
                                        <div class="input-group">
                                            <input type="text" id="message-input" name="message" class="form-control" 
                                                placeholder="Type your message..." required autocomplete="off" 
                                                onkeypress="if(event.keyCode == 13 && !event.shiftKey) { event.preventDefault(); sendMessage(); }">
                                                
                                            <button class="btn btn-outline-secondary btn-emoji" type="button" id="emoji-button" title="Add emoji">
                                                <i class="bi bi-emoji-smile"></i>
                                            </button>
                                            
                                            <button class="btn btn-success btn-send" type="submit" id="send-button">
                                                <i class="bi bi-send"></i> Send
                                            </button>
                                        </div>
                                        
                                        <div id="emoji-picker" class="emoji-picker-container d-none">
                                            <!-- Emoji picker will be inserted here with JavaScript -->
                                        </div>
                                    </form>
                                    
                                    <!-- Audio elements for notification sounds -->
                                    <audio id="message-received-sound" preload="auto">
                                        <source src="{{ asset('assets/sounds/message.mp3') }}" type="audio/mpeg">
                                    </audio>
                                    <audio id="message-sent-sound" preload="auto">
                                        <source src="{{ asset('assets/sounds/sent.mp3') }}" type="audio/mpeg">
                                    </audio>
                                @elseif(count($rooms) > 0)
                                    <div class="list-group mt-3">
                                        @foreach($rooms as $room)
                                            <a href="{{ route('chat.history', $room->id) }}" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">{{ $room->name }}</h5>
                                                    <small>{{ $room->created_at->diffForHumans() }}</small>
                                                </div>
                                                @php
                                                    $lastMessage = $room->messages()->latest()->first();
                                                @endphp
                                                @if($lastMessage)
                                                    <p class="mb-1">{{ Str::limit($lastMessage->message, 100) }}</p>
                                                @else
                                                    <p class="mb-1 text-muted">No messages yet</p>
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="alert alert-info mt-4">
                                        <i class="bi bi-info-circle me-2"></i> You don't have any chat history yet.
                                    </div>
                                    <div class="text-center mt-4">
                                        <a href="{{ route('chat.start') }}" class="btn btn-success">
                                            <i class="bi bi-chat-text me-1"></i> Start Your First Chat
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if($currentRoom)
<script>
    // Scroll to the bottom of the chat messages when the page loads
    window.onload = function() {
        const chatMessages = document.getElementById('chat-messages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    };
</script>
@endif

@push('scripts')
<script>
// Notification icon logic
function highlightChatNotification() {
    const icon = document.getElementById('chat-notification-icon');
    const badge = document.getElementById('chat-notification-badge');
    if (icon && badge) {
        icon.style.filter = 'drop-shadow(0 0 8px #28a745)';
        badge.classList.remove('d-none');
        // Animate for a short time
        setTimeout(() => {
            icon.style.filter = '';
        }, 1500);
    }
}

// Listen for new message event from polling JS
if (window.ecoVerseChat) {
    window.ecoVerseChat.onNewMessage = function() {
        highlightChatNotification();
    };
}
// If using custom polling, call highlightChatNotification() when a new message is received
</script>
@endpush

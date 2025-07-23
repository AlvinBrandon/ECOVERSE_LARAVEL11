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
    /* Modern Professional Chat History Styling */
    body, .main-content, .container-fluid {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
        font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        color: white;
    }

    .page-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1.5rem;
    }

    .page-header .btn {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        backdrop-filter: blur(10px);
        transition: all 0.2s ease;
    }

    .page-header .btn:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    .admin-badge {
        background: rgba(251, 191, 36, 0.2);
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, 0.3);
        backdrop-filter: blur(10px);
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
        border-radius: 0.5rem;
    }

    .added-admin-badge {
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
        backdrop-filter: blur(10px);
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
        border-radius: 0.5rem;
    }

    /* Chat Layout */
    .chat-container {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        border: none;
        min-height: 600px;
    }

    /* Sidebar Styling */
    .chat-sidebar {
        background: #f8fafc;
        border-right: 1px solid #e5e7eb;
        padding: 1.5rem;
    }

    .chat-sidebar h5 {
        color: #374151;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 1rem;
    }

    .chat-sidebar .nav-link {
        color: #6b7280;
        padding: 0.75rem 0;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border-radius: 0.5rem;
        margin-bottom: 0.25rem;
    }

    .chat-sidebar .nav-link:hover {
        color: #3b82f6;
        background: rgba(59, 130, 246, 0.05);
        padding-left: 0.75rem;
    }

    .chat-sidebar .nav-link.active {
        color: #3b82f6;
        background: rgba(59, 130, 246, 0.1);
        font-weight: 600;
        padding-left: 0.75rem;
    }

    .chat-sidebar .nav-link i {
        color: #9ca3af;
        width: 1.25rem;
    }

    .chat-sidebar .nav-link.active i {
        color: #3b82f6;
    }

    /* Admin Alert */
    .admin-alert {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 1px solid #93c5fd;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .admin-alert strong {
        color: #1e40af;
        font-weight: 600;
    }

    .admin-alert small {
        color: #1d4ed8;
        font-size: 0.75rem;
    }

    /* Chat Messages Area */
    .chat-messages {
        height: 400px;
        overflow-y: auto;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1.5rem;
        position: relative;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .message {
        margin-bottom: 1.5rem;
        animation: fadeInUp 0.3s ease-out;
    }
    
    .message-content {
        max-width: 80%;
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .message-content::before {
        content: '';
        position: absolute;
        bottom: -8px;
        width: 0;
        height: 0;
        border-style: solid;
    }

    /* User messages (right side) */
    .text-end .message-content {
        float: right;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: white !important;
    }

    .text-end .message-content::before {
        right: 20px;
        border-left: 8px solid #2563eb;
        border-top: 8px solid transparent;
    }

    /* Admin messages */
    .message-content[style*="198754"] {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
    }

    /* Admin feedback messages */
    .message-content[style*="ffc107"] {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: white !important;
    }

    /* Other user messages */
    .message-content[style*="f8f9fa"] {
        background: white !important;
        color: #374151 !important;
        border: 1px solid #e5e7eb;
    }

    .message-content[style*="f8f9fa"]::before {
        left: 20px;
        border-right: 8px solid #e5e7eb;
        border-top: 8px solid transparent;
    }
    
    .message-header {
        font-size: 0.75rem;
        margin-bottom: 0.5rem;
        opacity: 0.9;
    }
    
    .message-body {
        word-break: break-word;
        line-height: 1.5;
        font-size: 0.875rem;
    }

    /* Replied message styling */
    .replied-message {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 0.5rem;
        padding: 0.75rem;
        margin: 0.5rem 0;
        border-left: 3px solid rgba(255, 255, 255, 0.3) !important;
    }

    .replied-message .fw-bold {
        font-size: 0.75rem;
        margin-bottom: 0.25rem;
    }

    .replied-message .text-muted {
        font-size: 0.75rem;
        opacity: 0.8;
    }

    /* Message Actions */
    .message-actions .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.7rem;
        border-radius: 0.375rem;
        margin-right: 0.5rem;
        transition: all 0.2s ease;
    }

    .message-actions .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Status indicators */
    .user-status {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 5px;
    }
    
    .user-status.online {
        background-color: #10b981;
        box-shadow: 0 0 8px rgba(16, 185, 129, 0.4);
    }
    
    .user-status.offline {
        background-color: #ef4444;
    }

    /* Badges */
    .badge {
        font-size: 0.65rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
    }

    /* Reply and Feedback containers */
    #reply-container .alert,
    #feedback-container .alert {
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    #reply-container .alert {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
        border-left: 4px solid #3b82f6;
    }

    #feedback-container .alert {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        border-left: 4px solid #f59e0b;
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
        background-color: #6b7280;
        display: inline-block;
        animation: bounce 1.5s infinite ease-in-out;
    }
    
    .typing-indicator span:nth-child(1) { animation-delay: 0s; }
    .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
    
    @keyframes bounce {
        0%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-6px); }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* New message notification */
    .new-message-alert {
        position: absolute;
        bottom: 70px;
        left: 50%;
        transform: translateX(-50%);
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-radius: 1.5rem;
        cursor: pointer;
        z-index: 100;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        transition: all 0.3s;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .new-message-alert:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateX(-50%) translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
    }
    
    /* Message input styling */
    .input-group .form-control {
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem 0 0 0.75rem;
        padding: 0.875rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .input-group .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .btn-emoji {
        border: 1px solid #e5e7eb;
        border-left: none;
        border-right: none;
        background: #f9fafb;
        color: #6b7280;
        transition: all 0.2s ease;
    }

    .btn-emoji:hover {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-send {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        color: white;
        border-radius: 0 0.75rem 0.75rem 0;
        font-weight: 500;
        transition: all 0.2s ease;
        min-width: 80px;
    }

    .btn-send:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        transform: translateY(-1px);
        color: white;
    }

    /* Section Headers */
    .section-header {
        color: #374151;
        font-weight: 600;
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e5e7eb;
    }

    /* Room list styling */
    .list-group-item {
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        margin-bottom: 0.75rem;
        padding: 1.25rem;
        transition: all 0.2s ease;
        background: white;
    }

    .list-group-item:hover {
        border-color: #3b82f6;
        background: rgba(59, 130, 246, 0.05);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .list-group-item h5 {
        color: #1f2937;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .list-group-item p {
        color: #6b7280;
        margin-bottom: 0;
        font-size: 0.875rem;
    }

    /* Empty state */
    .alert-info {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 1px solid #93c5fd;
        color: #1e40af;
        border-radius: 0.75rem;
        padding: 1.25rem;
    }

    /* Button styling */
    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        font-weight: 500;
        transition: all 0.2s ease;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        transform: translateY(-2px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-header h4 {
            font-size: 1.25rem;
        }

        .chat-sidebar {
            padding: 1rem;
        }

        .chat-messages {
            height: 300px;
            padding: 1rem;
        }

        .message-content {
            max-width: 90%;
            padding: 0.75rem 1rem;
        }

        .message-header {
            font-size: 0.7rem;
        }

        .message-body {
            font-size: 0.8rem;
        }
    }

    /* Emoji picker container */
    .emoji-picker-container {
        position: absolute;
        bottom: 60px;
        right: 10px;
        z-index: 1000;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img id="chat-notification-icon" src="{{ asset('images/chat-notification.svg') }}" width="32" height="32" style="transition: filter 0.3s;" alt="Chat Notification" class="me-3">
                <span id="chat-notification-badge" class="badge bg-danger ms-1 d-none">New</span>
                <div>
                    <h4>
                        @if($currentRoom)
                            <i class="bi bi-chat-dots me-2"></i>{{ $currentRoom->name }}
                        @else
                            <i class="bi bi-clock-history me-2"></i>Chat History
                        @endif
                    </h4>
                    <p class="mb-0 opacity-75">
                        @if($currentRoom)
                            Active conversation with support team
                        @else
                            View and manage your past conversations
                        @endif
                    </p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                @if($currentRoom && auth()->user()->role === 'admin')
                    <span class="admin-badge">
                        <i class="bi bi-shield-check me-1"></i>Admin View
                    </span>
                    @php
                        $wasOriginalMember = $currentRoom->users()
                            ->where('users.id', auth()->id())
                            ->where('chat_room_user.created_at', '<=', $currentRoom->created_at->addMinutes(1))
                            ->exists();
                    @endphp
                    @if(!$wasOriginalMember)
                        <span class="added-admin-badge" title="You were added to this room because you're an admin">
                            <i class="bi bi-plus-circle me-1"></i>Added as Admin
                        </span>
                    @endif
                @endif
                <a href="{{ route('dashboard') }}" class="btn">
                    <i class="bi bi-house-door me-1"></i>Home
                </a>
            </div>
        </div>
    </div>

    <!-- Main Chat Container -->
    <div class="card chat-container">
    <!-- Main Chat Container -->
    <div class="card chat-container">
        <div class="card-body p-0">
            <div class="row g-0">
                <!-- Sidebar -->
                <div class="col-md-4">
                    <div class="chat-sidebar">
                        @if(isset($allChats) && $allChats && auth()->user()->role === 'admin')
                            <div class="admin-alert">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-shield-check fs-4 me-2"></i>
                                    <div>
                                        <strong>Admin Access</strong><br>
                                        <small>You can view and respond to all conversations</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <h5>Chat Options</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="{{ route('chat.start') }}" class="nav-link">
                                    <i class="bi bi-plus-circle me-2"></i> Start New Chat
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('chat.history') }}" class="nav-link active">
                                    <i class="bi bi-clock-history me-2"></i> Chat History
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('chat.index') }}" class="nav-link">
                                    <i class="bi bi-chat me-2"></i> Chat Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link">
                                    <i class="bi bi-house me-2"></i> Back to Dashboard
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="col-md-8">
                    <div class="chat-history p-4">
                        <h4 class="section-header">
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

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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

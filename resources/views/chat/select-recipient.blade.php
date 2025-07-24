@extends('layouts.app')

@push('styles')
<style>
    .recipient-selection-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .recipient-card {
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .recipient-card:hover {
        border-color: #007bff;
        box-shadow: 0 4px 12px rgba(0,123,255,0.15);
        transform: translateY(-1px);
    }
    
    .recipient-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }
    
    .recipient-details h5 {
        margin: 0;
        color: #333;
        font-weight: 600;
    }
    
    .recipient-role {
        color: #666;
        font-size: 0.9em;
        margin-top: 2px;
    }
    
    .last-message {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 10px;
        font-size: 0.9em;
        color: #666;
        border-left: 3px solid #007bff;
    }
    
    .quick-message-form {
        border-top: 1px solid #eee;
        padding-top: 15px;
    }
    
    .quick-message-input {
        border-radius: 20px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        font-size: 0.9em;
    }
    
    .quick-message-input:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    }
    
    .action-buttons {
        margin-top: 10px;
    }
    
    .btn-quick-send {
        border-radius: 20px;
        padding: 8px 20px;
        font-size: 0.9em;
        font-weight: 500;
    }
    
    .section-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        text-align: center;
    }
    
    .section-header h4 {
        margin: 0;
        font-weight: 600;
    }
    
    .no-users {
        text-align: center;
        color: #666;
        padding: 40px 20px;
        background: #f8f9fa;
        border-radius: 12px;
        border: 2px dashed #ddd;
    }
    
    .role-badge {
        background: #007bff;
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 0.8em;
        font-weight: 500;
    }
    
    .status-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }
    
    .status-online {
        background: #28a745;
    }
    
    .status-offline {
        background: #6c757d;
    }
    
    .message-count {
        background: #dc3545;
        color: white;
        border-radius: 12px;
        padding: 2px 8px;
        font-size: 0.8em;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="recipient-selection-container">
    <div class="section-header">
        <h4><i class="bi bi-chat-dots"></i> Select Recipient</h4>
        <p class="mb-0">Choose who you want to send a message to</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> 
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Existing Conversations -->
    @if($existingChats->count() > 0)
        <div class="mb-5">
            <h5 class="mb-3"><i class="bi bi-chat-left-text"></i> Continue Existing Conversations</h5>
            
            @foreach($existingChats as $chat)
                @php
                    $otherUser = $chat->users->first();
                    $lastMessage = $chat->messages->first();
                @endphp
                
                <div class="recipient-card">
                    <div class="recipient-info">
                        <div class="recipient-details">
                            <h5>
                                <span class="status-indicator status-offline"></span>
                                {{ $otherUser->name }}
                                <span class="role-badge">{{ ucfirst($otherUser->getCurrentRole()) }}</span>
                            </h5>
                            <div class="recipient-role">{{ $otherUser->email }}</div>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('chat.history', $chat->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-chat"></i> Open Chat
                            </a>
                            @if($chat->messages()->count() > 0)
                                <div class="mt-1">
                                    <span class="message-count">{{ $chat->messages()->count() }}</span> messages
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($lastMessage)
                        <div class="last-message">
                            <strong>{{ $lastMessage->user->name }}:</strong> 
                            {{ Str::limit($lastMessage->message, 100) }}
                            <div class="text-muted mt-1" style="font-size: 0.8em;">
                                {{ $lastMessage->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @endif
                    
                    <form action="{{ route('chat.send-quick-message') }}" method="POST" class="quick-message-form">
                        @csrf
                        <input type="hidden" name="recipient_id" value="{{ $otherUser->id }}">
                        
                        <div class="input-group">
                            <input type="text" name="message" class="form-control quick-message-input" 
                                   placeholder="Type a quick message to {{ $otherUser->name }}..." required>
                            <button type="submit" class="btn btn-primary btn-quick-send">
                                <i class="bi bi-send"></i> Send
                            </button>
                        </div>
                        
                        <div class="action-buttons">
                            <button type="submit" name="goto_chat" value="1" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-arrow-right"></i> Send & Open Chat
                            </button>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    @endif

    <!-- New Conversations -->
    @if($newChatUsers->count() > 0)
        <div class="mb-4">
            <h5 class="mb-3"><i class="bi bi-person-plus"></i> Start New Conversations</h5>
            
            @foreach($newChatUsers as $newUser)
                <div class="recipient-card">
                    <div class="recipient-info">
                        <div class="recipient-details">
                            <h5>
                                <span class="status-indicator status-offline"></span>
                                {{ $newUser->name }}
                                <span class="role-badge">{{ ucfirst($newUser->getCurrentRole()) }}</span>
                            </h5>
                            <div class="recipient-role">{{ $newUser->email }}</div>
                        </div>
                        <div>
                            <span class="badge bg-success">New Chat</span>
                        </div>
                    </div>
                    
                    <form action="{{ route('chat.send-quick-message') }}" method="POST" class="quick-message-form">
                        @csrf
                        <input type="hidden" name="recipient_id" value="{{ $newUser->id }}">
                        
                        <div class="input-group">
                            <input type="text" name="message" class="form-control quick-message-input" 
                                   placeholder="Start a conversation with {{ $newUser->name }}..." required>
                            <button type="submit" class="btn btn-success btn-quick-send">
                                <i class="bi bi-send"></i> Start Chat
                            </button>
                        </div>
                        
                        <div class="action-buttons">
                            <button type="submit" name="goto_chat" value="1" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-arrow-right"></i> Start & Open Chat
                            </button>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    @endif

    <!-- No Users Available -->
    @if($allowedUsers->count() === 0)
        <div class="no-users">
            <i class="bi bi-chat-square-x" style="font-size: 3rem; color: #ddd; margin-bottom: 15px;"></i>
            <h5>No Chat Partners Available</h5>
            <p>Based on your role ({{ ucfirst($user->getCurrentRole()) }}), there are no users available for chat at the moment.</p>
        </div>
    @endif

    <!-- Role Information -->
    <div class="mt-4 p-3 bg-light rounded">
        <h6><i class="bi bi-info-circle"></i> Chat Permissions</h6>
        <p class="mb-0 text-muted">
            As a <strong>{{ ucfirst($user->getCurrentRole()) }}</strong>, you can chat with:
            @php
                $rolePermissions = [
                    'admin' => ['Suppliers', 'Wholesalers', 'Staff'],
                    'supplier' => ['Admins'],
                    'wholesaler' => ['Admins', 'Retailers', 'Staff'],
                    'retailer' => ['Customers', 'Wholesalers'],
                    'customer' => ['Retailers'],
                    'staff' => ['Admins', 'Wholesalers']
                ];
                $currentRole = $user->getCurrentRole();
                $permissions = $rolePermissions[$currentRole] ?? [];
            @endphp
            
            @if(count($permissions) > 0)
                {{ implode(', ', $permissions) }}
            @else
                No one (check with administrator)
            @endif
        </p>
    </div>

    <!-- Navigation -->
    <div class="text-center mt-4">
        <a href="{{ route('chat.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Chat Dashboard
        </a>
    </div>
</div>

@push('scripts')
<script>
    // Auto-focus on message inputs when they become visible
    document.addEventListener('DOMContentLoaded', function() {
        // Handle form submissions
        const forms = document.querySelectorAll('.quick-message-form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const messageInput = form.querySelector('input[name="message"]');
                if (messageInput.value.trim() === '') {
                    e.preventDefault();
                    messageInput.focus();
                    return;
                }
                
                // Show loading state
                const submitButton = form.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Sending...';
                submitButton.disabled = true;
                
                // Re-enable after 3 seconds (in case of error)
                setTimeout(() => {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }, 3000);
            });
        });
        
        // Handle keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Escape key to focus on first message input
            if (e.key === 'Escape') {
                const firstInput = document.querySelector('.quick-message-input');
                if (firstInput) {
                    firstInput.focus();
                }
            }
        });
    });
</script>
@endpush
@endsection

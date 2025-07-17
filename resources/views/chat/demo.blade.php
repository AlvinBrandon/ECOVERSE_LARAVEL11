@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12 col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h1 class="h4 mb-0">EcoVerse Chat Demo</h1>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        This page demonstrates all the chat features including real-time messaging, notifications, and popups.
                    </div>
                    
                    <div class="mb-4">
                        <h5>Features:</h5>
                        <ul>
                            <li>Real-time messaging using Laravel Reverb WebSockets</li>
                            <li>Desktop notifications for new messages</li>
                            <li>Typing indicators show when someone is composing a message</li>
                            <li>Online/offline status indicators</li>
                            <li>Unread message counters</li>
                            <li>Sound notifications for new messages</li>
                            <li>Message read receipts</li>
                        </ul>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Your Chat Rooms:</h5>
                        
                        @php
                            $chatRooms = \App\Models\ChatRoom::whereHas('users', function($query) {
                                $query->where('users.id', auth()->id());
                            })->get();
                        @endphp
                        
                        @if($chatRooms->isEmpty())
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                You don't have any chat rooms yet.
                            </div>
                            
                            <a href="{{ route('chat.start') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle me-1"></i> Start a New Chat
                            </a>
                        @else
                            <div class="list-group mb-3">
                                @foreach($chatRooms as $room)
                                    <a href="{{ route('chat.history', $room->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $room->name }}</h6>
                                            <small class="text-muted">
                                                @php
                                                    $otherUsers = $room->users->where('id', '!=', auth()->id())->pluck('name')->join(', ');
                                                @endphp
                                                With: {{ $otherUsers ?: 'No other users' }}
                                            </small>
                                        </div>
                                        
                                        @php
                                            $unreadCount = $room->messages()->where('user_id', '!=', auth()->id())->whereNull('read_at')->count();
                                        @endphp
                                        
                                        @if($unreadCount > 0)
                                            <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                            
                            <a href="{{ route('chat.start') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle me-1"></i> Start a New Chat
                            </a>
                        @endif
                    </div>
                    
                    <div class="mt-5">
                        <h5>Quick Chat Widget:</h5>
                        <p>Click the button below to open a quick chat widget:</p>
                        
                        <button id="openChatWidget" class="btn btn-primary">
                            <i class="bi bi-chat-dots-fill me-1"></i> Open Chat Widget
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hidden chat widget that appears when button is clicked --}}
<div id="chatWidgetContainer" class="d-none">
    @php
        // Get the first chat room for demo purposes
        $demoRoom = $chatRooms->first();
        $roomId = $demoRoom->id ?? null;
        $title = $demoRoom->name ?? 'Chat';
    @endphp
    
    @include('components.simple-chat', ['roomId' => $roomId, 'title' => $title])
</div>

@endsection

@push('scripts')
<script>
    // Initialize chat widget toggle
    document.addEventListener('DOMContentLoaded', function() {
        const openChatBtn = document.getElementById('openChatWidget');
        const chatWidget = document.getElementById('chatWidgetContainer');
        
        if (openChatBtn && chatWidget) {
            openChatBtn.addEventListener('click', function() {
                chatWidget.classList.toggle('d-none');
            });
        }
        
        // Request notification permission
        if ('Notification' in window) {
            if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
                Notification.requestPermission();
            }
        }
    });
</script>
@endpush

@push('styles')
<style>
    /* Additional styles for demo page */
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    
    #chatWidgetContainer {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1050;
        max-width: 350px;
        width: 100%;
    }
</style>
@endpush

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-chat-dots-fill me-2"></i> Chat Support Dashboard</h4>
                    @if(auth()->user()->role === 'admin')
                        <span class="badge bg-warning text-dark">Admin View</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="chat-sidebar p-3 border-end">
                                <h5 class="border-bottom pb-2">Chat Options</h5>
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('chat.start') }}" class="nav-link px-0">
                                            <i class="bi bi-plus-circle me-2"></i> Start New Chat
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('chat.history') }}" class="nav-link px-0">
                                            <i class="bi bi-clock-history me-2"></i> Chat History
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard') }}" class="nav-link px-0">
                                            <i class="bi bi-house me-2"></i> Back to Dashboard
                                        </a>
                                    </li>
                                </ul>
                                
                                <h5 class="border-bottom pb-2 mt-4">Support Topics</h5>
                                <div class="list-group">
                                    <a href="{{ route('chat.start') }}?topic=order" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">
                                                <i class="bi bi-box-seam me-2 text-primary"></i> Order Issues
                                            </h6>
                                        </div>
                                    </a>
                                    <a href="{{ route('chat.start') }}?topic=product" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">
                                                <i class="bi bi-cart me-2 text-success"></i> Product Questions
                                            </h6>
                                        </div>
                                    </a>
                                    <a href="{{ route('chat.start') }}?topic=account" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">
                                                <i class="bi bi-person-circle me-2 text-info"></i> Account Help
                                            </h6>
                                        </div>
                                    </a>
                                    <a href="{{ route('chat.start') }}?topic=other" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">
                                                <i class="bi bi-question-circle me-2 text-warning"></i> Other Support
                                            </h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="chat-main-area">
                                @if($rooms->isEmpty())
                                    <div class="text-center my-5">
                                        <img src="/assets/img/chat-support.svg" alt="Chat Support" class="mb-4" style="max-width: 150px; opacity: 0.7;">
                                        <h3>Welcome to Ecoverse Chat Support</h3>
                                        <p class="text-muted">You don't have any active conversations yet. Start a new chat to begin messaging.</p>
                                        <a href="{{ route('chat.start') }}" class="btn btn-success mt-3">
                                            <i class="bi bi-chat-text me-1"></i> Start New Conversation
                                        </a>
                                    </div>
                                @else
                                    @if(isset($allChats) && $allChats && auth()->user()->role === 'admin')
                                        <div class="alert alert-info mb-4">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-shield-check fs-4 me-3"></i>
                                                <div>
                                                    <h5 class="mb-1">Administrator View</h5>
                                                    <p class="mb-0">You are viewing all chat rooms across the system. As an administrator, you have access to all conversations.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="mb-4">All Chat Rooms</h4>
                                    @else
                                        <h4 class="mb-4">Your Chat Rooms</h4>
                                    @endif
                                    <div class="row">
                                        @foreach($rooms as $room)
                                            <div class="col-md-6 mb-4">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $room->name }}</h5>
                                                        <p class="card-text text-muted small">
                                                            @if($room->messages->isNotEmpty())
                                                                <strong>Last message:</strong> 
                                                                {{ Str::limit($room->messages->first()->message, 40) }}
                                                                <br>
                                                                <small>{{ $room->messages->first()->created_at->diffForHumans() }}</small>
                                                            @else
                                                                No messages yet
                                                            @endif
                                                        </p>
                                                        
                                                        @php
                                                            $participants = $room->users->where('id', '!=', auth()->id())->take(3);
                                                            $extraCount = $room->users->where('id', '!=', auth()->id())->count() - 3;
                                                        @endphp
                                                        
                                                        <p class="card-text">
                                                            <small class="text-muted">
                                                                With: 
                                                                @foreach($participants as $participant)
                                                                    {{ $participant->name }}@if(!$loop->last), @endif
                                                                @endforeach
                                                                @if($extraCount > 0)
                                                                    and {{ $extraCount }} more
                                                                @endif
                                                            </small>
                                                        </p>
                                                        
                                                        @php
                                                            $unreadCount = $room->messages()
                                                                ->where('user_id', '!=', auth()->id())
                                                                ->whereNull('read_at')
                                                                ->count();
                                                        @endphp
                                                    </div>
                                                    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                                                        @if($unreadCount > 0)
                                                            <span class="badge bg-danger">{{ $unreadCount }} unread</span>
                                                        @else
                                                            <span></span>
                                                        @endif
                                                        
                                                        <a href="{{ route('chat.history', $room->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="bi bi-chat-dots me-1"></i> Open Chat
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="text-center mt-4">
                                        <a href="{{ route('chat.start') }}" class="btn btn-success">
                                            <i class="bi bi-plus-circle me-1"></i> Start New Chat
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

<div class="chat-widget">
    <div class="card dashboard-card">
        <div class="card-header dashboard-header">
            <h5 class="mb-0">
                <i class="bi bi-chat-dots-fill me-2"></i> Recent Messages
            </h5>
        </div>
        <div class="card-body p-0">
            @php
                $recentChats = App\Models\ChatRoom::whereHas('users', function($query) {
                    $query->where('users.id', auth()->id());
                })
                ->with(['messages' => function($query) {
                    $query->latest()->take(1);
                }])
                ->take(5)
                ->get();
            @endphp
            
            @if($recentChats->isEmpty())
                <div class="p-4 text-center">
                    <p>No chat rooms yet.</p>
                    <a href="{{ route('chat.start') }}" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Start New Chat
                    </a>
                </div>
            @else
                <div class="list-group list-group-flush">
                    @foreach($recentChats as $room)
                        <a href="{{ route('chat.history', $room->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $room->name }}</h6>
                                    @if($room->messages->isNotEmpty())
                                        <p class="text-muted small mb-0">
                                            {{ Str::limit($room->messages->first()->message, 40) }}
                                        </p>
                                        <small class="text-muted">
                                            {{ $room->messages->first()->created_at->diffForHumans() }}
                                        </small>
                                    @else
                                        <p class="text-muted small mb-0">No messages yet</p>
                                    @endif
                                </div>
                                @php
                                    $unreadCount = $room->messages()
                                        ->where('user_id', '!=', auth()->id())
                                        ->whereNull('read_at')
                                        ->count();
                                @endphp
                                @if($unreadCount > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="card-footer text-center py-2">
                    <a href="{{ route('chat.index') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-chat-fill me-1"></i> View All Chats
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

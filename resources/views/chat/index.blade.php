@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Chat Support Styling */
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

  .chat-sidebar .nav-link i {
    color: #9ca3af;
    width: 1.25rem;
  }

  /* Support Topics */
  .support-topics .list-group-item {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    margin-bottom: 0.5rem;
    padding: 1rem;
    transition: all 0.2s ease;
  }

  .support-topics .list-group-item:hover {
    border-color: #3b82f6;
    background: rgba(59, 130, 246, 0.05);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .support-topics .list-group-item h6 {
    margin: 0;
    color: #374151;
    font-weight: 500;
  }

  /* Main Chat Area */
  .chat-main-area {
    padding: 1.5rem;
  }

  /* Welcome State */
  .welcome-state {
    text-align: center;
    padding: 3rem 2rem;
    color: #6b7280;
  }

  .welcome-state img {
    filter: opacity(0.7);
    margin-bottom: 2rem;
  }

  .welcome-state h3 {
    color: #374151;
    margin-bottom: 1rem;
    font-weight: 600;
    font-size: 1.5rem;
  }

  .welcome-state p {
    font-size: 0.875rem;
    max-width: 400px;
    margin: 0 auto 2rem;
    line-height: 1.6;
  }

  /* Admin Alert */
  .admin-alert {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border: 1px solid #93c5fd;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
  }

  .admin-alert h5 {
    color: #1e40af;
    margin-bottom: 0.5rem;
    font-weight: 600;
  }

  .admin-alert p {
    color: #1d4ed8;
    margin: 0;
    font-size: 0.875rem;
  }

  /* Chat Room Cards */
  .chat-room-card {
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    transition: all 0.2s ease;
    height: 100%;
    background: white;
  }

  .chat-room-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    transform: translateY(-4px);
  }

  .chat-room-card .card-body {
    padding: 1.5rem;
  }

  .chat-room-card .card-title {
    color: #1f2937;
    font-weight: 600;
    font-size: 1.125rem;
    margin-bottom: 0.75rem;
  }

  .chat-room-card .card-text {
    color: #6b7280;
    font-size: 0.875rem;
    line-height: 1.5;
  }

  .chat-room-card .card-footer {
    background: #f9fafb;
    border-top: 1px solid #f3f4f6;
    padding: 1rem 1.5rem;
  }

  /* Unread Badge */
  .unread-badge {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 500;
  }

  /* Action Buttons */
  .btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border: none;
    font-weight: 500;
    transition: all 0.2s ease;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
    transform: translateY(-2px);
  }

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

  .btn-sm {
    padding: 0.375rem 0.875rem;
    font-size: 0.8rem;
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

    .chat-main-area {
      padding: 1rem;
    }

    .welcome-state {
      padding: 2rem 1rem;
    }

    .chat-room-card .card-body {
      padding: 1rem;
    }

    .chat-room-card .card-footer {
      padding: 0.75rem 1rem;
    }
  }

  /* Loading Animation */
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

  .chat-room-card {
    animation: fadeInUp 0.4s ease-out;
  }

  .chat-room-card:nth-child(2) {
    animation-delay: 0.1s;
  }

  .chat-room-card:nth-child(3) {
    animation-delay: 0.2s;
  }

  .chat-room-card:nth-child(4) {
    animation-delay: 0.3s;
  }
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-chat-dots-fill me-2"></i>Chat Support Dashboard</h4>
        <p class="mb-0 opacity-75">Connect with support and manage your conversations</p>
      </div>
      <div class="d-flex align-items-center gap-3">
        @if(auth()->user()->role === 'admin')
          <span class="admin-badge">
            <i class="bi bi-shield-check me-1"></i>Admin View
          </span>
        @endif
        
        @php
            // Check if user can chat with multiple types of users
            $userRole = auth()->user()->getCurrentRole();
            $multipleChats = in_array($userRole, ['admin', 'wholesaler', 'retailer', 'staff']);
        @endphp
        
        @if($multipleChats)
          <a href="{{ route('chat.selectRecipient') }}" class="btn btn-primary">
            <i class="bi bi-chat-dots me-1"></i>Quick Message
          </a>
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
            <h5>Chat Options</h5>
            <ul class="nav flex-column">
              <li class="nav-item">
                <a href="{{ route('chat.selectUser') }}" class="nav-link">
                  <i class="bi bi-people me-2"></i> Message User
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('chat.selectRecipient') }}" class="nav-link">
                  <i class="bi bi-chat-dots me-2"></i> Quick Message
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('chat.start') }}" class="nav-link">
                  <i class="bi bi-plus-circle me-2"></i> Support Chat
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('chat.history') }}" class="nav-link">
                  <i class="bi bi-clock-history me-2"></i> Chat History
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                  <i class="bi bi-house me-2"></i> Back to Dashboard
                </a>
              </li>
            </ul>
            
            <h5 class="mt-4">Support Topics</h5>
            <div class="support-topics">
              <a href="{{ route('chat.start') }}?topic=order" class="list-group-item list-group-item-action">
                <h6>
                  <i class="bi bi-box-seam me-2 text-primary"></i> Order Issues
                </h6>
              </a>
              <a href="{{ route('chat.start') }}?topic=product" class="list-group-item list-group-item-action">
                <h6>
                  <i class="bi bi-cart me-2 text-success"></i> Product Questions
                </h6>
              </a>
              <a href="{{ route('chat.start') }}?topic=account" class="list-group-item list-group-item-action">
                <h6>
                  <i class="bi bi-person-circle me-2 text-info"></i> Account Help
                </h6>
              </a>
              <a href="{{ route('chat.start') }}?topic=other" class="list-group-item list-group-item-action">
                <h6>
                  <i class="bi bi-question-circle me-2 text-warning"></i> Other Support
                </h6>
              </a>
            </div>
          </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-8">
          <div class="chat-main-area">
            @if($rooms->isEmpty())
              <div class="welcome-state">
                <img src="/assets/img/chat-support.svg" alt="Chat Support" style="max-width: 150px;">
                <h3>Welcome to Ecoverse Chat Support</h3>
                <p>You don't have any active conversations yet. Start a new chat to begin messaging and get the help you need.</p>
                <a href="{{ route('chat.start') }}" class="btn btn-success">
                  <i class="bi bi-chat-text me-2"></i> Start New Conversation
                </a>
              </div>
            @else
              @if(isset($allChats) && $allChats && auth()->user()->role === 'admin')
                <div class="admin-alert">
                  <div class="d-flex align-items-center">
                    <i class="bi bi-shield-check fs-4 me-3"></i>
                    <div>
                      <h5>Administrator View</h5>
                      <p>You are viewing all chat rooms across the system. As an administrator, you have access to all conversations.</p>
                    </div>
                  </div>
                </div>
                <h4 class="section-header">All Chat Rooms</h4>
              @else
                <h4 class="section-header">Your Chat Rooms</h4>
              @endif
              
              <div class="row">
                @foreach($rooms as $room)
                  <div class="col-md-6 mb-4">
                    <div class="card chat-room-card">
                      <div class="card-body">
                        <h5 class="card-title">{{ $room->name }}</h5>
                        <p class="card-text">
                          @if($room->messages->isNotEmpty())
                            <strong>Last message:</strong> 
                            {{ Str::limit($room->messages->first()->message, 40) }}
                            <br>
                            <small class="text-muted">{{ $room->messages->first()->created_at->diffForHumans() }}</small>
                          @else
                            <span class="text-muted">No messages yet</span>
                          @endif
                        </p>
                        
                        @php
                          $participants = $room->users->where('id', '!=', auth()->id())->take(3);
                          $extraCount = $room->users->where('id', '!=', auth()->id())->count() - 3;
                        @endphp
                        
                        <p class="card-text">
                          <small class="text-muted">
                            <i class="bi bi-people me-1"></i>
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
                      <div class="card-footer d-flex justify-content-between align-items-center">
                        @if($unreadCount > 0)
                          <span class="unread-badge">{{ $unreadCount }} unread</span>
                        @else
                          <span></span>
                        @endif
                        
                        <a href="{{ route('chat.history', $room->id) }}" class="btn btn-primary btn-sm">
                          <i class="bi bi-chat-dots me-1"></i> Open Chat
                        </a>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
              
              <div class="text-center mt-4">
                <a href="{{ route('chat.start') }}" class="btn btn-success">
                  <i class="bi bi-plus-circle me-2"></i> Start New Chat
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

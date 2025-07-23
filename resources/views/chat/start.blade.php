@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Chat Start Styling */
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

  /* Main Content Area */
  .chat-start {
    padding: 1.5rem;
  }

  .chat-start h4 {
    color: #1f2937;
    font-weight: 600;
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
  }

  .chat-start p {
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 2rem;
    line-height: 1.6;
  }

  /* Form Styling */
  .form-label {
    color: #374151;
    font-weight: 500;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
  }

  .form-control, .form-select {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    background: white;
  }

  .form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
  }

  .form-control::placeholder {
    color: #9ca3af;
  }

  .form-text {
    color: #6b7280;
    font-size: 0.75rem;
    margin-top: 0.25rem;
  }

  /* Form Check */
  .form-check {
    padding: 1rem;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
  }

  .form-check-input {
    border: 1px solid #d1d5db;
    border-radius: 0.25rem;
  }

  .form-check-input:checked {
    background-color: #f59e0b;
    border-color: #f59e0b;
  }

  .form-check-label {
    color: #374151;
    font-weight: 500;
    margin-left: 0.5rem;
  }

  /* Alert Styling */
  .alert {
    border: none;
    border-radius: 0.75rem;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
  }

  .alert-success {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #166534;
    border-left: 4px solid #22c55e;
  }

  .alert-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
    border-left: 4px solid #ef4444;
  }

  .alert ul {
    margin: 0;
    padding-left: 1rem;
  }

  /* Button Styling */
  .btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    font-weight: 500;
    transition: all 0.2s ease;
    border-radius: 0.5rem;
    padding: 0.875rem 1.5rem;
    font-size: 0.875rem;
  }

  .btn-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    transform: translateY(-2px);
  }

  /* File Input Styling */
  .form-control[type="file"] {
    padding: 0.5rem 0.75rem;
    background: #f9fafb;
    border: 2px dashed #d1d5db;
    transition: all 0.2s ease;
  }

  .form-control[type="file"]:hover {
    border-color: #3b82f6;
    background: rgba(59, 130, 246, 0.05);
  }

  /* Select Styling */
  .form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.75rem center;
    background-size: 16px 12px;
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

    .chat-start {
      padding: 1rem;
    }

    .chat-start h4 {
      font-size: 1.25rem;
    }

    .btn-success {
      padding: 0.75rem 1.25rem;
    }
  }

  /* Animation */
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

  .chat-start {
    animation: fadeInUp 0.4s ease-out;
  }

  /* Form Group Enhancement */
  .mb-3 {
    margin-bottom: 1.5rem;
  }

  .mb-3:last-child {
    margin-bottom: 0;
  }
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-chat-dots me-2"></i>Start New Chat</h4>
        <p class="mb-0 opacity-75">Begin a conversation with our support team</p>
      </div>
      <a href="{{ route('dashboard') }}" class="btn">
        <i class="bi bi-house-door me-1"></i>Home
      </a>
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
                <a href="{{ route('chat.start') }}" class="nav-link active">
                  <i class="bi bi-plus-circle me-2"></i> Start New Chat
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('chat.history') }}" class="nav-link">
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
          <div class="chat-start">
            <h4>New Conversation</h4>
            <p>Please fill in the details to start a conversation with our support team.</p>
            
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            
            @if (session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif
            
            @if (session('error'))
              <div class="alert alert-danger">
                {{ session('error') }}
              </div>
            @endif
            
            <form action="{{ route('chat.startChat') }}" method="POST" class="mt-4" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label for="subject" class="form-label">
                  <i class="bi bi-tag me-1"></i>Subject
                </label>
                <select id="subject" name="subject" class="form-select" required>
                  <option value="">Select a topic...</option>
                  <option value="order">📦 Order Issues</option>
                  <option value="product">🛒 Product Questions</option>
                  <option value="account">👤 Account Help</option>
                  <option value="other">❓ Other</option>
                </select>
              </div>
              
              <div class="mb-3">
                <label for="message" class="form-label">
                  <i class="bi bi-chat-text me-1"></i>Message
                </label>
                <textarea id="message" name="message" class="form-control" rows="5" placeholder="Please describe your issue or question in detail..." required></textarea>
              </div>
              
              <div class="mb-3">
                <label for="attachment" class="form-label">
                  <i class="bi bi-paperclip me-1"></i>Attachment (Optional)
                </label>
                <input type="file" id="attachment" name="attachment" class="form-control">
                <div class="form-text">
                  <i class="bi bi-info-circle me-1"></i>
                  You can attach a file related to your issue (max 5MB)
                </div>
              </div>
              
              <div class="form-check">
                <input type="checkbox" id="urgent" name="urgent" class="form-check-input">
                <label for="urgent" class="form-check-label">
                  <i class="bi bi-exclamation-triangle me-1"></i>
                  Mark as urgent - requires immediate attention
                </label>
              </div>
              
              <div class="d-grid">
                <button type="submit" class="btn btn-success">
                  <i class="bi bi-send me-2"></i> Start Chat Conversation
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="bi bi-chat-dots me-2"></i> Start New Chat</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="chat-sidebar p-3 border-end">
                                <h5 class="border-bottom pb-2">Chat Options</h5>
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('chat.start') }}" class="nav-link px-0 active">
                                            <i class="bi bi-plus-circle me-2"></i> Start New Chat
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('chat.history') }}" class="nav-link px-0">
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
                            <div class="chat-start">
                                <h4>New Conversation</h4>
                                <p class="text-muted">Please fill in the details to start a conversation with our support team.</p>
                                
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
                                        <label for="subject" class="form-label">Subject</label>
                                        <select id="subject" name="subject" class="form-select" required>
                                            <option value="">Select a topic...</option>
                                            <option value="order">Order Issues</option>
                                            <option value="product">Product Questions</option>
                                            <option value="account">Account Help</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea id="message" name="message" class="form-control" rows="5" placeholder="Please describe your issue or question..." required></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="attachment" class="form-label">Attachment (Optional)</label>
                                        <input type="file" id="attachment" name="attachment" class="form-control">
                                        <div class="form-text">You can attach a file related to your issue (max 5MB).</div>
                                    </div>
                                    
                                    <div class="form-check mb-3">
                                        <input type="checkbox" id="urgent" name="urgent" class="form-check-input">
                                        <label for="urgent" class="form-check-label">Mark as urgent</label>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-send me-1"></i> Start Chat
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

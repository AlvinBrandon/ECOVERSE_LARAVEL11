@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional User Selection Styling */
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

  /* Chat Container */
  .chat-container {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
    min-height: 600px;
  }

  /* User Cards */
  .user-card {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.2s ease;
    cursor: pointer;
  }

  .user-card:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .user-card.selected {
    background: #dbeafe;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
  }

  .user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 1.2rem;
  }

  .role-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.025em;
  }

  .role-admin { background: #dc2626; color: white; }
  .role-staff { background: #2563eb; color: white; }
  .role-supplier { background: #059669; color: white; }
  .role-wholesaler { background: #7c3aed; color: white; }
  .role-retailer { background: #ea580c; color: white; }
  .role-customer { background: #0891b2; color: white; }

  /* Form Styling */
  .form-control {
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    padding: 0.75rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }

  .form-control:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
  }

  .btn-primary {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    transform: translateY(-1px);
  }

  /* Alert Styling */
  .alert {
    border: none;
    border-radius: 0.75rem;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
  }

  .alert-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
    border-left: 4px solid #ef4444;
  }

  .alert-success {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #166534;
    border-left: 4px solid #22c55e;
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: #6b7280;
  }

  .empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
  }

  @media (max-width: 768px) {
    .user-card {
      padding: 1rem;
    }
    
    .user-avatar {
      width: 40px;
      height: 40px;
      font-size: 1rem;
    }
  }
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-people me-2"></i>Select User to Chat</h4>
        <p class="mb-0 opacity-75">Choose someone to start a conversation with</p>
      </div>
      <a href="{{ route('chat.index') }}" class="btn">
        <i class="bi bi-arrow-left me-1"></i>Back to Chat
      </a>
    </div>
  </div>

  <!-- Main Container -->
  <div class="card chat-container">
    <div class="card-body p-4">
      
      @if ($errors->any())
        <div class="alert alert-danger">
          <h6 class="alert-heading"><i class="bi bi-exclamation-triangle me-2"></i>Access Denied</h6>
          @foreach ($errors->all() as $error)
            <p class="mb-0">{{ $error }}</p>
          @endforeach
        </div>
      @endif

      @if (session('success'))
        <div class="alert alert-success">
          <h6 class="alert-heading"><i class="bi bi-check-circle me-2"></i>Success</h6>
          <p class="mb-0">{{ session('success') }}</p>
        </div>
      @endif

      <div class="row">
        <div class="col-md-8">
          <h5 class="mb-4">Available Users</h5>
          
          @if($allowedUsers->count() > 0)
            <form action="{{ route('chat.startDirectChat') }}" method="POST" id="chatForm">
              @csrf
              <input type="hidden" name="user_id" id="selectedUserId">
              
              <div class="row">
                @foreach($allowedUsers as $allowedUser)
                  <div class="col-md-6 mb-3">
                    <div class="user-card" onclick="selectUser({{ $allowedUser->id }}, '{{ $allowedUser->name }}')">
                      <div class="d-flex align-items-center">
                        <div class="user-avatar me-3">
                          {{ strtoupper(substr($allowedUser->name, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                          <h6 class="mb-1">{{ $allowedUser->name }}</h6>
                          <p class="text-muted mb-2">{{ $allowedUser->email }}</p>
                          <span class="role-badge role-{{ $allowedUser->getCurrentRole() }}">
                            {{ $allowedUser->getCurrentRole() }}
                          </span>
                        </div>
                        <div class="ms-2">
                          <i class="bi bi-chat-dots text-muted"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
              
              <div class="mt-4" id="messageSection" style="display: none;">
                <h6>Send Message to <span id="selectedUserName"></span></h6>
                <div class="mb-3">
                  <label for="message" class="form-label">Message</label>
                  <textarea name="message" id="message" class="form-control" rows="4" 
                           placeholder="Type your message here..." required></textarea>
                </div>
                <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-2"></i>Start Chat
                  </button>
                  <button type="button" class="btn btn-secondary" onclick="clearSelection()">
                    <i class="bi bi-x me-2"></i>Cancel
                  </button>
                </div>
              </div>
            </form>
          @else
            <div class="empty-state">
              <i class="bi bi-chat-x"></i>
              <h5>No Users Available</h5>
              <p>Based on your role ({{ $user->getCurrentRole() }}), there are no users you can chat with at the moment.</p>
              
              <div class="mt-4 p-3 bg-light rounded">
                <h6>Chat Permissions:</h6>
                <ul class="text-start list-unstyled">
                  @switch($user->getCurrentRole())
                    @case('admin')
                      <li><i class="bi bi-check text-success me-2"></i>Can chat with: Suppliers, Wholesalers, Staff</li>
                      @break
                    @case('supplier')
                      <li><i class="bi bi-check text-success me-2"></i>Can chat with: Admins only</li>
                      @break
                    @case('wholesaler')
                      <li><i class="bi bi-check text-success me-2"></i>Can chat with: Admins, Retailers, Staff</li>
                      @break
                    @case('retailer')
                      <li><i class="bi bi-check text-success me-2"></i>Can chat with: Customers, Wholesalers</li>
                      @break
                    @case('customer')
                      <li><i class="bi bi-check text-success me-2"></i>Can chat with: Retailers only</li>
                      @break
                    @case('staff')
                      <li><i class="bi bi-check text-success me-2"></i>Can chat with: Admins, Wholesalers</li>
                      @break
                  @endswitch
                </ul>
              </div>
            </div>
          @endif
        </div>
        
        <div class="col-md-4">
          <div class="p-3 bg-light rounded">
            <h6><i class="bi bi-info-circle me-2"></i>Chat Rules</h6>
            <ul class="small text-muted list-unstyled">
              <li class="mb-2"><i class="bi bi-dot me-1"></i>You can only chat with users based on your role</li>
              <li class="mb-2"><i class="bi bi-dot me-1"></i>All conversations are moderated</li>
              <li class="mb-2"><i class="bi bi-dot me-1"></i>Be respectful and professional</li>
              <li class="mb-2"><i class="bi bi-dot me-1"></i>Do not share sensitive information</li>
            </ul>
            
            <div class="mt-3">
              <h6>Your Role: <span class="role-badge role-{{ $user->getCurrentRole() }}">{{ $user->getCurrentRole() }}</span></h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function selectUser(userId, userName) {
  // Remove previous selections
  document.querySelectorAll('.user-card').forEach(card => {
    card.classList.remove('selected');
  });
  
  // Select current card
  event.currentTarget.classList.add('selected');
  
  // Update form
  document.getElementById('selectedUserId').value = userId;
  document.getElementById('selectedUserName').textContent = userName;
  document.getElementById('messageSection').style.display = 'block';
  
  // Scroll to message section
  document.getElementById('messageSection').scrollIntoView({ behavior: 'smooth' });
}

function clearSelection() {
  document.querySelectorAll('.user-card').forEach(card => {
    card.classList.remove('selected');
  });
  document.getElementById('selectedUserId').value = '';
  document.getElementById('messageSection').style.display = 'none';
  document.getElementById('message').value = '';
}
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

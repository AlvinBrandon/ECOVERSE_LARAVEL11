@props(['titlePage'])

@if(auth()->check() && (auth()->user()->role ?? null) === 'customer')
    <!-- Customer Jumia-style Top Bar -->
    <div class="container-fluid py-2 bg-white border-bottom mb-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <!-- Logo/Brand -->
            <div class="d-flex align-items-center me-3">
                <span class="fw-bold fs-3 text-primary me-2">ECOVERSE</span>
            </div>
            <!-- Search Bar -->
            <form action="{{ route('products.index') }}" method="GET" class="flex-grow-1 mx-3" style="max-width: 500px;">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search products, brands and categories" aria-label="Search">
                    <button class="btn btn-primary px-4" type="submit">Search</button>
                </div>
            </form>
            <!-- User, Help, Cart -->
            <div class="d-flex align-items-center ms-3">
                <span class="me-4"><i class="bi bi-person-circle me-1"></i> Hi, {{ auth()->user()->name ?? 'Customer' }}</span>
                <a href="#" class="text-decoration-none text-dark me-4" title="Help" data-bs-toggle="modal" data-bs-target="#helpModal">
                    <i class="bi bi-question-circle-fill" style="font-size: 1.2rem;"></i>
                </a>
                <a href="{{ route('cart.index') }}" class="text-decoration-none text-dark position-relative" title="Cart">
                    <i class="bi bi-cart-fill" style="font-size: 1.2rem;"></i>
                    @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                    @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.8rem;">{{ $cartCount }}</span>
                    @endif
                    <span class="ms-1">Cart</span>
                </a>
            </div>
        </div>
    </div>
@endif

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        {{-- Removed breadcrumb and title section --}}
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <!-- Removed the input-group with 'Type here...' label and input -->
            </div>
            <form method="POST" action="{{ route('logout') }}" class="d-none" id="logout-form">
                @csrf
            </form>
            <ul class="navbar-nav justify-content-end">
                <!-- Chat Notification Bell Icon (Golden Bell) -->
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0 position-relative" id="chatMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false" title="Chat Notifications">
                        <i class="bi bi-bell-fill cursor-pointer notification-bell-icon" 
                           style="font-size: 1.5rem; color: #FFD700; text-shadow: 0 0 5px rgba(255, 215, 0, 0.5); transition: all 0.3s ease;"></i>
                        @if(auth()->check() && auth()->user()->hasUnreadMessages())
                            <span class="position-absolute notification-badge">
                                {{ auth()->user()->unreadMessagesCount() }}
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="chatMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{ route('chat.index') }}">
                                <div class="d-flex py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">💬 Chat Dashboard</span>
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            View all your chat conversations
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{ route('chat.start') }}">
                                <div class="d-flex py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">✨ Start New Chat</span>
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            Create a new conversation
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @if(auth()->check())
                            @php
                                $recentChats = App\Models\ChatRoom::whereHas('users', function($query) {
                                    $query->where('users.id', auth()->id());
                                })
                                ->with(['messages' => function($query) {
                                    $query->latest()->take(1);
                                }])
                                ->take(3)
                                ->get();
                            @endphp
                            
                            @if($recentChats->isNotEmpty())
                                <li><hr class="dropdown-divider"></li>
                                <li class="dropdown-header">🔔 Recent Chats</li>
                                
                                @foreach($recentChats as $room)
                                    <li>
                                        <a class="dropdown-item border-radius-md" href="{{ route('chat.history', $room->id) }}">
                                            <div class="d-flex py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="text-sm font-weight-normal mb-1">
                                                        {{ $room->name }}
                                                        @php
                                                            $unreadCount = $room->messages()
                                                                ->where('user_id', '!=', auth()->id())
                                                                ->whereNull('read_at')
                                                                ->count();
                                                        @endphp
                                                        @if($unreadCount > 0)
                                                            <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                                                        @endif
                                                    </h6>
                                                    @if($room->messages->isNotEmpty())
                                                        <p class="text-xs text-secondary mb-0">
                                                            {{ Str::limit($room->messages->first()->message, 30) }}
                                                        </p>
                                                    @else
                                                        <p class="text-xs text-secondary mb-0">
                                                            No messages yet
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        @endif
                    </ul>
                </li>

                <!-- Settings Icon -->
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" title="Settings">
                        <i class="bi bi-gear-fill fixed-plugin-button-nav cursor-pointer" style="font-size: 1.3rem; color: #6c757d;"></i>
                    </a>
                </li>

                <!-- User Profile and Logout -->
                <li class="nav-item d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body font-weight-bold px-2" title="Sign Out">
                        <i class="bi bi-person-circle me-sm-1" style="font-size: 1.3rem; color: #6c757d;"></i>
                        <span class="d-sm-inline d-none"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign Out</span>
                    </a>
                </li>

                <!-- Mobile Sidebar Toggle -->
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav" title="Toggle Sidebar">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@push('scripts')
<script>
// Enhanced golden bell notification management
function updateChatNavbarNotification(count) {
    const badge = document.querySelector('#chatMenuButton .notification-badge');
    const bellIcon = document.querySelector('#chatMenuButton .notification-bell-icon');
    
    if (bellIcon) {
        if (count > 0) {
            // Show/update badge
            if (badge) {
                badge.textContent = count;
                badge.style.display = 'flex';
            } else {
                // Create new badge if it doesn't exist
                const newBadge = document.createElement('span');
                newBadge.className = 'notification-badge';
                newBadge.textContent = count;
                
                const hiddenText = document.createElement('span');
                hiddenText.className = 'visually-hidden';
                hiddenText.textContent = 'unread messages';
                newBadge.appendChild(hiddenText);
                
                document.getElementById('chatMenuButton').appendChild(newBadge);
            }
            
            // Add glowing effect to bell
            bellIcon.classList.add('has-notifications');
            
            // Ring the bell animation
            bellIcon.classList.add('bell-ringing');
            setTimeout(() => {
                bellIcon.classList.remove('bell-ringing');
            }, 800);
            
        } else {
            // Hide badge
            if (badge) {
                badge.style.display = 'none';
            }
            // Remove glow effect
            bellIcon.classList.remove('has-notifications');
        }
    }
}

// Enhanced bell hover and click effects
document.addEventListener('DOMContentLoaded', function() {
    const bellIcon = document.querySelector('#chatMenuButton .notification-bell-icon');
    const chatMenuButton = document.getElementById('chatMenuButton');
    
    if (bellIcon && chatMenuButton) {
        // Click effect - ring the bell
        chatMenuButton.addEventListener('click', function() {
            bellIcon.classList.add('bell-ringing');
            setTimeout(() => {
                bellIcon.classList.remove('bell-ringing');
            }, 800);
        });
        
        // Check if we have notifications on page load
        const existingBadge = document.querySelector('#chatMenuButton .notification-badge');
        if (existingBadge && existingBadge.textContent.trim() && existingBadge.textContent.trim() !== '0') {
            bellIcon.classList.add('has-notifications');
        }
    }
});

// Legacy function support for backward compatibility
function updateChatNavbarNotificationLegacy(count) {
    updateChatNavbarNotification(count);
}
</script>
@endpush

@push('styles')
<style>
/* Navigation Icons Standardization */
.navbar-nav .nav-link i {
    transition: all 0.3s ease;
}

.navbar-nav .nav-link:hover i {
    transform: scale(1.1);
}

/* Golden Bell Icon Styling - Using Bootstrap Icons */
.notification-bell-icon {
    font-size: 1.8rem !important;
    color: #FFD700 !important; /* Golden yellow */
    text-shadow: 
        0 0 5px rgba(255, 215, 0, 0.6),
        1px 1px 2px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease !important;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
}

#chatMenuButton:hover .notification-bell-icon {
    transform: scale(1.1) rotate(15deg);
    color: #FFA500 !important; /* Slightly more orange on hover */
    text-shadow: 
        0 0 10px rgba(255, 215, 0, 0.8),
        1px 1px 3px rgba(0, 0, 0, 0.4) !important;
}

/* Red Notification Badge - Matching the image */
.notification-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #dc3545 !important; /* Red background */
    color: white !important;
    border-radius: 50% !important;
    width: 20px !important;
    height: 20px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 0.75rem !important;
    font-weight: bold !important;
    border: 2px solid white !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3) !important;
    animation: pulse-badge 2s infinite;
}

/* Bell ring animation */
@keyframes ring-bell {
    0%, 100% { transform: rotate(0deg); }
    10% { transform: rotate(15deg); }
    20% { transform: rotate(-15deg); }
    30% { transform: rotate(10deg); }
    40% { transform: rotate(-10deg); }
    50% { transform: rotate(5deg); }
    60% { transform: rotate(-5deg); }
    70% { transform: rotate(0deg); }
}

/* Badge pulse animation */
@keyframes pulse-badge {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

/* Bell notification ring effect */
.bell-ringing {
    animation: ring-bell 0.8s ease-in-out;
}

/* Add subtle glow when notifications are present */
.has-notifications {
    animation: glow-bell 2s ease-in-out infinite alternate;
}

@keyframes glow-bell {
    from {
        text-shadow: 
            0 0 5px rgba(255, 215, 0, 0.6),
            1px 1px 2px rgba(0, 0, 0, 0.3);
    }
    to {
        text-shadow: 
            0 0 15px rgba(255, 215, 0, 0.9),
            1px 1px 3px rgba(0, 0, 0, 0.4);
    }
}

/* Consistent Icon Styling */
.nav-link i.bi {
    transition: all 0.3s ease;
}

.nav-link:hover i.bi {
    color: #007bff !important;
}

/* Settings and User Icons */
.nav-link i.bi-gear-fill:hover {
    color: #28a745 !important;
    transform: rotate(90deg);
}

.nav-link i.bi-person-circle:hover {
    color: #007bff !important;
}
</style>
@endpush

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
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search products, brands and categories" aria-label="Search">
                    <button class="btn btn-primary px-4" type="submit">Search</button>
                </div>
            </form>
            <!-- User, Help, Cart -->
            <div class="d-flex align-items-center ms-3">
                <span class="me-4"><i class="fas fa-user me-1"></i> Hi, {{ auth()->user()->name ?? 'Customer' }}</span>
                <a href="#" class="text-decoration-none text-dark me-4" title="Help" data-bs-toggle="modal" data-bs-target="#helpModal"><i class="fas fa-question-circle fa-lg"></i></a>
                <a href="{{ route('cart.index') }}" class="text-decoration-none text-dark position-relative" title="Cart">
                    <i class="fas fa-shopping-cart fa-lg"></i>
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
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <!-- Chat notification icon -->
                    <a href="{{ route('chat.history') }}" class="nav-link position-relative px-2" id="chat-navbar-link"
                        title="Open Chat" style="display:inline-block;">
                        <span style="position:relative;display:inline-block;">
                            <img id="chat-navbar-notification-icon" src="{{ asset('images/chat-notification.svg') }}" width="28"
                                height="28" alt="Chat Notification">
                            <sup id="chat-navbar-notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none"
                                style="font-size:0.8rem;z-index:2;min-width:1.5em;line-height:1.2;">0</sup>
                        </span>
                    </a>
                    <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign
                            Out</span>
                    </a>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>
                
                <!-- Chat Notification Icon -->
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0 position-relative" id="chatMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-comments cursor-pointer"></i>
                        @if(auth()->check() && auth()->user()->hasUnreadMessages())
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
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
                                            <span class="font-weight-bold">Chat Dashboard</span>
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
                                            <span class="font-weight-bold">Start New Chat</span>
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
                                <li class="dropdown-header">Recent Chats</li>
                                
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
                
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{ asset('assets') }}/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New message</span> from Laur
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            13 minutes ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{ asset('assets') }}/img/small-logos/logo-spotify.svg"
                                            class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New album</span> by Travis Scott
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            1 day
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <title>credit-card</title>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF"
                                                    fill-rule="nonzero">
                                                    <g transform="translate(1716.000000, 291.000000)">
                                                        <g transform="translate(453.000000, 454.000000)">
                                                            <path class="color-background"
                                                                d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                                opacity="0.593633743"></path>
                                                            <path class="color-background"
                                                                d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            Payment successfully completed
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            2 days
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

@push('scripts')
<script>
// Update chat notification badge in navbar
function updateChatNavbarNotification(count) {
    const badge = document.getElementById('chat-navbar-notification-badge');
    const icon = document.getElementById('chat-navbar-notification-icon');
    if (badge && icon) {
        if (count > 0) {
            badge.textContent = count;
            badge.classList.remove('d-none');
            icon.style.filter = 'drop-shadow(0 0 8px #dc3545)';
        } else {
            badge.classList.add('d-none');
            icon.style.filter = '';
        }
    }
}
// Example: Call updateChatNavbarNotification(unreadCount) from your polling JS when new messages arrive
</script>
@endpush

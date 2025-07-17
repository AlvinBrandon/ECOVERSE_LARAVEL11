<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Ecoverse')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
      .unit-label {
        font-size: 0.95em;
        color: #6366f1;
        font-weight: 500;
        margin-left: 2px;
      }
      .promo-bar {
        background: linear-gradient(90deg, #ff9800 0%, #ff5722 100%);
        color: #fff;
        font-weight: 600;
        font-size: 1.05rem;
        padding: 0.4rem 0;
        letter-spacing: 1px;
      }
      .navbar-ecoverse {
        background: #fff;
        border-bottom: 1px solid #f3f3f3;
        box-shadow: 0 2px 8px #ff98001a;
        z-index: 1030;
      }
      .navbar-brand {
        font-weight: bold;
        color: #ff9800 !important;
        font-size: 1.7rem;
        letter-spacing: 1px;
      }
      .search-bar {
        max-width: 420px;
        min-width: 220px;
      }
      .user-greeting {
        font-weight: 500;
        color: #333;
        margin-right: 1.2rem;
      }
      .cart-badge {
        font-size: 0.85em;
        background: #ff5722;
        color: #fff;
        top: 0;
        right: -8px;
      }
      .navbar-icon-btn {
        background: none;
        border: none;
        color: #ff9800;
        font-size: 1.3rem;
        margin-right: 0.7rem;
      }
      .navbar-icon-btn:last-child {
        margin-right: 0;
      }
    </style>
    @stack('styles')
    @yield('head')
    @stack('head')
</head>
<body @auth data-user-id="{{ auth()->id() }}" data-user-role="{{ auth()->user()->role }}" @endauth>
    @auth
        @include('components.navbars.navs.auth', ['titlePage' => $titlePage ?? 'Dashboard'])
    @else
        @include('components.navbars.navs.guest')
    @endauth
          </form>
          <a href="/dashboard" class="btn btn-outline-success ms-2" title="Home"><i class="bi bi-house-door"></i></a>
          <button class="navbar-icon-btn ms-2" title="Help" id="openHelpModalBtn"><i class="bi bi-question-circle"></i></button>
          @endif
          @auth
            <span class="user-greeting ms-2">Hi, {{ Auth::user()->name ?? 'Customer' }}</span>
          @endauth
          @if(auth()->user() && auth()->user()->role === 'customer')
            <a href="{{ route('cart.view') }}" class="btn btn-outline-primary position-relative ms-2">
              <i class="bi bi-cart" style="font-size:1.5rem;"></i>
              @php $cartCount = session('cart') ? collect(session('cart'))->sum('quantity') : 0; @endphp
              @if($cartCount > 0)
                <span class="position-absolute cart-badge badge rounded-pill">{{ $cartCount }}</span>
              @endif
              <span class="ms-1">Cart</span>
            </a>
          @endif
        </div>
      </div>
    </nav>
=======
<body @auth data-user-id="{{ auth()->id() }}" data-user-role="{{ auth()->user()->role }}" @endauth>
    @auth
        @include('components.navbars.navs.auth', ['titlePage' => $titlePage ?? 'Dashboard'])
    @else
        @include('components.navbars.navs.guest')
    @endauth
>>>>>>> chat
    <main class="py-4">
        @yield('content')
    </main>
    <div class="text-center py-3" style="color: #000;">
        © 2025, built with 💚 by the Ecoverse Team — powering smarter, greener communities.
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
<<<<<<< HEAD
    <script>
// Autocomplete for product search
(function() {
  const input = document.getElementById('productSearchInput');
  const suggestions = document.getElementById('searchSuggestions');
  let debounceTimeout;
  if (!input) return;
  input.addEventListener('input', function() {
    clearTimeout(debounceTimeout);
    const query = this.value.trim();
    // --- Real-time filter for shop page ---
    if (window.location.pathname.includes('/sales')) {
      const cards = document.querySelectorAll('.card');
      let found = 0;
      cards.forEach(card => {
        const title = card.querySelector('.card-title')?.textContent?.toLowerCase() || '';
        const desc = card.querySelector('.card-text')?.textContent?.toLowerCase() || '';
        if (query.length === 0 || title.includes(query.toLowerCase()) || desc.includes(query.toLowerCase())) {
          card.parentElement.style.display = '';
          found++;
        } else {
          card.parentElement.style.display = 'none';
        }
      });
      let noResult = document.getElementById('noProductsFoundMsg');
      if (!noResult) {
        noResult = document.createElement('div');
        noResult.id = 'noProductsFoundMsg';
        noResult.className = 'alert alert-warning mt-4';
        noResult.textContent = 'No products found.';
        const container = document.querySelector('.row.g-4');
        container?.parentElement.appendChild(noResult);
      }
      noResult.style.display = found === 0 ? '' : 'none';
    }
    // --- End real-time filter ---
    if (query.length < 2) {
      suggestions.style.display = 'none';
      suggestions.innerHTML = '';
      return;
    }
    debounceTimeout = setTimeout(() => {
      fetch(`/products/search?q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => {
          suggestions.innerHTML = '';
          if (data.length === 0) {
            suggestions.style.display = 'none';
            return;
          }
          data.forEach(product => {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'list-group-item list-group-item-action d-flex align-items-center';
            item.innerHTML = `<img src='/assets/img/products/${product.image ?? ''}' alt='' style='width:32px;height:32px;object-fit:contain;margin-right:10px;'> <span>${product.name}</span> <span class='ms-auto text-success'>UGX ${Number(product.price).toLocaleString()}</span>`;
            item.onclick = function() {
              suggestions.style.display = 'none';
              input.value = product.name;
              // Try to scroll to product card and focus quantity input
              const card = document.querySelector(`[data-product-id='${product.id}']`);
              if (card) {
                card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => {
                  card.focus();
                }, 400);
              }
            };
            suggestions.appendChild(item);
          });
          suggestions.style.display = 'block';
        });
    }, 200);
  });
  document.addEventListener('click', function(e) {
    if (!suggestions.contains(e.target) && e.target !== input) {
      suggestions.style.display = 'none';
    }
  });
})();
</script>
<!-- Help Modal -->
<div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="helpForm" method="POST" action="{{ route('help.request') }}">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="helpModalLabel"><i class="bi bi-question-circle me-2"></i>Need Help?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="helpEmail" class="form-label">Your Email</label>
            <input type="email" class="form-control" id="helpEmail" name="email" required value="@auth{{ Auth::user()->email }}@endauth">
          </div>
          <div class="mb-3">
            <label for="helpMessage" class="form-label">What do you need help with?</label>
            <textarea class="form-control" id="helpMessage" name="message" rows="4" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Send</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Help Success Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 2000">
  <div id="helpSuccessToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        <i class="bi bi-check-circle me-2"></i>A staff member will get back to you as soon as possible.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
<script>
  document.getElementById('openHelpModalBtn').addEventListener('click', function() {
    var helpModal = new bootstrap.Modal(document.getElementById('helpModal'));
    helpModal.show();
  });
  document.getElementById('helpForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = this;
    var data = new FormData(form);
    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': data.get('_token'),
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: data
    })
    .then(res => res.ok ? res.json() : Promise.reject(res))
    .then(() => {
      var helpModal = bootstrap.Modal.getInstance(document.getElementById('helpModal'));
      helpModal.hide();
      setTimeout(function() {
        var toastEl = document.getElementById('helpSuccessToast');
        var toast = new bootstrap.Toast(toastEl, { delay: 5000 });
        toast.show();
      }, 400);
      form.reset();
    })
    .catch(() => {
      alert('Could not send help request. Please try again.');
    });
  });
</script>
=======
    @stack('scripts')

>>>>>>> chat
</body>
</html>

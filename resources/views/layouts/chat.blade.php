<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat | {{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .chat-header {
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
            padding: 1.5rem 2rem;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: 1px;
            color: #3a3a3a;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        .chat-container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="chat-header">
        <span>Chat Room</span>
    </div>
    <div class="chat-container p-4">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Back Button Protection -->
    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });

        history.pushState(null, null, location.href);
        window.addEventListener('popstate', function() {
            fetch('{{ route("auth.check") }}', {
                method: 'GET',
                credentials: 'same-origin'
            }).then(response => {
                if (response.status === 401 || response.status === 403) {
                    window.location.href = '{{ route("login") }}';
                } else {
                    history.pushState(null, null, location.href);
                }
            }).catch(() => {
                window.location.href = '{{ route("login") }}';
            });
        });
    </script>
</body>
</html> 
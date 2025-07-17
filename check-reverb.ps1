# Check and troubleshoot Reverb WebSocket server
Write-Host "=========================================================" -ForegroundColor Cyan
Write-Host " EcoVerse Chat - Reverb WebSocket Server Troubleshooter" -ForegroundColor Cyan
Write-Host "=========================================================" -ForegroundColor Cyan

# Check if Reverb is running
$reverbProcess = Get-NetTCPConnection -LocalPort 8080 -ErrorAction SilentlyContinue | Where-Object { $_.State -eq "Listen" }

if ($reverbProcess) {
    Write-Host "✅ Reverb is running on port 8080" -ForegroundColor Green
    $pid = $reverbProcess.OwningProcess
    $process = Get-Process -Id $pid
    Write-Host "   Process: $($process.ProcessName) (PID: $pid)" -ForegroundColor Green
} else {
    Write-Host "❌ Reverb is NOT running on port 8080" -ForegroundColor Red
    
    # Ask user if they want to start Reverb
    $startReverb = Read-Host "Do you want to start the Reverb server now? (y/n)"
    
    if ($startReverb -eq "y") {
        Write-Host "Starting Reverb server..." -ForegroundColor Yellow
        Start-Process powershell -ArgumentList "-File `"$PSScriptRoot\start-reverb.ps1`"" -WindowStyle Normal
    }
}

# Check .env configuration
Write-Host "`nChecking .env configuration..." -ForegroundColor Cyan

$envPath = "$PSScriptRoot\.env"
$envContent = Get-Content $envPath -ErrorAction SilentlyContinue

$broadcastDriver = $envContent | Where-Object { $_ -match "^BROADCAST_DRIVER=" } | ForEach-Object { $_ -replace "^BROADCAST_DRIVER=", "" }

if ($broadcastDriver -eq "reverb") {
    Write-Host "✅ BROADCAST_DRIVER is set to 'reverb'" -ForegroundColor Green
} else {
    Write-Host "❌ BROADCAST_DRIVER is NOT set to 'reverb' (Current: $broadcastDriver)" -ForegroundColor Red
    
    # Ask if user wants to update it
    $updateDriver = Read-Host "Do you want to update BROADCAST_DRIVER to 'reverb'? (y/n)"
    
    if ($updateDriver -eq "y") {
        if ($broadcastDriver) {
            # Replace the existing line
            $envContent = $envContent -replace "^BROADCAST_DRIVER=.*$", "BROADCAST_DRIVER=reverb"
        } else {
            # Add a new line
            $envContent += "BROADCAST_DRIVER=reverb"
        }
        
        Set-Content -Path $envPath -Value $envContent
        Write-Host "Updated BROADCAST_DRIVER to 'reverb'" -ForegroundColor Green
    }
}

# Check Reverb config
$reverbAppKey = $envContent | Where-Object { $_ -match "^REVERB_APP_KEY=" } | ForEach-Object { $_ -replace "^REVERB_APP_KEY=", "" }

if ($reverbAppKey) {
    Write-Host "✅ REVERB_APP_KEY is configured: $reverbAppKey" -ForegroundColor Green
} else {
    Write-Host "❌ REVERB_APP_KEY is not configured" -ForegroundColor Red
    
    # Ask if user wants to set a default key
    $updateKey = Read-Host "Do you want to set REVERB_APP_KEY to 'ecoverse_key'? (y/n)"
    
    if ($updateKey -eq "y") {
        $envContent += "`nREVERB_APP_KEY=ecoverse_key"
        Set-Content -Path $envPath -Value $envContent
        Write-Host "Added REVERB_APP_KEY=ecoverse_key" -ForegroundColor Green
    }
}

# Check frontend connection
Write-Host "`nChecking JavaScript configuration..." -ForegroundColor Cyan

$appJsPath = "$PSScriptRoot\resources\js\app.js"
$appJsContent = Get-Content $appJsPath -ErrorAction SilentlyContinue

if ($appJsContent -match "broadcaster: 'reverb'") {
    Write-Host "✅ app.js is configured to use Reverb" -ForegroundColor Green
} else {
    Write-Host "❌ app.js is NOT configured to use Reverb" -ForegroundColor Red
}

# Generate test script to verify WebSocket connection
$testHtmlPath = "$PSScriptRoot\public\reverb-test.html"

# Create test file
$testHtml = @"
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reverb WebSocket Connection Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .status {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        #logs {
            height: 300px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f8f9fa;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <h1>Reverb WebSocket Connection Test</h1>
    
    <div id="connection-status" class="status info">
        Checking connection...
    </div>
    
    <h2>Connection Log:</h2>
    <div id="logs"></div>
    
    <button id="test-btn">Test Connection</button>
    
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.3/dist/echo.iife.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.4.0-rc2/dist/web/pusher.min.js"></script>
    
    <script>
        // Log element
        const logs = document.getElementById('logs');
        const status = document.getElementById('connection-status');
        
        // Log function
        function log(message, type = 'info') {
            const now = new Date().toLocaleTimeString();
            logs.innerHTML += `[\${now}] [\${type.toUpperCase()}] \${message}\n`;
            logs.scrollTop = logs.scrollHeight;
        }
        
        // Update status
        function updateStatus(message, type) {
            status.className = `status \${type}`;
            status.textContent = message;
        }
        
        // Test connection
        function testConnection() {
            log('Starting WebSocket connection test...');
            updateStatus('Connecting...', 'info');
            
            try {
                window.Pusher = Pusher;
                
                window.Echo = new Echo({
                    broadcaster: 'reverb',
                    key: 'ecoverse_key',
                    wsHost: window.location.hostname,
                    wsPort: 8080,
                    forceTLS: false,
                    disableStats: true,
                    enabledTransports: ['ws', 'wss'],
                    wsReconnect: true,
                    wsReconnectionAttempts: 3,
                    wsReconnectionDelay: 2000
                });
                
                log('Echo initialized with Reverb configuration');
                
                // Monitor connection events
                window.Echo.connector.socket.onopen = () => {
                    log('WebSocket connection established successfully!', 'success');
                    updateStatus('Connected to WebSocket server ✅', 'success');
                };
                
                window.Echo.connector.socket.onclose = (event) => {
                    log(`WebSocket connection closed: Code \${event.code}`, 'error');
                    updateStatus('Connection closed ❌', 'error');
                };
                
                window.Echo.connector.socket.onerror = (error) => {
                    log(`WebSocket error: \${JSON.stringify(error)}`, 'error');
                    updateStatus('Connection error ❌', 'error');
                };
                
                // Try to subscribe to a test channel
                setTimeout(() => {
                    try {
                        log('Attempting to subscribe to public channel: test-channel');
                        
                        const channel = window.Echo.channel('test-channel');
                        channel.listen('.test-event', (e) => {
                            log(`Received event on test-channel: \${JSON.stringify(e)}`, 'success');
                        });
                        
                        log('Successfully subscribed to test-channel', 'success');
                    } catch (err) {
                        log(`Error subscribing to channel: \${err.message}`, 'error');
                    }
                }, 1000);
                
            } catch (error) {
                log(`Error initializing Echo: \${error.message}`, 'error');
                updateStatus('Failed to initialize connection ❌', 'error');
            }
        }
        
        // Add button event listener
        document.getElementById('test-btn').addEventListener('click', testConnection);
        
        // Auto-test on page load
        window.addEventListener('load', testConnection);
    </script>
</body>
</html>
"@

Set-Content -Path $testHtmlPath -Value $testHtml
Write-Host "`n✅ Created test page at: $testHtmlPath" -ForegroundColor Green
Write-Host "   Access it at: http://localhost/ECOVERSE_LARAVEL11/public/reverb-test.html" -ForegroundColor Yellow

# Display next steps
Write-Host "`n=========== NEXT STEPS ===========" -ForegroundColor Cyan
Write-Host "1. Make sure Reverb is running by using start-reverb.ps1" -ForegroundColor White
Write-Host "2. Access the test page to verify WebSocket connectivity" -ForegroundColor White
Write-Host "3. Ensure BROADCAST_DRIVER=reverb in .env" -ForegroundColor White
Write-Host "4. Check if BroadcastServiceProvider is registered in config/app.php" -ForegroundColor White
Write-Host "5. Restart your application after making changes" -ForegroundColor White
Write-Host "=================================" -ForegroundColor Cyan

Write-Host "`nPress Enter to exit..." -ForegroundColor Cyan
Read-Host

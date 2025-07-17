# Setup Reverb environment configuration
Write-Host "Setting up Reverb environment configuration..." -ForegroundColor Cyan

$envPath = "$PSScriptRoot\.env"
$envContent = Get-Content $envPath -ErrorAction SilentlyContinue

# Verify broadcasting driver
$broadcastDriver = $envContent | Where-Object { $_ -match "^BROADCAST_DRIVER=" } | ForEach-Object { $_ -replace "^BROADCAST_DRIVER=", "" }
if ($broadcastDriver) {
    $envContent = $envContent -replace "^BROADCAST_DRIVER=.*$", "BROADCAST_DRIVER=reverb"
} else {
    $envContent += "`nBROADCAST_DRIVER=reverb"
}

# Set Reverb configuration
$reverbConfigExists = $envContent | Where-Object { $_ -match "^REVERB_APP_" }
if (!$reverbConfigExists) {
    $envContent += @"

# Reverb WebSocket Configuration
REVERB_APP_ID=ecoverse
REVERB_APP_KEY=ecoverse_key
REVERB_APP_SECRET=ecoverse_secret
REVERB_HOST=127.0.0.1
REVERB_PORT=8080
REVERB_SCHEME=http
"@
}

# Save updated .env file
Set-Content -Path $envPath -Value $envContent

Write-Host "✅ Updated .env file with Reverb configuration" -ForegroundColor Green
Write-Host "Run './start-reverb.ps1' to start the WebSocket server" -ForegroundColor Yellow

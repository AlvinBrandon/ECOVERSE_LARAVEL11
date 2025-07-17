# Ensure Reverb is correctly configured in .env file
Write-Host "Configuring Reverb in .env file..." -ForegroundColor Cyan

# Get the current .env file
$envPath = "$PSScriptRoot\.env"
$envContent = Get-Content -Path $envPath -ErrorAction SilentlyContinue -Raw

if (-not $envContent) {
    Write-Host "❌ .env file not found!" -ForegroundColor Red
    exit 1
}

# Check and update broadcast driver
if ($envContent -match "BROADCAST_DRIVER=") {
    $envContent = $envContent -replace "BROADCAST_DRIVER=.*", "BROADCAST_DRIVER=reverb"
    Write-Host "✅ Updated BROADCAST_DRIVER to 'reverb'" -ForegroundColor Green
} else {
    $envContent += "`nBROADCAST_DRIVER=reverb"
    Write-Host "✅ Added BROADCAST_DRIVER=reverb" -ForegroundColor Green
}

# Check and add Reverb configuration if missing
if (-not ($envContent -match "REVERB_APP_ID=")) {
    $configToAdd = @"

# Reverb WebSocket Configuration
REVERB_APP_ID=ecoverse
REVERB_APP_KEY=ecoverse_key
REVERB_APP_SECRET=ecoverse_secret
"@
    $envContent += $configToAdd
    Write-Host "✅ Added Reverb configuration" -ForegroundColor Green
}

# Save updated .env file
Set-Content -Path $envPath -Value $envContent
Write-Host "✅ .env file updated successfully" -ForegroundColor Green

Write-Host "`nPlease restart Reverb and your application to apply changes" -ForegroundColor Yellow
Write-Host "Run 'start-reverb.ps1' to start the Reverb WebSocket server" -ForegroundColor Yellow

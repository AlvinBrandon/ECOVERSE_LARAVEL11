# Start Laravel Reverb with increased memory
Write-Host "======================================" -ForegroundColor Cyan
Write-Host " Starting Laravel Reverb with 2GB RAM" -ForegroundColor Cyan
Write-Host "======================================" -ForegroundColor Cyan

# Try to get the current memory limit
$currentLimit = php -r "echo ini_get('memory_limit');" 2>$null
Write-Host "Current PHP memory_limit: $currentLimit" -ForegroundColor Yellow

# Start Reverb with increased memory limit
Write-Host "Starting Reverb with 2GB memory limit..." -ForegroundColor Green
php -d memory_limit=2048M artisan reverb:start

# If the above fails, try the custom command
if ($LASTEXITCODE -ne 0) {
    Write-Host "Trying alternative command..." -ForegroundColor Yellow
    php -d memory_limit=2048M artisan reverb:high-memory
    
    # If that fails too, try direct PHP execution of the start script
    if ($LASTEXITCODE -ne 0) {
        Write-Host "Trying direct PHP execution..." -ForegroundColor Yellow
        php -d memory_limit=2048M start-reverb.php
    }
}

@echo off
REM Windows Service script for Laravel Reverb
REM This script ensures Reverb runs with the correct memory settings

SETLOCAL

REM Change to the application directory (absolute path to avoid service issues)
cd /d "C:\xampp\htdocs\ECOVERSE_LARAVEL11"

REM Set PHP executable path - adjust if your PHP is installed elsewhere
SET PHP_PATH=C:\xampp\php\php.exe

REM Log file for output
SET LOG_FILE=storage\logs\reverb-service.log

REM Add timestamp to log
echo [%date% %time%] Starting Reverb service >> %LOG_FILE%

REM Run Reverb with increased memory
"%PHP_PATH%" -d memory_limit=2048M start-reverb.php >> %LOG_FILE% 2>&1

REM If Reverb exits, log it
echo [%date% %time%] Reverb service stopped with exit code %errorlevel% >> %LOG_FILE%

ENDLOCAL

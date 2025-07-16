@echo off
echo =================================================
echo  EcoVerse Reverb Windows Service Manager
echo =================================================
echo.

REM Get current directory
set APP_PATH=%~dp0
set APP_PATH=%APP_PATH:~0,-1%

REM Check if NSSM is available
IF NOT EXIST "%APP_PATH%\tools\nssm.exe" (
    echo NSSM not found! Please run install-nssm.bat first.
    pause
    exit /b 1
)

:MENU
cls
echo EcoVerse Reverb Service Manager
echo =================================================
echo.
echo  1 - Start Reverb service
echo  2 - Stop Reverb service
echo  3 - Restart Reverb service
echo  4 - Check service status
echo  5 - View service logs
echo  6 - Edit service configuration
echo  7 - Test service functionality
echo  8 - Exit
echo.
echo =================================================
echo.

SET /P CHOICE="Enter your choice (1-8): "

IF "%CHOICE%"=="1" GOTO START
IF "%CHOICE%"=="2" GOTO STOP
IF "%CHOICE%"=="3" GOTO RESTART
IF "%CHOICE%"=="4" GOTO STATUS
IF "%CHOICE%"=="5" GOTO LOGS
IF "%CHOICE%"=="6" GOTO EDIT
IF "%CHOICE%"=="7" GOTO TEST
IF "%CHOICE%"=="8" GOTO END

echo Invalid choice. Please try again.
timeout /t 2 >nul
GOTO MENU

:START
echo.
echo Starting Reverb service...
"%APP_PATH%\tools\nssm.exe" start EcoVerseReverb
timeout /t 3 >nul
GOTO MENU

:STOP
echo.
echo Stopping Reverb service...
"%APP_PATH%\tools\nssm.exe" stop EcoVerseReverb
timeout /t 3 >nul
GOTO MENU

:RESTART
echo.
echo Restarting Reverb service...
"%APP_PATH%\tools\nssm.exe" restart EcoVerseReverb
timeout /t 3 >nul
GOTO MENU

:STATUS
echo.
echo Checking Reverb service status...
sc query EcoVerseReverb
echo.
pause
GOTO MENU

:LOGS
echo.
echo Choose log file to view:
echo  1 - Reverb service log
echo  2 - Service stdout log
echo  3 - Service stderr log
echo  4 - Back to main menu
echo.
SET /P LOG_CHOICE="Enter your choice (1-4): "

IF "%LOG_CHOICE%"=="1" (
    type "%APP_PATH%\storage\logs\reverb-service.log"
    echo.
    pause
    GOTO MENU
)
IF "%LOG_CHOICE%"=="2" (
    type "%APP_PATH%\storage\logs\reverb-service-stdout.log"
    echo.
    pause
    GOTO MENU
)
IF "%LOG_CHOICE%"=="3" (
    type "%APP_PATH%\storage\logs\reverb-service-stderr.log"
    echo.
    pause
    GOTO MENU
)
IF "%LOG_CHOICE%"=="4" GOTO MENU

echo Invalid choice. Please try again.
timeout /t 2 >nul
GOTO LOGS

:EDIT
echo.
echo Opening service configuration...
"%APP_PATH%\tools\nssm.exe" edit EcoVerseReverb
GOTO MENU

:TEST
echo.
echo Testing WebSocket connection...
powershell -Command "try { $client = New-Object System.Net.WebSockets.ClientWebSocket; $uri = New-Object System.Uri('ws://localhost:8080'); $task = $client.ConnectAsync($uri, [System.Threading.CancellationToken]::None); $task.Wait(5000); if ($client.State -eq [System.Net.WebSockets.WebSocketState]::Open) { Write-Host 'Connection successful! WebSocket server is running.' -ForegroundColor Green } else { Write-Host 'Connection failed. WebSocket server might not be running.' -ForegroundColor Red } } catch { Write-Host 'Error: ' + $_.Exception.Message -ForegroundColor Red }"
echo.
pause
GOTO MENU

:END
exit /b 0

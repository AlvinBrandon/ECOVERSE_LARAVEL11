@echo off
echo =================================================
echo  EcoVerse Reverb Windows Service Installation
echo =================================================
echo.

REM Ensure we're running as Administrator
NET SESSION >nul 2>&1
IF %ERRORLEVEL% NEQ 0 (
    echo This script must be run as Administrator!
    echo Right-click on the script and select "Run as administrator".
    pause
    exit /b 1
)

REM Get current directory (to handle spaces in path)
set APP_PATH=%~dp0
set APP_PATH=%APP_PATH:~0,-1%

REM Remove trailing slash
IF %APP_PATH:~-1%==\ SET APP_PATH=%APP_PATH:~0,-1%

echo Installing EcoVerse Reverb as a Windows service...
echo.
echo Application path: %APP_PATH%

REM Check if NSSM is available
IF NOT EXIST "%APP_PATH%\tools\nssm.exe" (
    echo NSSM not found! Please run install-nssm.bat first.
    pause
    exit /b 1
)

REM Check if the service script exists
IF NOT EXIST "%APP_PATH%\reverb-service.bat" (
    echo reverb-service.bat not found!
    pause
    exit /b 1
)

echo Installing service "EcoVerseReverb"...

REM Remove existing service if it exists
"%APP_PATH%\tools\nssm.exe" stop EcoVerseReverb >nul 2>&1
"%APP_PATH%\tools\nssm.exe" remove EcoVerseReverb confirm >nul 2>&1

REM Install new service
"%APP_PATH%\tools\nssm.exe" install EcoVerseReverb "%APP_PATH%\reverb-service.bat"

REM Configure service
"%APP_PATH%\tools\nssm.exe" set EcoVerseReverb DisplayName "EcoVerse Reverb WebSocket Server"
"%APP_PATH%\tools\nssm.exe" set EcoVerseReverb Description "Laravel Reverb WebSocket server with increased memory limit for EcoVerse application"
"%APP_PATH%\tools\nssm.exe" set EcoVerseReverb AppDirectory "%APP_PATH%"
"%APP_PATH%\tools\nssm.exe" set EcoVerseReverb AppStdout "%APP_PATH%\storage\logs\reverb-service-stdout.log"
"%APP_PATH%\tools\nssm.exe" set EcoVerseReverb AppStderr "%APP_PATH%\storage\logs\reverb-service-stderr.log"
"%APP_PATH%\tools\nssm.exe" set EcoVerseReverb Start SERVICE_AUTO_START
"%APP_PATH%\tools\nssm.exe" set EcoVerseReverb ObjectName LocalSystem
"%APP_PATH%\tools\nssm.exe" set EcoVerseReverb AppRotateFiles 1
"%APP_PATH%\tools\nssm.exe" set EcoVerseReverb AppRotateSeconds 86400
"%APP_PATH%\tools\nssm.exe" set EcoVerseReverb AppRotateBytes 10485760
"%APP_PATH%\tools\nssm.exe" set EcoVerseReverb AppRestartDelay 10000

echo Service installed successfully!
echo.
echo Starting the service...
"%APP_PATH%\tools\nssm.exe" start EcoVerseReverb

echo.
echo Service installation complete!
echo To manage the service:
echo - Start: tools\nssm.exe start EcoVerseReverb
echo - Stop: tools\nssm.exe stop EcoVerseReverb
echo - Status: sc query EcoVerseReverb
echo.
echo You can also manage it through Windows Services Manager:
echo services.msc
echo.
echo Log files will be available in:
echo %APP_PATH%\storage\logs\reverb-service-stdout.log
echo %APP_PATH%\storage\logs\reverb-service-stderr.log

pause

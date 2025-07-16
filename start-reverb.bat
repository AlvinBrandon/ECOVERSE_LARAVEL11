@echo off
echo ======================================
echo  Starting Laravel Reverb with 2GB RAM
echo ======================================

REM First try with custom INI file
IF EXIST "%~dp0reverb-php.ini" (
    echo Using custom php.ini file: reverb-php.ini
    php -c "%~dp0reverb-php.ini" start-reverb.php
) ELSE (
    REM Fallback to memory_limit parameter
    echo Using memory_limit parameter
    php -d memory_limit=2048M start-reverb.php
)

echo.
echo If Reverb fails to start, try running: php -d memory_limit=2048M artisan reverb:start

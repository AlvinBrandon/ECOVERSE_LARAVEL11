@echo off
echo Checking Python installation...

where python >nul 2>nul
if %errorlevel% neq 0 (
    echo Python is not installed or not in PATH
    echo Please download and install Python from https://www.python.org/downloads/
    echo Make sure to check "Add Python to PATH" during installation
    echo After installation, run this script again
    pause
    exit /b 1
)

echo Python found. Checking version...
python --version

echo.
echo Installing/Upgrading pip...
python -m pip install --upgrade pip

echo.
echo Installing required packages...
pip install -r python/requirements.txt

echo.
echo Creating ML model directories...
if not exist "storage/app/ml/models" mkdir "storage/app/ml/models"

echo.
echo Checking scikit-learn installation...
python -c "import sklearn; print('scikit-learn version:', sklearn.__version__)"

echo.
echo Setup complete! You can now use the ML features.
pause 
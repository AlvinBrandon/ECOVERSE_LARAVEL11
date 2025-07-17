@echo off
echo Downloading NSSM (Non-Sucking Service Manager)...
powershell -Command "Invoke-WebRequest -Uri 'https://nssm.cc/release/nssm-2.24.zip' -OutFile 'tools\nssm-2.24.zip'"

echo Extracting NSSM...
powershell -Command "Expand-Archive -Path 'tools\nssm-2.24.zip' -DestinationPath 'tools' -Force"

echo Moving NSSM to proper location...
if exist tools\nssm-2.24\win64\nssm.exe (
    copy tools\nssm-2.24\win64\nssm.exe tools\nssm.exe
) else (
    copy tools\nssm-2.24\win32\nssm.exe tools\nssm.exe
)

echo NSSM installed successfully!
echo You can now use tools\nssm.exe to create the Reverb service.

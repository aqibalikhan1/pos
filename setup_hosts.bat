@echo off
echo Adding pos.local to hosts file...
echo.

:: Check if running as administrator
net session >nul 2>&1
if %errorLevel% neq 0 (
    echo Please run this script as Administrator!
    pause
    exit /b
)

:: Add entry to hosts file
echo 127.0.0.1 pos.local >> C:\Windows\System32\drivers\etc\hosts
echo 127.0.0.1 www.pos.local >> C:\Windows\System32\drivers\etc\hosts

echo.
echo Hosts file updated successfully!
echo You can now access your POS application at: http://pos.local
echo.
pause

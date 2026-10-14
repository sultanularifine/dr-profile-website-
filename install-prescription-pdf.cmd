@echo off
setlocal
cd /d "%~dp0"
echo This installs the server-side PDF package used for downloadable digital prescriptions.
echo Ensure PHP extensions dom and mbstring are enabled in your Laragon PHP configuration.
echo.
composer require "barryvdh/laravel-dompdf:^3.1"
if errorlevel 1 (
  echo.
  echo PDF dependency installation failed. Check Composer output and PHP extensions, then retry.
  exit /b 1
)
php artisan optimize:clear
if errorlevel 1 (
  echo.
  echo The package was installed, but Laravel cache clearing failed. Check config/view.php and storage/framework/views.
  exit /b 1
)
echo.
echo PDF package installation command completed. Test with a published digital prescription.
endlocal

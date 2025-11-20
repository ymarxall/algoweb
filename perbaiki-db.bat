@echo off
echo ========================================
echo PERBAIKAN DATABASE - ALGO COFFEE
echo ========================================
echo.
echo LANGKAH MANUAL DIPERLUKAN!
echo.
echo 1. Buka phpMyAdmin (http://localhost/phpmyadmin)
echo 2. Pilih database "rpl" di sidebar kiri
echo 3. Klik tab "SQL" di atas
echo 4. Copy-paste isi file "reset-database.sql"
echo 5. Klik tombol "Go" / "Kirim"
echo 6. Setelah selesai, tekan Enter di sini...
echo.
pause

echo.
echo [1/2] Menjalankan migrations...
php artisan migrate --force

echo.
echo [2/2] Mengisi database dengan data dummy...
php artisan db:seed --force

echo.
echo ========================================
echo SELESAI! Cek database di phpMyAdmin
echo Database sudah berisi:
echo - 1 User Kasir
echo - 4 Categories
echo - 12 Menu Items
echo - 10 Tables (Meja)
echo ========================================
echo.
pause

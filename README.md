# LARAVEL REST API TEMPLATE WITH SOA PATTERN
Template untuk membuat REST API dengan Laravel + JWT + SOA (Service-Oriented Architecture).

## Stuktur Folder Tambahan
- Services - Menyimpan Logika Bisnis, dipanggil di Controller
- DTOs - Membungkus data input, agar tidak langsung mengoper $request

## Requirements
- php >= 8.2
- Composer

## Instalasi
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `php artisan jwt:secret`
- buka `.env` kemudian isi variabel `CLIENT_TOKEN` dan `INITIAL_USER_PASSWORD`
- `php artisan migrate` untuk migrasi tabel users dan auth, setelahnya endpoint authentications sudah dapat dicoba dengan user default bawaan: `test@example.com`
- `php artisan make:dto {name}` untuk membuat DTO Class. Ganti `{name}` dengan nama class, contoh: `php artisan make:dto Game`
- `php artisan make:service {name}` untuk membuat Service Class. Ganti `{name}` dengan nama class, contoh: `php artisan make:service GameService`

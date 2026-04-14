# Arafah App

Sistem Pemeriksaan Medis & Resep Obat.

## Instalasi Cepat

1. **Database & Storage**

    ```bash
    php artisan migrate
    php artisan storage:link
    ```

2. **Setup PDF (dompdf)**
   Proyek ini menggunakan `barryvdh/laravel-dompdf`. Jika belum terpasang:
    ```bash
    composer require barryvdh/laravel-dompdf
    ```

## Akun

Buat akun yang harus punya role apoteker atau dokter

```php
// Contoh User Role
User::create([
    'name' => 'Dokter',
    'email' => 'dokter@gmail.com',
    'password' => Hash::make('123456'),
    'role' => 'dokter'
]);

User::create([
    'name' => 'Apoteker',
    'email' => 'apoteker@gmail.com',
    'password' => Hash::make('123456'),
    'role' => 'apoteker'
]);
```

## Cara Menjalankan

```bash
php artisan serve
```

Buka: `http://127.0.0.1:8000`

```

```

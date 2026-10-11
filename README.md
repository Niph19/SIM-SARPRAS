# SIM-SARPRAS

Aplikasi Laravel untuk pengelolaan sarana prasarana sekolah sesuai role admin, petugas sarpras, guru, dan murid.

## Menjalankan aplikasi

1. Siapkan PHP dan Composer, lalu pasang dependensi:

   ```bash
   composer install
   npm install
   ```

2. Salin `.env.example` menjadi `.env`, atur koneksi MySQL/MariaDB pada variabel `DB_*`, lalu buat `APP_KEY`:

   ```bash
   php artisan key:generate
   ```

3. Atur `SARPRAS_ADMIN_EMAIL` dan `SARPRAS_ADMIN_PASSWORD` di `.env` untuk membuat akun admin pertama. Password hanya di-hash saat disimpan.
4. Jalankan migrasi dan buat symlink file publik:

   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```

5. Jalankan Vite dan aplikasi Laravel:

   ```bash
   npm run dev
   php artisan serve
   ```

Registrasi publik selalu membuat akun `murid`. Akun `guru` dan `petugas_sarpras` dibuat dari menu admin.

## Pengujian

Jalankan rangkaian tes otomatis dengan:

```bash
php artisan test
```

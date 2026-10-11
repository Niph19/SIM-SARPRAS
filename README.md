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

Seeder menyediakan data demo yang idempotent untuk menguji pencarian, pagination, dan filter kategori: 12 kategori, 24 ruangan, 120 sarana, 150 laporan, 75 berita acara, serta akun untuk semua role. Jalankan dengan:

```bash
php artisan db:seed
```

Akun demo baru menggunakan password `password`. Akun role utama: `admin@gmail.com`, `petugas_sarpras@gmail.com`, `guru@gmail.com`, dan `murid@gmail.com`. Password akun utama yang sudah ada tidak diubah saat seeder dijalankan ulang.

## Pengujian

Jalankan rangkaian tes otomatis dengan:

```bash
php artisan test
```

<laravel-boost-guidelines>
# Laravel Application

This repository contains a Laravel application. Complete the following setup before working on the user's request.

## Prerequisites

Verify that PHP and Composer are available:

```sh
php -v
composer -V
```

If either command is unavailable, detect the user's operating system and install the prerequisites with the appropriate command:

macOS:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.5)"
```

Windows PowerShell:

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.5'))
```

Linux:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.5)"
```

After installation, ask the user to restart their terminal. If the agent needs the restarted shell to continue, ask the user to reopen their terminal and rerun their original prompt.

## Agent Setup

Install Laravel Boost from the application root before making application changes:

```sh
composer require laravel/boost --dev
php artisan boost:install
```

Boost replaces these bootstrap instructions with guidelines tailored to the application. After installation, read `AGENTS.md` again and continue with the user's original request using the generated guidelines.
</laravel-boost-guidelines>

# PRD: Sistem Informasi Manajemen Sarana Prasarana (SIM-SARPRAS)

## Overview

Web application built with Laravel (MVC, Blade, MySQL) for managing school facilities (sarana prasarana). Four distinct user roles with isolated access. Core workflows: facility data management, damage reporting by students, status tracking by staff, and official incident documentation (berita acara) by teachers and staff.

---

## Tech Stack

- **Framework:** Laravel (latest stable)
- **Frontend:** Blade templating, responsive UI
- **Database:** MySQL / MariaDB
- **Auth:** Laravel built-in auth with role-based middleware
- **File storage:** Local disk (photo uploads)

---

## Role-Based Access Control (RBAC)

Four roles: `admin`, `petugas_sarpras`, `guru`, `murid`.

| Feature / Menu | Admin | Petugas Sarpras | Guru | Murid |
|---|---|---|---|---|
| Login & session | ✓ | ✓ | ✓ | ✓ |
| Register akun baru | ✗ | ✗ | ✗ | ✓ (auto role: murid) |
| Dashboard analitik | ✓ | ✓ | ✗ | ✗ |
| CRUD Sarana | ✓ | ✓ | ✗ | ✗ |
| CRUD Kategori Sarana | ✓ | ✓ | ✗ | ✗ |
| CRUD Ruangan | ✓ | ✓ | ✗ | ✗ |
| Kelola Petugas Sarpras | ✓ | ✗ | ✗ | ✗ |
| Kelola Data Guru | ✓ | ✗ | ✗ | ✗ |
| Buat & kelola Berita Acara | ✓ | ✓ | Buat & view only | ✗ |
| Input Laporan Kerusakan | ✗ | ✗ | ✗ | ✓ (halaman utama) |
| View & update status laporan | ✓ | ✓ (update status) | ✗ | ✓ (riwayat pribadi, read-only) |
| Profil & logout | ✓ | ✓ | ✓ | ✓ |

**Enforcement:** Menu/navigation items hidden per role AND all restricted routes protected by authorization middleware (HTTP 403 on direct URL access).

---

## User Flows

### Admin
1. Login → redirect ke Dashboard.
2. Dashboard menampilkan 3 statistik: **Total Sarana**, **Sarana Bermasalah** (agregat dari laporan aktif murid), **Sarana Dalam Perbaikan**.
3. Akses penuh ke semua menu: Data Sarana, Kategori Sarana, Data Ruangan, Petugas Sarana, Data Guru, Berita Acara.
4. Membuat akun Guru melalui menu Data Guru; akun Petugas Sarpras melalui menu Petugas Sarana.
5. Logout kapan saja.

### Petugas Sarpras
1. Login (akun dibuat oleh Admin) → redirect ke Dashboard statistik.
2. Mengelola Data Sarana, Kategori Sarana, Data Ruangan.
3. Mengubah status laporan sarana (contoh: `pending` → `dalam_perbaikan` → `selesai`).
4. Membuat dan mengelola Berita Acara.
5. **Tidak dapat** mengakses menu Data Guru dan Petugas Sarana — disembunyikan di UI dan dilindungi middleware.
6. Logout.

### Guru
1. Login (akun dibuat oleh Admin) → redirect ke halaman Berita Acara.
2. Mengisi form Berita Acara (kerusakan, pemeliharaan, penghapusan barang).
3. Melihat daftar dan mencetak Berita Acara miliknya.
4. Logout.

### Murid
1. Register mandiri → role `murid` ditetapkan otomatis oleh sistem.
2. Setelah register/login → redirect ke halaman **Laporan Sarana** (halaman utama murid).
3. Mengisi form laporan kerusakan: pilih Ruangan, Sarana, Jenis Kerusakan, Deskripsi, Upload Foto.
4. Membuka menu **Riwayat Laporan** untuk memantau status: `pending` → `dalam_perbaikan` → `selesai`.
5. Edit profil, logout.

---

## Database Schema

### `users`
| Field | Type | Constraint | Keterangan |
|---|---|---|---|
| id | BIGINT | PK, Auto Increment | |
| nama | VARCHAR(100) | NOT NULL | Nama lengkap |
| email | VARCHAR(100) | UNIQUE, NOT NULL | Digunakan untuk login |
| password | VARCHAR(255) | NOT NULL | Bcrypt hash |
| role | ENUM('admin','petugas_sarpras','guru','murid') | NOT NULL | Hak akses |
| created_at | TIMESTAMP | NULLABLE | |
| updated_at | TIMESTAMP | NULLABLE | |

### `kategori_sarana`
| Field | Type | Constraint | Keterangan |
|---|---|---|---|
| id | BIGINT | PK, Auto Increment | |
| nama_kategori | VARCHAR(100) | NOT NULL | Contoh: Elektronik, Meubel |
| deskripsi | TEXT | NULLABLE | |

### `ruangan`
| Field | Type | Constraint | Keterangan |
|---|---|---|---|
| id | BIGINT | PK, Auto Increment | |
| kode_ruangan | VARCHAR(50) | UNIQUE, NOT NULL | Contoh: LAB-RPL-01 |
| nama_ruangan | VARCHAR(100) | NOT NULL | Contoh: Lab Komputer 1 |
| lokasi | VARCHAR(100) | NULLABLE | Gedung / Lantai |

### `sarana`
| Field | Type | Constraint | Keterangan |
|---|---|---|---|
| id | BIGINT | PK, Auto Increment | |
| kode_sarana | VARCHAR(50) | UNIQUE, NOT NULL | |
| nama_sarana | VARCHAR(150) | NOT NULL | |
| id_kategori | BIGINT | FK → `kategori_sarana.id` | |
| id_ruangan | BIGINT | FK → `ruangan.id` | Penempatan ruangan |
| kondisi | ENUM('baik','rusak_ringan','rusak_berat') | NOT NULL | |
| status_perbaikan | ENUM('normal','dalam_perbaikan') | NOT NULL | |
| jumlah | INT | DEFAULT 1 | Jumlah unit |

### `laporan_sarana`
| Field | Type | Constraint | Keterangan |
|---|---|---|---|
| id | BIGINT | PK, Auto Increment | |
| id_murid | BIGINT | FK → `users.id` | Pelapor |
| id_sarana | BIGINT | FK → `sarana.id` | |
| id_ruangan | BIGINT | FK → `ruangan.id` | Lokasi barang saat dilaporkan |
| deskripsi_kerusakan | TEXT | NOT NULL | |
| foto | VARCHAR(255) | NULLABLE | Path file bukti foto |
| status | ENUM('pending','dalam_perbaikan','selesai','ditolak') | NOT NULL, DEFAULT 'pending' | |
| tanggal_laporan | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | |

### `berita_acara`
| Field | Type | Constraint | Keterangan |
|---|---|---|---|
| id | BIGINT | PK, Auto Increment | |
| no_berita_acara | VARCHAR(100) | UNIQUE, NOT NULL | Nomor dokumen resmi |
| id_user_pembuat | BIGINT | FK → `users.id` | Admin / Petugas / Guru |
| id_sarana | BIGINT | FK → `sarana.id` | |
| jenis_tindakan | ENUM('perbaikan','pemeliharaan','penghapusan') | NOT NULL | |
| keterangan | TEXT | NOT NULL | Uraian hasil pemeriksaan |
| tanggal | DATE | NOT NULL | |

---

## Feature Specifications

### Authentication & Authorization
- Laravel session-based auth.
- Middleware per role group; unauthorized access returns HTTP 403 or redirects to login.
- Register route only creates `murid` role — role field not exposed to input.
- Password hashed with Bcrypt.

### Dashboard (Admin & Petugas Sarpras)
- Stat card 1: **Total Sarana** — count of all records in `sarana`.
- Stat card 2: **Sarana Bermasalah** — count of `laporan_sarana` where `status` IN (`pending`, `dalam_perbaikan`).
- Stat card 3: **Sarana Dalam Perbaikan** — count of `sarana` where `status_perbaikan = 'dalam_perbaikan'`.
- Stats update in real-time on page load (no polling required).

### CRUD Sarana
- Fields: kode_sarana, nama_sarana, id_kategori, id_ruangan, kondisi, status_perbaikan, jumlah.
- kode_sarana must be unique; validate on create and edit.
- Kategori and ruangan populated from their respective tables via dropdowns.

### CRUD Kategori Sarana
- Fields: nama_kategori, deskripsi.
- Prevent delete if referenced by any `sarana` record (FK constraint or soft check).

### CRUD Ruangan
- Fields: kode_ruangan (unique), nama_ruangan, lokasi.

### Kelola Data Guru & Petugas Sarpras (Admin only)
- Admin creates accounts for `guru` and `petugas_sarpras` roles.
- Form: nama, email, password (admin sets it), role (fixed per menu context).
- Admin can edit and delete these accounts.

### Laporan Sarana (Murid)
- Form fields: id_ruangan (dropdown), id_sarana (dropdown, ideally filtered by ruangan), jenis_kerusakan (free text or dropdown), deskripsi_kerusakan (textarea), foto (file upload, optional).
- On submit: creates `laporan_sarana` record with `status = 'pending'` and `id_murid = auth()->id()`.
- Riwayat Laporan: murid sees only their own laporan, with current status visible.

### Status Update Laporan (Petugas Sarpras & Admin)
- View all incoming laporan with filtering by status.
- Can change status: `pending` → `dalam_perbaikan` → `selesai` or `ditolak`.
- Status change on laporan should reflect on Dashboard stats immediately.

### Berita Acara (Admin, Petugas Sarpras, Guru)
- Form fields: no_berita_acara (manual input, unique), id_sarana (dropdown), jenis_tindakan (dropdown), keterangan (textarea), tanggal (date picker).
- `id_user_pembuat` set automatically to `auth()->id()`.
- List view shows all berita acara; Guru sees only their own.
- Print/export to PDF per record (browser print or PDF generation).

### Profil
- All roles can edit nama, email, password.

---

## Routing Structure (Reference)

```
GET  /                          → redirect based on role
GET  /login                     → login form
POST /login                     → authenticate
GET  /register                  → register form (public)
POST /register                  → store murid
POST /logout                    → logout

# Admin & Petugas Sarpras
GET  /dashboard                 → Dashboard stats

# Admin only
GET|POST|PUT|DELETE /guru           → CRUD Data Guru
GET|POST|PUT|DELETE /petugas        → CRUD Petugas Sarpras

# Admin & Petugas Sarpras
GET|POST|PUT|DELETE /sarana         → CRUD Sarana
GET|POST|PUT|DELETE /kategori       → CRUD Kategori Sarana
GET|POST|PUT|DELETE /ruangan        → CRUD Ruangan
GET|POST|PUT|DELETE /berita-acara   → CRUD Berita Acara
GET|PATCH /laporan/{id}/status      → Update status laporan

# Guru
GET|POST      /berita-acara         → Buat & view berita acara (filtered)

# Murid
GET|POST /laporan                   → Halaman utama + form laporan
GET      /laporan/riwayat           → Riwayat laporan murid

# Semua role
GET|PUT  /profil                    → Edit profil
```

---

## Constraints & Business Rules

1. Murid cannot access any route outside `/laporan`, `/laporan/riwayat`, `/profil`, and auth routes.
2. Guru cannot access dashboard, sarana management, or any laporan management route.
3. Petugas Sarpras cannot access `/guru` or `/petugas` routes — both hidden in nav and blocked by middleware.
4. `no_berita_acara` is manually entered and must be unique across the table.
5. Photo upload for laporan is optional but if provided, stored in `storage/app/public/laporan/` with path saved in `foto` field.
6. Dashboard stat **Sarana Bermasalah** is derived from `laporan_sarana` (active laporan count), not from `sarana.kondisi`.
7. Deleting a sarana that has existing laporan or berita acara should be blocked or handled with a warning.
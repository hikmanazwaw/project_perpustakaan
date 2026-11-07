# Mini Digital Library

Aplikasi manajemen perpustakaan mini (PHP Native + MySQL + Bootstrap 5) untuk mata kuliah **Pemrograman Web** – Program Studi Sistem Informasi.

## Identitas

Nama : Hikma Nazwa Agustin
NIM : 2513020076

## Fitur

- **Autentikasi**: login POST, session, "Remember Me" (cookie username 30 hari), logout aman (hapus session & cookie).
- **CRUD Buku**: judul, kategori, penulis, tahun terbit, stok/status ketersediaan.
- **Upload sampul**: .jpg/.png, maks 2 MB, validasi ekstensi + MIME + isi gambar; file disimpan di `uploads/`, nama file di database.
- **Hapus**: data MySQL + file sampul (`unlink`) ikut terhapus.
- **Logika bisnis**: stok > 0 → "Tersedia", stok = 0 → "Dipinjam" (if-else), kategori memakai array.
- **Keamanan**: prepared statements (mysqli), `password_hash/password_verify`, `session_regenerate_id`, token CSRF pada create/update/delete, escape output (`htmlspecialchars`).
- **UI**: Bootstrap 5 (CDN) + `css/style.css` + `js/style.js` (toggle password, preview gambar, konfirmasi hapus, validasi sisi klien).

## Struktur Folder

```
project_perpustakaan/
├── config/koneksi.php
├── includes/ (auth.php, header.php, footer.php, form_buku.php)
├── css/style.css
├── js/style.js
├── uploads/
├── database.sql
├── index.php, proses_login.php, logout.php
├── dashboard.php
├── tambah_buku.php, proses_tambah.php
├── edit_buku.php, proses_edit.php
└── hapus_buku.php
```

## Akun Demo

| Username | Password |
| -------- | -------- |
| admin    | admin123 |

## Catatan

- Koneksi internet diperlukan untuk memuat Bootstrap dari CDN.
- Cookie "Remember Me" hanya menyimpan username, tidak pernah password.
- Batas upload PHP (`upload_max_filesize`, `post_max_size`) minimal 2M di `php.ini`.

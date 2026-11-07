# Mini Digital Library

Aplikasi manajemen perpustakaan mini berbasis PHP Native, MySQL, dan Bootstrap 5 yang dikembangkan untuk memenuhi tugas mata kuliah **Pemrograman Web** – Program Studi Sistem Informasi.

---

## Identitas

- **Nama**: Hikma Nazwa Agustin
- **NIM**: 2513020076

---

## Fitur Utama

- **Autentikasi Aman**: Login POST, manajemen Session, fitur "Remember Me" (Cookie username 30 hari), dan Logout aman (menghapus session & cookie).
- **CRUD Data Buku**: Pengelolaan data buku meliputi judul, kategori, penulis, tahun terbit, stok, serta status ketersediaan.
- **Upload Sampul Buku**: Menerima format `.jpg` dan `.png` (maksimal 2 MB) dengan validasi ketat (ekstensi, MIME type, serta cek isi gambar). File disimpan di folder `uploads/` dan nama filenya disimpan pada database.
- **Penanganan Penghapusan (Delete)**: Menghapus data pada database MySQL sekaligus menghapus berkas gambar terkait dari server (`unlink`).
- **Logika Bisnis**: Stok > 0 bertanda "Tersedia", sedangkan Stok = 0 otomatis bertanda "Dipinjam" (logika conditional `if-else`). Kategori dikelola menggunakan struktur array.
- **Keamanan (Security)**:
  - Prepared Statements (`mysqli`) untuk mencegah SQL Injection.
  - `password_hash()` & `password_verify()` untuk keamanan kata sandi.
  - `session_regenerate_id()` untuk mencegah Session Fixation.
  - Token CSRF pada aksi Create, Update, dan Delete.
  - Escaping output (`htmlspecialchars`) untuk mengantisipasi serangan XSS.
- **Antarmuka (UI/UX)**: Bootstrap 5 (CDN) dipadu dengan `css/style.css` dan `js/style.js` (fitur toggle password, live preview gambar, dialog konfirmasi hapus, dan validasi di sisi klien).

---

## Struktur Folder

```text
project_perpustakaan/
├── config/
│   └── koneksi.php
├── includes/
│   ├── auth.php
│   ├── header.php
│   ├── footer.php
│   └── form_buku.php
├── css/
│   └── style.css
├── js/
│   └── style.js
├── uploads/
├── screenshoot/
│   ├── 1login.png
│   ├── 2tampilan.png
│   ├── 3tambah1.png
│   ├── 3tambah2.png
│   ├── 4tampilantambah.png
│   ├── 5edit.png
│   ├── 5edit2.png
│   └── 6hapus.png
├── database.sql
├── index.php
├── proses_login.php
├── logout.php
├── dashboard.php
├── tambah_buku.php
├── proses_tambah.php
├── edit_buku.php
├── proses_edit.php
└── hapus_buku.php
```

---

## Akun Demo

| Username | Password   |
| -------- | ---------- |
| `admin`  | `admin123` |

---

## Lampiran Mini Digital Perpustakaan

Berikut adalah tampilan antarmuka dari aplikasi Mini Digital Perpustakaan:

### 1. Halaman Login

![Halaman Login](screenshoot/1login.png)
_Keterangan: Halaman awal autentikasi pengguna. Dilengkapi dengan form masukan username, password (dengan toggle perlihatkan password), serta opsi "Remember Me"._

### 2. Dashboard / Daftar Buku

![Dashboard](screenshoot/2tampilan.png)
_Keterangan: Halaman utama setelah berhasil login. Menampilkan tabel daftar koleksi buku, pencarian, status ketersediaan (Tersedia/Dipinjam), serta tombol aksi untuk Tambah, Edit, dan Hapus._

### 3. Form Tambah Buku

![Tambah Buku](screenshoot/3tambahbuku1.png)
![Tambah Buku](screenshoot/3tambahbuku2.png)
![Tambah Buku](screenshoot/3tambahbuku3.png)
_Keterangan: Formulir input untuk menambahkan data buku baru ke perpustakaan beserta upload gambar sampul dan pratinjau (preview) gambar._

### 4. Form Edit Buku

![Edit Buku](screenshoot/5edit.png)
![Edit Buku](screenshoot/5edit2.png)
_Keterangan: Halaman pengubahan data buku yang sudah ada, termasuk opsi pembaruan sampul buku._

### 5. Konfirmasi Hapus Data

![Hapus Buku](screenshoot/6hapus.png)
_Keterangan: Dialog konfirmasi keamanan saat menghapus data buku untuk mencegah aksi tidak disengaja._

---

## Catatan Penggunaan

1. **Koneksi Internet**: Diperlukan untuk memuat library pustaka Bootstrap 5 via CDN.
2. **Cookie Security**: Fitur "Remember Me" hanya menyimpan data username dalam cookie dan tidak pernah menyimpan password.
3. **Konfigurasi PHP**: Pastikan konfigurasi `upload_max_filesize` dan `post_max_size` pada `php.ini` bernilai minimal **2M**.

---

## Link Demonstrasi Video

- **YouTube**: [Lihat Video Demo Aplikasi](https://youtu.be/BGXWxFxnXnE?si=RBoBsQk9L09BcgY_)

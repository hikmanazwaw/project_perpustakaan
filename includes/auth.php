<?php
// Helper umum: session, proteksi login, flash message, CSRF, status buku, upload
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/koneksi.php';

define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE', 2 * 1024 * 1024); // 2 MB

function e($str) { return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8'); }

function wajib_login() {
    if (empty($_SESSION['user_id'])) {
        header("Location: index.php?pesan=belum_login");
        exit;
    }
}

function set_flash($tipe, $pesan) { $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan]; }
function get_flash() {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

function csrf_token() {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_valid($token) {
    return !empty($_SESSION['csrf']) && is_string($token) && hash_equals($_SESSION['csrf'], $token);
}

// Logika bisnis: label status berdasarkan stok (if-else)
function label_status($stok) {
    if ($stok > 0) return ['Tersedia', 'success'];
    return ['Dipinjam', 'danger'];
}

// Array daftar kategori
function daftar_kategori() {
    return ['Teknologi', 'Sains', 'Sastra', 'Sejarah', 'Bisnis', 'Pendidikan', 'Lainnya'];
}

/**
 * Validasi & simpan file sampul. Return nama file, atau null jika tidak ada file.
 * Jika gagal, isi $error.
 */
function upload_sampul($file, &$error) {
    $error = '';
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) return null;
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $error = ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE)
            ? "Ukuran file melebihi batas." : "Upload gagal (kode {$file['error']}).";
        return null;
    }
    if ($file['size'] > MAX_FILE_SIZE) { $error = "Ukuran file maksimal 2 MB."; return null; }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png'], true)) { $error = "Format file harus .jpg atau .png."; return null; }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    if (!in_array($mime, ['image/jpeg', 'image/png'], true) || @getimagesize($file['tmp_name']) === false) {
        $error = "File bukan gambar JPG/PNG yang valid."; return null;
    }

    if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0755, true);
    $namaBaru = 'sampul_' . bin2hex(random_bytes(8)) . '.' . ($mime === 'image/png' ? 'png' : 'jpg');
    if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $namaBaru)) {
        $error = "Gagal menyimpan file ke server."; return null;
    }
    return $namaBaru;
}

function hapus_file_sampul($nama) {
    if ($nama) {
        $path = UPLOAD_DIR . basename($nama);
        if (is_file($path)) unlink($path);
    }
}

// Validasi input buku, return array error
function validasi_buku($d) {
    $err = [];
    if ($d['judul'] === '' || mb_strlen($d['judul']) > 200) $err[] = "Judul wajib diisi (maks 200 karakter).";
    if (!in_array($d['kategori'], daftar_kategori(), true)) $err[] = "Kategori tidak valid.";
    if ($d['penulis'] === '') $err[] = "Penulis wajib diisi.";
    if (!ctype_digit($d['tahun']) || (int)$d['tahun'] < 1900 || (int)$d['tahun'] > (int)date('Y') + 1) $err[] = "Tahun terbit tidak valid.";
    if (!ctype_digit($d['stok'])) $err[] = "Stok harus berupa angka bulat >= 0.";
    return $err;
}

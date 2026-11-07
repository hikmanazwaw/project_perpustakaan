<?php
require_once __DIR__ . '/includes/auth.php';
wajib_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valid($_POST['csrf'] ?? '')) {
    set_flash('danger', 'Permintaan tidak valid.');
    header("Location: dashboard.php"); exit;
}

$d = [
    'judul'    => trim($_POST['judul'] ?? ''),
    'kategori' => trim($_POST['kategori'] ?? ''),
    'penulis'  => trim($_POST['penulis'] ?? ''),
    'tahun'    => trim($_POST['tahun_terbit'] ?? ''),
    'stok'     => trim($_POST['stok'] ?? ''),
];
$errors = validasi_buku($d);

$namaFile = upload_sampul($_FILES['sampul'] ?? null, $errUpload);
if ($errUpload) $errors[] = $errUpload;

if ($errors) {
    hapus_file_sampul($namaFile);
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = ['judul'=>$d['judul'],'kategori'=>$d['kategori'],'penulis'=>$d['penulis'],'tahun_terbit'=>$d['tahun'],'stok'=>$d['stok'],'sampul'=>''];
    header("Location: tambah_buku.php"); exit;
}

$tahun = (int)$d['tahun']; $stok = (int)$d['stok'];
$stmt = $koneksi->prepare("INSERT INTO buku (judul, kategori, penulis, tahun_terbit, stok, sampul) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiis", $d['judul'], $d['kategori'], $d['penulis'], $tahun, $stok, $namaFile);
$stmt->execute();

set_flash('success', 'Buku berhasil ditambahkan.');
header("Location: dashboard.php");
exit;

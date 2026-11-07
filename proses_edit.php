<?php
require_once __DIR__ . '/includes/auth.php';
wajib_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valid($_POST['csrf'] ?? '')) {
    set_flash('danger', 'Permintaan tidak valid.');
    header("Location: dashboard.php"); exit;
}

$id = (int)($_POST['id'] ?? 0);
$stmt = $koneksi->prepare("SELECT sampul FROM buku WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$lama = $stmt->get_result()->fetch_assoc();
if (!$lama) { set_flash('danger', 'Data buku tidak ditemukan.'); header("Location: dashboard.php"); exit; }

$d = [
    'judul'    => trim($_POST['judul'] ?? ''),
    'kategori' => trim($_POST['kategori'] ?? ''),
    'penulis'  => trim($_POST['penulis'] ?? ''),
    'tahun'    => trim($_POST['tahun_terbit'] ?? ''),
    'stok'     => trim($_POST['stok'] ?? ''),
];
$errors = validasi_buku($d);

$namaBaru = upload_sampul($_FILES['sampul'] ?? null, $errUpload);
if ($errUpload) $errors[] = $errUpload;

if ($errors) {
    hapus_file_sampul($namaBaru);
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = ['judul'=>$d['judul'],'kategori'=>$d['kategori'],'penulis'=>$d['penulis'],'tahun_terbit'=>$d['tahun'],'stok'=>$d['stok']];
    header("Location: edit_buku.php?id=$id"); exit;
}

$tahun = (int)$d['tahun']; $stok = (int)$d['stok'];
if ($namaBaru) {
    $stmt = $koneksi->prepare("UPDATE buku SET judul=?, kategori=?, penulis=?, tahun_terbit=?, stok=?, sampul=? WHERE id=?");
    $stmt->bind_param("sssiisi", $d['judul'], $d['kategori'], $d['penulis'], $tahun, $stok, $namaBaru, $id);
    $stmt->execute();
    hapus_file_sampul($lama['sampul']); // hapus sampul lama
} else {
    $stmt = $koneksi->prepare("UPDATE buku SET judul=?, kategori=?, penulis=?, tahun_terbit=?, stok=? WHERE id=?");
    $stmt->bind_param("sssiii", $d['judul'], $d['kategori'], $d['penulis'], $tahun, $stok, $id);
    $stmt->execute();
}

set_flash('success', 'Data buku berhasil diperbarui.');
header("Location: dashboard.php");
exit;

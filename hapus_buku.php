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
$buku = $stmt->get_result()->fetch_assoc();

if ($buku) {
    $stmt = $koneksi->prepare("DELETE FROM buku WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    hapus_file_sampul($buku['sampul']); // unlink file gambar
    set_flash('success', 'Buku berhasil dihapus.');
} else {
    set_flash('danger', 'Data buku tidak ditemukan.');
}
header("Location: dashboard.php");
exit;

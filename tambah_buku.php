<?php
require_once __DIR__ . '/includes/auth.php';
wajib_login();

$data = $_SESSION['old'] ?? ['judul'=>'','kategori'=>'','penulis'=>'','tahun_terbit'=>'','stok'=>'1','sampul'=>''];
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['old'], $_SESSION['errors']);

$judulHalaman = 'Tambah Buku';
include __DIR__ . '/includes/header.php';
?>
<div class="card shadow-sm border-0">
  <div class="card-header bg-white py-3"><h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Buku</h5></div>
  <div class="card-body">
    <?php $aksi = 'proses_tambah.php'; $tombol = 'Simpan'; include __DIR__ . '/includes/form_buku.php'; ?>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>

<?php
require_once __DIR__ . '/includes/auth.php';
wajib_login();

$id = (int)($_GET['id'] ?? 0);
$stmt = $koneksi->prepare("SELECT * FROM buku WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$buku = $stmt->get_result()->fetch_assoc();
if (!$buku) { set_flash('danger', 'Data buku tidak ditemukan.'); header("Location: dashboard.php"); exit; }

$data = $_SESSION['old'] ?? $buku;
if (isset($_SESSION['old'])) $data['sampul'] = $buku['sampul'];
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['old'], $_SESSION['errors']);

$judulHalaman = 'Edit Buku';
include __DIR__ . '/includes/header.php';
?>
<div class="card shadow-sm border-0">
  <div class="card-header bg-white py-3"><h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Buku</h5></div>
  <div class="card-body">
    <?php $aksi = 'proses_edit.php'; $tombol = 'Perbarui'; include __DIR__ . '/includes/form_buku.php'; ?>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>

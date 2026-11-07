<?php
require_once __DIR__ . '/includes/auth.php';
wajib_login();

$cari = trim($_GET['cari'] ?? '');
if ($cari !== '') {
    $like = "%$cari%";
    $stmt = $koneksi->prepare("SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ? OR kategori LIKE ? ORDER BY id DESC");
    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $koneksi->query("SELECT * FROM buku ORDER BY id DESC");
}
$rows = $result->fetch_all(MYSQLI_ASSOC);

$total = $koneksi->query("SELECT COUNT(*) c FROM buku")->fetch_assoc()['c'];
$tersedia = $koneksi->query("SELECT COUNT(*) c FROM buku WHERE stok > 0")->fetch_assoc()['c'];
$dipinjam = $total - $tersedia;

$judulHalaman = 'Dashboard';
include __DIR__ . '/includes/header.php';
?>
<div class="row g-3 mb-4">
  <div class="col-12 col-md-4"><div class="card stat-card bg-primary text-white"><div class="card-body d-flex justify-content-between align-items-center">
    <div><div class="small">Total Buku</div><div class="fs-2 fw-bold"><?= $total ?></div></div><i class="bi bi-journal-bookmark fs-1 opacity-50"></i></div></div></div>
  <div class="col-6 col-md-4"><div class="card stat-card bg-success text-white"><div class="card-body d-flex justify-content-between align-items-center">
    <div><div class="small">Tersedia</div><div class="fs-2 fw-bold"><?= $tersedia ?></div></div><i class="bi bi-check-circle fs-1 opacity-50"></i></div></div></div>
  <div class="col-6 col-md-4"><div class="card stat-card bg-danger text-white"><div class="card-body d-flex justify-content-between align-items-center">
    <div><div class="small">Dipinjam</div><div class="fs-2 fw-bold"><?= $dipinjam ?></div></div><i class="bi bi-arrow-left-right fs-1 opacity-50"></i></div></div></div>
</div>

<div class="card shadow-sm border-0">
  <div class="card-header bg-white py-3">
    <div class="row g-2 align-items-center">
      <div class="col-12 col-md"><h5 class="mb-0 fw-bold">Daftar Buku</h5></div>
      <div class="col-12 col-md-5">
        <form method="GET" class="input-group">
          <input type="text" name="cari" class="form-control" placeholder="Cari judul / penulis / kategori" value="<?= e($cari) ?>">
          <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
        </form>
      </div>
      <div class="col-12 col-md-auto"><a href="tambah_buku.php" class="btn btn-primary w-100"><i class="bi bi-plus-lg"></i> Tambah Buku</a></div>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr><th>#</th><th>Sampul</th><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Tahun</th><th>Stok</th><th>Status</th><th class="text-end">Aksi</th></tr>
      </thead>
      <tbody>
      <?php if (!$rows): ?>
        <tr><td colspan="9" class="text-center text-muted py-4">Belum ada data buku.</td></tr>
      <?php endif; ?>
      <?php foreach ($rows as $i => $b): [$label, $warna] = label_status($b['stok']); ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td>
            <?php if ($b['sampul'] && is_file(UPLOAD_DIR . $b['sampul'])): ?>
              <img src="uploads/<?= e($b['sampul']) ?>" class="cover-thumb" alt="Sampul" data-bs-toggle="modal" data-bs-target="#modalSampul" data-src="uploads/<?= e($b['sampul']) ?>">
            <?php else: ?>
              <div class="cover-thumb cover-empty"><i class="bi bi-image"></i></div>
            <?php endif; ?>
          </td>
          <td class="fw-semibold"><?= e($b['judul']) ?></td>
          <td><span class="badge text-bg-light border"><?= e($b['kategori']) ?></span></td>
          <td><?= e($b['penulis']) ?></td>
          <td><?= e($b['tahun_terbit']) ?></td>
          <td><?= (int)$b['stok'] ?></td>
          <td><span class="badge text-bg-<?= $warna ?>"><?= $label ?></span></td>
          <td class="text-end text-nowrap">
            <a href="edit_buku.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
            <form action="hapus_buku.php" method="POST" class="d-inline form-hapus" data-judul="<?= e($b['judul']) ?>">
              <input type="hidden" name="id" value="<?= $b['id'] ?>">
              <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
              <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="modalSampul" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
  <div class="modal-body p-2 text-center"><img id="imgSampulBesar" src="" class="img-fluid rounded" alt="Sampul"></div>
</div></div></div>
<?php include __DIR__ . '/includes/footer.php'; ?>

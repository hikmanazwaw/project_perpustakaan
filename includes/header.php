<?php
$judulHalaman = $judulHalaman ?? 'Mini Digital Library';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($judulHalaman) ?> | Mini Digital Library</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark app-navbar">
  <div class="container">
    <a class="navbar-brand fw-bold" href="dashboard.php"><i class="bi bi-book-half me-2"></i>Mini Digital Library</a>
    <div class="d-flex align-items-center gap-3 text-white">
      <span class="small d-none d-sm-inline"><i class="bi bi-person-circle me-1"></i><?= e($_SESSION['nama'] ?? '') ?></span>
      <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
  </div>
</nav>
<main class="container py-4">
<?php if ($f = get_flash()): ?>
  <div class="alert alert-<?= e($f['tipe']) ?> alert-dismissible fade show auto-dismiss" role="alert">
    <?= e($f['pesan']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<?php
require_once __DIR__ . '/includes/auth.php';
if (!empty($_SESSION['user_id'])) { header("Location: dashboard.php"); exit; }

$usernameCookie = $_COOKIE['remember_username'] ?? '';
$pesan = $_GET['pesan'] ?? '';
$info = [
    'belum_login' => ['warning', 'Silakan login terlebih dahulu.'],
    'logout'      => ['success', 'Anda berhasil logout.'],
    'gagal'       => ['danger',  'Username atau password salah.'],
    'kosong'      => ['danger',  'Username dan password wajib diisi.'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Mini Digital Library</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body class="login-page">
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-11 col-sm-8 col-md-6 col-lg-4">
        <div class="card login-card shadow-lg border-0">
          <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
              <i class="bi bi-book-half display-4 text-primary"></i>
              <h4 class="fw-bold mt-2 mb-0">Mini Digital Library</h4>
              <p class="text-muted small">Masuk untuk mengelola koleksi buku</p>
            </div>
            <?php if (isset($info[$pesan])): ?>
              <div class="alert alert-<?= $info[$pesan][0] ?> py-2 small"><?= $info[$pesan][1] ?></div>
            <?php endif; ?>
            <form action="proses_login.php" method="POST" novalidate>
              <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person"></i></span>
                  <input type="text" name="username" class="form-control" value="<?= e($usernameCookie) ?>" required autofocus>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-lock"></i></span>
                  <input type="password" name="password" id="password" class="form-control" required>
                  <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="bi bi-eye"></i></button>
                </div>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" <?= $usernameCookie ? 'checked' : '' ?>>
                <label class="form-check-label small" for="remember">Remember Me</label>
              </div>
              <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
            </form>
            <p class="text-center text-muted small mt-3 mb-0">Demo: admin / admin123</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/style.js"></script>
</body>
</html>

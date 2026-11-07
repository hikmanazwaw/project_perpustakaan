<?php
require_once __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: index.php"); exit; }

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') { header("Location: index.php?pesan=kosong"); exit; }

$stmt = $koneksi->prepare("SELECT id, username, password, nama_lengkap FROM users WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(true);
    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nama']     = $user['nama_lengkap'];

    // Cookie "Remember Me": hanya menyimpan username (bukan password)
    if (isset($_POST['remember'])) {
        setcookie('remember_username', $user['username'], [
            'expires' => time() + (30 * 24 * 3600), 'path' => '/', 'httponly' => true, 'samesite' => 'Lax'
        ]);
    } else {
        setcookie('remember_username', '', time() - 3600, '/');
    }
    header("Location: dashboard.php");
    exit;
}

header("Location: index.php?pesan=gagal");
exit;

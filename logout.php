<?php
session_start();
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();
setcookie('remember_username', '', time() - 3600, '/');
header("Location: index.php?pesan=logout");
exit;

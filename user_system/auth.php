<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Optional: Restrict guests from accessing dashboard
if ($_SESSION['role'] === 'guest' && basename($_SERVER['PHP_SELF']) === 'admin_dashboard.php') {
    header("Location: ../index.php");
    exit();
}
?>
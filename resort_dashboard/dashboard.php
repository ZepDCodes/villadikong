<?php
session_start();

if (!isset($_SESSION["role"])) {
    header("Location: user_system/login.php");
    exit();
}

if ($_SESSION["role"] === "admin") {
    header("Location: admin_dashboard/admin_dashboard.php");
    exit();
} elseif ($_SESSION["role"] === "guest") {
    header("Location: customer_dashboard/customer_dashboard.php");
    exit();
} else {
    // Fallback (in case new roles are added in future)
    header("Location: user_system/login.php");
    exit();
}
?>
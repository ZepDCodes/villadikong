<?php
session_start();
$conn = new mysqli("localhost", "root", "", "resort_db");

if ($_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

if (isset($_POST["review_id"])) {
    $id = intval($_POST["review_id"]);
    $stmt = $conn->prepare("DELETE FROM reviews WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: ../resort_dashboard/admin_dashboard/admin_dashboard.php");
exit();

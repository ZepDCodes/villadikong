<?php
session_start();

$conn = new mysqli("localhost", "root", "", "resort_db");

if ($_SESSION["role"] !== "admin") {
    header("Location: ../user_system/login.php");
    exit();
}

if (isset($_POST["review_id"], $_POST["status"])) {
    $id = intval($_POST["review_id"]);
    $status = $_POST["status"];

    $stmt = $conn->prepare("UPDATE resort_db.reviews SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

header("Location: ../resort_dashboard/admin_dashboard.php");
exit();
?>
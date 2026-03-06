<?php
session_start();

// Only allow admin access
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

// Connect to DB
$conn = new mysqli("localhost", "root", "", "resort_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete Room
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["room_id"])) {
    $room_id = intval($_POST["room_id"]);

    $stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
    $stmt->bind_param("i", $room_id);

    if ($stmt->execute()) {
        header("Location: ../resort_dashboard/admin_dashboard/admin_dashboard.php?success=Room deleted successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

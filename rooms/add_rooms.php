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

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_number = trim($_POST["room_number"]);
    $type = trim($_POST["type"]);
    $price = floatval($_POST["price"]);
    $status = $_POST["status"];

    if (!empty($room_number) && !empty($type) && $price > 0) {
        $stmt = $conn->prepare("INSERT INTO rooms (room_number, type, price, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $room_number, $type, $price, $status);

        if ($stmt->execute()) {
            // ✅ Redirect back with a success message
            header("Location: ../resort_dashboard/admin_dashboard/admin_dashboard.php?success=1");
            exit();
        } else {
            // Redirect with an error
            header("Location: ../resort_dashboard/admin_dashboard/admin_dashboard.php?error=" . urlencode($conn->error));
            exit();
        }
    } else {
        // Redirect if fields missing
        header("Location: ../resort_dashboard/admin_dashboard/admin_dashboard.php?error=" . urlencode("Please fill in all fields"));
        exit();
    }
}
?>

<?php
session_start();

// Require login
if (!isset($_SESSION["role"])) {
    header("Location: ../user_system/login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["booking_id"])) {
    $booking_id = intval($_POST["booking_id"]);
    $role = $_SESSION["role"];
    $redirect = "";

    if ($role === "admin") {
        // Admin: can delete pending bookings
        $stmt = $conn->prepare("DELETE FROM resort_db.bookings WHERE id = ? AND status = 'Pending'");
        $redirect = "../resort_dashboard/admin_dashboard.php?msg=Booking+deleted";
    } elseif ($role === "guest") {
        // Customer: can delete only their own cancelled bookings
        $email = $_SESSION["email"];
        $stmt = $conn->prepare("DELETE FROM resort_db.bookings WHERE id = ? AND email = ? AND status = 'Cancelled'");
        $stmt->bind_param("is", $booking_id, $email);
        $redirect = "../resort_dashboard/customer_dashboard.php?msg=Booking+deleted";
    }

    if (isset($stmt)) {
        if ($role === "admin") {
            $stmt->bind_param("i", $booking_id);
        }
        if ($stmt->execute()) {
            header("Location: $redirect");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>

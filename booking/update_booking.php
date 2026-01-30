<?php
session_start();
$conn = new mysqli("localhost", "root", "", "resort_db");

// 1. Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Include PHPMailer functions
require_once '../includes/mail.php';

// 3. Admin access check
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

// 4. Check POST data
if (isset($_POST["booking_id"], $_POST["status"])) {

    $id = intval($_POST["booking_id"]);
    $status = $_POST["status"];
    $reason = $_POST["cancellation_reason"] ?? null;

    // 5. Update booking status and cancellation reason
    $stmt = $conn->prepare("UPDATE bookings SET status=?, cancellation_reason=? WHERE id=?");
    if (!$stmt) die("Prepare failed: " . $conn->error);
    $stmt->bind_param("ssi", $status, $reason, $id);
    $stmt->execute();
    $stmt->close();

    // 6. Get booking info from bookings table
    $stmt = $conn->prepare("SELECT room_id, name, email FROM bookings WHERE id=?");
    if (!$stmt) die("Prepare failed: " . $conn->error);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($data) {
        $room_id = $data['room_id'];
        $email   = $data['email'];
        $name    = $data['name'];

        // 7. Confirmed → occupy room + send email
        if ($status === "Confirmed") {
            $stmt = $conn->prepare("UPDATE rooms SET status='Occupied' WHERE id=?");
            if (!$stmt) die("Prepare failed: " . $conn->error);
            $stmt->bind_param("i", $room_id);
            $stmt->execute();
            $stmt->close();

            sendBookingConfirmedEmail($email, $name);
        }

        // 8. Cancelled → free room + send email
        if ($status === "Cancelled") {
            $stmt = $conn->prepare("UPDATE rooms SET status='Available' WHERE id=?");
            if (!$stmt) die("Prepare failed: " . $conn->error);
            $stmt->bind_param("i", $room_id);
            $stmt->execute();
            $stmt->close();

            sendBookingCancelledEmail($email, $name, $reason ?: 'No reason provided');
        }
    }
}

// 9. Redirect back
header("Location: ../resort_dashboard/admin_dashboard/admin_dashboard.php?updated=1");
exit();

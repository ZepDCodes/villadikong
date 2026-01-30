<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/mail.php';

// Admin access check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_POST['booking_id'])) {
    header("Location: ../resort_dashboard/dashboard.php");
    exit;
}

$booking_id = intval($_POST['booking_id']);

// 1. Update booking status
$update = $conn->prepare(
    "UPDATE bookings SET status = 'confirmed' WHERE id = ?"
);
$update->bind_param("i", $booking_id);
$update->execute();

// 2. Fetch customer details
$query = $conn->prepare("
    SELECT u.email, u.full_name
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    WHERE b.id = ?
");
$query->bind_param("i", $booking_id);
$query->execute();
$user = $query->get_result()->fetch_assoc();

// 3. Send email
if ($user) {
    sendBookingConfirmation(
        $user['email'],
        $user['full_name']
    );
}

// 4. Redirect back
header("Location: dashboard.php?success=confirmed");
exit;

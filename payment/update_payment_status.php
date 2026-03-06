<?php
$conn = new mysqli("localhost", "root", "", "resort_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $booking_id = intval($_POST["booking_id"]);
    $status = $_POST["status"];

    // Update both payments and bookings table
    $conn->query("UPDATE payments SET status='$status' WHERE booking_id=$booking_id");
    $conn->query("UPDATE bookings SET payment_status='$status' WHERE id=$booking_id");

    echo "<script>alert('Payment status updated to $status'); window.history.back();</script>";
}
?>
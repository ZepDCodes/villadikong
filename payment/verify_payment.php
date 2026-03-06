<?php
$conn = new mysqli("localhost", "root", "", "resort_db");

if (isset($_GET["id"]) && isset($_GET["status"])) {
    $id = $_GET["id"];
    $status = $_GET["status"];
    
    $conn->query("UPDATE payments SET status='$status' WHERE id=$id");
    
    if ($status == "verified") {
        // Also mark booking as paid
        $conn->query("UPDATE bookings 
                      JOIN payments ON bookings.id = payments.booking_id 
                      SET bookings.payment_status='paid', bookings.status='confirmed' 
                      WHERE payments.id=$id");
    }
    
    header("Location: admin_payments.php");
    exit();
}
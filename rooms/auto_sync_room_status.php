<?php
// auto_sync_room_status.php - Run this via cron job every hour or daily

$conn = new mysqli("localhost", "root", "", "resort_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$today = date('Y-m-d');

// Update ALL rooms based on actual bookings
$sql = "UPDATE rooms r 
        LEFT JOIN (
            SELECT room_id, MAX(check_out) as checkout
            FROM bookings 
            WHERE check_in <= ? 
            AND check_out > ?
            AND status != 'cancelled'
            GROUP BY room_id
        ) b ON r.id = b.room_id
        SET r.status = CASE 
            WHEN b.room_id IS NOT NULL THEN 'occupied'
            ELSE 'available'
        END";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $today, $today);
$stmt->execute();

echo "Synced " . $stmt->affected_rows . " rooms at " . date('Y-m-d H:i:s');
?>
<?php
header('Content-Type: application/json'); // ✅ So browser knows we’re returning JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomid = intval($_POST['room_id']);
    $name     = htmlspecialchars($_POST['name']);
    $email    = htmlspecialchars($_POST['email']);
    $phone    = htmlspecialchars($_POST['phone']);
    $checkin  = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $guests   = intval($_POST['guests']);
    $notes    = htmlspecialchars($_POST['notes']);
    $today = date("Y-m-d");

    // ✅ Validation
    if ($checkin < $today) {
        echo json_encode(["success" => false, "message" => "❌ Check-in date cannot be in the past."]);
        exit();
    }

    if ($checkout <= $checkin) {
        echo json_encode(["success" => false, "message" => "❌ Check-out date must be after the check-in date."]);
        exit();
    }

    // ✅ Database connection
    $conn = new mysqli("localhost", "root", "", "resort_db");
    if ($conn->connect_error) {
        echo json_encode(["success" => false, "message" => "DB Connection failed."]);
        exit();
    }

    // ✅ Insert booking
    $stmt = $conn->prepare("INSERT INTO bookings (room_id, name, email, phone, checkin, checkout, guests, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssis", $roomid, $name, $email, $phone, $checkin, $checkout, $guests, $notes);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "booking_id" => $stmt->insert_id]);
    } else {
        echo json_encode(["success" => false, "message" => "❌ Error saving booking: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
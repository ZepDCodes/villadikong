<?php
$conn = new mysqli("localhost", "root", "", "resort_db");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = intval($_POST["booking_id"]);
    $amount = floatval($_POST["amount"]);
    $reference_no = htmlspecialchars($_POST["reference_no"]);

    // ✅ Check if booking exists
    $check = $conn->prepare("SELECT id FROM bookings WHERE id = ?");
    $check->bind_param("i", $booking_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('⚠️ Invalid booking reference. Please confirm your booking again.'); window.history.back();</script>";
        exit();
    }

    // ✅ Validate upload
    if (!isset($_FILES["proof_image"]) || $_FILES["proof_image"]["error"] !== UPLOAD_ERR_OK) {
        echo "<script>alert('⚠️ Please upload a valid proof image.'); window.history.back();</script>";
        exit();
    }

    // ✅ Validate image type and size
    $allowed_types = ["jpg", "jpeg", "png"];
    $file_ext = strtolower(pathinfo($_FILES["proof_image"]["name"], PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_types)) {
        echo "<script>alert('❌ Only JPG, JPEG, and PNG files are allowed.'); window.history.back();</script>";
        exit();
    }

    if ($_FILES["proof_image"]["size"] > 5 * 1024 * 1024) { // 5MB limit
        echo "<script>alert('⚠️ File size should not exceed 5MB.'); window.history.back();</script>";
        exit();
    }

    // ✅ Upload image
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $file_name = time() . "_" . basename($_FILES["proof_image"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["proof_image"]["tmp_name"], $target_file)) {
        // ✅ Save payment record
        $stmt = $conn->prepare("INSERT INTO payments (booking_id, amount, reference_no, proof_image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("idss", $booking_id, $amount, $reference_no, $file_name);
        $stmt->execute();
        $stmt->close();

        // ✅ Update booking status
        $update = $conn->prepare("UPDATE bookings SET payment_status = 'pending_verification' WHERE id = ?");
        $update->bind_param("i", $booking_id);
        $update->execute();
        $update->close();

        echo "<script>
            alert('✅ Payment proof uploaded successfully! Please wait for admin verification.');
            window.location.href = '../booking/thankyou.php';
        </script>";
    } else {
        echo "<script>alert('❌ Error uploading file. Please try again.'); window.history.back();</script>";
    }
}
?>

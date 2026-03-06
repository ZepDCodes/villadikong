<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user_system/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_SESSION['username']; // take from session
    $rating = intval($_POST['rating']);
    $feedback = htmlspecialchars($_POST['feedback']);

    $conn = new mysqli("localhost", "root", "", "resort_db");

    if ($conn->connect_error) {
        die("DB Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO reviews (name, rating, feedback) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $name, $rating, $feedback);

    if ($stmt->execute()) {
        header("Location: thankyou.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

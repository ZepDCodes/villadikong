<?php
session_start();

// ✅ Only allow admin access
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

$current_page = basename($_SERVER['PHP_SELF']);//base kung asan yung user

// ✅ Connect to MySQL
$conn = new mysqli("localhost", "root", "", "resort_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Fetch data
$bookings = $conn->query("
    SELECT b.*, r.room_number AS booking_room_number, r.type AS booking_room_type
    FROM bookings b
    JOIN rooms r ON b.room_id = r.id
    ORDER BY b.created_at DESC
") or die("Bookings query failed: " . $conn->error);

$payments = $conn->query("
    SELECT p.*, b.name AS customer_name, b.email, b.payment_status
    FROM payments p
    JOIN bookings b ON p.booking_id = b.id
    ORDER BY p.created_at DESC
") or die("Payments query failed: " . $conn->error);

$rooms = $conn->query("SELECT * FROM resort_db.rooms ORDER BY created_at DESC") 
    or die("Bookings query failed: " . $conn->error);

$users = $conn->query("SELECT * FROM resort_db.users ORDER BY id DESC") 
    or die("Users query failed: " . $conn->error);

$reviews = $conn->query("SELECT * FROM resort_db.reviews ORDER BY created_at DESC") 
    or die("Reviews query failed: " . $conn->error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body>
    <div class="sidebar">
        <h2>Resort Admin</h2>
        <p class="welcome">Welcome, <?php echo $_SESSION["username"]; ?></p>
        <a href="../../index.php">Home</a>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="booking_list.php">Bookings</a>
        <a href="payment_list.php">Payments</a>
        <a href="room_list.php">Rooms</a>
        <a href="customer_list.php">Customers</a>
        <a href="<?php echo $root; ?>review_list.php">Reviews</a>
        
        <a href="../../user_system/logout.php" class="logout">Logout</a>
    </div>

    <div class="main-content">

        <!-- Quick Stats -->
        <div class="cards">
        </div>

    <!-- REVIEWS -->
<h2 id="reviews">Reviews</h2>
<div class="table-container">
    <table>
        <tr><th>#</th><th>Name</th><th>Rating</th><th>Feedback</th><th>Status</th><th>Action</th></tr>
        <?php $count=1; while($review=$reviews->fetch_assoc()): ?>
        <tr>
            <td><?= $count++ ?></td>
            <td><?= $review["name"] ?></td>
            <td><?= $review["rating"] ?> ⭐</td>
            <td><?= $review["feedback"] ?></td>
            <td><span class="status <?= strtolower($review["status"]) ?>"><?= $review["status"] ?></span></td>
            <td>
                <?php if ($review["status"]=="Pending"): ?>
                    <form method="post" action="../../resort_review_system/update_review.php" style="display:inline;">
                        <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                        <input type="hidden" name="status" value="Approved">
                        <button type="submit">Approve</button>
                    </form>
                    <form method="post" action="../../resort_review_system/update_review.php" style="display:inline;">
                        <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                        <input type="hidden" name="status" value="Denied">
                        <button type="submit">Deny</button>
                    </form>
                <?php endif; ?>
                <form method="post" action="../../resort_review_system/delete_review.php" 
                      onsubmit="return confirm('Delete this review?');" style="display:inline;">
                    <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</div>

</body>
</html>
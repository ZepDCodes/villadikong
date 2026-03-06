<?php
session_start();

// Only allow logged-in customers
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "guest") {
    header("Location: ../user_system/login.php");
    exit();
}



// Connect to MySQL
$conn = new mysqli("localhost", "root", "", "resort_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle cancel request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cancel_id"], $_POST["reason"])) {
    $cancel_id = intval($_POST["cancel_id"]);
    $reason = trim($_POST["reason"]);
    $user_email = $_SESSION["email"];

    $stmt = $conn->prepare("UPDATE bookings 
                            SET status = 'Cancelled', cancellation_reason = ? 
                            WHERE id = ? AND email = ? AND status = 'Pending'");
    $stmt->bind_param("sis", $reason, $cancel_id, $user_email);
    $stmt->execute();
    $stmt->close();

    header("Location: customer_dashboard.php");
    exit();


    
}

$user_email = $_SESSION["email"];
$username   = $_SESSION["username"];

// Fetch bookings (with room info + payment info)
$query = "SELECT b.*, r.room_number, r.type,
        COALESCE(p.status, 'Not Paid') AS payment_status,
        COALESCE(p.amount, 0) AS payment_amount,
        p.reference_no
        FROM bookings b
        JOIN rooms r ON b.room_id = r.id
        LEFT JOIN payments p ON b.id = p.booking_id
        WHERE b.email = ?
        ORDER BY b.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$bookings = $stmt->get_result();

// Fetch reviews
$reviews = $conn->query("SELECT * FROM reviews WHERE name = '$username' ORDER BY created_at DESC") 
    or die("Reviews query failed: " . $conn->error);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="costumer.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <style>
        .status {
            padding: 3px 8px;
            border-radius: 6px;
            color: white;
            font-weight: bold;
        }
        .status.pending { background: orange; }
        .status.confirmed { background: green; }
        .status.cancelled { background: red; }
        .status.paid { background: #007bff; }
        .status.notpaid { background: gray; }
        .status.verified { background: green; }
        .status.pending_verification { background: orange; }
        .status.rejected { background: crimson; }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <div class="navbar">
        <div class="left">
            <img src="../../house_logo.svg" class="logo-icon">
            <span id="left-text">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?></span>
        </div>
        <div class="right">
            <a href="../../index.php">Home</a>
            <a href="../../booking/booking.php">Book Now</a>
            <a href="../../resort_review_system/review.php">Write Review</a>
            <a href="../../user_system/logout.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="container">
        <h1>Your Dashboard</h1>


        <!-- BOOKINGS TABLE -->
        <h2>Your Bookings</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Room</th>
                    <th>Guests</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Reason</th>
                    <th>Action</th>
                </tr>
                <?php if ($bookings->num_rows > 0): ?>
                    <?php foreach ($bookings as $row): ?>
                    <tr>
                        <td><?= $row["checkin"] ?></td>
                        <td><?= $row["checkout"] ?></td>
                        <td><?= htmlspecialchars($row['type']) ?> (<?= htmlspecialchars($row['room_number']) ?>)</td>
                        <td><?= $row["guests"] ?></td>

                        <!-- Booking Status -->
                        <td>
                            <span class="status <?= strtolower($row["status"] ?? "pending") ?>">
                                <?= $row["status"] ?? "Pending" ?>
                            </span>
                        </td>

                        <!-- ✅ Payment Status -->
                        <td>
                    <?php if (!empty($row["payment_amount"]) && $row["payment_amount"] > 0): ?>
                        <div>
                            <strong>₱<?= number_format($row["payment_amount"], 2) ?></strong><br>
                            <small class="payment-status"><?= htmlspecialchars($row["payment_status"]) ?></small>
                        </div>
                    <?php else: ?>
                        <span class="status notpaid">Not Paid</span>
                            <?php endif; ?>
                        </td>

                        <!-- Reason for cancellation -->
                        <td>
                            <?php if ($row["status"] === "Cancelled"): ?>
                                <?= htmlspecialchars($row["cancellation_reason"] ?? "No reason provided") ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>

                        <!-- Action Buttons -->
                        <td>
                            <?php if ($row["status"] === "Cancelled"): ?>
                                <form method="post" action="../../booking/delete_booking.php"
                                      onsubmit="return confirm('Are you sure you want to permanently delete this cancelled booking?');">
                                    <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>

                            <?php elseif ($row["status"] === "Pending"): ?>
                                <form method="post" onsubmit="return confirm('Cancel this pending booking?');">
                                    <input type="hidden" name="cancel_id" value="<?= $row['id'] ?>">
                                    <textarea name="reason" placeholder="Enter reason" required></textarea><br>
                                    <button type="submit" class="cancel-btn">Cancel</button>
                                </form>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8">No bookings yet.</td></tr>
                <?php endif; ?>
            </table>
        </div>

        <!-- REVIEWS -->
        <h2>Your Reviews</h2>
        <div class="table-container">
            <table>
                <tr><th>Rating</th><th>Feedback</th><th>Date</th></tr>
                <?php if ($reviews->num_rows > 0): ?>
                    <?php foreach ($reviews as $review): ?>
                    <tr>
                        <td>
                            <?php 
                                $rating = (int)$review["rating"];
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $rating ? '<span class="star filled">&#9733;</span>' : '<span class="star">&#9734;</span>';
                                }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($review["feedback"]) ?></td>
                        <td><?= $review["created_at"] ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3">You haven’t submitted any reviews yet.</td></tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>

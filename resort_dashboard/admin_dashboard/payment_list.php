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
        <a href="<?php echo $root; ?>payment_list.php">Payments</a>
        <a href="room_list.php">Rooms</a>
        <a href="customer_list.php">Customers</a>
        <a href="review_list.php">Reviews</a>
        
        <a href="../../user_system/logout.php" class="logout">Logout</a>
    </div>

    <div class="main-content">

        <!-- Quick Stats -->
        <div class="cards">
        </div>

        <!-- PAYMENTS -->
<h2 id="payments"> Payments (GCash Proofs)</h2>
<div class="table-container">
    <table>
        <tr>
            <th>#</th><th>Customer</th><th>Email</th><th>Amount</th><th>Reference</th>
            <th>Proof</th><th>Status</th><th>Action</th>
        </tr>
        <?php $count=1; while($p=$payments->fetch_assoc()): ?>
        <tr>
            <td><?= $count++ ?></td>
            <td><?= htmlspecialchars($p["customer_name"]) ?></td>
            <td><?= htmlspecialchars($p["email"]) ?></td>
            <td>₱<?= number_format($p["amount"],2) ?></td>
            <td><?= htmlspecialchars($p["reference_no"]) ?></td>
            <td>
                <?php if ($p["proof_image"]): ?>
                    <img src="../../payment/uploads/<?= htmlspecialchars($p["proof_image"]) ?>" 
                         class="payment-proof" onclick="openImg('../../payment/uploads/<?= htmlspecialchars($p["proof_image"]) ?>')">
                <?php else: ?>No image<?php endif; ?>
            </td>
            <td><span class="status <?= strtolower($p["payment_status"]) ?>"><?= $p["payment_status"] ?></span></td>
            <td>
                <?php if ($p["payment_status"] === "pending_verification"): ?>
                    <form action="../../payment/update_payment_status.php" method="post" style="display:inline;">
                        <input type="hidden" name="booking_id" value="<?= $p["booking_id"] ?>">
                        <input type="hidden" name="status" value="verified">
                        <button type="submit">Verify</button>
                    </form>
                    <form action="../../payment/update_payment_status.php" method="post" style="display:inline;">
                        <input type="hidden" name="booking_id" value="<?= $p["booking_id"] ?>">
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="delete-btn">Reject</button>
                    </form>
                <?php else: ?>
                    <em>No action</em>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<script>
function toggleReason(select) {
    const reasonField = select.parentNode.querySelector('.reason-field');
    reasonField.style.display = (select.value === "Cancelled") ? "inline-block" : "none";
}

function openImg(src) {
    const modal = document.getElementById("imgModal");
    const img = document.getElementById("modalImage");
    img.src = src;
    modal.style.display = "block";
}

function closeImg() {
    document.getElementById("imgModal").style.display = "none";
}
</script>

<script src="../dashboard_js/modal.js"></script>
<script src="../dashboard_js/room.js"></script>
<script src="../dashboard_js/updbook.js"></script>

</body>
</html>
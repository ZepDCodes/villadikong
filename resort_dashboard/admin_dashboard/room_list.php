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
        <a href="<?php echo $root; ?>room_list.php">Rooms</a>
        <a href="customer_list.php">Customers</a>
        <a href="review_list.php">Reviews</a>
        
        <a href="../../user_system/logout.php" class="logout">Logout</a>
    </div>

    <div class="main-content">

        <!-- Quick Stats -->
        <div class="cards">
        </div>

<!-- ROOMS -->
<h2 id="rooms">Rooms</h2>
<button id="openModal">➕ Add Room</button>

<div id="roomModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Add New Room</h2>
    <form method="post" action="../../rooms/add_rooms.php">
      <input type="text" name="room_number" placeholder="Room Number" required>
      <input type="text" name="type" placeholder="Room Type (e.g. Single, Double)" required>
      <input type="number" step="0.01" name="price" placeholder="Price" required>
      <select name="status">
          <option value="Available">Available</option>
          <option value="Occupied">Occupied</option>
          <option value="Maintenance">Maintenance</option>
      </select>
      <button type="submit">Add Room</button>
    </form>
  </div>
</div>

<div class="table-container">
    <table>
        <tr><th>#</th><th>Room #</th><th>Type</th><th>Price</th><th>Status</th><th>Action</th></tr>
        <?php $count=1; while($room=$rooms->fetch_assoc()): ?>
        <tr>
            <td><?= $count++ ?></td>
            <td><?= $room["room_number"] ?></td>
            <td><?= $room["type"] ?></td>
            <td>₱<?= number_format($room["price"],2) ?></td>
            <td><span class="status <?= strtolower($room["status"]) ?>"><?= $room["status"] ?></span></td>
            <td>
                <form method="post" action="../../rooms/update_rooms.php" style="display:inline;">
                    <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                    <select name="status">
                        <option value="Available" <?= ($room["status"]=="Available"?"selected":"") ?>>Available</option>
                        <option value="Occupied" <?= ($room["status"]=="Occupied"?"selected":"") ?>>Occupied</option>
                        <option value="Maintenance" <?= ($room["status"]=="Maintenance"?"selected":"") ?>>Maintenance</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
                <form method="post" action="../../rooms/delete_rooms.php" 
                      onsubmit="return confirm('Delete this room?');" style="display:inline;">
                    <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- Image Modal -->
<div id="imgModal" class="modal-img">
    <span onclick="closeImg()">&times;</span>
    <img id="modalImage">
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
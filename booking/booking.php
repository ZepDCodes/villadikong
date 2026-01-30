<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  $next = urlencode($_SERVER['REQUEST_URI']);
  header("Location: ../user_system/login.php?next={$next}");
  exit();
}

$conn = new mysqli("localhost", "root", "", "resort_db");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// ✅ Fetch user info
$result = $conn->query("SELECT full_name, email, phone FROM users WHERE id = $user_id");
$user = $result ? $result->fetch_assoc() : null;

// ✅ Fetch available rooms
$sql = "SELECT id, room_number, type, price, status FROM rooms";
$rooms = $conn->query($sql);

if (!$rooms) {
  die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Resort Booking</title>

  <!-- ✅ Your CSS -->
  <link rel="stylesheet" href="booking_design.css">
  <link rel="stylesheet" href="nav_booking.css">

  <!-- ✅ Favicon & Fonts -->
  <link type="image/png" sizes="32x32" rel="icon" href="../favicon_logo.png">
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Gloock&display=swap" rel="stylesheet">

  <!-- ✅ Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<section class="review_hero">
  <?php
    $ROOT = '../';
    include __DIR__ . '/../nav.php';
  ?>

  <div class="booking-wrapper">
    <!-- Booking Form -->
    <div class="booking-container">
      <h2>🛎 Book Your Stay</h2>
      <form action="submit_booking.php" method="POST" class="booking-form">
        
        <!-- Guest Info -->
        <div class="section-title">Guest Information</div>
        <label for="name">Full Name <span style="color:red">*</span></label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" required>

        <label for="email">Email <span style="color:red">*</span></label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>

        <label for="phone">Phone Number <span style="color:red">*</span></label>
        <input type="number" id="phone" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required>

        <!-- Hidden selected room -->
        <input type="hidden" name="room_id" id="room_id" required>

        <!-- Booking Details -->
        <div class="section-title">Booking Details</div>
        <label for="checkin">Check-in Date <span style="color:red">*</span></label>
        <input type="date" id="checkin" name="checkin" min="<?= date('Y-m-d') ?>" required>

        <label for="checkout">Check-out Date <span style="color:red">*</span></label>
        <input type="date" id="checkout" name="checkout" required>

        <label for="guests">Number of Guests <span style="color:red">*</span></label>
        <input type="number" id="guests" name="guests" min="1" required>

        <!-- Other Requests -->
        <div class="section-title">Other</div>
        <label for="notes">Special Requests:</label>
        <textarea id="notes" name="notes" rows="3" placeholder="Allergies, late check-in, etc."></textarea>

        <!-- Confirm Booking Button -->
        <button type="button" class="btn btn-primary mt-3 w-100" onclick="confirmBooking()">Book Now</button>
      </form>
    </div>

    <!-- Room Selection -->
    <div class="room-list">
      <?php while ($room = $rooms->fetch_assoc()): ?>
        <div class="room-card <?= strtolower($room['status']) ?>" data-room-id="<?= $room['id'] ?>">
          <img src="../rooms/rooms_img/room_<?= $room['id'] ?>.jpg"
               alt="<?= htmlspecialchars($room['type']) ?>"
               onerror="this.src='../uploads/rooms/default.jpg'">
          
          <div class="room-info">
            <h4>
              <img src="../rooms/svg/two-people.png" alt="Family Icon" class="icon">
              <?= htmlspecialchars($room['type']) ?>
            </h4>
            <h5 id="highlight-title">HIGHLIGHTS</h5>
            <ul id="highlight">
              <li>Cozy Bed</li>
              <li>Shower</li>
              <li>Free WIFI</li>
              <li>Gaming Console</li>
            </ul>
            <p id="price">
              ₱<?= number_format($room['price'], 2) ?> / night
              <span class="room-status <?= strtolower($room['status']) ?>">
                <?= htmlspecialchars($room['status']) ?>
              </span>
            </p>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <!-- Image Modal -->
  <div id="imgModal" class="img-modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImg">
    <div id="caption"></div>
  </div>
</section>

<!-- ✅ GCash Payment Modal (Bootstrap) -->
<div class="modal fade" id="gcashModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title">Pay with GCash</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Send your payment to <strong>09XXXXXXXXX</strong></p>
        <img src="../payment/qr/gcash.png" alt="GCash QR" class="img-fluid mb-3 rounded shadow-sm" style="max-width:200px;display:block;margin:auto;">

        <form action="../payment/upload_payment.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="booking_id" id="booking_id">

          <div class="mb-3">
            <label class="form-label">Amount Paid</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">GCash Reference Number</label>
            <input type="text" name="reference_no" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Proof of Payment</label>
            <input type="file" name="proof_image" accept="image/*" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-success w-100">Submit Payment</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // ✅ Ensure checkout date is after checkin
  const checkin = document.getElementById("checkin");
  const checkout = document.getElementById("checkout");
  checkin.addEventListener("change", () => {
    checkout.min = checkin.value;
  });

  // ✅ Room selection
  const roomCards = document.querySelectorAll('.room-card');
  const hiddenInput = document.getElementById('room_id');

  roomCards.forEach(card => {
    card.addEventListener('click', () => {
      roomCards.forEach(c => c.classList.remove('active'));
      card.classList.add('active');
      hiddenInput.value = card.dataset.roomId;
    });

    // ✅ Click image to enlarge
    const img = card.querySelector("img");
    img.addEventListener("click", (e) => {
      e.stopPropagation();
      const modal = document.getElementById("imgModal");
      const modalImg = document.getElementById("modalImg");
      const caption = document.getElementById("caption");

      modal.style.display = "block";
      modalImg.src = img.src;
      caption.innerHTML = card.querySelector("h4").innerText;
    });
  });

  // ✅ Close image modal
  const modal = document.getElementById("imgModal");
  const closeBtn = document.querySelector(".img-modal .close");
  closeBtn.onclick = () => modal.style.display = "none";
  modal.onclick = (e) => {
    if (e.target === modal) modal.style.display = "none";
  };

function confirmBooking() {
  const form = document.querySelector(".booking-form");
  const formData = new FormData(form);

  fetch("submit_booking.php", {
    method: "POST",
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // ✅ Pass booking ID to modal
      document.getElementById("booking_id").value = data.booking_id;

      // ✅ Show GCash payment modal
      const modal = new bootstrap.Modal(document.getElementById('gcashModal'));
      modal.show();
    } else {
      alert(data.message);
    }
  })
  .catch(error => {
    console.error("Error:", error);
    alert("⚠️ Something went wrong. Please try again.");
  });
}
</script>
</body>
</html>

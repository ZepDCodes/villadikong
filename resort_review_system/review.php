<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  $next = urlencode($_SERVER['REQUEST_URI']);
  header("Location: ../user_system/login.php?next={$next}");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Resort Review</title>
    <link rel="stylesheet" href="review.css">
    <link rel="stylesheet" href="nav_review.css">
    <link type="image/png" sizes="32x32" rel="icon" href="../favicon_logo.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gloock&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap" rel="stylesheet">
</head>
<body>

<section class="review_hero">
    <?php
        $ROOT = '../';
        include __DIR__ . '/../nav.php';
    ?>
<div class="review-container">
    
    <h2>Leave us a Review!</h2>
    <!-- show logged in user -->
    <p><strong>Logged in as:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>

    <form action="submit_review.php" method="POST" class="review-form">
        <!-- removed the name input, we now take it from session -->

        <label for="rating">Star Rating:</label>
        <div class="stars">
            <input type="radio" id="star5" name="rating" value="5" required><label for="star5">★</label>
            <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
            <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
            <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
            <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
        </div>

        <label for="feedback">Your Feedback:</label>
        <textarea id="feedback" name="feedback" rows="4" required></textarea>

        <button type="submit">Submit Review</button>
    </form>

</div>

<div class="display-container">
<h2><i class="fa-regular fa-comment-dots"></i> What Our Guests Say</h2><p>Recently:</p>
    
<?php include 'display_reviews.php'; ?>
</div>
</section>
</body>
</html>

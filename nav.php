<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$root = isset($ROOT) ? $ROOT : '';

$isAuth = isset($_SESSION['user_id']);


$current_page = basename($_SERVER['PHP_SELF']);//base kung asan yung user
?>
<header>
  <nav>
    <input type="checkbox" id="sidebar-active">
    <label for="sidebar-active" class="open-sidebar-button">
      <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
    </label>

    <div class="link-container">
      <label for="sidebar-active" class="close-sidebar-button">
        <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg>
      </label>

      <h6 class="home-link"><!-house_logo->
        <img 
            src="<?php echo $current_page == '' ? 'active' : ''; ?>/resort_management/house_logo.svg" 
            alt="Home" 
            class="logo-icon">
        Villa Dikong Resort
      </h6>

      <a href="<?php echo $root; ?>index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Home</a>
      
      <?php if (!$isAuth): ?>
        <a href="<?php echo $root; ?>user_system/login.php?redirect=booking">Book now!</a>

        <a href="<?php echo $root; ?>index.php#explore-about">About</a>
        <a href="<?php echo $root; ?>user_system/login.php" class="<?php echo $current_page == 'login.php' ? 'active' : ''; ?>">Login</a>
      <?php endif; ?>

      <?php if ($isAuth): ?>
        <a href="<?php echo $root; ?>resort_review_system/review.php" class="<?php echo $current_page == 'review.php' ? 'active' : ''; ?>">Feedback</a>
        <a href="<?php echo $root; ?>booking/booking.php" class="<?php echo $current_page == 'booking.php' ? 'active' : ''; ?>">Book now!</a>
        <a href="<?php echo $root; ?>resort_dashboard/dashboard.php">Dashboard</a>
        <a href="<?php echo $root; ?>index.php#explore-about">About</a>
        <a href="<?php echo $root; ?>user_system/logout.php">Logout</a>
      <?php endif; ?>

    </div>
  </nav>
</header>

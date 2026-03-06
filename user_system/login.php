<?php
session_start();
$redirect = $_GET['redirect'] ?? '';
include "db.php";
include "../includes/mail.php";

$loginError = "";
$registerError = "";
$forgotError = "";
$forgotSuccess = "";
$resetError = "";
$resetSuccess = "";
$activeForm = "login"; // default is login form

// LOGIN
if (isset($_POST["login"])) {
    $activeForm = "login";
    $username = trim($_POST["loginUsername"]);
    $password = $_POST["loginPassword"];

    $stmt = $conn->prepare("SELECT id, username, password, email, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $user, $hashed, $email, $role);
        $stmt->fetch();
        if (password_verify($password, $hashed)) {
            session_regenerate_id(true);
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $user;
            $_SESSION["email"] = $email;
            $_SESSION["role"] = $role;

            if ($role === "admin" || $role === "staff") {
                header("Location: ../../resort_management/index.php");
            } else {
                header("Location: ../../resort_management/index.php");
            }
            exit();
        } else {
            $loginError = "Invalid password.";
        }
    } else {
        $loginError = "User not found.";
    }
    $stmt->close();
}

// REGISTER
if (isset($_POST["register"])) {
    $activeForm = "register";
    $username = trim($_POST["regUsername"]);
    $email = trim($_POST["regEmail"]);
    $password = $_POST["regPassword"];
    $confirm = $_POST["regConfirm"];

    if ($password !== $confirm) {
        $registerError = "Passwords do not match!";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $registerError = "Username or email already exists.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'guest')");
            $stmt->bind_param("sss", $username, $email, $hashed);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successful! Please login.'); window.location='login.php';</script>";
                exit();
            } else {
                $registerError = "Error: " . $conn->error;
            }
        }
        $stmt->close();
    }
}

// FORGOT PASSWORD
if (isset($_POST["forgot"])) {
    $activeForm = "forgot";
    $email = trim($_POST["forgotEmail"]);
    
    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Generate token
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Delete any existing tokens for this email
        $delStmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
        $delStmt->bind_param("s", $email);
        $delStmt->execute();
        $delStmt->close();
        
        // Insert new token
        $insStmt = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $insStmt->bind_param("sss", $email, $token, $expires);
        
        if ($insStmt->execute()) {
            // Create reset link
            $resetLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/login.php?reset_token=" . $token;
            
            // Send email
            if (sendPasswordResetEmail($email, $resetLink)) {
                $forgotSuccess = "Password reset link sent to your email!";
            } else {
                $forgotError = "Failed to send email. Please try again.";
            }
        } else {
            $forgotError = "Error processing request.";
        }
        $insStmt->close();
    } else {
        // Don't reveal if email exists for security
        $forgotSuccess = "If this email exists, a reset link has been sent.";
    }
    $stmt->close();
}

// HANDLE PASSWORD RESET
if (isset($_GET['reset_token'])) {
    $token = $_GET['reset_token'];
    $activeForm = "reset";
    
    // Verify token
    $stmt = $conn->prepare("SELECT email, expires_at FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($email, $expires);
        $stmt->fetch();
        
        if (strtotime($expires) < time()) {
            $resetError = "This reset link has expired. Please request a new one.";
            $activeForm = "forgot";
        }
    } else {
        $resetError = "Invalid reset token.";
        $activeForm = "login";
    }
    $stmt->close();
}

// PROCESS NEW PASSWORD
if (isset($_POST["resetPassword"])) {
    $token = $_POST['token'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    
    if ($newPassword !== $confirmPassword) {
        $resetError = "Passwords do not match!";
        $activeForm = "reset";
    } else if (strlen($newPassword) < 6) {
        $resetError = "Password must be at least 6 characters!";
        $activeForm = "reset";
    } else {
        // Get email from token
        $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW()");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($email);
            $stmt->fetch();
            
            // Update password
            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $updStmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $updStmt->bind_param("ss", $hashed, $email);
            
            if ($updStmt->execute()) {
                // Delete used token
                $delStmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
                $delStmt->bind_param("s", $email);
                $delStmt->execute();
                $delStmt->close();
                
                $resetSuccess = "Password updated successfully! Please login.";
                $activeForm = "login";
            } else {
                $resetError = "Error updating password.";
                $activeForm = "reset";
            }
            $updStmt->close();
        } else {
            $resetError = "Invalid or expired token.";
            $activeForm = "forgot";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" 
rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Gloock&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="login.css">
  <link rel="icon" type="image/png" href="logo.png">

  <title>Login</title>
  <style>
    .success { color: #28a745; font-size: 0.9em; margin-top: 5px; }
    .forgot-link { 
      text-align: center; 
      margin-top: 10px; 
      font-size: 0.9em;
    }
    .forgot-link a {
      color: #007bff;
      cursor: pointer;
      text-decoration: underline;
    }
    .back-link {
      text-align: center;
      margin-top: 15px;
      font-size: 0.9em;
    }
    .back-link a {
      color: #6c757d;
      cursor: pointer;
      text-decoration: none;
    }
    .back-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="login-logo">
  <img src="villa_dikong_logo.svg" alt="Villa Dikong Private Resort">
</div>

<div class="container">

  <!-- LOGIN FORM -->
  <form id="loginForm" class="<?php echo ($activeForm == 'login') ? 'active' : ''; ?>" method="POST" action="">
    <h2>Login</h2>
    <input type="text" name="loginUsername" placeholder="Username" required>
    <input type="password" name="loginPassword" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
    <p class="error"><?php echo $loginError; ?></p>
    <div class="switch-link">Don't have an account? <a onclick="showRegister()">Register</a></div>
    <div class="forgot-link"><a onclick="showForgot()">Forgot Password?</a></div>
  </form>

  <!-- REGISTER FORM -->
  <form id="registerForm" class="<?php echo ($activeForm == 'register') ? 'active' : ''; ?>" method="POST" action="">
    <h2>Register</h2>
    <input type="text" name="regUsername" placeholder="Username" required>
    <input type="email" name="regEmail" placeholder="Email" required>
    <input type="password" name="regPassword" placeholder="Password" required>
    <input type="password" name="regConfirm" placeholder="Confirm Password" required>
    <button type="submit" name="register">Register</button>
    <p class="error"><?php echo $registerError; ?></p>
    <div class="switch-link">Already have an account? <a onclick="showLogin()">Login</a></div>
  </form>

  <!-- FORGOT PASSWORD FORM -->
  <form id="forgotForm" class="<?php echo ($activeForm == 'forgot') ? 'active' : ''; ?>" method="POST" action="">
    <h2>Reset Password</h2>
    <p style="text-align: center; color: #666; margin-bottom: 20px; font-size: 0.9em;">
      Enter your email address and we'll send you a link to reset your password.
    </p>
    <input type="email" name="forgotEmail" placeholder="Email Address" required>
    <button type="submit" name="forgot">Send Reset Link</button>
    <p class="error"><?php echo $forgotError; ?></p>
    <p class="success"><?php echo $forgotSuccess; ?></p>
    <div class="back-link"><a onclick="showLogin()">← Back to Login</a></div>
  </form>

  <!-- RESET PASSWORD FORM -->
  <form id="resetForm" class="<?php echo ($activeForm == 'reset') ? 'active' : ''; ?>" method="POST" action="">
    <h2>Create New Password</h2>
    <input type="hidden" name="token" value="<?php echo isset($_GET['reset_token']) ? htmlspecialchars($_GET['reset_token']) : ''; ?>">
    <input type="password" name="newPassword" placeholder="New Password" required minlength="6">
    <input type="password" name="confirmPassword" placeholder="Confirm New Password" required>
    <button type="submit" name="resetPassword">Update Password</button>
    <p class="error"><?php echo $resetError; ?></p>
    <p class="success"><?php echo $resetSuccess; ?></p>
    <div class="back-link"><a onclick="showLogin()">← Back to Login</a></div>
  </form>

</div>

<script src="login.js"></script>
</body>
</html>
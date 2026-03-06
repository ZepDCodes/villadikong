<?php
// ===============================
// PHPMailer Manual Includes
// ===============================
require_once __DIR__ . '/mailer/PHPMailer.php';
require_once __DIR__ . '/mailer/SMTP.php';
require_once __DIR__ . '/mailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ===============================
// Create Mail Instance
// ===============================
$mail = new PHPMailer(true);

try {
    // ===============================
    // SMTP Configuration
    // ===============================
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'villadikong@gmail.com';      // YOUR EMAIL
    $mail->Password   = 'hibitcwxanxebhxv';         // APP PASSWORD
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // ===============================
    // Email Headers
    // ===============================
    $mail->setFrom('villadikong@gmail.com', 'Villa Dikong Booking');
    $mail->addAddress('takahashiukiyo@gmail.com');        // RECEIVER

    // ===============================
    // Email Content
    // ===============================
    $mail->isHTML(true);
    $mail->Subject = 'Booking Confirmation';
    $mail->Body    = '
        <h2>Booking Confirmed!</h2>
        <p>Your booking on Villa Dikong Private Resort is confirmed.</p>
    ';
    $mail->AltBody = 'Email sent successfully using PHPMailer';

    // ===============================
    // Send Email
    // ===============================
    $mail->send();
    echo 'Email sent successfully';

} catch (Exception $e) {
    echo 'Email failed: ' . $mail->ErrorInfo;
}

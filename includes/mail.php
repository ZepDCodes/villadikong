<?php
require_once __DIR__ . '/../mailer/PHPMailer.php';
require_once __DIR__ . '/../mailer/SMTP.php';
require_once __DIR__ . '/../mailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Helper function to set up the basic mailer config.
 * This saves you from typing your credentials multiple times!
 */
function getMailerSetup() {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'villadikong@gmail.com';
    $mail->Password   = 'fnajykzxfapzkvgq'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->setFrom('villadikong@gmail.com', 'Villa Dikong Private Resort');
    return $mail;
}

function sendBookingConfirmedEmail($email, $name, $id = '', $checkin = '', $checkout = '', $room_id = '') {
    try {
        $mail = getMailerSetup();
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "It's Official! Your stay at Villa Dikong is Confirmed";
        
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: auto;'>
            <h2 style='color: #2c3e50;'>Hi {$name},</h2>
            <p>We are delighted to let you know that your booking at <strong>Villa Dikong</strong> is officially confirmed. We’re already preparing for your arrival!</p>
            
            <table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>
                <tr style='background-color: #f8f9fa;'>
                    <td style='padding: 10px; border: 1px solid #ddd;'><strong>Confirmation #</strong></td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>{$id}</td>
                </tr>
                <tr>
                    <td style='padding: 10px; border: 1px solid #ddd;'><strong>Check-in</strong></td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>{$checkin}</td>
                </tr>
                <tr>
                    <td style='padding: 10px; border: 1px solid #ddd;'><strong>Check-out</strong></td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>{$checkout}</td>
                </tr>
                <tr style='background-color: #f8f9fa;'>
                    <td style='padding: 10px; border: 1px solid #ddd;'><strong>Room Number</strong></td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>{$room_id}</td>
                </tr>
            </table>

            <p><strong>Need anything else?</strong><br>
            If you have special requests or questions before your trip, simply reply to this email.</p>
            
            <p>See you soon in paradise,<br>
            <strong>The Villa Dikong Team</strong></p>
        </div>";

        $mail->AltBody = "Hi {$name}, your booking at Villa Dikong is confirmed! We look forward to seeing you.";

        $mail->send();
        return true; // Return true on success
    } catch (Exception $e) {
        // Log the error so you can debug without crashing the user's screen
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

function sendBookingCancelledEmail($email, $name, $reason) {
    try {
        $mail = getMailerSetup();
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Update regarding your Villa Dikong Booking';
        
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: auto;'>
            <h2 style='color: #c0392b;'>Booking Cancellation</h2>
            <p>Hello {$name},</p>
            <p>We are writing to let you know that your booking request has been cancelled.</p>
            <div style='background-color: #fdf2f2; border-left: 4px solid #c0392b; padding: 10px; margin: 20px 0;'>
                <strong>Reason:</strong> {$reason}
            </div>
            <p>If you believe this was an error or would like to book new dates, please don't hesitate to reply to this email or visit our website.</p>
            <p>Warm regards,<br><strong>The Villa Dikong Team</strong></p>
        </div>";

        $mail->AltBody = "Hello {$name}, your booking has been cancelled. Reason: {$reason}.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

function sendPasswordResetEmail($email, $resetLink) {
    try {
        $mail = getMailerSetup();
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request - Villa Dikong';
        
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: auto;'>
            <h2 style='color: #2c3e50;'>Password Reset Request</h2>
            <p>Hello,</p>
            <p>You requested a password reset for your Villa Dikong account. Click the button below to reset your password:</p>
            
            <div style='text-align: center; margin: 30px 0;'>
                <a href='{$resetLink}' style='background-color: #007bff; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block;'>Reset Password</a>
            </div>
            
            <p>Or copy and paste this link into your browser:</p>
            <p style='background-color: #f8f9fa; padding: 10px; border-radius: 5px; word-break: break-all;'>{$resetLink}</p>
            
            <p><strong>This link expires in 1 hour.</strong></p>
            <p>If you didn't request this, please ignore this email. Your password will remain unchanged.</p>
            
            <p>Best regards,<br>
            <strong>The Villa Dikong Team</strong></p>
        </div>";

        $mail->AltBody = "Password Reset Request. Copy this link: {$resetLink}";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Password reset email failed. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>

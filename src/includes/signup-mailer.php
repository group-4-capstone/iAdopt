<?php
// includes/signup_mailer.php

// Include the PHPMailer classes
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';
require '../phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Sends a welcome email to the newly registered user.
 *
 * @param string $recipientEmail The email address of the recipient.
 * @param string $recipientName The full name of the recipient.
 * @return bool|string Returns true on success, or an error message on failure.
 */
function sendWelcomeEmail($recipientEmail, $recipientName) {
    // Initialize PHPMailer
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'secaspiiadopt@gmail.com'; // Your SMTP username
        $mail->Password   = 'hznpjsvzbuzssdun'; // Your SMTP password or app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encryption
        $mail->Port       = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('helloimandreaaa@gmail.com', 'iADOPT'); // Sender's email and name
        $mail->addAddress($recipientEmail, $recipientName); // Add recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to iADOPT!';
        $mail->Body    = "
            <h1>Welcome to iADOPT, {$recipientName}!</h1>
            <p>Thank you for registering an account with us. We're excited to help you adopt a PAW-some friend!</p>
            <p>Log in the provided link below:</p>
            <a href='http://localhost/iAdopt/src/login.php'>Login</a>
            <br>
            <p>Best Regards,<br>The iADOPT Team</p>
        ";
        $mail->AltBody = "Welcome to iADOPT, {$recipientName}!\n\nThank you for registering an account with us. We're excited to help you adopt a PAW-some friend!\n\nIf you have any questions, feel free to reply to this email.\n\nBest Regards,\nThe iADOPT Team";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log the error message or handle it as needed
        return "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

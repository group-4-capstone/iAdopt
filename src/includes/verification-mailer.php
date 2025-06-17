<?php

// Include the PHPMailer files
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';
require '../phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendVerificationEmail($recipientEmail, $recipientName, $verificationCode) {
    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'secaspiiadopt@gmail.com'; // Your SMTP username
        $mail->Password   = 'zshenjmqasmtgnbd'; // Your SMTP password or app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encryption
        $mail->Port       = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('secaspiiadopt@gmail.com', 'iADOPT'); // Sender's email and name
        $mail->addAddress($recipientEmail, $recipientName); // Add recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Please Verify Your Email';
        $mail->Body    = "
            <h1>Hello, {$recipientName}!</h1>
            <p>Thank you for registering with iADOPT! Please use the following verification code to complete your registration:</p>
            <h2>Your Verification Code: {$verificationCode}</h2>
            <p>Enter this code in the verification modal on the website to confirm your email address.</p>
            <br>
            <p>Best Regards,<br>The iADOPT Team</p>
        ";
        $mail->AltBody = "Hello, {$recipientName}!\n\nThank you for registering with iADOPT! Please use the following verification code to complete your registration:\n\nVerification Code: {$verificationCode}\n\nBest Regards,\nThe iADOPT Team";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>

<?php
// includes/forgot-password-handler.php

// Include the PHPMailer classes
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';
require '../phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'db-connect.php'; // Database connection

// Function to send reset code email
function sendResetCodeEmail($recipientEmail, $resetCode) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'secaspiiadopt@gmail.com'; // Your SMTP username
        $mail->Password   = 'zshe njmq asmt gnbd'; // Your SMTP password or app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encryption
        $mail->Port       = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('secaspiiadopt@gmail.com', 'iADOPT'); // Sender's email and name
        $mail->addAddress($recipientEmail); // Add recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "
            <h1>Password Reset Request</h1>
            <p>We received a request to reset your password. Use the following code to reset it:</p>
            <h3>{$resetCode}</h3>
            <p>If you didn't request a password reset, you can ignore this email.</p>
            <br>
            <p>Best Regards,<br>The iADOPT Team</p>
        ";
        $mail->AltBody = "Password Reset Request\n\nWe received a request to reset your password. Use the following code to reset it:\n\n{$resetCode}\n\nIf you didn't request a password reset, you can ignore this email.\n\nBest Regards,\nThe iADOPT Team";

        // Send email
        $mail->send();
        return true;
    } catch (Exception $e) {
        // Return error message
        return "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Handle password reset request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Validate the email and check if it exists in the database
    $query = "SELECT * FROM users WHERE email = ?";
    if ($stmt = $db->prepare($query)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // If email is found, send a reset code
        if ($result->num_rows > 0) {
            $resetCode = rand(100000, 999999); // Generate a 6-digit reset code

            // Store the reset code in the database (you may store it for a limited time in your database)
            // You should ideally hash or salt this code, but for now we store it directly
            $user = $result->fetch_assoc();
            $userId = $user['user_id'];

            $updateQuery = "UPDATE users SET reset_code = ? WHERE user_id = ?";
            if ($stmt = $db->prepare($updateQuery)) {
                $stmt->bind_param("si", $resetCode, $userId);
                $stmt->execute();

                // Send the reset code to the user's email
                $emailSent = sendResetCodeEmail($email, $resetCode);

                if ($emailSent) {
                    echo json_encode(['success' => true, 'message' => 'Password reset code sent to your email.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Mailer Error: Could not send email.']);
                }
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Email address not found.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Database query error.']);
    }

    $db->close();
}
?>

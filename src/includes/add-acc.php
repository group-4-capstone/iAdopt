<?php
// Include database connection
require 'db-connect.php';

// Start session
session_start();

// Include PHPMailer for sending email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';
require '../phpmailer/Exception.php';

// Set JSON response header
header('Content-Type: application/json');

try {
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve and validate form data
        $creationDate = $_POST['creationDate'] ?? null;
        $volunteerName = $_POST['volunteerName'] ?? null;
        $email = $_POST['email'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$creationDate || !$volunteerName || !$email || !$status) {
            throw new Exception('All fields are required.');
        }

        // Generate a random 8-character password
        $initialPassword = bin2hex(random_bytes(4));

        // Hash the password
        $hashedPassword = password_hash($initialPassword, PASSWORD_DEFAULT);

        // Insert the user into the database
        $sql = "INSERT INTO users (email, password, role, status, acc_creation, first_name) VALUES (?, ?, 'admin', ?, ?, ?)";
        $stmt = $db->prepare($sql);

        if ($stmt === false) {
            throw new Exception('Database preparation error: ' . $db->error);
        }

        $stmt->bind_param("sssss", $email, $hashedPassword, $status, $creationDate, $volunteerName);

        if ($stmt->execute()) {
            // Send email with PHPMailer
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'secaspiiadopt@gmail.com';
                $mail->Password = 'zshe njmq asmt gnbd';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('secaspiiadopt@gmail.com', 'iADOPT');
                $mail->addAddress($email, $volunteerName);

                $mail->isHTML(true);
                $mail->Subject = 'Your Account Password';
                $mail->Body = "
                    <p>Hello $volunteerName,</p>
                    <p>Your account has been created successfully. Below are your login details:</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Password:</strong> $initialPassword</p>
                    <p>Please log in and change your password as soon as possible.</p>
                    <p>Best Regards,<br>Your App Team</p>
                ";

                $mail->send();
            } catch (Exception $e) {
                throw new Exception('Email sending failed: ' . $mail->ErrorInfo);
            }

            echo json_encode(['success' => true]);
        } else {
            throw new Exception('Database execution error: ' . $stmt->error);
        }

        $stmt->close();
    } else {
        throw new Exception('Invalid request method.');
    }
} catch (Exception $e) {
    // Catch and return errors as JSON
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>

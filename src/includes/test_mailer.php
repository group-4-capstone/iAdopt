<?php
require '../../vendor/autoload.php'; // Autoload PHPMailer using Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true); // Enable exceptions

try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Use your SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'secaspiiadopt@gmail.com'; // Your email address
    $mail->Password   = 'hznpjsvzbuzssdun'; // Your email password or app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encryption (TLS)
    $mail->Port       = 587; // TCP port to connect to

    // Sender and recipient settings
    $mail->setFrom('secaspiiadopt@gmail.com', 'iADOPT'); // Sender's email and name
    $mail->addAddress('andreasofiavillalobos529@gmail.com'); // Add recipient email

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'PHPMailer Test';
    $mail->Body    = '<h1>Hello</h1><p>This is a test email sent using PHPMailer.</p>';
    $mail->AltBody = 'This is a test email sent using PHPMailer.';

    // Send email
    if ($mail->send()) {
        echo 'Message has been sent successfully';
    } else {
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo "Message could not be sent. PHPMailer Error: {$mail->ErrorInfo}";
}
?>

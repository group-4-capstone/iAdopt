<?php
// Include the PHPMailer files
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';
require '../phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize PHPMailer
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Use your SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'secaspiiadopt@gmail.com'; // Your email address
    $mail->Password   = 'hznpjsvzbuzssdun'; // Your email password or app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encryption (TLS)
    $mail->Port       = 587; // TCP port to connect to
    

      // Sender and recipient settings
      $mail->setFrom('helloimandreaaa@gmail.com', 'iADOPT'); // Sender's email and name
      $mail->addAddress('andreasofiavillalobos529@gmail.com'); // Add recipient email

    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body = 'This is a test email using PHPMailer without Composer.';
    
    $mail->send();
    echo 'Email has been sent successfully';
} catch (Exception $e) {
    echo "Email could not be sent. Error: {$mail->ErrorInfo}";
}
?>


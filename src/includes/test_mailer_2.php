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
    $mail->Username   = 'helloimandreaaa@gmail.com'; // Your email address
    $mail->Password   = 'anepehwowjfneydq'; // Your email password or app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SSL
    $mail->Port = 465;
   

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

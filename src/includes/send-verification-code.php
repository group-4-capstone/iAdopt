<?php
// send_verification_code.php
session_start();

// Get the user's email from the POST request
$email = $_POST['email'];

// Generate the 6-digit random verification code
$verificationCode = rand(100000, 999999);

// Store the code in the session
$_SESSION['verification_code'] = $verificationCode;

// Get the user's name (optional, if needed)
$userName = "User"; // Default to "User" or retrieve from form

// Send the verification email with the code
require_once 'verification-mailer.php';
sendVerificationEmail($email, $userName, $verificationCode);

// Respond back to front-end (can also send a message to indicate success)
echo 'Verification code sent.';
?>
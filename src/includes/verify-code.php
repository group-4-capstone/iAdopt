<?php

// verify_code.php
session_start(); // Start the session to access the verification code stored in it

// Get the entered verification code from the POST request
$enteredCode = $_POST['verification_code'];

// Compare the entered code with the one stored in the session
if (isset($_SESSION['verification_code']) && $_SESSION['verification_code'] == $enteredCode) {
    echo 'valid'; // The code is correct
} else {
    echo 'invalid'; // The code is incorrect
}

?>

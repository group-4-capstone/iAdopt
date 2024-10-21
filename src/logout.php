<?php

session_start();


// Destroy the session
session_unset();
session_destroy();
echo "after session destroy";
// Check if the session is destroyed
if (session_status() == PHP_SESSION_NONE) {
    echo "Session has been successfully destroyed. Redirecting to login...";
    header("Location: login.php");
    exit();
} else {
    echo "Failed to destroy the session.";
}?>

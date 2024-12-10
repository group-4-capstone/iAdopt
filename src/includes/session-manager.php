<?php
// Start the session if it hasn't been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in by checking 'logged_in' and 'email' session variables
if (!empty($_SESSION['logged_in']) && !empty($_SESSION['email'])) {
    // Redirect based on the user's role
    switch ($_SESSION['role']) {
        case 'user':
            header("Location: home.php");
            break;
        case 'admin':
        case 'head_admin':
            header("Location: dashboard.php");
            break;
        default:
            header("Location: home.php"); // Optional fallback
            break;
    }
    exit; // Ensure no further code is executed
}

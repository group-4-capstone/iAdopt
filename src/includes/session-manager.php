<?php

// Check if the user is logged in by checking email and logged_in status
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && isset($_SESSION['email'])) {
    // Redirect based on the user's role
    if ($_SESSION['role'] === 'user') {
        header("Location: home.php");
        exit;
    } elseif ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head admin') {
        header("Location: dashboard.php");
        exit;
    }
}

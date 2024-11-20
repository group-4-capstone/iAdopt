<?php
// Update password PHP script (update-password.php)
session_start();
require_once 'db-connect.php';  // Database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];

    // Check if new password meets security requirements
    if (strlen($new_password) < 8 || !preg_match('/[A-Z]/', $new_password) || !preg_match('/\d/', $new_password) || !preg_match('/[@$!%*?&#]/', $new_password)) {
        echo 'Password must be at least 8 characters, include uppercase letters, a number, and a special character.';
        exit;
    }

    // Ensure the user is logged in (session handling)
    if (!isset($_SESSION['user_id'])) {
        echo 'You must be logged in to change your password.';
        exit;
    }

    // Get current user ID
    $user_id = $_SESSION['user_id'];

    // Check if the new password is the same as the current one
    $query = "SELECT password FROM users WHERE user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (password_verify($new_password, $user['password'])) {
        echo 'The new password cannot be the same as the current password.';
        exit;
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Update the password in the database
    $update_query = "UPDATE users SET password = ? WHERE user_id = ?";
    $update_stmt = $db->prepare($update_query);
    $update_stmt->bind_param("si", $hashed_password, $user_id);
    if ($update_stmt->execute()) {
        echo 'Password updated successfully!';
    } else {
        echo 'An error occurred while updating the password. Please try again.';
    }
}


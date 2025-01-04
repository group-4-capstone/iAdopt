<?php
// Verify password PHP script (verify-password.php)
session_start();
require_once 'db-connect.php';  // Database connection file

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];

    // Ensure the user is logged in (session handling)
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'You must be logged in to verify the password.']);
        exit;
    }

    // Get the current user ID
    $user_id = $_SESSION['user_id'];

    // Validate the current password input
    if (empty($current_password)) {
        echo json_encode(['success' => false, 'message' => 'Current password is required.']);
        exit;
    }

    // Query the database to retrieve the stored password for the user
    $query = "SELECT password FROM users WHERE user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // If the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $stored_password = $user['password'];

        // Verify the entered current password against the stored password
        if (password_verify($current_password, $stored_password)) {
            echo json_encode(['success' => true, 'message' => 'Password verified successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Incorrect current password.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found.']);
    }

    // Close the statement and database connection
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

// Close the database connection
$db->close();
?>

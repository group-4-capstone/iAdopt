<?php
session_start();
include_once 'db-connect.php'; // Include your database connection file

// Set the response type to JSON
header('Content-Type: application/json');

// Check if the request is valid
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    if (empty($_POST['current_password'])) {
        echo json_encode(['success' => false, 'error' => 'Current password is required']);
        exit;
    }

    $currentPassword = trim($_POST['current_password']); // Ensure no leading/trailing spaces

    // Get the user's hashed password from the database
    $userId = $_SESSION['user_id']; // Assuming user_id is stored in the session

    // Check if the user is logged in
    if (!$userId) {
        echo json_encode(['success' => false, 'error' => 'User not logged in']);
        exit;
    }

    // Prepare and execute the query to fetch the user's hashed password
    $query = $db->prepare("SELECT password FROM users WHERE user_id = ?");
    $query->bind_param("i", $userId);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify the password against the hashed password
        if (password_verify($currentPassword, $hashedPassword)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Incorrect password']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'User not found']);
    }

    // Close the query statement
    $query->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

// Close the database connection
$db->close();
?>

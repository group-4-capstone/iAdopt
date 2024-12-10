<?php 
// Include database connection
require 'db-connect.php';

// Start session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data with validation
    $creationDate = $_POST['creationDate'] ?? null;
    $volunteerName = $_POST['volunteerName'] ?? null;
    $email = $_POST['email'] ?? null;
    $status = $_POST['status'] ?? null;

    // Ensure all fields are provided
    if (!$creationDate || !$volunteerName || !$email || !$status) {
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit();
    }

    // Generate a random 8-character password
    //$initialPassword = bin2hex(random_bytes(4));

    // Use a temporary password
    $initialPassword = '12345abc';

    // Hash the initial password for storage
    $hashedPassword = password_hash($initialPassword, PASSWORD_DEFAULT);

    // Prepare SQL to insert new admin
    $sql = "INSERT INTO users (email, password, role, status, acc_creation, first_name) VALUES (?, ?, 'admin', ?, ?, ?)";
    $stmt = $db->prepare($sql);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'error' => 'Error in SQL preparation: ' . $db->error]);
        exit();
    }

    // Bind parameters and execute the query
    $stmt->bind_param("sssss", $email, $hashedPassword, $status, $creationDate, $volunteerName);
    if ($stmt->execute()) {
        // Set a session variable to indicate success
        $_SESSION['showSuccessModal'] = true;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error: ' . $stmt->error]);
    }

    // Close statement and connection
    $stmt->close();
    $db->close();
}

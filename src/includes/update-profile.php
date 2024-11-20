<?php
include_once 'db-connect.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect data from the AJAX request
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $middle_initial = $_POST['middle_initial'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';
    $address = $_POST['address'] ?? '';
    $fb_link = $_POST['fb_link'] ?? ''; // Fallback for fb_link
    $contact_num = $_POST['contact_num'] ?? '';
    $email = $_POST['email'] ?? '';

    // Validate and sanitize input (example for email)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Update the user data in the database
    $query = "UPDATE users SET first_name = ?, last_name = ?, middle_initial = ?, birthdate = ?, address = ?, fb_link = ?, contact_num = ? WHERE email = ?";
    
    $stmt = $db->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param('ssssssss', $first_name, $last_name, $middle_initial, $birthdate, $address, $fb_link, $contact_num, $email);
        if ($stmt->execute()) {
            echo "Profile updated successfully!";
        } else {
            echo "Failed to update profile. Please try again.";
        }
        $stmt->close();
    } else {
        echo "Database error. Please contact support.";
    }
} else {
    echo "Invalid request method.";
}

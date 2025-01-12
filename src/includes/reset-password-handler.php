<?php
// includes/reset-password-handler.php
include 'db-connect.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }

    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update password
    $updateQuery = "UPDATE users SET password = ? WHERE email = ?";
    if ($stmt = $db->prepare($updateQuery)) {
        $stmt->bind_param('ss', $passwordHash, $email);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update password.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Database query error.']);
    }

    $db->close();
}
?>

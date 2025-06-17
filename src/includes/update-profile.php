<?php
include_once 'db-connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Get POST data
    $first_name = $_POST['first_name'] ?? null;
    $last_name = $_POST['last_name'] ?? null;
    $middle_initial = $_POST['middle_initial'] ?? null;
    $birthdate = $_POST['birthdate'] ?? null;
    $contact_num = $_POST['contact_num'] ?? null;
    $fb_link = $_POST['fb_link'] ?? null;
    $email = $_POST['email'] ?? null;

    // Prepare SQL query
    $query = "UPDATE users SET 
                first_name = ?, 
                last_name = ?, 
                middle_initial = ?, 
                birthdate = ?, 
                contact_num = ?, 
                fb_link = ?, 
                email = ?
              WHERE user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param(
        "sssssssi",
        $first_name,
        $last_name,
        $middle_initial,
        $birthdate,
        $contact_num,
        $fb_link,
        $email,
        $user_id
    );

    if ($stmt->execute()) {
        // Update session data
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        
        echo json_encode([
            
            "status" => "success",
            "message" => "Profile updated successfully."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to update profile. Please try again."
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request."
    ]);
}
?>

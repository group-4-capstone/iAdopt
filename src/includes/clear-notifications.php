<?php
include 'session-handler.php';
include 'db-connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}


$user_id = $_SESSION['user_id'];

$query = "UPDATE notifications SET display = 0 WHERE user_id = ?";

if ($stmt = $db->prepare($query)) {
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false]);
}

$db->close();

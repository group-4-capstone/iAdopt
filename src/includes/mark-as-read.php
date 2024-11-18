<?php
include 'session-handler.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$notification_id = isset($_POST['notification_id']) ? $_POST['notification_id'] : '';

include 'db-connect.php';

$sql = "UPDATE notifications SET is_read = 1 WHERE user_id = ? AND notification_id = ?";

$stmt = $db->prepare($sql);

$stmt->bind_param('ii', $user_id, $notification_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update notification']);
}
?>

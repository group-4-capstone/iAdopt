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

$sql = "SELECT * FROM notifications WHERE user_id = ? AND notification_id = ?";


$stmt = $db->prepare($sql);

$stmt->bind_param('ii', $user_id, $notification_id);

$stmt->execute();

$result = $stmt->get_result();
$notification = $result->fetch_assoc();

// Return the results as JSON
if ($notification) {
    echo json_encode(['success' => true, 'data' => $notification]);
} else {
    echo json_encode(['success' => false, 'message' => 'Notification not found']);
}
?>

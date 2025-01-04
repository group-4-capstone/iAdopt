<?php
include 'session-handler.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

include 'db-connect.php';

$unread_sql = "SELECT COUNT(*) as unread_count FROM notifications WHERE user_id = ? AND is_read = 0 AND display = 1";
$unread_stmt = $db->prepare($unread_sql);
$unread_stmt->bind_param('i', $user_id);
$unread_stmt->execute();
$unread_result = $unread_stmt->get_result();
$unread_row = $unread_result->fetch_assoc();
$unread_count = (int)$unread_row['unread_count'];
$unread_stmt->close();

// Fetch all notifications for the user
$sql = "SELECT notification_id, message, is_read, created_at 
        FROM notifications 
        WHERE user_id = ? AND display = 1
        ORDER BY created_at DESC";

$stmt = $db->prepare($sql);
$stmt->bind_param('i', $user_id);

if (!$stmt->execute()) {
    echo json_encode(['error' => 'Failed to fetch notifications']);
    exit();
}

$result = $stmt->get_result();
$notifications = [];

while ($row = $result->fetch_assoc()) {
    $row['css_class'] = $row['is_read'] == 1 ? 'read' : 'unread';
    $notifications[] = $row;
}

echo json_encode([
    'data' => $notifications,
    'unread_count' => $unread_count
]);

$stmt->close();
$db->close();
?>

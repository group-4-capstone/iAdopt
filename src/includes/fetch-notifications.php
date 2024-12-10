<?php
include 'session-handler.php';

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id']; 
} else {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

include 'db-connect.php'; 

// Fetch all notifications and count unread notifications
$sql = "SELECT *, (SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0) as unread_count 
        FROM notifications 
        WHERE user_id = ? 
        ORDER BY created_at DESC";

$stmt = $db->prepare($sql);

$stmt->bind_param('ii', $user_id, $user_id);

$stmt->execute();

$result = $stmt->get_result();

$notifications = [];
$unread_count = 0;
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
    if ($unread_count === 0) {
        $unread_count = (int)$row['unread_count'];
    }
}

echo json_encode([
    'data' => $notifications,
    'unread_count' => $unread_count
]);

$stmt->close();
$db->close();
?>

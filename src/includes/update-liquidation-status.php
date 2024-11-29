<?php
include_once 'session-handler.php';
include_once 'db-connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $liquidation_id = $_POST['liquidation_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if ($liquidation_id && $action) {
        $status = $action === 'approve' ? 'Verified' : 'Invalid';

        $query = "UPDATE liquidation SET liquidation_status = ? WHERE liquidation_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('si', $status, $liquidation_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request data.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$db->close();
?>

<?php
include_once 'session-handler.php';
include_once 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rescue_id = $_POST['rescue_id'] ?? null;
    $action = $_POST['action'] ?? null;
    $deny_reason = $_POST['deny_reason'] ?? null;

    if (!$rescue_id || !$action) {
        echo json_encode(['success' => false, 'message' => 'Invalid rescue ID or action.']);
        exit;
    }

    $userQuery = "SELECT user_id FROM rescue WHERE rescue_id = ?";
    $userStmt = $db->prepare($userQuery);
    if ($userStmt === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the query for user retrieval.']);
        exit;
    }

    $userStmt->bind_param("i", $rescue_id);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    
    if ($userResult->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Rescue ID not found.']);
        $userStmt->close();
        exit;
    }

    $userRow = $userResult->fetch_assoc();
    $user_id = $userRow['user_id'];
    $userStmt->close();

    if ($action === 'accept') {
        $status = 'On Process';
        $message = "Your rescue report has been accepted by the shelter.";
        $notification_type = 'Rescue Report Success';
    } elseif ($action === 'deny' && $deny_reason) {
        $status = 'Denied';
        $message = "Your rescue report has been denied by the shelter due to " . strtolower($deny_reason) . ".";
        $notification_type = 'Rescue Report Unsuccess';

        $query_rescue = "UPDATE rescue SET deny_reason = ? WHERE rescue_id = ?";
        $stmt_rescue = $db->prepare($query_rescue);
        if ($stmt_rescue === false) {
            echo json_encode(['success' => false, 'message' => 'Failed to prepare the query for deny reason.']);
            exit;
        }

        $stmt_rescue->bind_param('si', $deny_reason, $rescue_id);
        if (!$stmt_rescue->execute()) {
            echo json_encode(['success' => false, 'message' => 'Error updating deny reason.']);
            $stmt_rescue->close();
            exit;
        }
        $stmt_rescue->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Deny reason is required for denial.']);
        exit;
    }

    $query_animal = "UPDATE animals SET animal_status = ? WHERE animal_id = (SELECT animal_id FROM rescue WHERE rescue_id = ?)";
    $stmt_animal = $db->prepare($query_animal);
    if ($stmt_animal === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the query for updating animal status.']);
        exit;
    }

    $stmt_animal->bind_param('si', $status, $rescue_id);
    if ($stmt_animal->execute()) {
        $is_read = 0; 
        $display = 1;
        $notifSql = "INSERT INTO notifications (user_id, message, notification_type, is_read, created_at, display) VALUES (?, ?, ?, ?, NOW(), ?)";
        $notifStmt = $db->prepare($notifSql);
        if ($notifStmt === false) {
            echo json_encode(['success' => false, 'message' => 'Failed to prepare the query for notification.']);
            $stmt_animal->close();
            exit;
        }

        $notifStmt->bind_param("issi", $user_id, $message, $notification_type, $is_read);
        $notifStmt->execute();
        $notifStmt->close();

        echo json_encode(['success' => true, 'message' => "Animal status updated to '$status'."]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating animal status.']);
    }

    $stmt_animal->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$db->close();
?>

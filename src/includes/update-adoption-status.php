<?php
include_once 'session-handler.php';
include_once 'db-connect.php'; 

// Make sure to validate and sanitize input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get input values
    $application_id = $_POST['application_id'];
    $application_status = $_POST['application_status'];

    // Retrieve user_id for notification
    $userQuery = "SELECT user_id FROM applications WHERE application_id = ?";
    $userStmt = $db->prepare($userQuery);
    $userStmt->bind_param("i", $application_id);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $userRow = $userResult->fetch_assoc();
    $user_id = $userRow['user_id'];

    if ($application_status == 'Approved') {
        $sched_interview = $_POST['sched_interview'];

        // Update application status and schedule interview
        $sql = "UPDATE applications SET application_status = ?, sched_interview = ? WHERE application_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssi", $application_status, $sched_interview, $application_id);

        if ($stmt->execute()) {
            
            $formattedDate = date("F j, Y g:i A", strtotime($sched_interview));
            // Insert notification for approved application
            $message = "Congratulations! Your application has been approved. Interview scheduled on: $formattedDate.";
            $notification_type = 'Application Approved';
            $is_read = 0; // Unread by default

            $notifSql = "INSERT INTO notifications (user_id, message, notification_type, is_read, created_at) VALUES (?, ?, ?, ?, NOW())";
            $notifStmt = $db->prepare($notifSql);
            $notifStmt->bind_param("issi", $user_id, $message, $notification_type, $is_read);
            $notifStmt->execute();

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    } elseif ($application_status == 'Rejected') {
        $status_message = $_POST['status_message'];

        // Update application status with rejection message
        $sql = "UPDATE applications SET application_status = ?, status_message = ? WHERE application_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssi", $application_status, $status_message, $application_id);

        if ($stmt->execute()) {
            // Insert notification for rejected application
            $message = "We're sorry. Your application has been rejected. Reason: $status_message.";
            $notification_type = 'Application Rejected';
            $is_read = 0; // Unread by default

            $notifSql = "INSERT INTO notifications (user_id, message, notification_type, is_read, created_at) VALUES (?, ?, ?, ?, NOW())";
            $notifStmt = $db->prepare($notifSql);
            $notifStmt->bind_param("issi", $user_id, $message, $notification_type, $is_read);
            $notifStmt->execute();

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    $db->close();
}
?>
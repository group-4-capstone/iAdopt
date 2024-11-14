<?php
include_once 'session-handler.php';
include_once 'db-connect.php'; 

// Make sure to validate and sanitize input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get input values
    $application_id = $_POST['application_id'];
    $application_status = $_POST['application_status'];

    if ($application_status == 'Approved') {
        $sched_interview = $_POST['sched_interview'];

        $sql = "UPDATE applications SET application_status = ?, sched_interview = ? WHERE application_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssi", $application_status, $sched_interview, $application_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    } elseif ($application_status == 'Rejected') {
        $status_message = $_POST['status_message'];

        $sql = "UPDATE applications SET application_status = ?, status_message = ? WHERE application_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssi", $application_status, $status_message, $application_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    $db->close();
}
?>

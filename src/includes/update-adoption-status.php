<?php
include_once 'session-handler.php';
include_once 'db-connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $application_id = $_POST['application_id'];
    $application_status = $_POST['application_status'];

    $sql = "UPDATE applications SET application_status = ? WHERE application_id = ?";
    
    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param("si", $application_status, $application_id); 

        if ($stmt->execute()) {
            echo "Status updated successfully";
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $db->error;
    }
}
$db->close();
?>

<?php
include_once 'session-handler.php';
include_once 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rescue_id = $_POST['rescue_id'] ?? null;

    if ($rescue_id) {
        $query = "UPDATE animals 
                  SET animal_status = 'Under Review' 
                  WHERE animal_id = (SELECT animal_id FROM rescue WHERE rescue_id = ?)";
        
        // Prepare and execute the statement
        if ($stmt = $db->prepare($query)) {
            $stmt->bind_param('i', $rescue_id);

            if ($stmt->execute()) {
                echo $rescue_id;
                echo 'Animal status updated successfully.';
            } else {
                echo json_encode(['success' => false, 'message' => 'Error updating animal status.']);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Database query preparation failed.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid rescue ID.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$db->close();
?>

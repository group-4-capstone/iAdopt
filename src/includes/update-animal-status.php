<?php
include_once 'session-handler.php';
include_once 'db-connect.php'; 
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['animal_id'], $_POST['animal_status'])) {
        // Sanitize inputs
        $animal_id = intval($_POST['animal_id']);
        $status = htmlspecialchars($_POST['animal_status']);

        // Update query
        $query = "UPDATE animals SET animal_status = ? WHERE animal_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("si", $status, $animal_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Database update failed.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid form submission.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>

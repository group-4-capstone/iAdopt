<?php
include_once 'session-handler.php';
include_once 'db-connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['animal_id'], $_POST['animal_status'], $_POST['application_id'])) {
        // Sanitize inputs
        $animal_id = intval($_POST['animal_id']);
        $application_id = intval($_POST['application_id']);
        $status = htmlspecialchars($_POST['animal_status']);

        // Update animal status
        $updateAnimalQuery = "UPDATE animals SET animal_status = ? WHERE animal_id = ?";
        $animalStmt = $db->prepare($updateAnimalQuery);
        $animalStmt->bind_param("si", $status, $animal_id);

        if ($animalStmt->execute()) {
            // If the status is "Adopted," update the adoption date
            if ($status === 'Adopted') {
                $adoptionDate = date('Y-m-d H:i:s'); // Current timestamp
                $updateApplicationQuery = "UPDATE applications SET adoption_date = ? WHERE application_id = ?";
                $applicationStmt = $db->prepare($updateApplicationQuery);
                $applicationStmt->bind_param("si", $adoptionDate, $application_id);

                if (!$applicationStmt->execute()) {
                    echo json_encode(['success' => false, 'error' => 'Failed to update adoption date.']);
                    exit;
                }
            }
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update animal status.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid form submission.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>

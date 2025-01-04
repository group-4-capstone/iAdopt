<?php
include_once 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animal_id = isset($_POST['animal_id']) ? intval($_POST['animal_id']) : 0;

    if ($animal_id > 0) {
        $sql = "UPDATE animals SET animal_status = 'Adopted' WHERE animal_id = ?";
        
        
        if ($stmt = $db->prepare($sql)) {
            $stmt->bind_param("i", $animal_id);
            if ($stmt->execute()) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "error" => $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "error" => $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Invalid animal ID."]);
    }

    $db->close();
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method."]);
}
?>

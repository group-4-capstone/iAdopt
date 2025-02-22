<?php
include_once 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animal_id = isset($_POST['animal_id']) ? intval($_POST['animal_id']) : 0;
    $application_id = isset($_POST['application_id']) ? intval($_POST['application_id']) : 0;

    if ($animal_id > 0 && $application_id > 0) {
        // Update animals table
        $sql1 = "UPDATE animals SET animal_status = 'Adopted' WHERE animal_id = ?";
        if ($stmt1 = $db->prepare($sql1)) {
            $stmt1->bind_param("i", $animal_id);
            if ($stmt1->execute()) {
                $stmt1->close();
            } else {
                echo json_encode(["success" => false, "error" => $stmt1->error]);
                exit;
            }
        } else {
            echo json_encode(["success" => false, "error" => $conn->error]);
            exit;
        }

        // Update applications table
        $sql2 = "UPDATE applications SET application_status = 'Approved' WHERE application_id = ?";
        if ($stmt2 = $db->prepare($sql2)) {
            $stmt2->bind_param("i", $application_id);
            if ($stmt2->execute()) {
                $stmt2->close();
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "error" => $stmt2->error]);
            }
        } else {
            echo json_encode(["success" => false, "error" => $conn->error]);
        }

        $db->close();
    } else {
        echo json_encode(["success" => false, "error" => "Invalid animal ID or application ID."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method."]);
}
?>

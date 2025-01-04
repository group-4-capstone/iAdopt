<?php
include 'db-connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form data, but do not include the fields to be removed
    $animal_id = $_POST['animal_id'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $age = $_POST['age'] ?? '';
    $medical_treatments = $_POST['medical_treatments'] ?? '';
    $illness_injuries = $_POST['illness_injuries'] ?? '';
    $remarks = $_POST['remarks'] ?? '';

    // Check if all required fields are provided
    if (empty($animal_id) || empty($weight) || empty($age)) {
        echo json_encode([
            "status" => "error",
            "message" => "Animal ID, weight, and age are required."
        ]);
        exit;
    }

    // Escape the input data to prevent SQL injection
    $animal_id = $db->real_escape_string($animal_id);
    $weight = $db->real_escape_string($weight);
    $age = $db->real_escape_string($age);
    $medical_treatments = $db->real_escape_string($medical_treatments);
    $illness_injuries = $db->real_escape_string($illness_injuries);
    $remarks = $db->real_escape_string($remarks);

    // Check if a medical record already exists for this animal
    $checkQuery = "SELECT * FROM medical WHERE animal_id = '$animal_id'";
    $result = $db->query($checkQuery);

    if ($result && $result->num_rows > 0) {
        // Record exists, update it (excluding removed fields)
        $updateQuery = "UPDATE medical 
                        SET weight = '$weight', age = '$age', medical_treatments = '$medical_treatments', illness_injuries = '$illness_injuries', remarks = '$remarks', last_updated = NOW() 
                        WHERE animal_id = '$animal_id'";

        if ($db->query($updateQuery)) {
            echo json_encode([
                "status" => "success",
                "message" => "Health record has been successfully updated."
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Error updating health record: " . $db->error
            ]);
        }
    } else {
        // No record found, insert new record (excluding removed fields)
        $insertQuery = "INSERT INTO medical (animal_id, weight, age, medical_treatments, illness_injuries, remarks, age_added) 
                        VALUES ('$animal_id', '$weight', '$age', '$medical_treatments', '$illness_injuries', '$remarks', NOW())";

        if ($db->query($insertQuery)) {
            echo json_encode([
                "status" => "success",
                "message" => "Health record has been successfully added."
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Error inserting health record: " . $db->error
            ]);
        }
    }

    // Close the database connection
    $db->close();
} else {
    // Invalid request method
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method."
    ]);
}

?>

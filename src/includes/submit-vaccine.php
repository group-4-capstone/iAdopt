<?php
include 'db-connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $animal_id = mysqli_real_escape_string($db, $_POST['animal_id']);
    $vaccine_name = mysqli_real_escape_string($db, $_POST['vaccine_name']);
    
    // If "Other" is selected, use the custom vaccine name from the 'other_vaccine_name' input
    if ($vaccine_name === 'Other' && !empty($_POST['other_vaccine_name'])) {
        $vaccine_name = mysqli_real_escape_string($db, $_POST['other_vaccine_name']);
    }
    
    $vaccination_date = mysqli_real_escape_string($db, $_POST['vaccination_date']);
    $next_due_date = mysqli_real_escape_string($db, $_POST['next_due_date']);
    $vet_name = mysqli_real_escape_string($db, $_POST['vet_name']);
    $vet_contact = mysqli_real_escape_string($db, $_POST['vet_contact']);
    $remarks = mysqli_real_escape_string($db, $_POST['remarks']);

    // Validate that animal_id is numeric
    if (empty($animal_id) || !is_numeric($animal_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid animal ID.']);
        exit;
    }

    // Prepare the SQL query for insertion
    $sql = "INSERT INTO vaccines (animal_id, vaccine_name, vaccination_date, next_due_date, vet_name, vet_contact, remarks)
            VALUES ('$animal_id', '$vaccine_name', '$vaccination_date', 
                    " . (!empty($next_due_date) ? "'$next_due_date'" : "NULL") . ", 
                    '$vet_name', '$vet_contact', '$remarks')";

    // Execute the query and return success or error message
    if ($db->query($sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Vaccine record submitted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $db->error]);
    }

    // Close the database connection
    $db->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>

<?php
include 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $volunteer_id = $_POST['volunteer_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    // Build the update query
    $updateQuery = "UPDATE volunteers SET first_name = ?, last_name = ?, role = ?, status = ? WHERE volunteer_id = ?";
    $params = [$first_name, $last_name, $role, $status, $volunteer_id];

    // Prepare and execute the query
    $stmt = $db->prepare($updateQuery);
    $stmt->bind_param(str_repeat('s', count($params) - 1) . 'i', ...$params); // Use 'i' for the volunteer_id (assuming it's an integer)

    if ($stmt->execute()) {
        echo "Volunteer information updated successfully.";
    } else {
        echo "Error: Could not update volunteer information. " . $stmt->error;
    }

    $stmt->close();
    $db->close();
}
?>

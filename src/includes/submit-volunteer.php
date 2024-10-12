<?php
include_once 'db-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    
    // Temporary user_id
    $user_id = 1;

    // Prepare and bind the SQL query
    $stmt = $db->prepare("INSERT INTO volunteers (first_name, last_name, role, status, admin) VALUES (?, ?, ?, ?, ?)");

    // Check if the statement preparation is successful
    if ($stmt === false) {
        die('Error in preparing the statement: ' . $db->error);
    }

    // Bind the parameters to the statement, using correct parameter types
    $stmt->bind_param("ssssi", $first_name, $last_name, $role, $status, $user_id);

    // Execute the query
    if ($stmt->execute()) {
        echo "Volunteer information successfully recorded!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$db->close();
?>

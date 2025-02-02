<?php
include_once 'db-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $names = $_POST['names'];
    $group_name = $_POST['group_name'];
    $pax = $_POST['pax'];
    $purpose = $_POST['purpose'];
    $visitDateTime = $_POST['visitDateTime'];

    // Prepare and bind the SQL query
    $stmt = $db->prepare("INSERT INTO visit (name, group_name, num_pax, purpose, visit_date) VALUES (?, ?, ?, ?, ?)");

    // Check if the statement preparation is successful
    if ($stmt === false) {
        die('Error in preparing the statement: ' . $db->error);
    }


    // Bind the parameters to the statement, using correct parameter types
    $stmt->bind_param("ssiss", $names, $group_name, $pax, $purpose, $visitDateTime);

    // Execute the query
    if ($stmt->execute()) {
        echo "Visit successfully recorded!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$db->close();
?>

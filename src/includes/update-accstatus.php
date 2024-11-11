<?php
include_once 'db-connect.php'; // Make sure this includes your Database class

$database = new Database(); // Create a new Database instance
$db = $database->getConnection(); // Get the database connection

if (isset($_POST['user_id']) && isset($_POST['status'])) {
    $userId = $_POST['user_id'];
    $status = $_POST['status'];

    // Prepare the SQL query
    $query = "UPDATE users SET status = ? WHERE user_id = ?";
    $stmt = $db->prepare($query);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("si", $status, $userId);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        $stmt->close(); // Close the statement
    } else {
        echo json_encode(['success' => false, 'error' => 'Statement preparation failed']);
    }
} else {
    error_log("Invalid request: Missing user_id or status"); // Log for debugging
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>

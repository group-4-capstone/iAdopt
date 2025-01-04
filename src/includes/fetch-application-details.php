<?php
include 'session-handler.php'; 
include 'db-connect.php';   

$response = array('success' => false, 'message' => '');

$applicationID = isset($_POST['application_id']) ? $_POST['application_id'] : null;

// Validate that the application ID is provided
if ($applicationID) {
    $sql = "SELECT * FROM applications WHERE application_id = ?";
    
    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param("i", $applicationID);
        
        // Execute the query
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            // Check if application data exists
            if ($result->num_rows > 0) {
                $applicationData = $result->fetch_assoc();
                $response = array(
                    'success' => true,
                    'data' => array(
                        'sched_interview' => $applicationData['sched_interview']
                    )
                );
            } else {
                // No application data found
                $response['message'] = 'Application not found.';
            }
        } else {
            // Query execution failed
            $response['message'] = 'Error executing query: ' . $stmt->error;
        }
        
        // Close the statement
        $stmt->close();
    } else {
        // Prepared statement creation failed
        $response['message'] = 'Error preparing SQL query: ' . $db->error;
    }
} else {
    // Application ID is missing
    $response['message'] = 'Application ID is required.';
}

// Close the database connection
$db->close();

// Send response as JSON
echo json_encode($response);
?>

<?php
include_once 'session-handler.php';
include_once 'db-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $faq_status = $_POST['faq_status'];

    // Temporary user_id for admin
    $admin_id = $_SESSION['user_id'];

    // Prepare and bind the SQL query
    $stmt = $db->prepare("INSERT INTO faqs (question, answer, faq_status, admin) VALUES (?, ?, ?, ?)");

    // Check if the statement preparation is successful
    if ($stmt === false) {
        die('Error in preparing the statement: ' . $db->error);
    }

    // Bind the parameters to the statement, using correct parameter types
    $stmt->bind_param("sssi", $question, $answer, $faq_status, $admin_id);

    // Execute the query
    if ($stmt->execute()) {
        echo "FAQ successfully recorded!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$db->close();
?>

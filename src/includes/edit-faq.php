<?php
include 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $faq_id = $_POST['faq_id'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $status = $_POST['status'];

    // Build the update query
    $updateQuery = "UPDATE faqs SET question = ?, answer = ?, status = ? WHERE faq_id = ?";
    $params = [$question, $answer, $status, $faq_id];

    // Prepare and execute the query
    $stmt = $db->prepare($updateQuery);
    $stmt->bind_param('sssi', ...$params); // Use 'i' for faq_id, assuming it's an integer

    if ($stmt->execute()) {
        echo "FAQ information updated successfully.";
    } else {
        echo "Error: Could not update FAQ information. " . $stmt->error;
    }

    $stmt->close();
    $db->close();
}
?>

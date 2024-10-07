<?php
include_once 'db-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure button_id is set
    if (isset($_POST['button_id'])) {
        $buttonId = $_POST['button_id'];
    } else {
        echo "Invalid button ID.";
        exit;
    }

    // Get the shared form data
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $user_id = 1;  // Set the user_id to 1

    // Handle donation submission
    if ($buttonId === 'submitDonation') {
        if (isset($_POST['donator'])) {
            $donator = $_POST['donator'];
        } else {
            echo "Donator is required for donation.";
            exit;
        }

        // Set the type
        $type = 'donation';

        // Prepare and bind the SQL statement for donation
        $stmt = $db->prepare("INSERT INTO liquidation (amount, description, donator, type, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("dsssi", $amount, $description, $donator, $type, $user_id);

    } elseif ($buttonId === 'submitExpense') {
        // Set the type
        $type = 'expense';

        // Prepare and bind the SQL statement for expense
        $stmt = $db->prepare("INSERT INTO liquidation (amount, description, type, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("dssi", $amount, $description, $type, $user_id);
        
    } else {
        echo "Invalid button ID.";
        exit;
    }

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $db->close();
}

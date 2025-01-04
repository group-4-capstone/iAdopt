<?php
include_once 'session-handler.php';
include_once 'db-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define upload directory
    $uploadDir = '../styles/assets/post-adoption/';

    // Check if the directory exists, if not, create it
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create directory with full permissions
    }

    // Retrieve form data
    $description = trim($_POST['currentDescription']);
    echo $application_id = intval($_POST['application_id']);
   echo $notification_id = intval($_POST['notification_id']);

    $query = "SELECT user_id, animal_id FROM applications WHERE application_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $application_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $appData = $result->fetch_assoc();

    if (!$appData) {
        echo json_encode(['success' => false, 'message' => 'Invalid application ID.']);
        exit;
    }

    $user_id = $appData['user_id'];
    $animal_id = $appData['animal_id'];

    // Handle file uploads
    $uploadedFiles = [];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'mp4', 'mov'];

    foreach ($_FILES['uploadFiles']['name'] as $key => $fileName) {
        $fileTmpName = $_FILES['uploadFiles']['tmp_name'][$key];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Validate file extension
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = uniqid('post_', true) . '.' . $fileExtension; // Generate unique name
            $filePath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpName, $filePath)) {
                $uploadedFiles[] = $newFileName; // Store the filename
            } else {
                echo json_encode(['success' => false, 'message' => 'File upload failed.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid file format.']);
            exit;
        }
    }

    // Store uploaded files as JSON
    $fileJson = json_encode($uploadedFiles);

    // Insert data into the post_adoption table
    $stmt = $db->prepare("INSERT INTO post_adoption (user_id, animal_id, application_id, notification_id, adoption_description, adoption_image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiss", $user_id, $animal_id, $application_id, $notification_id, $description, $fileJson);

    if ($stmt->execute()) {
        // Update the notifications table to set display = 0
        $updateQuery = "UPDATE notifications SET display = 0 WHERE notification_id = ?";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->bind_param("i", $notification_id);

        echo $notification_id;

        if ($updateStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Post-adoption form submitted successfully and notification updated!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Form submitted but failed to update notification.']);
        }

        $updateStmt->close(); // Close the update statement
    } else {
        echo json_encode(['success' => false, 'message' => 'Database insertion failed.']);
    }

    // Close resources
    $stmt->close();
    $db->close();
}
?>

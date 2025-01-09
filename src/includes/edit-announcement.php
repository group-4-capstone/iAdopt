<?php
include 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $announcement_id = $_POST['announcement_id'];
    $title = $_POST['title'];
    $status = $_POST['announcement_status'];
    $publish_date = $_POST['announcement_date'];
    $description = $_POST['description']; // Quill content from hidden input

    $newImageName = '';
    $imageUpdated = false;

    // Check if a new image is uploaded
    if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] == 0) {
        $imageFile = $_FILES['new_image'];
        $imageExtension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);

        // Rename the image with a unique name
        $newImageName = 'announcement_' . $announcement_id . '_' . time() . '.' . $imageExtension;
        $directory = 'styles/assets/announcement/';

        if (!is_dir($directory)) {
            if (!mkdir($directory, 0777, true)) {
                die(json_encode(['status' => 'error', 'message' => 'Failed to create directory for announcements.']));
            }
        }

        // Set the destination for the uploaded file
        $imageDestination = $directory . $newImageName;

        // Move the uploaded file to the specified destination
        if (move_uploaded_file($imageFile['tmp_name'], $imageDestination)) {
            $imageUpdated = true;
        } else {
            die(json_encode(['status' => 'error', 'message' => 'Unable to upload image.']));
        }
    }

    // Build the update query
    $updateQuery = "UPDATE announcements SET title = ?, announcement_status = ?, publish_date = ?, description = ?";

    // Include image field if it was updated
    if ($imageUpdated) {
        $updateQuery .= ", image = ?";
    }

    $updateQuery .= " WHERE announcement_id = ?";
    $params = [$title, $status, $publish_date, $description];

    // Add image if it's updated
    if ($imageUpdated) {
        $params[] = $newImageName;
    }
    
    $params[] = $announcement_id;

    // Prepare and execute the update statement
    $stmt = $db->prepare($updateQuery);
    $stmt->bind_param(str_repeat('s', count($params) - 1) . 'i', ...$params); // Bind parameters

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Announcement updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Could not update announcement.', 'error' => $stmt->error]);
    }

    $stmt->close();
    $db->close();
}
?>

<?php
include 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $announcement_id = $_POST['announcement_id'];
    $title = $_POST['title'];
    $status = $_POST['status'];
    $publish_date = $_POST['announcement_date'];

    $newImageName = '';
    $imageUpdated = false;

    // Check if a new image is uploaded
    if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] == 0) {
        $imageFile = $_FILES['new_image'];
        $imageExtension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);

        // Rename the image with a unique name
        $newImageName = 'announcement_' . $announcement_id . '_' . time() . '.' . $imageExtension;
        $imageDestination = 'styles/assets/announcement/' . $newImageName;

        // Move the uploaded file to the specified destination
        if (move_uploaded_file($imageFile['tmp_name'], $imageDestination)) {
            $imageUpdated = true;
        } else {
            die('Error: Unable to upload image.');
        }
    }

    // Update announcement details
    $updateQuery = "UPDATE announcements SET title = ?, status = ?, publish_date = ?";
    $params = [$title, $status, $publish_date];

    // Include image field if it was updated
    if ($imageUpdated) {
        $updateQuery .= ", image = ?";
        $params[] = $newImageName;
    }

    $updateQuery .= " WHERE announcement_id = ?";
    $params[] = $announcement_id;

    // Prepare and execute the update statement
    $stmt = $db->prepare($updateQuery);
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);

    if ($stmt->execute()) {
        echo "Announcement updated successfully.";
    } else {
        echo "Error: Could not update announcement. " . $stmt->error;
    }

    $stmt->close();
    $db->close();
}
?>

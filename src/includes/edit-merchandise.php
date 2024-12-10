<?php
include 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    $merch_id = $_POST['merch_id'];
    $item = $_POST['item'];
    $link = $_POST['link'];
    $status = $_POST['status'];

    $newImageName = '';
    $imageUpdated = false;

    if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] == 0) {
      
        $imageFile = $_FILES['new_image'];
        $imageExtension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);

        $newImageName = 'merch_' . $merch_id . '_' . time() . '.' . $imageExtension;
        $imageDestination = 'styles/assets/merchandise/' . $newImageName;

        if (move_uploaded_file($imageFile['tmp_name'], $imageDestination)) {
            $imageUpdated = true;
        } else {
            die('Error: Unable to upload image.');
        }
    }

    $updateQuery = "UPDATE merchandise SET item = ?, link = ?, status = ?";
    $params = [$item, $link, $status];

    // Include image field if it was updated
    if ($imageUpdated) {
        $updateQuery .= ", image = ?";
        $params[] = $newImageName;
    }

    $updateQuery .= " WHERE merch_id = ?";
    $params[] = $merch_id;

    $stmt = $db->prepare($updateQuery);
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);

    if ($stmt->execute()) {
        echo "Merchandise updated successfully.";
    } else {
        echo "Error: Could not update merchandise. " . $stmt->error;
    }

    $stmt->close();
    $db->close();
}
?>

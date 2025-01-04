<?php
include 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $animal_id = $_POST['animal_id']; 
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $type = $_POST['type'];
    $rescued_by = $_POST['rescued_by'];
    $rescued_at = $_POST['rescued_at'];
    $description = $_POST['description'];
    $tags = isset($_POST['tags']) ? implode(',', $_POST['tags']) : ''; 
    if (isset($_POST['animal_status']) && $_POST['animal_status'] !== '') {
        $animal_status = $_POST['animal_status']; // New selected status
    } else {
        $animal_status = $_POST['current_animal_status']; // Fallback to currentt staus
    }
    $imageFileName = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $newFileName = uniqid('animal_') . '.webp';
        $uploadPath = "../styles/assets/animals/$newFileName";

      
        if ($fileExtension === 'jpg' || $fileExtension === 'jpeg') {
            $image = imagecreatefromjpeg($fileTmpPath);
        } elseif ($fileExtension === 'png') {
            $image = imagecreatefrompng($fileTmpPath);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid image format. Only JPG and PNG are allowed.']);
            exit;
        }

        // Convert and save the image to WebP format
        if (isset($image) && imagewebp($image, $uploadPath)) {
            imagedestroy($image);
            $imageFileName = $newFileName;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to convert image to WebP format.']);
            exit;
        }
    }

  
    $updateAnimalSql = "
        UPDATE animals
        SET name = ?, gender = ?, type = ?, description = ?, tags = ?, animal_status = ?
        WHERE animal_id = ?
    ";
    $stmt = $db->prepare($updateAnimalSql);
    $stmt->execute([$name, $gender, $type, $description, $tags, $animal_status, $animal_id]); 

    if ($imageFileName) {
        $updateImageSql = "
            UPDATE animals
            SET image = ?
            WHERE animal_id = ?
        ";
        $stmt = $db->prepare($updateImageSql);
        $stmt->execute([$imageFileName, $animal_id]);
    }

    $updateRescueSql = "
        UPDATE rescue
        SET rescued_by = ?, rescued_at = ?
        WHERE animal_id = ?
    ";
    $stmt = $db->prepare($updateRescueSql);
    $stmt->execute([$rescued_by, $rescued_at, $animal_id]);

    echo json_encode(['status' => 'success', 'message' => 'Record updated successfully.']);
}
?>

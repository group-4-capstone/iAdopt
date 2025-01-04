<?php
include_once 'session-handler.php';
include_once 'db-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $title = $_POST['title'];
    $announcement_status = $_POST['announcement_status'];
    $announcementDate = isset($_POST['announcement_date']) && !empty($_POST['announcement_date']) ? $_POST['announcement_date'] : null;
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];

 
        $uploadDir = '../styles/assets/announcement/';

        // Check if the directory exists, and create it if not
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // 0755 permissions and 'true' for recursive creation
        }
        
        $imageWebpFileName = uniqid() . '.webp'; 
        $uploadWebpPath = $uploadDir . $imageWebpFileName;

  
        $fileType = mime_content_type($image['tmp_name']);
        if (!in_array($fileType, ['image/jpeg', 'image/png'])) {
            die('Invalid file type. Only JPEG and PNG formats are allowed.');
        }

        // Convert image to webp
        if ($fileType === 'image/jpeg') {
            $imageResource = imagecreatefromjpeg($image['tmp_name']);
        } elseif ($fileType === 'image/png') {
            $imageResource = imagecreatefrompng($image['tmp_name']);
        }

        // Save the image in webp format
        if (!imagewebp($imageResource, $uploadWebpPath)) {
            die('Failed to convert and save the image as webp.');
        }

        // Free the memory
        imagedestroy($imageResource);
    } else {
        $imageWebpFileName = null; // No image uploaded
    }

    // Prepare and bind the SQL query
    $stmt = $db->prepare("INSERT INTO announcements (title, announcement_status, publish_date, description, image, admin) VALUES (?, ?, ?, ?, ?, ?)");

    // Check if the statement preparation is successful
    if ($stmt === false) {
        die('Error in preparing the statement: ' . $db->error);
    }

    // Bind the parameters to the statement, using correct parameter types
    $stmt->bind_param("sssssi", $title, $announcement_status, $announcementDate, $description, $imageWebpFileName, $user_id); // Use $imageWebpFileName here

    // Execute the query
    if ($stmt->execute()) {
        echo "Announcement successfully recorded!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$db->close();
?>

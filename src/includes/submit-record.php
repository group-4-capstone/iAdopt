<?php
include_once 'session-handler.php';
include_once 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Get and sanitize inputs
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'UTF-8');
        $type = htmlspecialchars($_POST['type'], ENT_QUOTES, 'UTF-8');
        $rescued_by = htmlspecialchars($_POST['rescued_by'], ENT_QUOTES, 'UTF-8');
        $rescued_at = htmlspecialchars($_POST['rescued_at'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
        $animal_status = 'On Process';

        // Handle image upload and convert to WebP
        $upload_dir = '../styles/assets/animals/';
        $image = $_FILES['image']['tmp_name'];
        $file_name = basename($_FILES['image']['name']);
        $image_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Check allowed file extensions
        $allowed_extensions = ['jpeg', 'jpg', 'png'];
        if (!in_array($image_extension, $allowed_extensions)) {
            throw new Exception("Unsupported file format. Only JPEG, JPG, and PNG are allowed.");
        }

        // Generate unique file name for WebP image
        $webp_file_name = uniqid('', true) . '.webp';
        $target_file = $upload_dir . $webp_file_name;

        // Convert to WebP based on original image type
        if ($image_extension === 'jpeg' || $image_extension === 'jpg') {
            $img = imagecreatefromjpeg($image);
        } elseif ($image_extension === 'png') {
            $img = imagecreatefrompng($image);
        } else {
            throw new Exception("Unsupported file format.");
        }

        // Save the WebP image
        if ($img) {
            if (imagewebp($img, $target_file)) {
                imagedestroy($img); // Free up memory
            } else {
                throw new Exception("Failed to convert image to WebP.");
            }
        } else {
            throw new Exception("Error processing the uploaded image.");
        }

        // Insert animal data into animals table, including the WebP image file path and animal status
        $stmt = $db->prepare("INSERT INTO animals (name, gender, type, image, description, animal_status) 
                              VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $gender, $type, $webp_file_name, $description, $animal_status);

        if ($stmt->execute()) {
            // Get the last inserted animal_id
            $animal_id = $stmt->insert_id;

            // Insert into rescue table with report_type
            $user_id = $_SESSION['user_id'];

            // Set report type
            $report_type = 'rescue';
            
            // Update the query to include user_id
            $stmt = $db->prepare("INSERT INTO rescue (animal_id, rescued_by, rescued_at, report_type, user_id) 
                                  VALUES (?, ?, ?, ?, ?)");
            
            // Bind the parameters, including user_id
            $stmt->bind_param("isssi", $animal_id, $rescued_by, $rescued_at, $report_type, $user_id);

            if ($stmt->execute()) {
                echo 'Rescue record successfully submitted.';
            } else {
                throw new Exception("Error inserting into rescue table: " . $db->error);
            }
        } else {
            throw new Exception("Error inserting into animals table: " . $db->error);
        }
    } catch (Exception $e) {
        // Log detailed error message for debugging
        error_log('Error: ' . $e->getMessage());
        // Show a generic error message to the user
        http_response_code(500);
        echo 'An error occurred while processing your request.';
    }
}
?>

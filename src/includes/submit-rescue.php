<?php
include_once 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Sanitize input data
        $type = htmlspecialchars($_POST['type'], ENT_QUOTES, 'UTF-8');
        $specific = htmlspecialchars($_POST['specific'], ENT_QUOTES, 'UTF-8');
        $barangay = htmlspecialchars($_POST['barangay'], ENT_QUOTES, 'UTF-8');
        $municipality = htmlspecialchars($_POST['municipality'], ENT_QUOTES, 'UTF-8');
        $province = htmlspecialchars($_POST['province'], ENT_QUOTES, 'UTF-8');
        $rescue_description = htmlspecialchars($_POST['rescue_description'], ENT_QUOTES, 'UTF-8');

        // Create location from parts
        $location = $specific . ', ' . $barangay . ', ' . $municipality . ', ' . $province;

        // Handle image upload
        $upload_dir = '../styles/assets/rescue-reports/';
        $image = $_FILES['animal_image'];

        // Validate file extension
        $file_name = basename($image['name']);
        $image_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpeg', 'jpg', 'png'];

        if (!in_array($image_extension, $allowed_extensions)) {
            throw new Exception("Unsupported file format for: " . $file_name);
        }

        // Validate file size (limit: 10MB)
        if ($image['size'] > 10 * 1024 * 1024) { 
            throw new Exception("File size exceeds limit for: " . $file_name);
        }

        // Convert image to WebP format
        $webp_file_name = uniqid('', true) . '.webp';
        $target_file = $upload_dir . $webp_file_name;

        if ($image_extension === 'jpeg' || $image_extension === 'jpg') {
            $img = imagecreatefromjpeg($image['tmp_name']);
        } elseif ($image_extension === 'png') {
            $img = imagecreatefrompng($image['tmp_name']);
        } else {
            throw new Exception("Unsupported file format for: " . $file_name);
        }

        // Save image as WebP and check for errors
        if ($img) {
            if (imagewebp($img, $target_file)) {
                imagedestroy($img); // Free memory
                $animal_image = $webp_file_name; // Store only the filename
            } else {
                throw new Exception("Failed to convert image to WebP: " . $file_name);
            }
        } else {
            throw new Exception("Error loading image: " . $file_name);
        }

        // Insert into animals table using prepared statements
        $stmt = $db->prepare("INSERT INTO animals (type) VALUES (?)");
        $stmt->bind_param("s", $type);

        if ($stmt->execute()) {
            $animal_id = $stmt->insert_id; // Get the last inserted ID from animals table

            // Insert into rescue table using prepared statements
            $user_id = 1; // Static value for user_id
            $report_type = 'report'; // Static value for report_type
            $stmt = $db->prepare("INSERT INTO rescue (animal_id, location, animal_image, rescue_description, user_id, report_type) 
                                  VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssis", $animal_id, $location, $animal_image, $rescue_description, $user_id, $report_type);

            if ($stmt->execute()) {
                echo 'Rescue report successfully submitted.';
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

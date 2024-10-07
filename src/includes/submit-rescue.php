<?php
include_once 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $type = htmlspecialchars($_POST['type'], ENT_QUOTES, 'UTF-8');
        $specific = htmlspecialchars($_POST['specific'], ENT_QUOTES, 'UTF-8');
        $barangay = htmlspecialchars($_POST['barangay'], ENT_QUOTES, 'UTF-8');
        $municipality = htmlspecialchars($_POST['municipality'], ENT_QUOTES, 'UTF-8');
        $province = htmlspecialchars($_POST['province'], ENT_QUOTES, 'UTF-8');
        $rescue_description = htmlspecialchars($_POST['rescue_description'], ENT_QUOTES, 'UTF-8');

        $location = $specific . ', ' . $barangay . ', ' . $municipality . ', ' . $province;

        $upload_dir = '../styles/assets/rescue-reports/';
        $images = [];

        foreach ($_FILES['animal_image']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['animal_image']['name'][$key]);
            $image_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed_extensions = ['jpeg', 'jpg', 'png'];

            if (!in_array($image_extension, $allowed_extensions)) {
                throw new Exception("Unsupported file format for: " . $file_name);
            }

            if ($_FILES['animal_image']['size'][$key] > 10 * 1024 * 1024) { 
                throw new Exception("File size exceeds limit for: " . $file_name);
            }

            $webp_file_name = uniqid('', true) . '.webp';
            $target_file = $upload_dir . $webp_file_name;

            if ($image_extension === 'jpeg' || $image_extension === 'jpg') {
                $image = imagecreatefromjpeg($tmp_name);
            } elseif ($image_extension === 'png') {
                $image = imagecreatefrompng($tmp_name);
            } else {
                throw new Exception("Unsupported file format for: " . $file_name);
            }

            if ($image) {
                if (imagewebp($image, $target_file)) {
                    imagedestroy($image); 
                    $images[] = $target_file;
                } else {
                    throw new Exception("Failed to convert image to WebP: " . $file_name);
                }
            } else {
                throw new Exception("Error loading image: " . $file_name);
            }
        }

        $animal_images = json_encode($images);

        // Insert into animals table using prepared statements
        $stmt = $db->prepare("INSERT INTO animals (type) VALUES (?)");
        $stmt->bind_param("s", $type);

        if ($stmt->execute()) {
            $animal_id = $stmt->insert_id;

            // Insert into rescue table using prepared statements
            $stmt = $db->prepare("INSERT INTO rescue (animal_id, location, animal_image, rescue_description) 
                                  VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $animal_id, $location, $animal_images, $rescue_description);

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

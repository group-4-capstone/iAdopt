<?php
include_once 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {

        $type = $_POST['type'];
        $specific = $_POST['specific'];
        $barangay = $_POST['barangay'];
        $municipality = $_POST['municipality'];
        $province = $_POST['province'];
        $rescue_description = $_POST['rescue_description'];

        $location = $specific . ', ' . $barangay . ', ' . $municipality . ', ' . $province;

        $upload_dir = '../styles/assets/rescue-reports/';
        $images = [];

        foreach ($_FILES['animal_image']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['animal_image']['name'][$key]);
            $image_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $webp_file_name = pathinfo($file_name, PATHINFO_FILENAME) . '.webp';
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

        // Insert into animals table
        $query = "INSERT INTO animals (type) VALUES ('$type')";
        if (mysqli_query($db, $query)) {
            $animal_id = mysqli_insert_id($db);

            $query = "INSERT INTO rescue (animal_id, location, animal_image, rescue_description) 
                      VALUES ('$animal_id', '$location', '$animal_images', '$rescue_description')";

            if (mysqli_query($db, $query)) {
                echo 'Rescue report successfully submitted.';
            } else {
                throw new Exception("Error inserting into rescue table: " . mysqli_error($db));
            }
        } else {
            throw new Exception("Error inserting into animals table: " . mysqli_error($db));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo 'Error: ' . $e->getMessage();
    }
}
?>

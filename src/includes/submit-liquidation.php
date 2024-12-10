<?php
include_once 'session-handler.php';
include_once 'db-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure button_id is set
    if (isset($_POST['button_id'])) {
        $buttonId = $_POST['button_id'];
    } else {
        echo "Invalid button ID.";
        exit;
    }

    // Get the shared form data
    $amount = $_POST['amount'];
    $user_id = $_SESSION['user_id'];

    // Handle donation submission
    if ($buttonId === 'submitDonation') {

      // Set target directory
    $upload_dir = "../styles/assets/donations/";

    // Check if directory exists, create if not
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            echo "Failed to create target directory.";
            exit;
        }
    }

  
    if (isset($_FILES['proof_of_donation']) && $_FILES['proof_of_donation']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['proof_of_donation'];

        // Validate file extension
        $file_name = basename($image['name']);
        $image_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpeg', 'jpg', 'png'];

        if (!in_array($image_extension, $allowed_extensions)) {
            echo "Unsupported file format for: " . $file_name;
            exit;
        }

        // Validate file size (limit: 10MB)
        if ($image['size'] > 10 * 1024 * 1024) {
            echo "File size exceeds limit for: " . $file_name;
            exit;
        }

        // Convert image to WebP format
        $webp_file_name = uniqid('', true) . '.webp';
        $target_file = $upload_dir . $webp_file_name;

        if ($image_extension === 'jpeg' || $image_extension === 'jpg') {
            $img = imagecreatefromjpeg($image['tmp_name']);
        } elseif ($image_extension === 'png') {
            $img = imagecreatefrompng($image['tmp_name']);
        } else {
            echo "Unsupported file format for: " . $file_name;
            exit;
        }

        // Save image as WebP and check for errors
        if ($img) {
            if (imagewebp($img, $target_file)) {
                imagedestroy($img); // Free memory
                $proof = $webp_file_name; // Store only the filename
            } else {
                echo "Failed to convert image to WebP: " . $file_name;
                exit;
            }
        } else {
            echo "Error loading image: " . $file_name;
            exit;
        }
    } else {
        echo "Proof of donation is required.";
        exit;
    }

    
    $mode_of_donation = $_POST['mode_of_donation'];
    $type = 'Donation';
    $liquidation_status = 'For Verification';
    $donor_name = isset($_POST['donor_name']) && !empty($_POST['donor_name']) ? $_POST['donor_name'] : 'Anonymous';

    $stmt = $db->prepare("INSERT INTO liquidation (mode, amount, donor, type, liquidation_status, user_id, proof) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsssis", $mode_of_donation, $amount, $donor_name, $type, $liquidation_status, $user_id, $proof);
    
    
    } elseif ($buttonId === 'submitExpense') {
        // Set the type
        $description = $_POST['description'];

        if ($description === "Others") {
            $description = $_POST['other_description'];
        }
        $type = 'Expense';

           // Set target directory
    $upload_dir = "../styles/assets/expenses/";

    // Check if directory exists, create if not
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            echo "Failed to create target directory.";
            exit;
        }
    }

  
    if (isset($_FILES['proof_of_expense']) && $_FILES['proof_of_expense']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['proof_of_expense'];

        // Validate file extension
        $file_name = basename($image['name']);
        $image_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpeg', 'jpg', 'png'];

        if (!in_array($image_extension, $allowed_extensions)) {
            echo "Unsupported file format for: " . $file_name;
            exit;
        }

        // Validate file size (limit: 10MB)
        if ($image['size'] > 10 * 1024 * 1024) {
            echo "File size exceeds limit for: " . $file_name;
            exit;
        }

        // Convert image to WebP format
        $webp_file_name = uniqid('', true) . '.webp';
        $target_file = $upload_dir . $webp_file_name;

        if ($image_extension === 'jpeg' || $image_extension === 'jpg') {
            $img = imagecreatefromjpeg($image['tmp_name']);
        } elseif ($image_extension === 'png') {
            $img = imagecreatefrompng($image['tmp_name']);
        } else {
            echo "Unsupported file format for: " . $file_name;
            exit;
        }

        // Save image as WebP and check for errors
        if ($img) {
            if (imagewebp($img, $target_file)) {
                imagedestroy($img); // Free memory
                $proof = $webp_file_name; // Store only the filename
            } else {
                echo "Failed to convert image to WebP: " . $file_name;
                exit;
            }
        } else {
            echo "Error loading image: " . $file_name;
            exit;
        }
    } else {
        echo "Proof of expense is required.";
        exit;
    }
        // Prepare and bind the SQL statement for expense
        $stmt = $db->prepare("INSERT INTO liquidation (amount, description, type, user_id, proof) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("dssis", $amount, $description, $type, $user_id , $proof);
        
    } else {
        echo "Invalid button ID.";
        exit;
    }

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $db->close();
}

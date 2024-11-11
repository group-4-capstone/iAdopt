<?php
require '../phpqrcode/qrlib.php';
require 'db-connect.php';

if (isset($_POST['animal_id'])) {
    $animal_id = $_POST['animal_id'];
    $baseURL = 'http://localhost/iAdopt/src/animal-record.php?animal_id=' . $animal_id;

    // Check if QR code already exists
    $checkQuery = "SELECT * FROM qrcode WHERE animal_id = ?";
    $stmt = $db->prepare($checkQuery);
    $stmt->bind_param("i", $animal_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // QR code already exists, display the existing image
        $row = $result->fetch_assoc();
        $qrImage = $row['qr_image'];
        echo '<img src="' . $qrImage . '" alt="QR Code" class="img-fluid">';
        exit;
    }

    $qrText = $baseURL;
    $qrDir = '../styles/assets/qr_images/';
    $qrImage = $qrDir . 'animal_' . $animal_id . '.png';

    if (!is_dir($qrDir)) {
        mkdir($qrDir, 0775, true);
    }

    QRcode::png($qrText, $qrImage, 'L', 4, 2);

    // Check if the file was created
    if (file_exists($qrImage)) {
        // Insert QR code info into the database
        $insertQuery = "INSERT INTO qrcode (animal_id, qr_text, qr_image) VALUES (?, ?, ?)";
        $stmt = $db->prepare($insertQuery);
        $stmt->bind_param("iss", $animal_id, $qrText, $qrImage);

        if ($stmt->execute()) {
            
            echo '<img src="' . $qrImage . '" alt="QR Code" class="img-fluid">';
        } else {
            echo 'Error saving QR code to the database.';
        }
    } else {
        echo 'Error generating QR code image.';
    }

    // Close the statement
    $stmt->close();
}
?>

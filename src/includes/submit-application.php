<?php
include_once 'session-handler.php';
require 'db-connect.php';

// Function to convert images to WebP
function convertToWebP($source, $destination)
{
    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
    } else {
        move_uploaded_file($source, $destination);
        return;
    }

    imagewebp($image, $destination);
    imagedestroy($image);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $animal_id = $_POST['animal_id'] ?? NULL;
    $user_id = $_SESSION['user_id'];

    // Use null coalescing operator to set to NULL if not set
    $address1 = $_POST['address1'] ?? NULL;
    $address2 = $_POST['address2'] ?? NULL;
    $address3 = $_POST['address3'] ?? NULL;
    $address4 = $_POST['address4'] ?? NULL;
    $complete_address = ($address1 ? $address1 . ', ' : '') .
        ($address2 ? $address2 . ', ' : '') .
        ($address3 ? $address3 . ', ' : '') .
        ($address4 ? $address4 : '');

    $profession = $_POST['profession'] ?? NULL;
    $purpose = $_POST['purpose'] ?? NULL;
    $residence = $_POST['residence'] ?? NULL;
    $household_members = $_POST['household_members'] ?? NULL;
    $reg_years = $_POST['reg_years'] ?? NULL;
    $new_address = $_POST['new_address'] ?? NULL;
    $involve_reason = $_POST['involve_reason'] ?? NULL;
    $objection_reason = $_POST['objection_reason'] ?? NULL;
    $children_visit = $_POST['children_visit'] ?? NULL;
    $other_visit = $_POST['other_visit'] ?? NULL;
    $member_allergy = $_POST['member_allergy'] ?? NULL;
    $move_unexpectedly = $_POST['move_unexpectedly'] ?? NULL;
    $unacceptable_behavior = $_POST['unacceptable_behavior'] ?? NULL;
    $no_human_hours = $_POST['no_human_hours'] ?? NULL;
    $emergency = $_POST['emergency'] ?? NULL;
    $vet_name = $_POST['vet_name'] ?? NULL;
    $vet_address = $_POST['vet_address'] ?? NULL;
    $vet_number = $_POST['vet_number'] ?? NULL;
    $other_animals = $_POST['other_animals'] ?? NULL;
    $house_part = $_POST['house_part'] ?? NULL;
    $stay_place = $_POST['stay_place'] ?? NULL;
    $fence = $_POST['fence'] ?? NULL;
    $no_fence = $_POST['no_fence'] ?? NULL;
    $litter_place = $_POST['litter_place'] ?? NULL;

    // Handle Rent Letter (PDF or Image)
    $rent_letter_file = '';
    if (isset($_FILES['rent_letter']) && $_FILES['rent_letter']['error'] == 0) {
        $rent_letter_tmp = $_FILES['rent_letter']['tmp_name'];
        $rent_letter_ext = strtolower(pathinfo($_FILES['rent_letter']['name'], PATHINFO_EXTENSION));

        $rent_target_dir = "../styles/assets/applications/letter/";
        $rent_letter_file = uniqid() . '.' . $rent_letter_ext;
        $rent_target_file = $rent_target_dir . $rent_letter_file;

        if (in_array($rent_letter_ext, ['pdf', 'jpg', 'jpeg', 'png', 'webp'])) {
            // If it's an image, convert it to webp
            if ($rent_letter_ext !== 'pdf') {
                $rent_letter_file = uniqid() . '.webp';
                $rent_target_file = $rent_target_dir . $rent_letter_file;
                convertToWebP($rent_letter_tmp, $rent_target_file);
            } else {
                move_uploaded_file($rent_letter_tmp, $rent_target_file); // PDF or Image move
            }
        } else {
            echo "Invalid file type for Rent Letter.";
        }
    }

    // Handle Valid ID (single image)
    $valid_id_file = '';
    if (isset($_FILES['valid_id']) && $_FILES['valid_id']['error'] == 0) {
        $valid_id_tmp = $_FILES['valid_id']['tmp_name'];
        $valid_id_ext = strtolower(pathinfo($_FILES['valid_id']['name'], PATHINFO_EXTENSION));

        $valid_id_target_dir = "../styles/assets/applications/ids/";
        $valid_id_file = uniqid() . '.webp';
        $valid_id_target_file = $valid_id_target_dir . $valid_id_file;

        // Convert image to WebP and save
        convertToWebP($valid_id_tmp, $valid_id_target_file);
    }

    // Handle Proof of Place (multiple images)
    $proof_place_files = array();
    if (isset($_FILES['proof_place'])) {
        $total_files = count($_FILES['proof_place']['name']);
        $proof_place_target_dir = "../styles/assets/applications/proof/";

        for ($i = 0; $i < $total_files; $i++) {
            if ($_FILES['proof_place']['error'][$i] == 0) {
                $proof_place_tmp = $_FILES['proof_place']['tmp_name'][$i];
                $proof_place_ext = strtolower(pathinfo($_FILES['proof_place']['name'][$i], PATHINFO_EXTENSION));

                // Generate unique file name and target file path
                $proof_place_file = uniqid() . '.webp';
                $proof_place_target_file = $proof_place_target_dir . $proof_place_file;

                // Convert image to WebP and save
                convertToWebP($proof_place_tmp, $proof_place_target_file);

                // Store file name for database insertion
                $proof_place_files[] = $proof_place_file;
            }
        }
    }
    $proof_place_json = json_encode($proof_place_files); // Convert array to JSON string

   // Insert into database
$sql = "INSERT INTO applications (
    animal_id, user_id, complete_address, profession, purpose, residence, 
    household_members, reg_years, new_address, involve_reason, objection_reason, 
    children_visit, other_visit, member_allergy, move_unexpectedly, unacceptable_behavior, 
    no_human_hours, emergency, vet_name, vet_address, vet_number, other_animals, 
    house_part, stay_place, fence, no_fence, litter_place, rent_letter, valid_id, 
    proof_place, application_status
) 
VALUES (
    '$animal_id', 
    '$user_id', 
    " . ($complete_address ? "'$complete_address'" : "NULL") . ",
    " . ($profession ? "'$profession'" : "NULL") . ",
    " . ($purpose ? "'$purpose'" : "NULL") . ",
    " . ($residence ? "'$residence'" : "NULL") . ",
    " . ($household_members ? "'$household_members'" : "NULL") . ",
    " . ($reg_years ? "'$reg_years'" : "NULL") . ",
    " . ($new_address ? "'$new_address'" : "NULL") . ",
    " . ($involve_reason ? "'$involve_reason'" : "NULL") . ",
    " . ($objection_reason ? "'$objection_reason'" : "NULL") . ",
    " . ($children_visit ? "'$children_visit'" : "NULL") . ",
    " . ($other_visit ? "'$other_visit'" : "NULL") . ",
    " . ($member_allergy ? "'$member_allergy'" : "NULL") . ",
    " . ($move_unexpectedly ? "'$move_unexpectedly'" : "NULL") . ",
    " . ($unacceptable_behavior ? "'$unacceptable_behavior'" : "NULL") . ",
    " . ($no_human_hours ? "'$no_human_hours'" : "NULL") . ",
    " . ($emergency ? "'$emergency'" : "NULL") . ",
    " . ($vet_name ? "'$vet_name'" : "NULL") . ",
    " . ($vet_address ? "'$vet_address'" : "NULL") . ",
    " . ($vet_number ? "'$vet_number'" : "NULL") . ",
    " . ($other_animals ? "'$other_animals'" : "NULL") . ",
    " . ($house_part ? "'$house_part'" : "NULL") . ",
    " . ($stay_place ? "'$stay_place'" : "NULL") . ",
    " . ($fence ? "'$fence'" : "NULL") . ",
    " . ($no_fence ? "'$no_fence'" : "NULL") . ",
    " . ($litter_place ? "'$litter_place'" : "NULL") . ",
    " . ($rent_letter_file ? "'$rent_letter_file'" : "NULL") . ",
    " . ($valid_id_file ? "'$valid_id_file'" : "NULL") . ",
    '$proof_place_json',
    'Under Review'
)";


    if ($db->query($sql) === TRUE) {
        echo "Application successfully submitted.";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}

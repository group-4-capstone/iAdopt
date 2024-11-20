<?php // Include the database connection
include 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch and sanitize form data
    $last_name = mysqli_real_escape_string($db, $_POST['last-name']);
    $first_name = mysqli_real_escape_string($db, $_POST['first-name']);
    $mi = mysqli_real_escape_string($db, $_POST['mi']);
    $birthdate = mysqli_real_escape_string($db, $_POST['birthdate']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    
    // Fetch and sanitize address components
    $region = mysqli_real_escape_string($db, $_POST['region']);
    $province = mysqli_real_escape_string($db, $_POST['province']);
    $city = mysqli_real_escape_string($db, $_POST['city']);
    $barangay = mysqli_real_escape_string($db, $_POST['barangay']);
    
    // Concatenate the address components
    $address = $region . ', ' . $province . ', ' . $city . ', ' . $barangay;

    $facebook_profile = mysqli_real_escape_string($db, $_POST['facebook-profile']);
    $contact_number = mysqli_real_escape_string($db, $_POST['contact-number']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Check for missing fields and create error messages
    $errors = [];
    if (empty($last_name)) $errors[] = "Last name is required.";
    if (empty($first_name)) $errors[] = "First name is required.";
    if (empty($birthdate)) $errors[] = "Birthday is required.";
    if (empty($gender)) $errors[] = "Gender is required";
    if (empty($email)) $errors[] = "Email is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if (empty($_POST['password']) || empty($_POST['confirm-password'])) $errors[] = "Password and confirmation are required.";
    if ($_POST['password'] !== $_POST['confirm-password']) $errors[] = "Passwords do not match.";

    // Check if email or Facebook link already exists in the database
    if (empty($errors)) {
        $check_sql = "SELECT * FROM users WHERE email = '$email' OR fb_link = '$facebook_profile'";
        $result = mysqli_query($db, $check_sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['email'] == $email) {
                $errors[] = "The email address is already registered.";
            }
            if ($row['fb_link'] == $facebook_profile) {
                $errors[] = "The Facebook link is already registered.";
            }
        }
    }

    // If there are no errors, insert into the database
    if (empty($errors)) {
        $sql = "INSERT INTO users (email, password, role, last_name, first_name, middle_initial, birthdate, gender, address, fb_link, contact_num) 
                VALUES ('$email', '$password', 'user', '$last_name', '$first_name', '$mi', '$birthdate', '$gender', '$address', '$facebook_profile', '$contact_number')";

        if (mysqli_query($db, $sql)) {
            header("Location: ../signup.php?success=true");
        } else {
            $errors[] = "Error: " . mysqli_error($db);
        }
    }

    // Redirect back with error messages
    if (!empty($errors)) {
        header("Location: ../signup.php?error=" . urlencode(implode(',', $errors)));
    }

    // Close the database connection
    mysqli_close($db);
}

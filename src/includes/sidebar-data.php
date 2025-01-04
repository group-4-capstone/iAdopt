<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Retrieve user data from session variables
    $first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Guest';
    $last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';

      // Capitalize the first letter of each word
      $first_name = ucwords(strtolower($first_name));
      $last_name = ucwords(strtolower($last_name));

    // Return the user data as a JSON response
    echo json_encode([
        'first_name' => $first_name,
        'last_name' => $last_name
    ]);
} else {
    // If the user is not logged in, return default values
    echo json_encode([
        'first_name' => 'Guest',
        'last_name' => ''
    ]);
}
?>

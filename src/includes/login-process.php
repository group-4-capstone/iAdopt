<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db-connect.php';

header('Content-Type: application/json'); // Ensure the response is JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (!empty($email) && !empty($password)) {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "SELECT role, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($role, $hashed_password);
            $stmt->fetch();

            // Debugging: Log the email and password
            error_log("Email: $email");
            error_log("Input Password: $password");
            error_log("Hashed Password from DB: $hashed_password");

            if (password_verify($password, $hashed_password)) {
                $_SESSION['logged_in'] = true;
                $_SESSION['role'] = $role;
                $_SESSION['email'] = $email;

                // Return success response with the user's role
                echo json_encode(['success' => true, 'role' => $role]);
            } else {
                // Return error for incorrect password
                echo json_encode(['success' => false, 'error' => 'Invalid password. Please try again.']);
            }
        } else {
            // Return error for no account found
            echo json_encode(['success' => false, 'error' => 'No account found with that email.']);
        }

        $stmt->close();
        $conn->close();
    } else {
        // Return error for missing email or password
        echo json_encode(['success' => false, 'error' => 'Email and password are required.']);
    }
}
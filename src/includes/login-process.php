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

        $sql = "SELECT role, password, user_id FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($role, $hashed_password, $user_id); 
            $stmt->fetch();

            // Debugging: Log the email and password
            /*error_log("Email: $email");
            error_log("Input Password: $password");
            error_log("Hashed Password from DB: $hashed_password");
            */

            if (password_verify($password, $hashed_password)) {
                $_SESSION['logged_in'] = true;
                $_SESSION['role'] = $role;
                $_SESSION['email'] = $email;
                $_SESSION['user_id'] = $user_id; // Set user_id in session


                    // Retrieve and store first and last names in session bago to
                    $nameSql = "SELECT first_name, last_name FROM users WHERE user_id = ?";
                    $nameStmt = $conn->prepare($nameSql);
                    $nameStmt->bind_param("i", $user_id);
                    $nameStmt->execute();
                    $nameStmt->bind_result($first_name, $last_name);
                    if ($nameStmt->fetch()) {
                        $_SESSION['first_name'] = $first_name;
                        $_SESSION['last_name'] = $last_name;
                    }
                    $nameStmt->close();
                    
                // Return success response with the user's role
                echo json_encode(['success' => true, 'role' => $role, 'user_id' => $user_id]);
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

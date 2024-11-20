<?php
include 'session-handler.php';
include 'db-connect.php';

header('Content-Type: application/json'); // Ensure the response is JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (!empty($email) && !empty($password)) {
        $db = new Database();
        $conn = $db->getConnection();

        // Single query to retrieve all necessary user information
        $sql = "SELECT user_id, role, password, first_name, last_name, middle_initial, birthdate, fb_link, contact_num, address FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Bind all the retrieved data
                $stmt->bind_result($user_id, $role, $hashed_password, $first_name, $last_name, $middle_initial, $birthdate, $fb_link, $contact_num, $address);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    // Start session management, regenerate session ID for security
                    session_regenerate_id(true);

                    // Set session variables
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;
                    $_SESSION['first_name'] = $first_name;
                    $_SESSION['last_name'] = $last_name;
                    $_SESSION['middle_initial'] = $middle_initial;
                    $_SESSION['birthdate'] = $birthdate;
                    $_SESSION['fb_link'] = $fb_link;
                    $_SESSION['contact_num'] = $contact_num;
                    $_SESSION['address'] = $address;

                    // Return success response with the user's role
                    echo json_encode(['success' => true, 'role' => $role, 'user_id' => $user_id]);
                } else {
                    // Incorrect password response
                    echo json_encode(['success' => false, 'error' => 'Invalid password. Please try again.']);
                }
            } else {
                // No account found response
                echo json_encode(['success' => false, 'error' => 'No account found with that email.']);
            }

            $stmt->close();
        } else {
            // SQL statement preparation error
            echo json_encode(['success' => false, 'error' => 'Database query error.']);
        }

        $conn->close();
    } else {
        // Missing email or password response
        echo json_encode(['success' => false, 'error' => 'Email and password are required.']);
    }
}

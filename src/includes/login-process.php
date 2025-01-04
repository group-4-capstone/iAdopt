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

                    checkNotifications($conn, $user_id);


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

function checkNotifications($conn, $user_id)
{
    $is_read = 0;
    $display = 1;
    $current_date = new DateTime();

    // Prepare query to fetch user applications and associated animals
    $stmt = $conn->prepare("SELECT animals.adoption_date, animals.name, animals.animal_id, applications.application_id
            FROM applications 
            INNER JOIN animals 
            ON applications.animal_id = animals.animal_id
            WHERE applications.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Always target January 1 of the current year
    $target_date = new DateTime($current_date->format('Y') . '-12-20');

    // Collect all rows first to handle multiple results
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    // Process each row for notification
    foreach ($rows as $row) {
        $send_notification = true;

        // Check if a notification has already been sent for this year
        $check_stmt = $conn->prepare("SELECT created_at FROM notifications 
                WHERE user_id = ? AND notification_type = 'Post-Adoption Form Reminder' 
                AND message LIKE ? 
                ORDER BY created_at DESC LIMIT 1");

        $search_message = "%" . $row['name'] . "%"; // Search message for specific animal name
        $check_stmt->bind_param("is", $user_id, $search_message);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        // Evaluate if a notification was already sent this year
        if ($check_row = $check_result->fetch_assoc()) {
            $last_notification_date = new DateTime($check_row['created_at']);
            if ($last_notification_date->format('Y') == $current_date->format('Y')) {
                $send_notification = false; // Already sent this year
            }
        }

        // Send notification if conditions are met
        if ($send_notification && $current_date >= $target_date) {
            $message = "How's " . $row['name'] . " doing? Kindly fill out the post-adoption form :) Click here";
            $notification_type = 'Post-Adoption Form Reminder';

            $insert_stmt = $conn->prepare("INSERT INTO notifications (user_id, application_id, message, notification_type, is_read, display) 
                VALUES (?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("iissii", $user_id, $row['application_id'], $message, $notification_type, $is_read, $display);
            $insert_stmt->execute();
        }
    }
}





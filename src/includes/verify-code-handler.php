<?php
include 'db-connect.php'; // Database connection

header('Content-Type: application/json'); // Ensure JSON output

$response = ['success' => false, 'message' => 'Invalid reset code.'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $code = $_POST['code'];

    $query = "SELECT * FROM users WHERE email = ? AND reset_code = ?";
    if ($stmt = $db->prepare($query)) {
        $stmt->bind_param("ss", $email, $code);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response = [
                'success' => true,
                'email' => $email
            ];
        }
        $stmt->close();
    }
    $db->close();
}

echo json_encode($response);
?>

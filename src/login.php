<?php
include_once 'includes/db-connect.php';
include_once 'includes/session-handler.php';
include_once 'includes/session-manager.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
    <!--links-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Google Fonts Links For Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

<div class="row align-items-center">
    <!-- First Column: Hidden on Small Screens -->
    <div class="col-12 col-md-6 col-lg-6 d-none d-md-flex align-items-center text-center bg-image">
        <div class="mb-5">
            <img src="styles/assets/secaspi-logo.png" alt="Logo" class="img-fluid logo" width="30%">
        </div>
        <h3 class="fw-bold">iAdopt-SECASPI</h3>
        <h4>
            SECOND CHANCE ASPIN SHELTER <br> PHILIPPINES INCORPORATED
        </h4>
    </div>

    <!-- Second Column: Login Form Section -->
    <div class="col-12 col-md-6 d-flex justify-content-center">
        <form id="loginForm">
            <!-- Logo and Text for Small Screens -->
            <div class="d-md-none text-center my-4">
                <img src="styles/assets/secaspi-logo.png" alt="Logo" class="img-fluid" width="30%">
                <h3 class="fw-bold mt-2">iAdopt-SECASPI</h3>
                <h5>SECOND CHANCE ASPIN SHELTER <br> PHILIPPINES INCORPORATED</h5>
            </div>

            <div class="px-5">
            <h2 class="fw-bold text-center mt-5 mt-sm-4">ACCOUNT LOGIN</h2>
            <p class="text-center">SIGN IN TO YOUR ACCOUNT</p>

            <div id="error-msg" class="alert alert-danger d-none"></div>

            <label for="email" class="form-label mt-2">Email</label>
            <div class="input-group">
                <input type="email" id="email" class="form-control" maxlength="100" placeholder="juanadelacruz@gmail.com" required>
            </div>

            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input type="password" id="password" class="form-control" maxlength="100" placeholder="********" required>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger"><?= urldecode($_GET['error']) ?></div>
            <?php endif; ?>

            <div class="mb-5 text-end">
                <a href="forgot-password.php" class="forgot-password">Forgot Password?</a>
            </div>

            <div class="d-grid mb-3 login-button-container">
                <button type="submit" class="login-btn">Login</button>
            </div>

            <div class="text-center mb-4">
                <p>Don't have an account? <a href="signup.php" class="signup-option">Sign Up Now</a></p>
            </div>
            </div>
        </form>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX Script for handling login -->
    <script>
        $(document).ready(function() {
            // Remove error message and red borders when user starts typing in email or password
            $("#email, #password").on('input', function() {
                $("#error-msg").addClass('d-none'); // Hide the error message
                $("#email, #password").removeClass('is-invalid'); // Remove red border
            });

            $("#loginForm").submit(function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Clear any previous error styles
                $("#email, #password").removeClass('is-invalid');
                $("#error-msg").addClass('d-none'); // Hide error message initially

                // Get form data
                var email = $("#email").val();
                var password = $("#password").val();

                $.ajax({
                    type: "POST",
                    url: "includes/login-process.php", // The PHP file that handles the login
                    data: {
                        email: email,
                        password: password
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            // Redirect based on the user's role
                            if (response.role === 'user') {
                                window.location.href = "home.php";
                            } else if (response.role === 'admin' || response.role === 'head_admin') {
                                window.location.href = "dashboard.php";
                            }
                        } else {
                            // Display the error message
                            $("#error-msg").removeClass('d-none').text(response.error);

                            // Add red border to input fields with errors
                            if (response.error.includes('password')) {
                                $("#password").addClass('is-invalid');
                            } else {
                                $("#email").addClass('is-invalid');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle unexpected errors
                        $("#error-msg").removeClass('d-none').text("An error occurred. Please try again.");
                        console.error("Error details:", status, error);
                    }
                });
            });
        });
    </script>

</body>

</html>
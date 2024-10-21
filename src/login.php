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
    <!--links-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/sidebar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Google Fonts Links For Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
     <!-- Include jQuery -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="login-container">

        <div class="image-section">
            <div class="row">
                <div class="col-sm-12 d-flex justify-content-center">
                    <div class="logo d-flex justify-content-center">
                        <img src="styles/assets/secaspi-logo.png" alt="Logo">
                    </div>
                    <div class="row">
                        <h3><strong>iAdopt-SECASPI</strong></h3>
                    </div>
                    <div class="row">
                        <h4>SECOND CHANCE ASPIN SHELTER <br> PHILIPPINES INCORPORATED</h>
                    </div>
                </div>
            </div>
            <img src="styles/assets/loginbg.png" alt="Background Image">
        </div>
        <div class="login-form-section col-sm-12 col-lg-6 col-6">
        <form id="loginForm">
                <h2><strong>ACCOUNT LOGIN</strong></h2>
                <p>SIGN IN TO YOUR ACCOUNT</p>
                <div class="input-group col-sm-12 col-lg-6 col-6">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="juanadelacruz@gmail.com" required>
                </div>
                <div class="input-group col-sm-12 col-lg-6 col-6">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="********" required>
                </div>
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?= urldecode($_GET['error']) ?></div>
                <?php endif; ?>
                <div class="options col-sm-12 col-lg-6 col-6">
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>
                <div class="login-button-container col-12 d-flex justify-content-center">
                    <button type="submit" class="login-btn">Login</button>
                </div>

                <div class="signup-option">
                    <p>Don't have an account? <a href="signup.php">Sign Up Now</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- AJAX Script for handling login -->
        <script>
            $(document).ready(function() {
                $("#loginForm").submit(function(e) {
                    e.preventDefault(); // Prevent the default form submission

                    // Get form data
                    var email = $("#email").val();
                    var password = $("#password").val();

                    // Debugging: log email and password
                    console.log("Email:", email);
                    console.log("Password:", password);

                    $.ajax({
                        type: "POST",
                        url: "includes/login-process.php", // The PHP file that handles the login
                        data: { 
                            email: email, 
                            password: password 
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log("Response from server:", response); // Log the server response
                            if (response.success) {
                                // Redirect based on the user's role
                                if (response.role === 'user') {
                                    window.location.href = "home.php";
                                } else if (response.role === 'admin' || response.role === 'head admin') {
                                    window.location.href = "dashboard.php";
                                }
                            } else {
                                // Show the error message if login fails
                                $("#error-msg").removeClass('d-none').text(response.error);
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
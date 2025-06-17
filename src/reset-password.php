<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles/topnavbar.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .input-error { border: 2px solid red; }
        .error-message {
            color: red;
            font-size: 0.9em;
            display: none;
            margin-top: 5px;
        }
        .is-invalid + .error-message {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container mt-5 col-5">
        <h2 class="text-center">Reset Password</h2>
        <form id="reset-password-form" action="includes/reset-password-handler.php" method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
            <div class="mb-3  mt-5">
                <label for="password" class="form-label">New Password</label>
                <input type="password" id="password" name="password" class="form-control" 
                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" 
                    maxlength="80" required 
                    title="Password must be at least 8 characters, include an uppercase, a lowercase, a number, and a special character.">
                <div id="password-error" class="error-message">Password must meet the strength requirements.</div>
            </div>
            <div class="mb-4 mt-4">
                <label for="confirm-password" class="form-label">Confirm New Password</label>
                <input type="password" id="confirm-password" name="confirm_password" class="form-control" maxlength="80" required>
                <div id="confirm-password-error" class="error-message">Passwords do not match.</div>
            </div>
            <p id="password-hint" class="text-muted small mb-4">Password must be at least 8 characters long, contain an uppercase letter, lowercase letter, a number, and a special character.</p>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
    </div>

    <!-- Success Modal Structure with Timer -->
    <div class="modal fade" id="successModal2" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="text-center">
              <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
              <p class="mt-3">Password changed successfully!</p>
              <p id="logoutTimer">You will be logged out in <span id="timer">5</span> seconds...</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    const resetPasswordForm = document.getElementById("reset-password-form");
    const passwordField = document.getElementById("password");
    const confirmPasswordField = document.getElementById("confirm-password");
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    const timerElement = document.getElementById("timer");

    const successModal = new bootstrap.Modal(document.getElementById('successModal2'));

    resetPasswordForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent form submission initially

        let validationFailed = false;

        // Clear previous error messages
        clearErrors();

        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;

        // Check if password meets the strong password requirement
        if (!passwordRegex.test(password)) {
            showError(passwordField, "Password does not meet the requirements.");
            validationFailed = true;
        }

        // Check if passwords match
        if (password !== confirmPassword) {
            showError(confirmPasswordField, "Passwords do not match.");
            validationFailed = true;
        }

        if (!validationFailed) {
            // Proceed with form submission using AJAX
            $.ajax({
                url: 'includes/reset-password-handler.php',  // Directly link to the handler
                type: 'POST',
                data: $(resetPasswordForm).serialize(),
                success: function (response) {
                    var jsonResponse = JSON.parse(response); // Parse the JSON response
                    // Ensure that the response contains a 'success' message
                    if (jsonResponse.success) {
                        successModal.show(); // Show success modal
                        startTimer(); // Start the countdown timer
                    } else {
                        alert("There was an error resetting your password. Please try again." + jsonResponse.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);  // Log the error details in console
                    alert("An error occurred. Please try again.");
                    
                }
            });
        }
    });

    // Add input event listeners for immediate validation
    passwordField.addEventListener("input", function () {
        if (!passwordRegex.test(passwordField.value)) {
            showError(passwordField, "Password does not meet the requirements.");
        } else {
            clearError(passwordField);
        }
    });

    confirmPasswordField.addEventListener("input", function () {
        if (passwordField.value !== confirmPasswordField.value) {
            showError(confirmPasswordField, "Passwords do not match.");
        } else {
            clearError(confirmPasswordField);
        }
    });

    function showError(inputElement, errorMessage) {
        inputElement.classList.add("is-invalid");
        const errorDiv = inputElement.parentNode.querySelector(".error-message");
        if (errorDiv) {
            errorDiv.textContent = errorMessage;
            errorDiv.style.display = "block"; // Show error message
        }
    }

    function clearError(inputElement) {
        inputElement.classList.remove("is-invalid");
        const errorDiv = inputElement.parentNode.querySelector(".error-message");
        if (errorDiv) {
            errorDiv.style.display = "none"; // Hide error message
        }
    }

    function clearErrors() {
        const errorMessages = document.querySelectorAll(".error-message");
        errorMessages.forEach(error => error.style.display = "none");
        const invalidInputs = document.querySelectorAll(".is-invalid");
        invalidInputs.forEach(input => input.classList.remove("is-invalid"));
    }

    function startTimer() {
        let countdown = 5; // Timer starting value
        timerElement.textContent = countdown;

        const interval = setInterval(() => {
            countdown--;
            timerElement.textContent = countdown;
            if (countdown === 0) {
                clearInterval(interval);
                window.location.href = 'logout.php'; // Redirect or log out after timer
            }
        }, 1000);
    }
});
</script>


</body>
</html>

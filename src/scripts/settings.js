$(document).ready(function() {
    // Initially make the input fields read-only
    $("input:not(#new-password):not(#confirm-password)").prop("readonly", true);

    // Toggle between Edit and Save on button click
    $("#edit-button").click(function() {
        // Check if the button is in Edit Mode (it is by default)
        if ($(this).text().includes("Edit")) {
            // Enable input fields for editing
            $("input:not(#new-password):not(#confirm-password)").prop("readonly", false);

            // Change button text to Save
            $(this).html('<i class="fas fa-save"></i> Save Changes');
        } else {
            // Collect updated data from the form
            var updatedData = {
                first_name: $("input[placeholder='First Name']").val(),
                last_name: $("input[placeholder='Last Name']").val(),
                middle_initial: $("input[placeholder='Middle Initial']").val(),
                birthdate: $("input[type='date']").val(),
                address: $("input[placeholder='enter address line 1']").val(),
                fb_link: $("input[placeholder='']").val(),
                contact_num: $("input[placeholder='enter phone number']").val(),
                email: $("input[placeholder='enter email id']").val()
            };

            // Send data to the server via AJAX
            $.ajax({
                url: 'includes/update-profile.php',
                type: 'POST',
                data: updatedData,
                success: function(response) {
                    // After saving, switch the fields back to read-only
                    $("input:not(#new-password):not(#confirm-password)").prop("readonly", true);

                    // Change button back to Edit mode
                    $("#edit-button").html('<i class="fas fa-edit"></i> Edit Information');

                    // Dynamically update the name display after the changes
                    $(".font-weight-bold").text('Hi, ' + updatedData.first_name + ' ' + updatedData.last_name + '!');

                    // Show success modal instead of alert
                    $('#successModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('An error occurred: ' + error);
                }
            });
        }
    });

    // ===================================== Change Password ===================================== //

    // Show the change password modal when the button is clicked
    $('#change-password-button').click(function() {
        $('#changePasswordModal').modal('show');
        $('#changePasswordModal').attr('aria-hidden', 'false');
    });

    // Function to validate password strength
    function isStrongPassword(password) {
        const strongPasswordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
        return strongPasswordRegex.test(password);
    }

    // Check password strength on input
    $('#new-password').on('input', function() {
        const password = $(this).val();
        if (isStrongPassword(password)) {
            $('#password-help').text('Strong password!').css('color', 'green');
        } else {
            $('#password-help').text('Must be at least 8 characters, include uppercase, number, and special character.').css('color', 'red');
        }
    });

    // Save button click handler for the Change Password modal
    $('#save-password-button').click(function() {
        const newPassword = $('#new-password').val();
        const confirmPassword = $('#confirm-password').val();

        // Check if the passwords match
        if (newPassword !== confirmPassword) {
            alert('Passwords do not match!');
            return;
        }

        // Check password strength
        if (!isStrongPassword(newPassword)) {
            alert('Please enter a strong password.');
            return;
        }

        // AJAX call to update password
        $.ajax({
            url: 'includes/update-password.php',  // Path to PHP file that handles the password change
            type: 'POST',
            data: { new_password: newPassword },
            success: function(response) {
                // Show success modal instead of alert
                $('#successModal').modal('show');
                $('#changePasswordModal').modal('hide');  // Close the modal
            },
            error: function(xhr, status, error) {
                console.error('An error occurred: ' + error);
            }
        });
    });

    // Reset aria-hidden when the modal is hidden
    $('#changePasswordModal').on('hidden.bs.modal', function () {
        $(this).attr('aria-hidden', 'true');
    });
});

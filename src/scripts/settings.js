$(document).ready(function() {
// Initially make the input fields read-only
$("input:not(#new-password):not(#confirm-password):not(#current-password)").prop("readonly", true);

// Store original values of the input fields for comparison
$("input:not(#new-password):not(#confirm-password)").each(function () {
  $(this).data("original", $(this).val().trim());
});

// Edit button click functionality
$("#edit-button").click(function () {
  // Enable input fields for editing
  $("input:not(#new-password):not(#confirm-password):not(#current-password)").prop("readonly", false);

  // Switch buttons: hide Edit button, show Save Changes button
  $(this).addClass("d-none");
  $("#save-button").removeClass("d-none");

  // Display a toaster message
  showToast("You are now editing your profile.");
});

// Success Modal Timer and Logout
function startLogoutTimer() {
  let countdown = 5; // Starting countdown value
  const timerElement = $('#logoutTimer'); // Select the timer element in the modal

  const timer = setInterval(() => {
    timerElement.text(`You will be logged out in ${countdown} seconds...`); // Update text
    countdown--;

    if (countdown < 0) { // When the countdown reaches 0
      clearInterval(timer); // Stop the timer
      window.location.href = "logout.php"; // Redirect to the logout page
    }
  }, 1000); // Update every second
}

// Save button functionality
$("#save-button").click(function () {
  let fieldsEdited = false;
  let emailChanged = false;

  // Check if any input value has changed
  $("input:not(#new-password):not(#confirm-password)").each(function () {
    const originalValue = $(this).data("original") || "";
    const currentValue = $(this).val().trim();
    if (originalValue !== currentValue) {
      fieldsEdited = true; // Mark that at least one field was edited
      $(this).data("original", currentValue); // Update the stored original value
      if ($(this).attr("name") === "email") {
        emailChanged = true; // Specifically track if the email was changed
      }
    }
  });

  if (fieldsEdited) {
    // Gather updated data
    const updatedData = {
      first_name: $("input[name='first_name']").val(),
      last_name: $("input[name='last_name']").val(),
      middle_initial: $("input[name='middle_initial']").val(),
      birthdate: $("input[name='birthdate']").val(),
      contact_num: $("input[name='contact_num']").val(),
      fb_link: $("input[name='fb_link']").val(),
      email: $("input[name='email']").val()
    };

    // Submit the changes via AJAX
    $.ajax({
      url: 'includes/update-profile.php',
      type: 'POST',
      data: updatedData,
      success: function (response) {
        try {
          const result = JSON.parse(response);
          if (result.status === "success") {

            // Update the sidebar name dynamically
            const firstName = updatedData.first_name || '';
            const lastName = updatedData.last_name || '';
            const fullName = `${firstName} ${lastName}`.trim() || 'Guest';
            
            // Update the sidebar element
            $("#sidebar-fullname").text(fullName);
            
            // Make input fields readonly again
            $("input:not(#new-password):not(#confirm-password):not(#current-password)").prop("readonly", true);

            // Revert buttons: show Edit button, hide Save Changes button
            $("#save-button").addClass("d-none");
            $("#edit-button").removeClass("d-none");

            if (emailChanged) {
              // Show success modal with timer if the email was changed
              $('#successModal2').modal('show');
              startLogoutTimer();
            } else {
              // Show success modal without timer for other fields
              $('#successModal').modal('show');
            }
          } else {
            showToast(result.message || "An error occurred while updating the profile.");
          }
        } catch (error) {
          showToast("An error occurred while processing the response.");
        }
      },
      error: function () {
        showToast("An error occurred while updating the profile.");
      }
    });
  } else {
    // If no fields were edited, display a toaster message
    showToast("No changes were made.");

    // Revert buttons and make fields readonly
    $("input:not(#new-password):not(#confirm-password):not(#current-password)").prop("readonly", true);
    $("#save-button").addClass("d-none");
    $("#edit-button").removeClass("d-none");
  }
});

// Toast Notification Function
function showToast(message) {
  const toastHTML = `
    <div class="toast align-items-center text-bg-info border-0 position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">${message}</div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>`;
  
  const $toast = $(toastHTML);
  $('body').append($toast);
  const toastInstance = new bootstrap.Toast($toast[0]);
  toastInstance.show();

  $toast.on('hidden.bs.toast', function () {
    $(this).remove();
  });
}


    // ===================================== Change Password ===================================== //
    
    // Show the verify password modal
    $('#change-password-button').click(function () {
      $('#verifyPasswordModal').modal('show');
      $('#verifyPasswordModal').attr('aria-hidden', 'false');
    });

    // Verify password button click handler
    $('#verify-password-button').click(function () {
      const currentPassword = $('#current-password').val().trim();

      if (!currentPassword) {
          alert('Please enter your current password.');
          return;
      }

      //console.log('Sending current password:', currentPassword); // Debugging line

      // AJAX call to verify the current password
      $.ajax({
          url: 'includes/verify-password.php', // PHP file to verify password
          type: 'POST',
          data: { current_password: currentPassword },
          dataType: 'json',
          success: function (response) {
            console.log('Response:', response); // Debugging line

              if (response.success) {
                  // Password verified successfully
                  $('#verifyPasswordModal').modal('hide'); // Hide the verify modal
                  $('#changePasswordModal').modal('show'); // Show the change password modal
                  
                  // Store the current password in a variable to compare with the new one
                  $('#current-password').prop('disabled', true); // Disable current password field

                  // You could also save this password in a hidden field or a JavaScript variable.
                  // This ensures users do not input the current password as the new password.
                  $('#current-password').data('verified-password', currentPassword); 
              } else {
                  // Incorrect password
                   alert(response.message || 'Incorrect password. Please try again.');
              }
          },
          error: function (xhr, status, error) {
              console.error('An error occurred: ' + error);
              alert('An unexpected error occurred. Please try again later.');
          }
      });
    });

    // Validate password strength on input
    $('#new-password').on('input', function () {
      const password = $(this).val();
      if (isStrongPassword(password)) {
          $('#password-help').text('Strong password!').css('color', 'green');
      } else {
          $('#password-help').text('Must be at least 8 characters, include uppercase, number, and special character.').css('color', 'red');
      }
    });

    // Change Password Modal - Save Password
    $('#save-password-button').click(function () {
      const newPassword = $('#new-password').val();
      const confirmPassword = $('#confirm-password').val();

       // Get the current password stored after verification
      const currentPassword = $('#current-password').data('verified-password');

       // Check if the new password is the same as the current password
      if (newPassword === currentPassword) {
        alert('The new password cannot be the same as the current password!');
        return;
      }

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

      // AJAX call to update the password
      $.ajax({
          url: 'includes/update-password.php',
          type: 'POST',
          data: { new_password: newPassword },
          success: function (response) {
              // Show success modal instead of alert
              $('#successModal2').modal('show');
              startLogoutTimer();
              $('#changePasswordModal').modal('hide'); // Close the modal
          },
          error: function (xhr, status, error) {
              console.error('An error occurred: ' + error);
          }
      });
    });

    // Helper function to validate password strength
    function isStrongPassword(password) {
      const strongPasswordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
      return strongPasswordRegex.test(password);
    }

    // Reset aria-hidden when the modals are hidden
    $('#verifyPasswordModal, #changePasswordModal').on('hidden.bs.modal', function () {
      $(this).attr('aria-hidden', 'true');
    });

});


// ===================================== names validation ===================================== //
document.addEventListener('DOMContentLoaded', function () {
    // Validate Last Name
    const lastNameField = document.getElementById('last-name');
    if (lastNameField) {
        lastNameField.addEventListener('input', function (e) {
            validateField(e.target);
        });
    }

    // Validate First Name
    const firstNameField = document.getElementById('first-name');
    if (firstNameField) {
        firstNameField.addEventListener('input', function (e) {
            validateField(e.target);
        });
    }

    // Validate Middle Initial
    const middleInitialField = document.getElementById('middle-initial');
    if (middleInitialField) {
        middleInitialField.addEventListener('input', function (e) {
            validateField(e.target);
        });
    }
});

// Reusable function to validate input fields
function validateField(inputField) {
    const regex = /^[a-zA-Z\s'-]*$/; // Allow only letters, spaces, hyphens, and apostrophes

    // Check if input contains invalid characters or is only spaces
    if (!regex.test(inputField.value) || inputField.value.trim() === '') {
        // Remove invalid characters by keeping only valid ones
        inputField.value = inputField.value.replace(/[^a-zA-Z\s'-]/g, '').trim();

        // Add the invalid class and show the error
        inputField.classList.add('is-invalid');
        const error = inputField.nextElementSibling; // Assuming error is right after input
        if (error) {
            error.classList.remove('d-none');
        }

        // Hide error after 2 seconds
        setTimeout(() => {
            inputField.classList.remove('is-invalid');
            if (error) {
                error.classList.add('d-none');
            }
        }, 2000); // Hide error after 2 seconds
    } else {
        // If input is valid, remove the invalid class and hide the error
        inputField.classList.remove('is-invalid');
        const error = inputField.nextElementSibling;
        if (error) {
            error.classList.add('d-none');
        }
    }
}
    //============================ Birthdate only 18 y/o ===========================// 
    document.addEventListener('DOMContentLoaded', function () {
        // Birthdate validation: Ensure user is at least 18 years old
        const birthdateInput = document.getElementById('birthdate');
        
        if (birthdateInput) {
            // Get today's date and subtract 18 years
            const today = new Date();
            const minDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
            
            // Set the max attribute to allow only birthdates for users who are at least 18 years old
            birthdateInput.max = minDate.toISOString().split('T')[0]; // Format the date as YYYY-MM-DD
        } else {
            console.error("Birthdate input field not found.");
        }
    });

   //============================ Contact Number Validation =======================//
   document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('contact-number').addEventListener('input', function (e) {
        const contactNumberInput = e.target;
        const contactError = contactNumberInput.nextElementSibling; // Get the next sibling which is the invalid-feedback div
        const contactNumber = contactNumberInput.value;

        // Remove any non-numeric characters (allow only digits)
        contactNumberInput.value = contactNumber.replace(/\D/g, '');  // \D matches any non-digit character

        // Contact number regex: only allow exactly 11 digits
        const contactRegex = /^[0-9]{11}$/;

        // If contact number is invalid, display error and mark as invalid
        if (!contactRegex.test(contactNumberInput.value)) {
            contactNumberInput.classList.add('is-invalid');
            contactError.style.display = 'block';  // Show the invalid-feedback message
        } else {
            // If valid, hide error and mark as valid
            contactNumberInput.classList.remove('is-invalid');
            contactError.style.display = 'none';  // Hide the invalid-feedback message
        }
    });
});

  //============================ Email Validation =======================//
document.addEventListener('DOMContentLoaded', function () {
    const emailInput = document.getElementById('email');
    const emailError = emailInput.nextElementSibling; // Get the invalid-feedback div for email

    emailInput.addEventListener('input', function (e) {
        const emailValue = e.target.value;

        // Basic email regex for validation
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        // If email is invalid, display error and mark as invalid
        if (!emailRegex.test(emailValue)) {
            emailInput.classList.add('is-invalid');
            emailError.classList.remove('d-none'); // Show the error message
        } else {
            // If valid, hide the error and mark as valid
            emailInput.classList.remove('is-invalid');
            emailError.classList.add('d-none'); // Hide the error message
        }
    });
});



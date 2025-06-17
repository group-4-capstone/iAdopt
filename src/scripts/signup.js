// When the "Sign Up" button is clicked
$('#sign-up-btn').click(function(e) {
    e.preventDefault();  // Prevent form submission

    var form = $('#signup-form')[0];
    var email = $('#email').val();

    // Form validation
    if (form.checkValidity()) {
        if (email) {
            $.ajax({
                type: 'POST',
                url: 'includes/send-verification-code.php',
                data: { email: email },
                success: function(response) {
                    $('#verificationModal').modal('show');
                },
                error: function() {
                    alert('There was an issue sending the verification code.');
                }
            });
        } else {
            alert('Please enter a valid email.');
        }
    } else {
        form.reportValidity();  // Show HTML5 validation errors
    }
});

// When the "Verify" button is clicked (email verification code validation)
$('#verify-btn').click(function(e) {
    e.preventDefault();  // Prevent form submission
    var verificationCode = $('#verification-code').val();

    if (verificationCode.match(/^\d{6}$/)) {
        $.ajax({
            type: 'POST',
            url: 'includes/verify-code.php',
            data: { verification_code: verificationCode },
            success: function(response) {
                if (response === 'valid') {
                    // If the verification code is valid, submit the form via AJAX
                    var form = $('#signup-form')[0];  // Get the form element
                    var formData = new FormData(form);  // Gather all form data
                    $.ajax({
                        type: 'POST',
                        url: 'includes/signup-process.php',  // Target PHP script to process the signup
                        data: formData,
                        processData: false,  // Prevent jQuery from processing the data
                        contentType: false,  // Prevent jQuery from setting content-type header
                        success: function(response) {
                            // Trigger the success toast
                            var toast = new bootstrap.Toast($('#success-toast')[0]);
                            toast.show();  // Show the toast

                            // Optionally, you can hide the modal after successful signup
                            $('#verificationModal').modal('hide');

                            // After 5 seconds, redirect to the login page
                            setTimeout(function() {
                                window.location.href = "login.php";  // Redirect to the login page
                            }, 5000);  // 5000ms = 5 seconds delay before redirection
                        },
                        error: function() {
                            alert('There was an issue during the signup process.');
                        }
                    });
                } else {
                    $('#verification-code').addClass('is-invalid');
                    alert('Invalid verification code!');
                }
            }
        });
    } else {
        $('#verification-code').addClass('is-invalid');
    }
});

// Clear the invalid feedback for verification code input
$('#verification-code').on('input', function() {
    $(this).removeClass('is-invalid');
});

// Enable/Disable the "Verify" button based on verification code length
$('#verification-code').on('input', function() {
    var verificationCode = $(this).val();
    $('#verify-btn').prop('disabled', verificationCode.length !== 6);
});

//============================ Last Name, First Name, Middle Name Special Characters ==========================//
['last-name', 'first-name', 'mi'].forEach(function(id) {
    document.getElementById(id).addEventListener('input', function (e) {
        const regex = /^[a-zA-Z\s'-]*$/;
        const inputField = e.target;

        if (!regex.test(inputField.value) || inputField.value.trim() === '') {
            inputField.value = inputField.value.replace(/[^a-zA-Z\s'-]/g, '').trim();
            inputField.classList.add('is-invalid');
            const error = document.querySelector('.invalid-feedback');
            error.classList.remove('d-none');
            setTimeout(() => {
                inputField.classList.remove('is-invalid');
                error.classList.add('d-none');
            }, 2000);
        } else {
            inputField.classList.remove('is-invalid');
            const error = document.querySelector('.invalid-feedback');
            error.classList.add('d-none');
        }
    });
});

//============================ Birthdate (18 years old) Validation ==========================//
const birthdateInput = document.getElementById('birthdate');
const today = new Date();
const minDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
birthdateInput.max = minDate.toISOString().split('T')[0];

//============================ Contact Number Validation =======================//
document.getElementById('contact-number').addEventListener('input', function (e) {
    const contactNumberInput = e.target;
    const contactNumber = contactNumberInput.value.replace(/\D/g, '');  // Remove non-digit characters
    const contactError = contactNumberInput.nextElementSibling; // Error message div

    contactNumberInput.value = contactNumber;

    // Contact number regex: only allow exactly 11 digits
    const contactRegex = /^[0-9]{11}$/;

    if (!contactRegex.test(contactNumber)) {
        contactNumberInput.classList.add('is-invalid');
        contactError.style.display = 'block';  // Show error message
    } else {
        contactNumberInput.classList.remove('is-invalid');
        contactError.style.display = 'none';  // Hide error message
    }
});

//============================ Space Only / Validation =========================// 
document.querySelector('form').addEventListener('submit', function (e) {
    let valid = true;
    const inputs = document.querySelectorAll('input[required]');
    const facebookInput = document.getElementById('facebook-profile');
    const facebookPattern = /^https:\/\/facebook\.com\/.+$/;

    inputs.forEach(input => {
        const trimmedValue = input.value.trim();

        if (trimmedValue === "" || /^\s+$/.test(trimmedValue)) {
            valid = false;
            input.classList.add('is-invalid');
        } else {
            input.classList.remove('is-invalid');
        }

        input.value = trimmedValue;  // Trim spaces in the input field
    });

    if (!facebookPattern.test(facebookInput.value)) {
        valid = false;
        facebookInput.classList.add('is-invalid');
    } else {
        facebookInput.classList.remove('is-invalid');
    }

    if (!valid) {
        e.preventDefault();  // Prevent form submission if validation fails
    }
});

//============================ Password Validation =======================//
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('confirm-password');
const form = document.querySelector('form');

// Regular expression for a strong password
const strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

// Real-time validation for password strength
passwordInput.addEventListener('input', function () {
    const passwordError = passwordInput.nextElementSibling; // Invalid-feedback div
    if (!strongPasswordRegex.test(passwordInput.value)) {
        passwordInput.classList.add('is-invalid');
        passwordError.style.display = 'block';
    } else {
        passwordInput.classList.remove('is-invalid');
        passwordError.style.display = 'none';
    }
});

// Real-time validation for password confirmation
confirmPasswordInput.addEventListener('input', function () {
    const confirmPasswordError = confirmPasswordInput.nextElementSibling;
    if (passwordInput.value !== confirmPasswordInput.value) {
        confirmPasswordInput.classList.add('is-invalid');
        confirmPasswordError.style.display = 'block';
    } else {
        confirmPasswordInput.classList.remove('is-invalid');
        confirmPasswordError.style.display = 'none';
    }
});

// Form submit validation
form.addEventListener('submit', function (e) {
    let valid = true;

    // Check password strength
    if (!strongPasswordRegex.test(passwordInput.value)) {
        valid = false;
        passwordInput.classList.add('is-invalid');
    } else {
        passwordInput.classList.remove('is-invalid');
    }

    // Check if passwords match
    if (passwordInput.value !== confirmPasswordInput.value) {
        valid = false;
        confirmPasswordInput.classList.add('is-invalid');
    } else {
        confirmPasswordInput.classList.remove('is-invalid');
    }

    // Prevent form submission if validation fails
    if (!valid) {
        e.preventDefault();
    }
});

//============================ Terms & Conditions and Privacy Policy =======================//

document.addEventListener("DOMContentLoaded", () => {
    const termsModal = document.getElementById("termsModal");
    const privacyModal = document.getElementById("privacyModal");
    const openTermsBtn = document.getElementById("openTerms");
    const openPrivacyBtn = document.getElementById("openPrivacy");
    const closeTermsBtn = document.getElementById("closeTerms");
    const closePrivacyBtn = document.getElementById("closePrivacy");

    // Open Terms Modal
    openTermsBtn.addEventListener("click", (event) => {
        event.preventDefault();
        termsModal.style.display = "block";
        history.pushState({ modalOpen: "terms" }, null, "#terms");
    });

    // Open Privacy Modal
    openPrivacyBtn.addEventListener("click", (event) => {
        event.preventDefault();
        privacyModal.style.display = "block";
        history.pushState({ modalOpen: "privacy" }, null, "#privacy");
    });

    // Close Modals
    closeTermsBtn.addEventListener("click", () => {
        termsModal.style.display = "none";
        history.back();
    });

    closePrivacyBtn.addEventListener("click", () => {
        privacyModal.style.display = "none";
        history.back();
    });

    // Handle Back Navigation
    window.addEventListener("popstate", () => {
        termsModal.style.display = "none";
        privacyModal.style.display = "none";
    });
});

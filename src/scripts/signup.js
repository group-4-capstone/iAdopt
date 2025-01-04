//============================Last-Name Special Characters===========================// 
document.getElementById('last-name').addEventListener('input', function (e) {
    const regex = /^[a-zA-Z\s'-]*$/; // Allow only letters, spaces, hyphens, and apostrophes
    const inputField = e.target;

    // Check if input contains invalid characters or is only spaces
    if (!regex.test(inputField.value) || inputField.value.trim() === '') {
        // Remove invalid characters by keeping only valid ones
        inputField.value = inputField.value.replace(/[^a-zA-Z\s'-]/g, '').trim();

        // Add the invalid class and show the error
        inputField.classList.add('is-invalid');
        const error = document.querySelector('.invalid-feedback');
        error.classList.remove('d-none');

        // Hide error after 2 seconds
        setTimeout(() => {
            inputField.classList.remove('is-invalid');
            error.classList.add('d-none');
        }, 2000); // Hide error after 2 seconds
    } else {
        // If input is valid, remove the invalid class and hide the error
        inputField.classList.remove('is-invalid');
        const error = document.querySelector('.invalid-feedback');
        error.classList.add('d-none');
    }
});
//============================Last-Name Special Characters===========================// 
document.getElementById('first-name').addEventListener('input', function (e) {
    const regex = /^[a-zA-Z\s'-]*$/; // Allow only letters, spaces, hyphens, and apostrophes
    const inputField = e.target;

    // Check if input contains invalid characters or is only spaces
    if (!regex.test(inputField.value) || inputField.value.trim() === '') {
        // Remove invalid characters by keeping only valid ones
        inputField.value = inputField.value.replace(/[^a-zA-Z\s'-]/g, '').trim();

        // Add the invalid class and show the error
        inputField.classList.add('is-invalid');
        const error = document.querySelector('.invalid-feedback');
        error.classList.remove('d-none');

        // Hide error after 2 seconds
        setTimeout(() => {
            inputField.classList.remove('is-invalid');
            error.classList.add('d-none');
        }, 2000); // Hide error after 2 seconds
    } else {
        // If input is valid, remove the invalid class and hide the error
        inputField.classList.remove('is-invalid');
        const error = document.querySelector('.invalid-feedback');
        error.classList.add('d-none');
    }
});
//============================Middle-Name Special Characters===========================// 
document.getElementById('mi').addEventListener('input', function (e) {
    const regex = /^[a-zA-Z\s'-]*$/; // Allow only letters, spaces, hyphens, and apostrophes
    const inputField = e.target;

    // Check if input contains invalid characters or is only spaces
    if (!regex.test(inputField.value) || inputField.value.trim() === '') {
        // Remove invalid characters by keeping only valid ones
        inputField.value = inputField.value.replace(/[^a-zA-Z\s'-]/g, '').trim();

        // Add the invalid class and show the error
        inputField.classList.add('is-invalid');
        const error = document.querySelector('.invalid-feedback');
        error.classList.remove('d-none');

        // Hide error after 2 seconds
        setTimeout(() => {
            inputField.classList.remove('is-invalid');
            error.classList.add('d-none');
        }, 2000); // Hide error after 2 seconds
    } else {
        // If input is valid, remove the invalid class and hide the error
        inputField.classList.remove('is-invalid');
        const error = document.querySelector('.invalid-feedback');
        error.classList.add('d-none');
    }
});


    
    //============================ Birthdate only 18 y/o ===========================// 
    
        const birthdateInput = document.getElementById('birthdate');
        
        // Get today's date and subtract 18 years
        const today = new Date();
        const minDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
        
        // Set the max attribute to allow only birthdates for users who are at least 18 years old
        birthdateInput.max = minDate.toISOString().split('T')[0];



   //============================ Contact Number Validation =======================//
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


    //============================== Space Only / Validation =========================// 

    document.querySelector('form').addEventListener('submit', function (e) {
        let valid = true;
        const inputs = document.querySelectorAll('input[required]');
        const facebookInput = document.getElementById('facebook-profile');
        const facebookPattern = /^https:\/\/facebook\.com\/.+$/;

        inputs.forEach(input => {
            const trimmedValue = input.value.trim();
            
            // Check if input is empty or consists of spaces
            if (trimmedValue === "" || /^\s+$/.test(trimmedValue)) {
                valid = false;
                input.classList.add('is-invalid'); // Add red border for invalid inputs
            } else {
                input.classList.remove('is-invalid');
            }

            input.value = trimmedValue; // Trim spaces in the input field
        });

        // Additional validation for Facebook link pattern
        if (!facebookPattern.test(facebookInput.value)) {
            valid = false;
            facebookInput.classList.add('is-invalid');
        } else {
            facebookInput.classList.remove('is-invalid');
        }

        if (!valid) {
            e.preventDefault(); // Prevent form submission if any input is invalid
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
        passwordError.style.display = 'block'; // Show the invalid-feedback message
    } else {
        passwordInput.classList.remove('is-invalid');
        passwordError.style.display = 'none'; // Hide the invalid-feedback message
    }
});

// Real-time validation for password confirmation
confirmPasswordInput.addEventListener('input', function () {
    const confirmPasswordError = confirmPasswordInput.nextElementSibling; // Invalid-feedback div
    if (passwordInput.value !== confirmPasswordInput.value) {
        confirmPasswordInput.classList.add('is-invalid');
        confirmPasswordError.style.display = 'block'; // Show the invalid-feedback message
    } else {
        confirmPasswordInput.classList.remove('is-invalid');
        confirmPasswordError.style.display = 'none'; // Hide the invalid-feedback message
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

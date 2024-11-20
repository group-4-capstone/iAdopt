
    //============================ Birthdate only 18 y/o ===========================// 
    document.addEventListener('DOMContentLoaded', function () {
        const birthdateInput = document.getElementById('birthdate');
        
        // Get today's date and subtract 18 years
        const today = new Date();
        const minDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
        
        // Set the max attribute to allow only birthdates for users who are at least 18 years old
        birthdateInput.max = minDate.toISOString().split('T')[0];
    });


    //============================ Contact Number Validation =======================//
    document.getElementById('contact-number').addEventListener('input', function () {
        const contactNumberInput = document.getElementById('contact-number');
        const contactError = document.getElementById('contact-error');
        const contactNumber = contactNumberInput.value;
        const contactRegex = /^[0-9]{10,11}$/; // Only allow 10-11 digits

        // If contact number is invalid, display error and mark as invalid
        if (!contactRegex.test(contactNumber)) {
            contactError.style.display = 'block';
            contactNumberInput.classList.add('is-invalid');
        } else {
            // If valid, hide error and mark as valid
            contactError.style.display = 'none';
            contactNumberInput.classList.remove('is-invalid');
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


    //============= Address Submission ==================//

    document.querySelector('form').addEventListener('submit', function (e) {
        let valid = true;
    
        // Validate each address dropdown
        const region = document.getElementById('region');
        const province = document.getElementById('province');
        const city = document.getElementById('city');
        const barangay = document.getElementById('barangay');
    
        // Check if any dropdown is not selected
        if (region.value === "Choose Region" || province.value === "Choose Province" || city.value === "Choose City/Municipality" || barangay.value === "Choose Barangay") {
            valid = false;
            alert("Please fill out the complete address.");
        }
    
        // Prevent form submission if validation fails
        if (!valid) {
            e.preventDefault();
        }
    });
    
 //=============Password Validation ==================//
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm-password');
        const form = document.querySelector('form');
    
        // Regular expression for a strong password
        const strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    
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
    
        // Real-time validation for password strength
        passwordInput.addEventListener('input', function () {
            if (strongPasswordRegex.test(passwordInput.value)) {
                passwordInput.classList.remove('is-invalid');
            }
        });
    
        // Real-time validation for password confirmation
        confirmPasswordInput.addEventListener('input', function () {
            if (passwordInput.value === confirmPasswordInput.value) {
                confirmPasswordInput.classList.remove('is-invalid');
            }
        });
    });
    
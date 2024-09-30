
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
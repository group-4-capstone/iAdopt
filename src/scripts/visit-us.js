document.getElementById('submitVisitBtn').addEventListener('click', function(event) {
    event.preventDefault();

    clearErrorMessages();

    // Validate fields
    let isValid = true;

    const names = document.querySelector('input[name="names"]');
    const groupName = document.querySelector('input[name="group_name"]');
    const pax = document.querySelector('input[name="pax"]');
    const purpose = document.querySelector('input[name="purpose"]');
    const visitDate = document.getElementById('visit_date');
    const visitTime = document.getElementById('visit_time');

    // Validate each field and accumulate the validity status
    isValid &= validateField(names, "This field is required.");
    isValid &= validateField(groupName, "This field is required.");
    isValid &= validatePaxField(pax);
    isValid &= validateField(purpose, "This field is required.");
      // Validate each field and accumulate the validity status
      isValid &= validateField(names, "This field is required.");
      isValid &= validateField(groupName, "This field is required.");
      isValid &= validatePaxField(pax);
      isValid &= validateField(purpose, "This field is required.");
      isValid &= validateField(visitDate, "Please select a valid date.");
      isValid &= validateField(visitTime, "Please select a valid time.");
  

    // If the form is valid, submit via AJAX
    if (isValid) {
        var visitForm = document.getElementById('visitForm');
        var formData = $(visitForm).serialize();

        $.ajax({
            type: 'POST',
            url: 'includes/submit-visit.php',
            data: formData,
            success: function(response) {
                console.log("Form submitted successfully:", response);
                $('#successVisitModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error occurred:", xhr.responseText);
            }
        });
    }
});

function validateField(inputElement, message) {
    if (!inputElement.value.trim()) {
        showErrorMessage(inputElement, message);
        return false;
    }
    return true;
}

function validatePaxField(inputElement) {
    const value = inputElement.value.trim();
    const regex = /^(?!0)\d+$/; 
    if (!value) {
        showErrorMessage(inputElement, "This field is required.");
        return false;
    } else if (!regex.test(value)) {
        showErrorMessage(inputElement, "Please enter a valid positive number (greater than 0).");
        return false;
    }
    return true;
}

function showErrorMessage(inputElement, message) {
    clearSpecificErrorMessage(inputElement); 
    const errorMessage = document.createElement('div');
    errorMessage.className = 'error-message text-danger';
    errorMessage.innerText = message;
    inputElement.classList.add('is-invalid'); 
    inputElement.parentNode.appendChild(errorMessage);
}

function clearErrorMessages() {
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(msg => msg.remove());
    const invalidInputs = document.querySelectorAll('.is-invalid');
    invalidInputs.forEach(input => input.classList.remove('is-invalid'));
}

function clearSpecificErrorMessage(inputElement) {
    const errorMessage = inputElement.parentNode.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
    inputElement.classList.remove('is-invalid'); 
}

const paxInput = document.querySelector('input[name="pax"]');

paxInput.addEventListener('input', function() {
    clearSpecificErrorMessage(this); 
    const value = this.value;

    const regex = /^(?!0)\d*$/; 
    if (value && !regex.test(value)) {
        showErrorMessage(this, "Please enter a valid positive number (greater than 0).");
    }
});

paxInput.addEventListener('keypress', function(event) {
    if (event.key === '-') {
        event.preventDefault(); 
    }

    if (this.value === '' && event.key === '0') {
        event.preventDefault(); 
    }

    if (this.value.length >= 2) {
        event.preventDefault(); 
    }
});

// Apply the input behavior to both input and select elements
document.querySelectorAll('input, select').forEach(element => {
    element.addEventListener('input', function() {
        clearSpecificErrorMessage(this); 
    });

    element.addEventListener('change', function() {
        clearSpecificErrorMessage(this); 
    });

    element.addEventListener('keypress', function(event) {
        if (this.value === '' && event.key === ' ') {
            event.preventDefault();
        }

        // Restrict non-letter keys for name inputs (not applicable to select)
        if (this.tagName.toLowerCase() === 'input' && this !== paxInput && this.value.length === 0 && !/^[a-zA-Z]$/.test(event.key)) {
            event.preventDefault(); 
        }
    });
});

const namesInput = document.querySelector('input[name="names"]');

namesInput.addEventListener('keypress', function(event) {
    const regex = /^[a-zA-Z\s,-]*$/;
    if (!regex.test(event.key)) {
        event.preventDefault();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const visitDate = document.getElementById('visit_date');
    const visitTime = document.getElementById('visit_time');
    const hiddenVisitDateTime = document.getElementById('visitDateTime');

    // Get today's date and add 1 day (tomorrow)
    let tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);

    // Format the date as YYYY-MM-DD
    let tomorrowStr = tomorrow.toISOString().split('T')[0];

    // Set the min attribute to tomorrow's date
    visitDate.min = tomorrowStr;
  

    function updateVisitDateTime() {
      if (visitDate.value && visitTime.value) {
        let visitDateTime = `${visitDate.value} ${visitTime.value}`;
        hiddenVisitDateTime.value = visitDateTime;
        console.log('Concatenated visitDateTime:', visitDateTime); // For debugging
      }
    }

    // Update the hidden input whenever the date or time changes
    visitDate.addEventListener('change', updateVisitDateTime);
    visitTime.addEventListener('change', updateVisitDateTime);
  });

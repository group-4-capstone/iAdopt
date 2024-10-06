document.getElementById('placeUploads').addEventListener('change', function(event) {
    const files = event.target.files;
    const validExtensions = ['jpg', 'jpeg', 'png', 'mp4', 'mov'];
    let invalidFiles = [];

    for (let i = 0; i < files.length; i++) {
        const fileName = files[i].name;
        const fileExtension = fileName.split('.').pop().toLowerCase();

        if (!validExtensions.includes(fileExtension)) {
            invalidFiles.push(fileName);
        }
    }

    if (invalidFiles.length > 0) {
        $('#errorModal').modal('show');

        event.target.value = '';
    }
});


var textInputs = rescueForm.querySelectorAll('input[type="text"], input[name="rescue_description"]');
textInputs.forEach(function(input) {
    input.addEventListener('keypress', function(event) {
        if (input.value.length === 0 && event.key === ' ') {
            event.preventDefault();
        }
    });
});

document.getElementById('submitVisitBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission

    var rescueForm = document.getElementById('rescueForm');
    var formData = new FormData(rescueForm);
    
    // Clear previous error messages
    var errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(function(msg) {
        msg.remove();
    });

    // Validation flags
    var isValid = true;

    // Check required fields
    var fields = [
        { element: document.getElementById('animalType'), message: "This field is required." },
        { element: rescueForm.querySelector('input[name="specific"]'), message: "This field is required." },
        { element: rescueForm.querySelector('input[name="barangay"]'), message: "This field is required." },
        { element: rescueForm.querySelector('input[name="municipality"]'), message: "This field is required." },
        { element: rescueForm.querySelector('input[name="province"]'), message: "This field is required." },
        { element: rescueForm.querySelector('input[name="rescue_description"]'), message: "This field is required." },
        { element: document.getElementById('placeUploads'), message: "This field is required.", isFileInput: true }
    ];

    fields.forEach(function(field) {
        if (field.isFileInput) {
            if (field.element.files.length === 0) {
                isValid = false;
                showError(field.element, field.message);
            }
        } else {
            if (field.element.value.trim() === "") {
                isValid = false;
                showError(field.element, field.message);
            } else {
                // Remove error message if the field is valid
                field.element.classList.remove('is-invalid');
                removeError(field.element);
            }
        }
    });

    // Submit the form if all fields are valid
    if (isValid) {
        $.ajax({
            type: 'POST',
            url: 'includes/submit-rescue.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#successRescueModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
});

// Function to display error message
function showError(input, message) {
    var errorMessage = document.createElement('div');
    errorMessage.className = 'error-message text-danger'; 
    errorMessage.innerText = message;
    input.classList.add('is-invalid');
    input.parentNode.insertBefore(errorMessage, input.nextSibling); 

    // Add input event listener to remove the error message
    input.addEventListener('input', function() {
        if (input.value.trim() !== "") {
            input.classList.remove('is-invalid');
            removeError(input);
        }
    });
}

// Function to remove error message
function removeError(input) {
    var errorMessage = input.parentNode.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
}

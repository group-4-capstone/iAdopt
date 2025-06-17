// Clicking the placeholder triggers the file input
document.getElementById('uploadPlaceholder').addEventListener('click', function () {
    console.log("Upload placeholder clicked. Triggering file input.");
    document.getElementById('imageUpload').click();
});

// Handle file input change and update placeholder with image preview and file name
document.getElementById('imageUpload').addEventListener('change', function (event) {
    const files = event.target.files;
    const validExtensions = ['jpg', 'jpeg', 'png'];
    let invalidFiles = [];

    // Clear any previous error messages related to image upload
    console.log("Image upload input changed. Validating files...");
    removeError(event.target);

    // Reference to file name display element
    const fileNameDisplay = document.getElementById('fileNameDisplay');

    Array.from(files).forEach(file => {
        const fileName = file.name;
        const fileExtension = fileName.split('.').pop().toLowerCase();

        console.log(`Processing file: ${fileName}, extension: ${fileExtension}`);

        if (!validExtensions.includes(fileExtension) || !file.type.startsWith('image/')) {
            invalidFiles.push(fileName);
            console.warn(`Invalid file type: ${fileName}`);
        } else {
            const reader = new FileReader();
            reader.onload = function (e) {
                console.log(`File loaded successfully: ${fileName}`);
                const uploadPlaceholder = document.getElementById('uploadPlaceholder');
                uploadPlaceholder.style.backgroundImage = `url(${e.target.result})`;
                uploadPlaceholder.style.backgroundSize = 'cover';
                uploadPlaceholder.style.backgroundPosition = 'center';
                document.getElementById('placeholderText').style.display = 'none';
                document.getElementById('overlay').style.display = 'block';

                uploadPlaceholder.querySelector('i').style.display = 'none';

                // Display the file name
                fileNameDisplay.textContent = `Uploaded file: ${fileName}`;
                fileNameDisplay.style.display = 'block';

                // Remove the error message if a valid image is uploaded
                removeError(document.getElementById('imageUpload'));
            };
            reader.readAsDataURL(file);
        }
    });

    // Handle invalid files
    if (invalidFiles.length > 0) {
        console.warn(`Invalid files detected: ${invalidFiles.join(', ')}`);
        event.target.value = ''; // Clear the input
        showError(event.target, "Please upload a valid image (JPG, JPEG, or PNG).");

        // Clear the file name display if invalid files were uploaded
        fileNameDisplay.style.display = 'none';
    }
});

// Prevent leading space in text inputs
var textInputs = document.querySelectorAll('input[type="text"], textarea[name="description"]');
textInputs.forEach(input => {
    input.addEventListener('keypress', function (event) {
        if (input.value.length === 0 && event.key === ' ') {
            event.preventDefault(); // Prevent leading space
            console.log("Prevented leading space in text input.");
        }
    });
});

// Handle form submission
document.getElementById('addRecordBtn').addEventListener('click', function (event) {
    event.preventDefault(); // Prevent the default form submission

    console.log("Form submission triggered.");
    var addRecordForm = document.getElementById('addRecordForm');
    var formData = new FormData(addRecordForm);

    // Clear previous error messages
    clearErrorMessages();

    // Validation flags
    var isValid = validateForm();

    // Submit the form if all fields are valid
    if (isValid) {
        console.log("Form is valid. Submitting...");
        $.ajax({
            type: 'POST',
            url: 'includes/submit-record.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log("Form submitted successfully:", response);
                $('#successRecordModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error("Error submitting form:", xhr.responseText);
            }
        });
    } else {
        console.log("Form validation failed.");
    }
});

// Function to validate the form
function validateForm() {
    var isValid = true;

    console.log("Validating form fields...");
    // Check required fields
    var fields = [
        { element: document.getElementById('name'), message: "This field is required." },
        { element: document.getElementById('gender'), message: "This field is required." },
        { element: document.getElementById('type'), message: "This field is required." },
        { element: document.getElementById('rescuedBy'), message: "This field is required." },
        { element: document.getElementById('rescuedAt'), message: "This field is required." },
        { element: document.getElementById('remarks'), message: "This field is required." },
        { element: document.getElementById('imageUpload'), message: "This field is required.", isFileInput: true }
    ];

    fields.forEach(field => {
        if (field.isFileInput) {
            if (field.element.files.length === 0) {
                isValid = false;
                showError(field.element, field.message);
            } else {
                removeError(field.element);
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

    console.log("Form validation complete. Is valid:", isValid);
    return isValid;
}

// Function to display error message
function showError(input, message) {
    // Avoid adding duplicate error messages
    console.log("Displaying error for:", input.id);
    removeError(input);

    var errorMessage = document.createElement('div');
    errorMessage.className = 'error-message text-danger';
    errorMessage.innerText = message;

    if (input.id === 'imageUpload') {
        var uploadPlaceholder = document.getElementById('uploadPlaceholder');
        uploadPlaceholder.parentNode.insertBefore(errorMessage, uploadPlaceholder.nextSibling); // Insert after the upload placeholder
    } else {
        input.classList.add('is-invalid');
        input.parentNode.insertBefore(errorMessage, input.nextSibling);
    }

    // Add input event listener to remove the error message dynamically
    if (input.id !== 'imageUpload') {
        input.addEventListener('input', function () {
            if (input.value.trim() !== "") {
                input.classList.remove('is-invalid');
                removeError(input);
            }
        });
    }
}

// Function to remove error messages
function removeError(input) {
    var errorMessages = input.parentNode.querySelectorAll('.error-message');
    errorMessages.forEach(function (msg) {
        msg.remove();
    });
    console.log("Removed error messages for:", input.id);
}

// Clear all error messages on the form
function clearErrorMessages() {
    var errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(function (msg) {
        msg.remove();
    });
    console.log("Cleared all error messages.");
}

// Event listener for the image upload to remove error message dynamically
document.getElementById('imageUpload').addEventListener('change', function () {
    if (this.files.length > 0) {
        removeError(this);
    }
});

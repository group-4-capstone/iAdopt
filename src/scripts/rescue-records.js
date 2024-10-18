
// ===================================== Rescue Request Table ================================= //
// Function to handle table row clicks and open the modal with dynamic data
document.querySelectorAll('#newRescueTable tbody tr').forEach(function(row) {
    row.addEventListener('click', function() {
        // Get data from the clicked row
        const rescueDate = row.getAttribute('data-rescue-date');
        const characteristics = row.getAttribute('data-characteristics');  // Fetch characteristics from attribute
        const reporter = row.cells[1].textContent;  // Using the 2nd cell for reporter
        const address = row.cells[2].textContent;   // Using the 3rd cell for address
        const status = row.getAttribute('data-status');  // From the data-status attribute

        // Populate modal fields with the clicked row's data
        document.getElementById('rescueDate').value = rescueDate;
        document.getElementById('characteristics').value = characteristics;  // Populate characteristics
        document.getElementById('reporter').value = reporter;
        document.getElementById('address').value = address;
        // Optionally, populate status or other remarks field if needed
        // document.getElementById('remarks').value = status;

        // Open the modal
        new bootstrap.Modal(document.getElementById('rescueRequestModal')).show();
    });
});




// ===================================== Rescue Records Table ================================= //
document.addEventListener("DOMContentLoaded", function() {
    // Get all rows from the table
    const tableRows = document.querySelectorAll("#rescueTable tbody tr");

    // Add click event listener to each row
    tableRows.forEach(row => {
        row.addEventListener("click", function() {
            // Fetch data from row attributes
            const petName = this.dataset.petName;
            const rescuedBy = this.dataset.rescuedBy;
            const rescueDate = this.dataset.rescueDate;
            const type = this.dataset.type;
            const status = this.dataset.status;
            const gender = this.dataset.gender;
            const rescuedAt = this.dataset.rescuedAt; // New field
            const remarks = this.dataset.remarks; // Assuming remarks data is also available in the row attributes

            // Populate modal fields with row data
            document.getElementById('petName').value = petName;
            document.getElementById('rescuer').value = rescuedBy;
            document.getElementById('rescueDate').value = rescueDate;
            document.getElementById('type').value = type;
            document.getElementById('status').value = status;
            document.getElementById('gender').value = gender;
            document.getElementById('rescued-at').value = rescuedAt; // New field
            document.getElementById('remarks').value = remarks || ''; // Handle empty remarks

            // Initialize and show the modal
            const informationModal = new bootstrap.Modal(document.getElementById('informationModal'));
            informationModal.show();
        });
    });

    const updateButton = document.getElementById("updateButton");
    const inputs = document.querySelectorAll("#petName, #rescueDate, #rescuer, #type, #status, #gender, #rescued-at, #remarks");

    updateButton.addEventListener("click", function() {
        inputs.forEach(input => {
            input.removeAttribute("disabled");
        });
    });
});

// Clicking the placeholder triggers the file input
document.getElementById('uploadPlaceholder').addEventListener('click', function() {
    document.getElementById('imageUpload').click();
});

// Handle file input change and update placeholder with image preview
document.getElementById('imageUpload').addEventListener('change', function(event) {
    const files = event.target.files;
    const validExtensions = ['jpg', 'jpeg', 'png'];
    let invalidFiles = [];

    // Clear any previous error messages related to image upload
    removeError(event.target);

    Array.from(files).forEach(file => {
        const fileName = file.name;
        const fileExtension = fileName.split('.').pop().toLowerCase();

        if (!validExtensions.includes(fileExtension) || !file.type.startsWith('image/')) {
            invalidFiles.push(fileName);
        } else {
            const reader = new FileReader();
            reader.onload = function(e) {
                const uploadPlaceholder = document.getElementById('uploadPlaceholder');
                uploadPlaceholder.style.backgroundImage = `url(${e.target.result})`;
                uploadPlaceholder.style.backgroundSize = 'cover';
                uploadPlaceholder.style.backgroundPosition = 'center';
                document.getElementById('placeholderText').style.display = 'none';
                uploadPlaceholder.querySelector('i').style.display = 'none';
                
                // Remove the error message if a valid image is uploaded
                removeError(document.getElementById('imageUpload'));
            };
            reader.readAsDataURL(file);
        }
    });

    // Optionally handle invalid files
    if (invalidFiles.length > 0) {
        console.warn(`Invalid file type: ${invalidFiles.join(', ')}`);
        event.target.value = ''; // Clear the input
        showError(event.target, "Please upload a valid image (JPG, JPEG, or PNG).");
    }
});

// Prevent leading space in text inputs
var textInputs = document.querySelectorAll('input[type="text"], textarea[name="description"]');
textInputs.forEach(input => {
    input.addEventListener('keypress', function(event) {
        if (input.value.length === 0 && event.key === ' ') {
            event.preventDefault(); // Prevent leading space
        }
    });
});

// Handle form submission
document.getElementById('addRecordBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission

    var addRecordForm = document.getElementById('addRecordForm');
    var formData = new FormData(addRecordForm);

    // Clear previous error messages
    clearErrorMessages();

    // Validation flags
    var isValid = validateForm();

    // Submit the form if all fields are valid
    if (isValid) {
        $.ajax({
            type: 'POST',
            url: 'includes/submit-record.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#successRecordModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
});

// Function to validate the form
function validateForm() {
    var isValid = true;

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

    return isValid;
}

// Function to display error message
function showError(input, message) {
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

    // Add input event listener to remove the error message
    input.addEventListener('input', function() {
        if (input.value.trim() !== "") {
            input.classList.remove('is-invalid');
            removeError(input);
        }
    });
}

// Function to remove error messages
function removeError(input) {
    var errorMessages = input.parentNode.querySelectorAll('.error-message');
    errorMessages.forEach(function(msg) {
        msg.remove();
    });
}

// Clear all error messages on the form
function clearErrorMessages() {
    var errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(function(msg) {
        msg.remove();
    });
}


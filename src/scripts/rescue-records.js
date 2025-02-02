$('[id^="updateStatusForm_"]').submit(function (e) {
    e.preventDefault();
});

$('[id^="acceptButton_"]').click(function () {
    $('#confirmationText').text('Are you sure you want to accept this report?');
    $('#denyReasonContainer').hide();
    $('#confirmationModal').modal('show');
    $('#confirmActionButton').data('action', 'accept');
});

$('[id^="denyButton_"]').click(function () {
    $('#confirmationText').text('Are you sure you want to deny this report?');
    $('#denyReasonContainer').show();
    $('#confirmationModal').modal('show');
    $('#confirmActionButton').data('action', 'deny');
});

$('#denyReason').on('input', function () {
    $(this).css('border', '');
    $('#denyReasonError').remove();
});

$('#confirmActionButton').click(function () {
    var action = $(this).data('action');
    var formData = new FormData($('[id^="updateStatusForm_"]')[0]);
    formData.append('action', action);

    if (action === 'deny') {
        var $denyReasonInput = $('#denyReason');
        var reason = $denyReasonInput.val();

        $denyReasonInput.css('border', '');
        $('#denyReasonError').remove();

        if (!reason) {
            $denyReasonInput.css('border', '1px solid red');
            $denyReasonInput.after('<div id="denyReasonError" style="color: red; font-size: 0.9rem;">This is required.</div>');
            return; 
        } else {
            formData.append('deny_reason', reason);
        }
    }

    $('#confirmationModal').modal('hide'); 

    $.ajax({
        type: 'POST',
        url: 'includes/update-rescue-status.php',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (action === 'accept') {
                $('#successMessage').text('Report has been accepted!');
            } else if (action === 'deny') {
                $('#successMessage').text('Report has been denied!');
            }
            $('#successModal').modal('show');
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

// Rescue Reports Sort By Event Listener
document.querySelectorAll('.report-sort-option').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        const sortOrder = this.getAttribute('data-sort');
        load_data_report('', 1, sortOrder);
    });
});

// Rescue Records Sort By Event Listener
document.querySelectorAll('.record-sort-option').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        const sortOrder = this.getAttribute('data-sort');
        load_data('', 1, sortOrder);
    });
});

// ----------------------------- DISPLAY AND PAGINATION -------------------------- //
// ----------------------------- REPORTS TABLE ----------------------------------- //
load_data_report();

function load_data_report(query = '', page_number = 1, sort_order = 'desc') {
    var form_data = new FormData();
    form_data.append('query', query);
    form_data.append('page', page_number);
    form_data.append('sort_order', sort_order); // Add sort_order parameter

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'includes/fetch-reports.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function () {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);
            var html = '';
            var serial_no = 1;

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {
                    var type = response.data[count].type.toLowerCase().replace(/\b\w/g, function (char) {
                        return char.toUpperCase();
                    });

                    var rescue_id = response.data[count].rescue_id;
                    var location = response.data[count].location;
                    var first_name = response.data[count].first_name;
                    var last_name = response.data[count].last_name;

                    html += '<tr data-bs-toggle="modal" data-bs-target="#reportModal_' + rescue_id + '">';
                    html += '<td>' + rescue_id + '</td>';
                    html += '<td>' + response.data[count].report_date + '</td>';
                    html += '<td>' + type + '</td>';
                    html += '<td>' + location + '</td>';
                    html += '<td>' + first_name + " " + last_name + '</td>';
                    html += '</tr>';
                    serial_no++;
                }
            } else {
                html += '<tr><td colspan="5" class="text-center">No Data Found</td></tr>';
            }

            document.getElementById('report_data').innerHTML = html;
            document.getElementById('report_pagination_link').innerHTML = response.pagination;
        }
    };
}

document.querySelectorAll('[id^="copyLink_"]').forEach(function(copyLink) {
    copyLink.addEventListener('click', function (e) {
        e.preventDefault();
        
        // Get the rescue_id from the link's id
        const rescueId = this.id.split('_')[1];
        
        // Find the corresponding textarea by using the same rescue_id
        const message = document.getElementById('verificationMessage_' + rescueId);
        
        // Copy the message to clipboard
        message.classList.remove('d-none');  // Make it visible temporarily
        message.select();
        document.execCommand('copy');
        message.classList.add('d-none');  // Hide it again
        
        // Show Bootstrap toast
        const toastElement = document.getElementById('copyToast');
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    });
});

// ----------------------------- RESCUE TABLE ----------------------------------- //
load_data();


function load_data(query = '', page_number = 1, sort_order = 'desc') {
    var form_data = new FormData();
    form_data.append('query', query);
    form_data.append('page', page_number);
    form_data.append('sort_order', sort_order); 

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'includes/fetch-records.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function () {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);

            var html = '';
            var serial_no = 1;

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {
                    var name = response.data[count].name.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
                    var type = response.data[count].type.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
                    var rescued_by = response.data[count].rescued_by.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());

                    var status = response.data[count].animal_status.toLowerCase();
                    var statusDisplay = status.replace(/\b\w/g, char => char.toUpperCase());

                    if (statusDisplay === "Adoptable") {
                        statusDisplay = '<span class="badge bg-success text-light">Adoptable</span>';
                    } else if (statusDisplay === "On Process") {
                        statusDisplay = '<span class="badge bg-danger text-light">On Process</span>';
                    } else if (statusDisplay === "Unadoptable") {
                        statusDisplay = '<span class="badge bg-secondary text-light">Unadoptable</span>';
                    }

                    html += '<tr onclick="window.location.href=\'animal-record.php?animal_id=' + response.data[count].animal_id + '\'">';
                    html += '<td>' + response.data[count].rescue_id + '</td>';
                    html += '<td>' + response.data[count].report_date + '</td>';
                    html += '<td>' + (name ? name : '-') + '</td>';
                    html += '<td>' + type + '</td>';
                    html += '<td>' + (rescued_by ? rescued_by : '-') + '</td>';
                    html += '<td>' + statusDisplay + '</td>';
                    html += '</tr>';
                    serial_no++;
                }
            } else {
                html += '<tr><td colspan="6" class="text-center">No Data Found</td></tr>';
            }

            document.getElementById('post_data').innerHTML = html;
            document.getElementById('pagination_link').innerHTML = response.pagination;
        }
    }
}


// Clicking the placeholder triggers the file input
document.getElementById('uploadPlaceholder').addEventListener('click', function () {
    document.getElementById('imageUpload').click();
});

// Handle file input change and update placeholder with image preview and file name
document.getElementById('imageUpload').addEventListener('change', function (event) {
    const files = event.target.files;
    const validExtensions = ['jpg', 'jpeg', 'png'];
    let invalidFiles = [];

    // Clear any previous error messages related to image upload
    removeError(event.target);

    // Reference to file name display element
    const fileNameDisplay = document.getElementById('fileNameDisplay');

    Array.from(files).forEach(file => {
        const fileName = file.name;
        const fileExtension = fileName.split('.').pop().toLowerCase();

        if (!validExtensions.includes(fileExtension) || !file.type.startsWith('image/')) {
            invalidFiles.push(fileName);
        } else {
            const reader = new FileReader();
            reader.onload = function (e) {
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
        console.warn(`Invalid file type: ${invalidFiles.join(', ')}`);
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
        }
    });
});

// Handle form submission
document.getElementById('addRecordBtn').addEventListener('click', function (event) {
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
            success: function (response) {
                $('#successRecordModal').modal('show');
            },
            error: function (xhr, status, error) {
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

    return isValid;
}

// Function to display error message
function showError(input, message) {
    // Avoid adding duplicate error messages
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
}

// Clear all error messages on the form
function clearErrorMessages() {
    var errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(function (msg) {
        msg.remove();
    });
}

// Event listener for the image upload to remove error message dynamically
document.getElementById('imageUpload').addEventListener('change', function () {
    if (this.files.length > 0) {
        removeError(this);
    }
});



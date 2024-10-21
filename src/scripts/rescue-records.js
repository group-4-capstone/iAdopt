
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

// ----------------------------- DISPLAY AND PAGINATION -------------------------- //
// ----------------------------- REPORTS TABLE ----------------------------------- //
load_data_report();

function load_data_report(query = '', page_number = 1) {
    var form_data = new FormData();
    form_data.append('query', query);
    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'includes/fetch-reports.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);
            var html = '';
            var serial_no = 1;

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {
                    var type = response.data[count].type.toLowerCase().replace(/\b\w/g, function(char) {
                        return char.toUpperCase();
                    });

                    var statusDisplay = response.data[count].animal_status.toLowerCase().replace(/\b\w/g, function(char) {
                        return char.toUpperCase();
                    });

                    // Fix variables referencing correct response data
                    var rescue_id = response.data[count].rescue_id;
                    var location = response.data[count].location;
                    var first_name = response.data[count].first_name;
                    var last_name = response.data[count].last_name;
                    var animal_image = response.data[count].animal_image;
            
                    html += '<tr data-animal-image="' + animal_image + '">';
                    html += '<td>' + rescue_id + '</td>';
                    html += '<td>' + response.data[count].report_date + '</td>';
                    html += '<td>' + type + '</td>';
                    html += '<td>' + location + '</td>';
                    html += '<td>' + first_name + " " + last_name + '</td>';
                    html += '<td>' + statusDisplay + '</td>';
                    html += '</tr>';
                    serial_no++;
                }
            } else {
                // Update colspan to match the number of columns (6)
                html += '<tr><td colspan="6" class="text-center">No Data Found</td></tr>';
            }

            document.getElementById('report_data').innerHTML = html;
            document.getElementById('report_pagination_link').innerHTML = response.pagination;
        }
    };
}


// Assuming 'html' is appended to a table with id 'reportTable'
$('#reportTable').on('click', 'tr', function() {
    // Get the rescue_id from the clicked row
    var rescue_id = $(this).find('td').eq(0).text(); // Adjust index if necessary
    var report_date = $(this).find('td').eq(1).text();
    var type = $(this).find('td').eq(2).text();
    var location = $(this).find('td').eq(3).text();
    var rescuer = $(this).find('td').eq(4).text();
    var status = $(this).find('td').eq(5).text();
    
    // Get the animal image from the data attribute
    var animal_image = $(this).data('animal-image');

    // Prepend the path to the animal image
    var imagePath = 'styles/assets/rescue-reports/' + animal_image;

    // Populate the modal with the details
    $('#modalRescueId').text(rescue_id);
    $('#modalReportDate').text(report_date);
    $('#modalType').text(type);
    $('#modalLocation').text(location);
    $('#modalRescuer').text(rescuer);
    $('#modalStatus').text(status);
    $('#modalAnimalImage').attr('src', imagePath); // Set the image source with path

    // Show the modal
    $('#rescueDetailModal').modal('show');
});


// ----------------------------- RESCUE TABLE ----------------------------------- //
load_data();

function load_data(query = '', page_number = 1)
{
    var form_data = new FormData();

    form_data.append('query', query);

    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();

    ajax_request.open('POST', 'includes/fetch-records.php');

    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function()
    {
        if(ajax_request.readyState == 4 && ajax_request.status == 200)
        {
            var response = JSON.parse(ajax_request.responseText);

            var html = '';

            var serial_no = 1;

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {
                    // Capitalize the first letter of each word for name, type, and rescued_by
                    var name = response.data[count].name.toLowerCase().replace(/\b\w/g, function(char) {
                        return char.toUpperCase();
                    });
            
                    var type = response.data[count].type.toLowerCase().replace(/\b\w/g, function(char) {
                        return char.toUpperCase();
                    });
            
                    var rescued_by = response.data[count].rescued_by.toLowerCase().replace(/\b\w/g, function(char) {
                        return char.toUpperCase();
                    });
            
                    // Capitalize and conditionally apply the badge class for animal_status
                    var status = response.data[count].animal_status.toLowerCase();
                    var statusDisplay = status.replace(/\b\w/g, function(char) {
                        return char.toUpperCase();
                    });
            
                    if (statusDisplay === "Under Review") {
                        statusDisplay = '<span class="badge bg-red text-dark">Under Review</span>';
                    }
            
                    // Construct the HTML
                    html += '<tr onclick="window.location.href=\'animal-record.php?animal_id=' + response.data[count].animal_id + '\'">'; 
                    html += '<td>' + response.data[count].rescue_id + '</td>';
                    html += '<td>' + response.data[count].report_date + '</td>';
                    html += '<td>' + name + '</td>';    
                    html += '<td>' + type + '</td>';            
                    html += '<td>' + rescued_by + '</td>';      
                    html += '<td>' + statusDisplay + '</td>';  
                    html += '</tr>';
                    serial_no++;
                }
            }
            
            
            else
            {
                html += '<tr><td colspan="3" class="text-center">No Data Found</td></tr>';
            }

            document.getElementById('post_data').innerHTML = html;


            document.getElementById('pagination_link').innerHTML = response.pagination;

        }

    }
}


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


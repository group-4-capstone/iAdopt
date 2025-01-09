// ----------------------------- DISPLAY AND PAGINATION -------------------------- //
// ----------------------------- announcements TABLE ----------------------------------- //
load_data_announcements();

function load_data_announcements(query = '', page_number = 1) {
    var form_data = new FormData();
    form_data.append('query', query);
    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'includes/fetch-announcements.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function () {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);
            var html = '';
            var serial_no = 1;

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {

                    var announcement_id = response.data[count].announcement_id;
                    var image = response.data[count].image;
                    var title = response.data[count].title;
                    var description = response.data[count].description;
                    var announcement_status = response.data[count].announcement_status;
                    var first_name = response.data[count].first_name;
                    var last_name = response.data[count].last_name;
                    var announcement_date = response.data[count].announcement_date;

                    html += '<tr data-announcement-image="' + image + '">';
                    html += '<td>' + announcement_id + '</td>';
                    html += '<td><b>' + title + '</b></td>';
                    html += '<td>' + announcement_date + '</td>';
                    var badgeClass = '';
                    if (announcement_status === 'Draft') {
                        badgeClass = 'badge-draft'; // Gray color
                    } else if (announcement_status === 'Published') {
                        badgeClass = 'badge-published'; // Green color
                    } else if (announcement_status === 'Unpublished') {
                        badgeClass = 'badge-unpublished'; // Red color
                    } else if (announcement_status === 'Scheduled Post') {
                        badgeClass = 'badge-scheduled'; // Orange color
                    }

                    html += '<td><span class="custom-badge ' + badgeClass + '">' + announcement_status + '</span></td>';

                    html += '<td>' + first_name + ' ' + last_name + '</td>';
                    html += '<td class="text-center align-middle">';
                    html += '<button class="btn" data-bs-toggle="modal" data-bs-target="#announcementModal_' + announcement_id + '">...</button>';
                    html += '</td>';
                    html += '</tr>';
                    serial_no++;
                    html += '<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
                }
            } else {
                // Update colspan to match the number of columns (6)
                html += '<tr><td colspan="6" class="text-center">No Data Found</td></tr>';
            }

            document.getElementById('announcements_data').innerHTML = html;
            document.getElementById('announcements_pagination_link').innerHTML = response.pagination;
        }
    };
}

document.getElementById('imageUpload').addEventListener('change', function (event) {
    const files = event.target.files;
    const validExtensions = ['jpg', 'jpeg', 'png', 'webp'];
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

// --------------------------- ANNOUNCEMENT ------------------------------------------- //
// Quill initialization for announcement content
const quill = new Quill('#announcementContent', {
    theme: 'snow'
});

// Save button click event
document.getElementById('saveAnnouncementBtn').addEventListener('click', function (event) {
    event.preventDefault();

    clearErrorMessages();

    // Validate fields
    let isValid = true;

    const title = document.getElementById('announcementTitle');
    const status = document.getElementById('announcementStatus');
    const publishDate = document.getElementById('publishDate');
    const imageUpload = document.getElementById('imageUpload');

    // Get the Quill content
    const announcementContentHTML = quill.root.innerHTML;
    document.getElementById('announcementContentHidden').value = announcementContentHTML; // Store Quill content in hidden field

    // Validate the fields
    isValid &= validateField(title, "This field is required.");
    isValid &= validateField(status, "Please select a status.");

    // Only validate publishDate if it's enabled
    if (!publishDate.disabled) {
        isValid &= validateField(publishDate, "Please select a valid publish date.");
    }

    isValid &= validateContentField(announcementContentHTML, "Content is required."); // Validate Quill content
    isValid &= validateImageField(imageUpload, "Please upload an image.");

    // If the form is valid, submit via AJAX
    if (isValid) {
        var announcementForm = document.getElementById('announcementForm');
        var formData = new FormData(announcementForm); // Use FormData for file uploads

        $.ajax({
            type: 'POST',
            url: 'includes/submit-announcement.php',
            data: formData,
            processData: false, // Important for FormData
            contentType: false, // Important for FormData
            success: function (response) {
                console.log("Form submitted successfully:", response);
                $('#addAnnouncementModal').modal('hide');
                $('#successAnnouncementModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error("Error occurred:", xhr.responseText);
            }
        });
    }
});

// Validation Functions
function validateField(inputElement, message) {
    if (!inputElement.value.trim()) {
        showErrorMessage(inputElement, message);
        return false;
    }
    return true;
}

function validateContentField(contentHTML, message) {
    if (contentHTML.trim() === "" || contentHTML === "<p><br></p>") {
        showErrorMessage(document.getElementById('announcementContent'), message);
        return false;
    }
    return true;
}

function validateImageField(inputElement, message) {
    if (!inputElement.files.length) {
        showErrorMessage(inputElement, message);
        return false;
    }
    return true;
}

// Show Error Message Function
function showErrorMessage(inputElement, message) {
    clearSpecificErrorMessage(inputElement);

    const errorMessage = document.createElement('div');
    errorMessage.className = 'error-message text-danger';
    errorMessage.innerText = message;

    if (inputElement.id === 'announcementContent') {
        // For Quill, append the error message below the Quill editor
        inputElement.closest('.ql-container').appendChild(errorMessage);
        inputElement.classList.add('is-invalid');

    } else {
        // For regular inputs
        inputElement.classList.add('is-invalid');
        inputElement.parentNode.appendChild(errorMessage);
    }
}

// Clear Error Messages Function
function clearErrorMessages() {
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(msg => msg.remove());
    const invalidInputs = document.querySelectorAll('.is-invalid');
    invalidInputs.forEach(input => input.classList.remove('is-invalid'));
}

// Clear Specific Error Message Function
function clearSpecificErrorMessage(inputElement) {
    const errorMessage = inputElement.parentNode.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
    inputElement.classList.remove('is-invalid');
}

// Input event listeners to clear error messages on interaction
document.querySelectorAll('input, select, #announcementContent').forEach(element => {
    element.addEventListener('input', function () {
        clearSpecificErrorMessage(this);
    });

    element.addEventListener('change', function () {
        clearSpecificErrorMessage(this);
    });
});

// Ensure publish date is not set in the past
document.addEventListener('DOMContentLoaded', function () {
    const publishDate = document.getElementById('publishDate');

    let today = new Date();
    let todayStr = today.toISOString().split('T')[0];

    publishDate.min = todayStr;
});

const statusSelect = document.getElementById('announcementStatus');
const publishDateInput = document.getElementById('publishDate');

// Function to check the status and enable/disable publishDate
function checkStatus() {
    if (statusSelect.value === 'Draft' || statusSelect.value === 'Published') {
        publishDateInput.disabled = true; // Disable publishDate if status is draft
        publishDateInput.value = ''; // Optionally clear the date value
    } else {
        publishDateInput.disabled = false; // Enable publishDate if status is not draft
    }
}

// Check status on page load
checkStatus();

// Add change event listener to update publishDate based on selection
statusSelect.addEventListener('change', checkStatus);

function toggleEditAnnouncement(id) {
    const formId = `announcementForm_${id}`;
    const saveButtonId = `saveAnnouncementBtn_${id}`;
    const editButtonId = `editAnnouncementBtn_${id}`;

    // Enable inputs for editing
    const formElement = document.getElementById(formId);
    const titleInput = document.getElementById(`announcementTitle_${id}`);
    const statusSelect = document.getElementById(`announcementStatus_${id}`);
    const publishDateInput = document.getElementById(`publishDate_${id}`);
    const imageInput = document.getElementById(`annImageInput_${id}`);
    const quillContainerId = `announcementContent_${id}`;
    const hiddenContentInputId = `announcementContentHidden_${id}`;

    // Enable inputs by removing readonly/disabled attributes
    titleInput.removeAttribute('readonly');
    statusSelect.removeAttribute('disabled');
    publishDateInput.removeAttribute('readonly');
    imageInput.style.display = 'block'; // Assuming you're showing an image input for editing

    // Make Quill editor content editable
    const quillEditor = new Quill(`#${quillContainerId}`, {
        theme: 'snow'
    });

    // Show Save Changes button and hide Edit button
    document.getElementById(editButtonId).style.display = 'none';
    const saveButton = document.getElementById(saveButtonId);
    saveButton.style.display = 'inline-block';
    saveButton.disabled = false;

    // Check status on page load to disable/enable publishDate
    function checkStatus() {
        if (statusSelect.value === 'Draft' || statusSelect.value === 'Published') {
            publishDateInput.disabled = true; // Disable publishDate if status is draft
            publishDateInput.value = ''; // Optionally clear the date value
        } else {
            publishDateInput.disabled = false; // Enable publishDate if status is not draft
        }
    }

    // Check status on page load
    checkStatus();

    // Add change event listener to update publishDate based on selection
    statusSelect.addEventListener('change', checkStatus);

    // Save button click event with dynamic form ID
    saveButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Clear any existing error messages
        clearErrorMessages();

        // Validate fields
        let isValid = true;

        // Validate the fields
        isValid &= validateField(titleInput, "Title is required.");
        isValid &= validateField(statusSelect, "Please select a status.");

        if (!publishDateInput.disabled) {
            isValid &= validateField(publishDateInput, "Please select a valid publish date.");
        }

        const announcementContentHTML = quillEditor.root.innerHTML; // Get Quill content
        const contentHiddenInput = document.getElementById(hiddenContentInputId);
        contentHiddenInput.value = announcementContentHTML; // Store Quill content in hidden input

        isValid &= validateContentField(announcementContentHTML, "Content is required.");

        // If the form is valid, submit via AJAX
        if (isValid) {
            const formData = new FormData(formElement);

            $.ajax({
                type: 'POST',
                url: 'includes/edit-announcement.php', // Use edit-announcement.php for editing
                data: formData,
                processData: false, // Important for FormData
                contentType: false, // Important for FormData
                success: function(response) {
                    console.log("Form edited successfully:", response);
                    // Hide modal and show a success message
                    $(`#announcementModal_${id}`).modal('hide');
                    $('#successEditAnnouncementModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("Error occurred:", xhr.responseText);
                }
            });
        }
    });
}


// Helper functions for validation (assuming these exist in your code)
function validateField(field, errorMessage) {
    if (!field.value.trim()) {
        showErrorMessage(field, errorMessage);
        return false;
    }
    return true;
}

function validateContentField(content, errorMessage) {
    if (!content.trim()) {
        showErrorMessage(document.getElementById('announcementContent_' + id), errorMessage);
        return false;
    }
    return true;
}

function showErrorMessage(field, message) {
    // Assuming you have a way to display error messages next to the field
    const errorElement = field.nextElementSibling; // Assuming the next sibling is the error message container
    errorElement.textContent = message;
    errorElement.style.display = 'block';
}

function clearErrorMessages() {
    // Clear all error messages
    const errorMessages = document.querySelectorAll('.error-message'); // Assuming you have a class for error messages
    errorMessages.forEach(errorMessage => {
        errorMessage.textContent = '';
        errorMessage.style.display = 'none';
    });
}

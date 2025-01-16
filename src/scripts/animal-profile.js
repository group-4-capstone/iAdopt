let initialFormValues = {};

// Function to get all current values of the form, including button states
function getCurrentFormValues() {
    let values = {};

    // Get values for inputs, textareas, and selects
    document.querySelectorAll('#animalInfoForm input, #animalInfoForm textarea, #animalInfoForm select').forEach(input => {
        if (input.type === 'checkbox') {
            values[input.id] = input.checked; // Track checkbox state
        } else {
            values[input.name] = input.value;
        }
    });

    // Track the presence of 'btn-selected' class on buttons
    document.querySelectorAll('#animalInfoForm .btn-tags').forEach(button => {
        values[button.id] = button.classList.contains('btn-selected');
    });

    return values;
}

// Save initial form values when "Edit" button is clicked
document.getElementById('editBtn').addEventListener('click', function () {
    // Enable form inputs and buttons
    let inputs = document.querySelectorAll('#animalInfoForm input, #animalInfoForm textarea, #animalInfoForm select');
    inputs.forEach(input => {
        input.removeAttribute('readonly');
        input.removeAttribute('disabled');
    });

    let buttons = document.querySelectorAll('#animalInfoForm .btn-tags');
    buttons.forEach(button => {
        button.removeAttribute('disabled');
    });

    // Save the initial form values
    initialFormValues = getCurrentFormValues();

    // Show "Editing Mode" toast
    let toast = new bootstrap.Toast(document.getElementById('editToast'));
    toast.show();
    document.getElementById('editBtn').style.display = 'none';
    document.getElementById('backBtn').style.display = 'none';
    document.getElementById('qrBtn').style.display = 'none';
    // Show "Apply Changes" and "Cancel" buttons
    document.getElementById('applyBtn').style.display = 'block';
    document.getElementById('cancelBtn').style.display = 'block';
    document.getElementById('applyBtn').setAttribute('disabled', true);


    // Show file upload input and status
    document.getElementById('fileUploadContainer').style.display = 'block';
    document.getElementById('status_input').style.display = 'block';




});

// Function to check if any form value has changed
function hasFormChanged() {
    let currentValues = getCurrentFormValues();
    for (let key in currentValues) {
        if (currentValues[key] !== initialFormValues[key]) {
            return true;
        }
    }
    return false;
}

// Add event listeners to all form inputs to detect changes
document.querySelectorAll('#animalInfoForm input, #animalInfoForm textarea, #animalInfoForm select').forEach(input => {
    input.addEventListener('input', function () {
        if (hasFormChanged()) {
            document.getElementById('applyBtn').removeAttribute('disabled');
        } else {
            document.getElementById('applyBtn').setAttribute('disabled', true);
        }
    });
});

// Submit the form when "Apply Changes" button is clicked
document.getElementById('applyBtn').addEventListener('click', function () {
    var animalInfoForm = document.getElementById('animalInfoForm');
    var formData = new FormData(animalInfoForm); // Use FormData for file uploads

    $.ajax({
        type: 'POST',
        url: 'includes/edit-record.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log("Form submitted successfully:", response);

            let inputs = document.querySelectorAll('#animalInfoForm input, #animalInfoForm textarea, #animalInfoForm select');
            inputs.forEach(input => {
                input.setAttribute('readonly', true);
                input.setAttribute('disabled', true);
            });

            let buttons = document.querySelectorAll('#animalInfoForm .btn-tags');
            buttons.forEach(button => {
                button.setAttribute('disabled', true);
            });

            $('#successEditModal').modal('show');

            // Hide "Apply Changes" and "Cancel" buttons
            document.getElementById('applyBtn').style.display = 'none';
            document.getElementById('cancelBtn').style.display = 'none';
            document.getElementById('applyBtn').setAttribute('disabled', true);

            document.getElementById('fileUploadContainer').style.display = 'none';
            document.getElementById('status_input').style.display = 'none';

            // Show "Edit" and "Back" buttons again
            document.getElementById('editBtn').style.display = 'inline-block';
            document.getElementById('backBtn').style.display = 'inline-block';
            document.getElementById('qrBtn').style.display = 'inline-block';
        },
        error: function (xhr, status, error) {
            console.error("Error occurred:", xhr.responseText);
            // Show an error message toast
            let errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
            errorToast.show();
        }
    });
});

// Cancel button functionality
document.getElementById('cancelBtn').addEventListener('click', function () {
    // Reset form values to initial values
    for (let name in initialFormValues) {
        let element = document.querySelector(`#animalInfoForm [name="${name}"]`);
        if (element) {
            element.value = initialFormValues[name];
        }
    }

    let inputs = document.querySelectorAll('#animalInfoForm input, #animalInfoForm textarea, #animalInfoForm select');
    inputs.forEach(input => {
        input.setAttribute('readonly', true);
        input.setAttribute('disabled', true);
    });

    let buttons = document.querySelectorAll('#animalInfoForm .btn-tags');
    buttons.forEach(button => {
        button.setAttribute('disabled', true);
    });

    document.getElementById('fileUploadContainer').style.display = 'none';
    document.getElementById('status_input').style.display = 'none';
    document.getElementById('applyBtn').style.display = 'none';
    document.getElementById('cancelBtn').style.display = 'none';
    document.getElementById('editBtn').style.display = 'inline-block';
    document.getElementById('backBtn').style.display = 'inline-block';
    document.getElementById('qrBtn').style.display = 'inline-block';

    document.getElementById('applyBtn').setAttribute('disabled', true);
});

function toggleButton(button) {
    button.classList.toggle('btn-selected');
    let checkbox = document.getElementById(`checkbox${button.id.replace('tag', '')}`);
    checkbox.checked = button.classList.contains('btn-selected');

    document.getElementById('applyBtn').disabled = !hasFormChanged();
}

$('#qrBtn').on('click', function () {
    const animalId = $(this).data('animal-id');

    $.ajax({
        url: 'includes/generate-qr.php',
        type: 'POST',
        data: { animal_id: animalId },
        success: function (response) {
            $('#qrCodeContainer').html(response);
            $('#qrModal').modal('show');
        },
        error: function () {
            alert('Failed to generate QR code.');
        }
    });
});

// Function to download the QR code as PNG
function downloadQRCode() {
    const qrImage = document.getElementById('qrCodeImage');
    const qrSrc = qrImage.src;

    // Get the animal_id from the data attribute
    const animalId = qrImage.src.match(/animal_(\d+)\.png/)[1];

    // Create a temporary link element
    const downloadLink = document.createElement('a');
    downloadLink.href = qrSrc;
    downloadLink.download = `animal_id#${animalId}_qrcode.png`;
    downloadLink.click();
}

// Function to print the QR code
function printQRCode() {
    const printWindow = window.open('', '_blank');
    const qrImageSrc = document.getElementById('qrCodeImage').src;

    // Create a simple HTML for printing
    printWindow.document.write(`
        <html>
            <head>
                <title>Print QR Code</title>
                <style>
                    body {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                    }
                    img {
                        max-width: 100%;
                        max-height: 100%;
                    }
                </style>
            </head>
            <body>
                <img src="${qrImageSrc}" alt="QR Code">
            </body>
        </html>
    `);

    // Print and close
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.onafterprint = () => {
        printWindow.close();
    };
}

function toggleOtherInput() {
    var vaccineSelect = document.getElementById('vaccine_name');
    var otherVaccineInput = document.getElementById('other_vaccine_input');

    // If "Other" is selected, show the text input, else hide it
    if (vaccineSelect.value === 'Other') {
        otherVaccineInput.style.display = 'block';
    } else {
        otherVaccineInput.style.display = 'none';
    }
}

const fields = document.querySelectorAll('input, textarea');

fields.forEach(field => {
    field.addEventListener('keypress', function (event) {
        if (event.key === ' ' && field.selectionStart === 0) {
            event.preventDefault();
        }
    });
});

$('#submitVaccineBtn').click(function (event) {
    event.preventDefault();

    var form = $('#vaccineForm')[0];
    var formData = new FormData(form);

    $.ajax({
        url: 'includes/submit-vaccine.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#addVaccineModal').modal('hide');
                $('#successVaccineModal').modal('show');
            }
        },
        error: function () {
            alert('An unexpected error occurred.');
        }
    });
});

document.querySelectorAll('a[data-bs-toggle="modal"]').forEach(function (element) {
    element.addEventListener('click', function () {
        // Get vaccine details from the data attributes
        const vaccineName = this.getAttribute('data-vaccine-name');
        const vaccinationDate = this.getAttribute('data-vaccination-date');
        const nextDueDate = this.getAttribute('data-next-due-date');
        const vetName = this.getAttribute('data-vet-name');
        const vetContact = this.getAttribute('data-vet-contact');
        const remarks = this.getAttribute('data-remarks');

        // Set the values inside the modal
        document.getElementById('modalVaccineName').textContent = vaccineName;
        document.getElementById('modalVaccinationDate').textContent = vaccinationDate;
        document.getElementById('modalNextDueDate').textContent = nextDueDate;
        document.getElementById('modalVetName').textContent = vetName;
        document.getElementById('modalVetContact').textContent = vetContact;
        document.getElementById('modalRemarks').textContent = remarks;
    });
});

$('#submitHealthInfoBtn').click(function (event) {
    event.preventDefault();

    var form = $('#healthInfoForm')[0];
    var formData = new FormData(form);

    $.ajax({
        url: 'includes/submit-health-info.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#updateHealthInfoModal').modal('hide');
                $('#healthStatusMessage').text(response.message);
                $('#successHealthModal').modal('show');
            } else {
                alert(response.message || "Failed to update health information. Please try again.");
            }
        },
        error: function () {
            alert('An unexpected error occurred.');
        }
    });
});

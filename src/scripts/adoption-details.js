$(document).ready(function() {

       // Get the current date in YYYY-MM-DD format
       const today = new Date().toISOString().split('T')[0];
       // Set the minimum date attribute to today
       document.getElementById('interviewDate').setAttribute('min', today);
       
    // Schedule Interview Submission
    $('#submitInterviewBtn').click(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Get date and time values
        const date = $('#interviewDate').val();
        const time = $('#interviewTime').val();
        
        // Validate date and time are selected
        if (!date || !time) {
            alert('Please select both date and time.');
            return;
        }

        // Concatenate date and time in "YYYY-MM-DD HH:MM" format
        const schedInterview = `${date} ${time}`;
        $('#sched_interview').val(schedInterview); // Set the hidden input value

        // Create FormData object and append form data
        var form = $('#scheduleInterviewForm')[0]; // Get the form element
        var formData = new FormData(form);

        $.ajax({
            url: 'includes/update-adoption-status.php',
            type: 'POST',
            data: formData,
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting content type
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#scheduleInterviewModal').modal('hide');
                    $('#statusUpdateModal').modal('show');
                } else {
                    alert('Error updating application status');
                }
            },
            error: function() {
                alert('Failed to process request. Please try again.');
            }
        });
    });

    // Reject Reason Submission
    $('#submitRejectBtn').click(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Create FormData object and append form data
        var form = $('#rejectReasonForm')[0]; // Get the form element
        var formData = new FormData(form);

        $.ajax({
            url: 'includes/update-adoption-status.php',
            type: 'POST',
            data: formData,
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting content type
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#rejectReasonModal').modal('hide');
                    $('#statusUpdateModal').modal('show');
                } else {
                    alert('Error updating application status');
                }
            },
            error: function() {
                alert('Failed to process request. Please try again.');
            }
        });
    });
});

$(document).ready(function () {
    const $statusDropdown = $('#status');
    const $confirmationModal = $('#confirmationModal');
    const $newStatusSpan = $('#newStatus');
    const $confirmBtn = $('#confirmBtn');
    const animalId = $('#animalId').val();
    const applicationId = $('#applicationId').val();
    let selectedStatus = '';

    // Listen for changes in the dropdown
    $statusDropdown.on('change', function () {
        selectedStatus = $(this).val();
        $newStatusSpan.text(selectedStatus); // Update modal with selected status
        $confirmationModal.modal('show'); // Show modal
    });

    // Handle confirmation
    $confirmBtn.on('click', function () {
        $confirmationModal.modal('hide');

        // Send AJAX request to update status
        $.ajax({
            url: 'includes/update-animal-status.php',
            method: 'POST',
            data: {
                animal_id: animalId,
                application_id: applicationId,
                animal_status: selectedStatus
            },
            success: function (response) {
                if (response.success) {
                    $('#successModal').modal('show');
                } else {
                    alert('Error updating status: ' + response.error);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                alert('An unexpected error occurred.');
            }
        });
    });
});
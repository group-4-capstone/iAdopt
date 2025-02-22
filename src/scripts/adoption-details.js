       // Get the current date in YYYY-MM-DD format
       const today = new Date().toISOString().split('T')[0];
       // Set the minimum date attribute to today
       document.getElementById('interviewDate').setAttribute('min', today);
       
    // Schedule Interview Submission
    $('#submitInterviewBtn').click(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Get date and time values
        const date = $('#interviewDate');
        const time = $('#interviewTime');

        let isValid = true;

        // Validate date is selected
        if (!date.val()) {
            date.css('border', '1px solid red');
            if (!date.next('.error-text').length) {
                date.after('<span class="error-text" style="color:red;">This field is required.</span>');
            }
            isValid = false;
        } else {
            date.css('border', '');
            date.next('.error-text').remove();
        }

        // Validate time is selected
        if (!time.val()) {
            time.css('border', '1px solid red');
            if (!time.next('.error-text').length) {
                time.after('<span class="error-text" style="color:red;">This field is required.</span>');
            }
            isValid = false;
        } else {
            time.css('border', '');
            time.next('.error-text').remove();
        }

        if (!isValid) return;

        // Concatenate date and time in "YYYY-MM-DD HH:MM" format
        const schedInterview = `${date.val()} ${time.val()}`;
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

    // Remove error dynamically on input
    $('#interviewDate, #interviewTime').on('input', function() {
        $(this).css('border', '');
        $(this).next('.error-text').remove();
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


document.getElementById('confirmBtn').addEventListener('click', function () {
    const animalId = document.getElementById('animalId').value;
    const applicationId = document.getElementById('applicationId').value;
    const formData = new FormData();
    formData.append('animal_id', animalId);
    formData.append('application_id', applicationId);

    $.ajax({
        type: 'POST',
        url: 'includes/update-to-adopted.php',
        data: formData,
        processData: false, 
        contentType: false,
        success: function (response) {
            console.log("Form submitted successfully:", response);
            $('#confirmationModal').modal('hide');
            $('#successModal').modal('show');
        },
        error: function (xhr, status, error) {
            console.error("Error occurred:", xhr.responseText);
            alert('Failed to mark as adopted.');
        }
    });
});
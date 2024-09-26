
document.getElementById('submitVisitBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission
    var visitForm = document.getElementById('visitForm');
    var formData = $(visitForm).serialize();

    $.ajax({
        type: 'POST',
        url: 'includes/submit-visit.php',
        data: formData,
        success: function(response) {
            $('#successVisitModal').modal('show');
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error(xhr.responseText);
        }
    });
});


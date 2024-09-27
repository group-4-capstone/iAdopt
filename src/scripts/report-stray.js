document.getElementById('submitVisitBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission
    
    var rescueForm = document.getElementById('rescueForm');
    var formData = new FormData(rescueForm); 

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
            // Handle errors here
            console.error(xhr.responseText);
        }
    });
});

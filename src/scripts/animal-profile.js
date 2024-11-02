function downloadMergedImage() {
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');

    // Load background image
    const background = new Image();
    background.src = 'styles/assets/profile.png';  // Path to background image

    // Load profile image
    const profileImage = document.getElementById('profile-image');
    const profileSrc = profileImage.src;  // Get the source of the profile image

    // Ensure both images are loaded before drawing
    background.onload = function() {
        const foreground = new Image();
        foreground.src = profileSrc;

        foreground.onload = function() {
            // Set canvas dimensions to match the background image
            canvas.width = background.width;
            canvas.height = background.height;

            // Draw the background image on canvas at its original size
            ctx.drawImage(background, 0, 0);

            // Desired dimensions for the profile image
            const desiredWidth = 660;
            const desiredHeight = 760;

            // Get the original dimensions of the profile image
            const originalWidth = foreground.width;
            const originalHeight = foreground.height;

            // Calculate scaling factors
            const widthScale = desiredWidth / originalWidth;
            const heightScale = desiredHeight / originalHeight;

            // Determine the scale to cover the desired dimensions
            const scale = Math.max(widthScale, heightScale);

            // Calculate new dimensions after scaling
            const scaledWidth = originalWidth * scale;
            const scaledHeight = originalHeight * scale;

            // Calculate cropping offsets to center the image
            const xOffset = (canvas.width - desiredWidth) / 2;
            const yOffset = (canvas.height - desiredHeight) / 2;

            // Additional adjustments
            const leftAdjustment = 130;  // Move image to the left
            const downAdjustment = 60;  // Move image down

            // Calculate the rotation angle in radians
            const angle = -3 * (Math.PI / 180);

            // Save the current state of the canvas
            ctx.save();

            // Translate the canvas to the center of the image
            ctx.translate(canvas.width / 2, canvas.height / 2);

            // Rotate the canvas
            ctx.rotate(angle);

            // Translate back to the top-left corner
            ctx.translate(-canvas.width / 2, -canvas.height / 2);

            // Draw the profile image with cropping, rotation, and adjustments
            ctx.drawImage(
                foreground,
                (originalWidth - desiredWidth / scale) / 2,  // Crop horizontally
                (originalHeight - desiredHeight / scale) / 2,  // Crop vertically
                originalWidth - (originalWidth - desiredWidth / scale),  // Crop width
                originalHeight - (originalHeight - desiredHeight / scale),  // Crop height
                xOffset - leftAdjustment,  // Move image to the left
                yOffset + downAdjustment,  // Move image down
                desiredWidth,
                desiredHeight
            );

            // Restore the canvas state to remove the rotation
            ctx.restore();

            // Create a link element to download the combined image
            const link = document.createElement('a');
            link.download = 'animal-profile.png';
            link.href = canvas.toDataURL();
            link.click();
        };
    };
}

// Enable editing when "Edit" button is clicked
document.getElementById('editBtn').addEventListener('click', function() {
    // Enable all form inputs, textareas, and select elements
    let inputs = document.querySelectorAll('#animalInfoForm input, #animalInfoForm textarea, #animalInfoForm select');
    inputs.forEach(input => {
        input.removeAttribute('readonly');
        input.removeAttribute('disabled'); 
    });

    let buttons = document.querySelectorAll('#animalInfoForm .btn-tags');
    buttons.forEach(button => {
        button.removeAttribute('disabled');
    });

    // Show "Editing Mode" toast
    let toast = new bootstrap.Toast(document.getElementById('editToast'));
    toast.show();

    // Show the file upload input
    document.getElementById('fileUploadContainer').style.display = 'block';

    // Hide "Edit Information" and "Back to Records" buttons
    document.getElementById('editBtn').style.display = 'none';
    document.getElementById('backBtn').style.display = 'none';

    // Show "Apply Changes" and "Cancel" buttons
    document.getElementById('applyBtn').style.display = 'inline-block';
    document.getElementById('cancelBtn').style.display = 'inline-block';
});

// Submit the form when "Apply Changes" button is clicked
document.getElementById('applyBtn').addEventListener('click', function() {
    var animalInfoForm = document.getElementById('animalInfoForm');
    var formData = new FormData(animalInfoForm); // Use FormData for file uploads

    $.ajax({
        type: 'POST',
        url: 'includes/edit-record.php', 
        data: formData,
        processData: false, 
        contentType: false, 
        success: function(response) {
            console.log("Form submitted successfully:", response);

            let inputs = document.querySelectorAll('#animalInfoForm input, #animalInfoForm textarea');
            inputs.forEach(input => {
                input.setAttribute('readonly', true);
            });

            let buttons = document.querySelectorAll('#animalInfoForm .btn-tags');
            buttons.forEach(button => {
                button.setAttribute('disabled', true);
            });

            // Show "Edit" and "Back" buttons again
            document.getElementById('editBtn').style.display = 'inline-block';
            document.getElementById('backBtn').style.display = 'inline-block';

            // Hide "Apply Changes" and "Cancel" buttons
            document.getElementById('applyBtn').style.display = 'none';
            document.getElementById('cancelBtn').style.display = 'none';

            document.getElementById('fileUploadContainer').style.display = 'none';
            
            $('#successEditModal').modal('show');
         
        },
        error: function(xhr, status, error) {
            console.error("Error occurred:", xhr.responseText);
            // Optionally, show an error message or handle the error
            let errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
            errorToast.show();
        }
    });
});


document.getElementById('cancelBtn').addEventListener('click', function() {
  
    let inputs = document.querySelectorAll('#animalInfoForm input, #animalInfoForm textarea');
    inputs.forEach(input => {
        input.setAttribute('readonly', true);
        input.setAttribute('disabled', true);
    });

    let buttons = document.querySelectorAll('#animalInfoForm .btn-tags');
    buttons.forEach(button => {
        button.setAttribute('disabled', true);
    });

    document.getElementById('fileUploadContainer').style.display = 'none';
    document.getElementById('editBtn').style.display = 'inline-block';
    document.getElementById('backBtn').style.display = 'inline-block';
    document.getElementById('applyBtn').style.display = 'none';
    document.getElementById('cancelBtn').style.display = 'none';
});



function toggleButton(button) {
    button.classList.toggle('btn-selected');
    let checkbox = document.getElementById(`checkbox${button.id.replace('tag', '')}`);
    checkbox.checked = button.classList.contains('btn-selected');
}
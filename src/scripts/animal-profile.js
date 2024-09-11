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

document.querySelectorAll('.btn-tags').forEach(button => {
    button.addEventListener('click', () => {
        button.classList.toggle('btn-selected');
    });
});

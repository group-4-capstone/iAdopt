
//===================================================pagination=====================================//
document.addEventListener("DOMContentLoaded", function () {
    const paginationLinks = document.querySelectorAll(".pagination .page-link");
  
    paginationLinks.forEach(link => {
      link.addEventListener("click", function (event) {
        event.preventDefault();
        const page = this.getAttribute("data-page");
        loadPage(page);
      });
    });
  
    function loadPage(page) {
      const xhr = new XMLHttpRequest();
      xhr.open("GET", `animal-profiles.php?page=${page}`, true);
      xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
      xhr.onload = function () {
        if (xhr.status === 200) {
          document.getElementById("animal-cards").innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }
  });

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

    document.getElementById('qrBtn').style.display = 'none';

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
            document.getElementById('qrBtn').style.display = 'inline-block';

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

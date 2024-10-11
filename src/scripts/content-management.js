function openPage(pageName, elmnt, color) {
    // Hide all elements with class="tabcontent" by default */
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
  
    // Remove the background color of all tablinks/buttons
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].style.backgroundColor = "";
    }
  
    // Show the specific tab content
    document.getElementById(pageName).style.display = "block";
  
    // Add the specific color to the button used to open the tab content
    elmnt.style.backgroundColor = color;
  }
  
  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();

  document.getElementById('imageUpload').addEventListener('change', function(event) {
    const files = event.target.files;
    const validExtensions = ['jpg', 'jpeg', 'png'];
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
document.getElementById('saveAnnouncementBtn').addEventListener('click', function(event) {
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
          success: function(response) {
              console.log("Form submitted successfully:", response);
              $('#addAnnouncementModal').modal('hide');
              $('#successContentModal').modal('show');
          },
          error: function(xhr, status, error) {
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
  element.addEventListener('input', function() {
      clearSpecificErrorMessage(this); 
  });

  element.addEventListener('change', function() {
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

document.querySelectorAll('input').forEach(input => {
  input.addEventListener('keypress', function(event) {
      if (this.value.length === 0 && !/^[a-zA-Z]$/.test(event.key)) {
          event.preventDefault(); // Prevent numbers or spaces as the first character in non-amount fields
      }
  });
});

document.addEventListener('DOMContentLoaded', function() {
  const statusSelect = document.getElementById('announcementStatus');
  const publishDateInput = document.getElementById('publishDate');

  // Function to check the status and enable/disable publishDate
  function checkStatus() {
      if (statusSelect.value === 'draft') {
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
});

// --------------------------- ANNOUNCEMENT ------------------------------------------- //

// --------------------------- MERCHANDISE ------------------------------------------- //

  const quill1 = new Quill('#faqContent', {
    theme: 'snow'
  });
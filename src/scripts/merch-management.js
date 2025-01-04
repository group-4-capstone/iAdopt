// ----------------------------- MERCHANDISE TABLE ----------------------------------- //
load_data_merch();

function load_data_merch(query = '', page_number = 1) {
    var form_data = new FormData();
    form_data.append('query', query);
    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'includes/fetch-merchandise.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);
            var html = '';
            var serial_no = 1;

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {

                    var merch_id = response.data[count].merch_id;
                    var item = response.data[count].item;
                    var link = response.data[count].link;
                    var status = response.data[count].status;
                    var image = response.data[count].image;
                    var date = response.data[count].date;
            
                    html += '<tr data-merch-image="' + image + '">';
                    html += '<td>' + merch_id + '</td>';
                    html += '<td><b>' + item + '</b></td>';
                    html += '<td>' + date + '</td>';
                    var badgeClass = '';
                    if (status === 'Draft') {
                        badgeClass = 'badge-draft'; // Gray color
                    } else if (status === 'Published') {
                        badgeClass = 'badge-published'; // Green color
                    } else if (status === 'Unpublished') {
                        badgeClass = 'badge-unpublished'; // Red color
                    }

                    html += '<td><span class="custom-badge ' + badgeClass + '">' + status + '</span></td>';
                    html += '<td>' + link + '</td>';
                    html += '<td class="text-center align-middle">';
                    html += '<button class="btn" data-bs-toggle="modal" data-bs-target="#merchModal_' + merch_id + '">...</button>';
                    html += '</td>';
                    html += '</tr>';
                    serial_no++;
                    html += '<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
                }
            } else {
                // Update colspan to match the number of columns (6)
                html += '<tr><td colspan="6" class="text-center">No Data Found</td></tr>';
            }

            document.getElementById('merchandise_data').innerHTML = html;
            document.getElementById('merchandise_pagination_link').innerHTML = response.pagination;
        }
    };
}


document.getElementById('merchupload').addEventListener('change', function(event) {
    const files = event.target.files;
    const validExtensions = ['jpg', 'jpeg', 'png','webp'];
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

// --------------------------- MERCHANDISE ------------------------------------------- //

// Save button click event
document.getElementById('saveMerchandiseBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission
  
    clearErrorMessages(); // Clear any existing error messages
  
    // Validate fields
    let isValid = true;
  
    const merchandiseItem = document.getElementById('merchandiseItem');
    const itemLink = document.getElementById('itemLink');
    const imageUpload = document.getElementById('merchupload');
    const merchandiseStatus = document.getElementById('merchandiseStatus');
  
    // Validate the fields
    isValid &= validateField(merchandiseItem, "This field is required.");
    isValid &= validateField(itemLink, "This field is required.");
    isValid &= validateField(merchandiseStatus, "Please select a status.");
    isValid &= validateImageField(imageUpload, "Please upload an image.");
  
    // If the form is valid, submit via AJAX
    if (isValid) {
      var merchandiseForm = document.getElementById('merchandiseForm');
      var formData = new FormData(merchandiseForm); // Use FormData for file uploads
  
      $.ajax({
        type: 'POST',
        url: 'includes/submit-merch.php', // Replace with the actual PHP file handling the form
        data: formData,
        processData: false, // Important for FormData
        contentType: false, // Important for FormData
        success: function(response) {
          console.log("Form submitted successfully:", response);
          // You can hide the modal and show a success message here
          $('#addMerchandiseModal').modal('hide');
          $('#successMerchModal').modal('show');
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
  
    inputElement.classList.add('is-invalid'); 
    inputElement.parentNode.appendChild(errorMessage);
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
  document.querySelectorAll('input, select').forEach(element => {
    element.addEventListener('input', function() {
      clearSpecificErrorMessage(this);
    });
  
    element.addEventListener('change', function() {
      clearSpecificErrorMessage(this);
    });
  });

  // --------------------------- MERCHANDISE EDIT ------------------------------------------- //

// Edit button click event to enable form inputs
function toggleEditMode(merchId) {
  const form = document.getElementById(`merchForm_${merchId}`);
  const merchandiseItem = document.getElementById(`merchItem_${merchId}`);
  const itemLink = document.getElementById(`itemLink_${merchId}`);
  const imageUpload = document.getElementById(`newImageInput_${merchId}`);
  const merchandiseStatus = document.getElementById(`merchStatus_${merchId}`);
  const editButton = document.getElementById(`editMerchandiseBtn_${merchId}`);
  const saveButton = document.getElementById(`saveMerchandiseBtn_${merchId}`);

  // Enable fields for editing
  merchandiseItem.removeAttribute('readonly');
  itemLink.removeAttribute('readonly');
  imageUpload.style.display = 'block'; // Show image upload input
  merchandiseStatus.removeAttribute('disabled');

  // Toggle buttons
  editButton.style.display = 'none';
  saveButton.style.display = 'inline-block';
  saveButton.removeAttribute('disabled');
}

// Save button click event for AJAX submission
document.querySelectorAll('[id^="saveMerchandiseBtn_"]').forEach(button => {
  button.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const merchId = this.id.split('_')[1];
    const form = document.getElementById(`merchForm_${merchId}`);
    clearErrorMessages(); // Clear any existing error messages

    // Validate fields
    let isValid = true;

    const merchandiseItem = document.getElementById(`merchItem_${merchId}`);
    const itemLink = document.getElementById(`itemLink_${merchId}`);
    const imageUpload = document.getElementById(`newImageInput_${merchId}`);
    const merchandiseStatus = document.getElementById(`merchStatus_${merchId}`);

    // Validate the fields
    isValid &= validateField(merchandiseItem, "This field is required.");
    isValid &= validateField(itemLink, "This field is required.");
    isValid &= validateField(merchandiseStatus, "Please select a status.");


    // If the form is valid, submit via AJAX
    if (isValid) {
      const formData = new FormData(form); // Use FormData for file uploads

      $.ajax({
        type: 'POST',
        url: 'includes/edit-merchandise.php',
        data: formData,
        processData: false, // Important for FormData
        contentType: false, // Important for FormData
        success: function(response) {
          console.log("Form submitted successfully:", response);
          // Hide the modal and show a success message
          $(`#merchModal_${merchId}`).modal('hide');
          $('#successEditMerchModal').modal('show');
        },
        error: function(xhr, status, error) {
          console.error("Error occurred:", xhr.responseText);
        }
      });
    }
  });
});

// Validation Functions
function validateField(inputElement, message) {
  if (!inputElement.value.trim()) {
    showErrorMessage(inputElement, message);
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

  inputElement.classList.add('is-invalid');
  inputElement.parentNode.appendChild(errorMessage);
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
document.querySelectorAll('input, select').forEach(element => {
  element.addEventListener('input', function() {
    clearSpecificErrorMessage(this);
  });

  element.addEventListener('change', function() {
    clearSpecificErrorMessage(this);
  });
});

  
  
  
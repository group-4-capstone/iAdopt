// ----------------------------- VOLUNTEERS TABLE ----------------------------------- //
load_data_volunteers();

function load_data_volunteers(query = '', page_number = 1) {
    var form_data = new FormData();
    form_data.append('query', query);
    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'includes/fetch-volunteers.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);
            var html = '';
            var serial_no = 1;

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {

                    var volunteer_id = response.data[count].volunteer_id;
                    var last_name = response.data[count].last_name;
                    var first_name = response.data[count].first_name;
                    var role = response.data[count].role;
                    var status = response.data[count].status;
                    var date_active = response.data[count].date_active;
                    var date_inactive = response.data[count].date_inactive;
            
                    html += '<tr>';
                    html += '<td>' + volunteer_id + '</td>';
                    html += '<td>' + first_name + ' ' + last_name + '</td>';
                    html += '<td>' + date_active + '</td>';
                    var badgeClass = '';
                    if (status === 'Inactive') {
                        badgeClass = 'badge-draft'; // Gray color
                    } else if (status === 'Active') {
                        badgeClass = 'badge-published'; // Green color
                    } 

                    html += '<td><span class="custom-badge ' + badgeClass + '">' + status + '</span></td>';
                    html += '<td>' + role + '</td>';
                    html += '<td class="text-center align-middle">';
                    html += '<button class="btn" data-bs-toggle="modal" data-bs-target="#volunteerModal_' + volunteer_id + '">...</button>';
                    html += '</td>';
                    html += '</tr>';
                    serial_no++;
                    html += '<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
                }
            } else {
                // Update colspan to match the number of columns (6)
                html += '<tr><td colspan="6" class="text-center">No Data Found</td></tr>';
            }

            document.getElementById('volunteer_data').innerHTML = html;
            document.getElementById('volunteer_pagination_link').innerHTML = response.pagination;
        }
    };
}

// ----------------------------- VOLUNTEERS TABLE ----------------------------------- //

// --------------------------- VOLUNTEER ------------------------------------------- //

// Save button click event
document.getElementById('saveVolunteerBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission
  
    clearErrorMessages(); // Clear any existing error messages
  
    // Validate fields
    let isValid = true;
  
    const volunteerFName = document.getElementById('volunteerFName');
    const volunteerLName = document.getElementById('volunteerLName');
    const volunteerRole = document.getElementById('volunteerRole');
    const volunteerStatus = document.getElementById('volunteerStatus');
  
    // Validate the fields
    isValid &= validateField(volunteerFName, "First name is required.");
    isValid &= validateField(volunteerLName, "Last name is required.");
    isValid &= validateField(volunteerRole, "Please select a role.");
    isValid &= validateField(volunteerStatus, "Please select a status.");
  
    // If the form is valid, submit via AJAX
    if (isValid) {
      var volunteerForm = document.getElementById('volunteerForm');
      var formData = new FormData(volunteerForm);
  
      $.ajax({
        type: 'POST',
        url: 'includes/submit-volunteer.php', 
        data: formData,
        processData: false, // Important for FormData
        contentType: false, // Important for FormData
        success: function(response) {
          console.log("Form submitted successfully:", response);
          // You can hide the modal and show a success message here
          $('#addVolunteerModal').modal('hide');
          $('#successVolunteerModal').modal('show');
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
  
  // --------------------------- VOLUNTEER ------------------------------------------- //

  // Edit button click event
function toggleEditVolunteer(volunteerId) {
  const formId = `volunteerForm_${volunteerId}`;
  const saveButtonId = `saveVolunteerBtn_${volunteerId}`;
  const editButtonId = `editVolunteerBtn_${volunteerId}`;

  // Enable inputs for editing
  const volunteerForm = document.getElementById(formId);
  const volunteerFName = document.getElementById(`volunteerFName_${volunteerId}`);
  const volunteerLName = document.getElementById(`volunteerLName_${volunteerId}`);
  const volunteerRole = document.getElementById(`volunteerRole_${volunteerId}`);
  const volunteerStatus = document.getElementById(`volunteerStatus_${volunteerId}`);

  // Remove readonly and disabled attributes
  volunteerFName.removeAttribute('readonly');
  volunteerLName.removeAttribute('readonly');
  volunteerRole.removeAttribute('disabled');
  volunteerStatus.removeAttribute('disabled');

  // Show Save Changes button and hide Edit button
  document.getElementById(editButtonId).style.display = 'none';
  const saveButton = document.getElementById(saveButtonId);
  saveButton.style.display = 'block';
  saveButton.disabled = false;

  // Save button click event with dynamic form ID
  saveButton.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission

    clearErrorMessages(); // Clear any existing error messages

    // Validate fields
    let isValid = true;

    // Validate the fields
    isValid &= validateField(volunteerFName, "First name is required.");
    isValid &= validateField(volunteerLName, "Last name is required.");
    isValid &= validateField(volunteerRole, "Please select a role.");
    isValid &= validateField(volunteerStatus, "Please select a status.");

    // If the form is valid, submit via AJAX
    if (isValid) {
      const formData = new FormData(volunteerForm);

      $.ajax({
        type: 'POST',
        url: 'includes/edit-volunteer.php', // Use edit-volunteer.php for editing
        data: formData,
        processData: false, // Important for FormData
        contentType: false, // Important for FormData
        success: function(response) {
          console.log("Form edited successfully:", response);
          // Hide modal and show a success message
          $(`#volunteerModal_${volunteerId}`).modal('hide');
          $('#successEditVolunteerModal').modal('show');
        },
        error: function(xhr, status, error) {
          console.error("Error occurred:", xhr.responseText);
        }
      });
    }
  });
}

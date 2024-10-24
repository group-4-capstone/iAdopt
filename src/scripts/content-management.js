// ----------------------------- DISPLAY AND PAGINATION -------------------------- //
// ----------------------------- announcements TABLE ----------------------------------- //
load_data_announcements();

function load_data_announcements(query = '', page_number = 1) {
    var form_data = new FormData();
    form_data.append('query', query);
    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'includes/fetch-announcements.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);
            var html = '';
            var serial_no = 1;

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {

                    var announcement_id = response.data[count].announcement_id;
                    var image = response.data[count].image;
                    var title = response.data[count].title;
                    var description = response.data[count].description;
                    var status = response.data[count].status;
                    var first_name = response.data[count].first_name;
                    var last_name = response.data[count].last_name;
                    var announcement_date = response.data[count].announcement_date;
            
                    html += '<tr data-announcement-image="' + image + '">';
                    html += '<td>' + announcement_id + '</td>';
                    html += '<td><b>' + title + '</b></td>';
                    html += '<td>' + announcement_date + '</td>';
                    var badgeClass = '';
                    if (status === 'Draft') {
                        badgeClass = 'badge-draft'; // Gray color
                    } else if (status === 'Published') {
                        badgeClass = 'badge-published'; // Green color
                    } else if (status === 'Unpublished') {
                        badgeClass = 'badge-unpublished'; // Red color
                    } else if (status === 'Scheduled Post') {
                        badgeClass = 'badge-scheduled'; // Orange color
                    }
                    
                    html += '<td><span class="custom-badge ' + badgeClass + '">' + status + '</span></td>';
                    
                    html += '<td>' + first_name + ' ' + last_name + '</td>';
                    html += '<td class="text-center align-middle">';
                    html += '<button class="btn" data-bs-toggle="modal" data-bs-target="#announcementModal_' + announcement_id + '">...</button>';
                    html += '</td>';
                    html += '</tr>';
                    serial_no++;
                    html += '<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
                }
            } else {
                // Update colspan to match the number of columns (6)
                html += '<tr><td colspan="6" class="text-center">No Data Found</td></tr>';
            }

            document.getElementById('announcements_data').innerHTML = html;
            document.getElementById('announcements_pagination_link').innerHTML = response.pagination;
        }
    };
}

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
                    } else if (status === 'Publish') {
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
load_data_faq();

function load_data_faq(query = '', page_number = 1) {
    var form_data = new FormData();
    form_data.append('query', query);
    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'includes/fetch-faqs.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);
            var html = '';
            var serial_no = 1;

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {

                    var faq_id = response.data[count].faq_id;
                    var last_name = response.data[count].last_name;
                    var first_name = response.data[count].first_name;
                    var question = response.data[count].question;
                    var answer = response.data[count].answer;
                    var status = response.data[count].status;
            
                    html += '<tr>';
                    html += '<td>' + faq_id + '</td>';
                    html += '<td><b>' + question + '</b></td>';
                    var badgeClass = '';
                    if (status === 'Draft') {
                        badgeClass = 'badge-draft'; // Gray color
                    } else if (status === 'Published') {
                        badgeClass = 'badge-published'; // Green color
                    }  else if (status === 'Unpublished') {
                      badgeClass = 'badge-unpublished'; 
                  }
                    html += '<td><span class="custom-badge ' + badgeClass + '">' + status + '</span></td>';
                    html += '<td>' + first_name + ' ' + last_name + '</td>';
                    html += '<td class="text-center align-middle">';
                    html += '<button class="btn" data-bs-toggle="modal" data-bs-target="#FAQModal_' + faq_id + '">...</button>';
                    html += '</td>';
                    html += '</tr>';
                    serial_no++;
                    html += '<tr><td></td><td></td><td></td><td></td><td></td></tr>';
                }
            } else {
                // Update colspan to match the number of columns (6)
                html += '<tr><td colspan="6" class="text-center">No Data Found</td></tr>';
            }

            document.getElementById('faq_data').innerHTML = html;
            document.getElementById('faq_pagination_link').innerHTML = response.pagination;
        }
    };
}



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
              $('#successAnnouncementModal').modal('show');
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
      if (statusSelect.value === 'Draft' || statusSelect.value === 'Published' ) {
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


// --------------------------- MERCHANDISE ------------------------------------------- //

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


// --------------------------- FAQS ------------------------------------------- //


  const quill1 = new Quill('#faqContent', {
    theme: 'snow'
  });

  // Save button click event
document.getElementById('saveFAQBtn').addEventListener('click', function(event) {
  event.preventDefault();

  clearErrorMessages();

  // Validate fields
  let isValid = true;

  const question = document.getElementById('question');
  const status = document.getElementById('faqStatus');

  // Get the Quill content for FAQ Answer
  const faqContentHTML = quill1.root.innerHTML;
  document.getElementById('faqContentHidden').value = faqContentHTML; // Store Quill content in hidden field

  // Validate the fields
  isValid &= validateField(question, "This field is required.");
  isValid &= validateField(status, "Please select a status.");
  isValid &= validateContentField(faqContentHTML, "Answer is required."); // Validate Quill content

  // If the form is valid, submit via AJAX
  if (isValid) {
      var faqForm = document.getElementById('FAQForm');
      var formData = new FormData(faqForm); // Use FormData for file uploads

      $.ajax({
          type: 'POST',
          url: 'includes/submit-faq.php',
          data: formData,
          processData: false, // Important for FormData
          contentType: false, // Important for FormData
          success: function(response) {
              console.log("Form submitted successfully:", response);
              $('#addFAQModal').modal('hide');
              $('#successFAQModal').modal('show');
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
      showErrorMessage(document.getElementById('faqContent'), message);
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

  if (inputElement.id === 'faqContent') {
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
document.querySelectorAll('input, select, #faqContent').forEach(element => {
  element.addEventListener('input', function() {
      clearSpecificErrorMessage(this); 
  });

  element.addEventListener('change', function() {
      clearSpecificErrorMessage(this); 
  });
});

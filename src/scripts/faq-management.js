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
                    var faq_status = response.data[count].faq_status;
            
                    html += '<tr>';
                    html += '<td>' + faq_id + '</td>';
                    html += '<td><b>' + question + '</b></td>';
                    var badgeClass = '';
                    if (faq_status === 'Draft') {
                        badgeClass = 'badge-draft'; // Gray color
                    } else if (faq_status === 'Published') {
                        badgeClass = 'badge-published'; // Green color
                    }  else if (faq_status === 'Unpublished') {
                      badgeClass = 'badge-unpublished'; 
                  }
                    html += '<td><span class="custom-badge ' + badgeClass + '">' + faq_status + '</span></td>';
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

// EDITTT

// Enable Editing for Specific FAQ Modal
function toggleEditFAQ(id) {
    const formId = `FAQForm_${id}`;
    const questionInput = document.getElementById(`question_${id}`);
    const statusSelect = document.getElementById(`faqStatus_${id}`);
    const contentHiddenInput = document.getElementById(`faqContentHidden_${id}`);
    const saveButton = document.getElementById(`saveFAQBtn_${id}`);
    const editButton = document.getElementById(`editFAQBtn_${id}`);

    // Enable inputs for editing
    questionInput.readOnly = false;
    statusSelect.disabled = false;

    // Show the save button and enable it
    editButton.style.display = 'none';
    saveButton.style.display = 'inline-block';
    saveButton.disabled = false;

    // Initialize Quill editor for the FAQ content area
    const quill = new Quill(`#faqContent_${id}`, { theme: 'snow', readOnly: false });
    
    // Update hidden input with current Quill editor content
    const faqContentHTML = quill.root.innerHTML;
    contentHiddenInput.value = faqContentHTML;

    // On content change, update hidden input
    quill.on('text-change', function() {
        contentHiddenInput.value = quill.root.innerHTML;
    });
}

// Save Button Click Event (Reusable Validation for FAQ)
$(document).on('click', '[id^="saveFAQBtn_"]', function (event) {
    event.preventDefault();
    clearErrorMessages();

    const buttonId = this.id;
    const id = buttonId.split('_')[1];
    const formId = `FAQForm_${id}`;
    const formElement = document.getElementById(formId);

    const question = document.getElementById(`question_${id}`);
    const status = document.getElementById(`faqStatus_${id}`);
    const contentHiddenInput = document.getElementById(`faqContentHidden_${id}`);
    
    // Initialize Quill editor to get content
    const quillEditor = new Quill(`#faqContent_${id}`, { theme: 'snow' });
    const faqContentHTML = quillEditor.root.innerHTML;
    contentHiddenInput.value = faqContentHTML;

    // Validate fields
    let isValid = true;
    isValid &= validateField(question, "This field is required.");
    isValid &= validateField(status, "Please select a status.");
    isValid &= validateContentField(faqContentHTML, "Answer is required.");

    if (isValid) {
        const formData = new FormData(formElement);

        $.ajax({
            type: 'POST',
            url: 'includes/edit-faq.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log("FAQ edited successfully:", response);
                $(`#FAQModal_${id}`).modal('hide');
                $('#successEditFAQModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error("Error occurred:", xhr.responseText);
            }
        });
    }
});

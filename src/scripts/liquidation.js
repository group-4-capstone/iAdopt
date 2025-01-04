const textInputs = document.querySelectorAll('input[type="text"], textarea');

textInputs.forEach(function(input) {
    input.addEventListener('keydown', function(event) {
        // Prevent space if the input is empty
        if (input.value.length === 0 && event.key === ' ') {
            event.preventDefault();
        }
    });
});

document.getElementById('or_number').addEventListener('input', function (e) {
    // Replace any non-numeric characters with an empty string
    this.value = this.value.replace(/[^0-9]/g, '');
});


// Function to clear error messages for a specific input
function clearErrorMessage(input) {
    input.classList.remove('is-invalid');
    const errorDiv = input.parentElement.querySelector('.invalid-feedback');
    if (errorDiv) {
        errorDiv.remove();
    }
}

// Add event listeners to remove error dynamically
function addDynamicErrorClearListeners() {
    // For text and number inputs
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function () {
            clearErrorMessage(input);
        });
    });

    // For select elements
    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', function () {
            clearErrorMessage(select);
        });
    });
}

// Call this function after the DOM has loaded
document.addEventListener('DOMContentLoaded', addDynamicErrorClearListeners);

// Validate amount field
function validateAmountField(amount) {
    if (!amount.value || amount.value <= 0) {
        amount.classList.add('is-invalid');
        const errorMessage = document.createElement('div');
        errorMessage.classList.add('invalid-feedback');
        errorMessage.textContent = "Amount is required.";
        amount.parentElement.appendChild(errorMessage);
        return false;
    }
    return true;
}

// Validate general field (e.g., select inputs)
function validateField(field, errorMessage) {
    if (!field.value) {
        field.classList.add('is-invalid');
        const errorDiv = document.createElement('div');
        errorDiv.classList.add('invalid-feedback');
        errorDiv.textContent = errorMessage;
        field.parentElement.appendChild(errorDiv);
        return false;
    }
    return true;
}

// Validate image file field
function validateImageField(fileInput, errorMessage) {
    if (!fileInput.files.length) {
        fileInput.classList.add('is-invalid');
        const errorDiv = document.createElement('div');
        errorDiv.classList.add('invalid-feedback');
        errorDiv.textContent = errorMessage;
        fileInput.parentElement.appendChild(errorDiv);
        return false;
    }
    return true;
}

// Clear all error messages
function clearErrorMessages() {
    document.querySelectorAll('.is-invalid').forEach(input => {
        input.classList.remove('is-invalid');
        const errorDiv = input.parentElement.querySelector('.invalid-feedback');
        if (errorDiv) {
            errorDiv.remove();
        }
    });
}

// Donation Form Submission
document.getElementById('submitDonation').addEventListener('click', function (event) {
    event.preventDefault();
    clearErrorMessages();

    // Validate donation form
    let isValid = true;
    const amount = document.querySelector('#donationAmount');
    const modeOfDonation = document.querySelector('#donationMode');
    const proof = document.querySelector('#donationProof');
    const donorNameInput = document.getElementById('donorName'); 

    isValid &= validateAmountField(amount);
    isValid &= validateField(modeOfDonation, "Please select a mode of donation.");
    isValid &= validateImageField(proof, "Proof of donation is required.");

    const anonymousCheckbox = document.getElementById('anonymousDonation');
    
    if (!anonymousCheckbox.checked) {
        isValid &= validateField(donorNameInput, "Donor name is required.");
    }

    if (isValid) {
        const formData = new FormData(document.getElementById('donationForm'));

        $.ajax({
            type: 'POST',
            url: 'includes/submit-liquidation.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log("Donation submitted successfully:", response);
                $('#donationModal').modal('hide');
                $('#successDonationModal').modal('show');
            },
            error: function (xhr) {
                console.error("Error submitting donation:", xhr.responseText);
            }
        });
    }
});

// Expense Form Submission
document.getElementById('submitExpense').addEventListener('click', function (event) {
    event.preventDefault();
    clearErrorMessages();

    // Validate expense form
    let isValid = true;
    const amount = document.querySelector('#expenseAmount');
    const purpose = document.querySelector('#expensePurpose');
    const proof = document.querySelector('#expenseProof');


    isValid &= validateAmountField(amount);
    isValid &= validateField(purpose, "This field is required.");
    isValid &= validateImageField(proof, "Proof of expense is required.");

    if (isValid) {
        const formData = new FormData(document.getElementById('expenseForm'));

        $.ajax({
            type: 'POST',
            url: 'includes/submit-liquidation.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log("Expense submitted successfully:", response);
                $('#expenseModal').modal('hide');
                $('#successExpenseModal').modal('show');
            },
            error: function (xhr) {
                console.error("Error submitting expense:", xhr.responseText);
            }
        });
    }
});


load_data();

function load_data(query = '', page_number = 1)
{
    var form_data = new FormData();

    form_data.append('query', query);

    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();

    ajax_request.open('POST', 'includes/fetch-liquidation.php');

    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function()
    {
        if(ajax_request.readyState == 4 && ajax_request.status == 200)
        {
            var response = JSON.parse(ajax_request.responseText);

            var html = '';

            var serial_no = 1;

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {
                    var liquidation_id = response.data[count].liquidation_id;
            
                    html += '<tr data-bs-toggle="modal" data-bs-target="#liquidationModal_' + liquidation_id + '">';
                    html += '<td>' + liquidation_id + '</td>';
                    html += '<td>' + response.data[count].date + '</td>';
                    html += '<td><span class="badge text-bg-' + (response.data[count].type === 'Donation' ? 'success' : 'danger') + '">' + response.data[count].type.charAt(0).toUpperCase() + response.data[count].type.slice(1) + '</span></td>';
                    html += '<td>' + response.data[count].amount + '</td>';
                    html += '<td>' + response.data[count].description + '</td>';
                  
                    html += '<td>';
                 
                    // Check the liquidation status and assign the appropriate badge class
                    if (response.data[count].type === 'Expense') {
                        html += 'N/A';
                    } else if (response.data[count].liquidation_status === 'For Verification') {
                        html += '<span class="badge bg-warning text-dark oval-badge">For Verification</span>';
                    } else if (response.data[count].liquidation_status === 'Verified') {
                        html += '<span class="badge bg-success oval-badge">Verified</span>';
                    } else if (response.data[count].liquidation_status === 'Invalid') {
                        html += '<span class="badge bg-danger oval-badge">Invalid</span>';
                    }
                
                    html += '</td>';
                    html += '</tr>';
                    serial_no++;
                }
            }
            else
            {
                html += '<tr><td colspan="3" class="text-center">No Data Found</td></tr>';
            }

            document.getElementById('post_data').innerHTML = html;


            document.getElementById('pagination_link').innerHTML = response.pagination;

        }

    }
}



  function updateLiquidationStatus(liquidationId, action) {
   
    const form = document.getElementById(`updateLiquidationForm_${liquidationId}`);
    const formData = new FormData(form);

    formData.append('action', action);
    formData.append('liquidation_id', liquidationId);  

    $.ajax({
        url: 'includes/update-liquidation-status.php', 
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log('Server response:', response); 
            if (response.success) {
                $(`#liquidationModal_${liquidationId}`).modal('hide');
                $('#successModal').modal('show');
            } else {
                alert('Error: ' + response.message); 
            }
        },
        error: function (xhr, status, error) {
            console.error('Request failed. Status:', status, 'Error:', error); 
        }
    });
}

const anonymousCheckbox = document.getElementById('anonymousDonation');
const donorNameField = document.getElementById('donorNameField');

anonymousCheckbox.addEventListener('change', () => {
  if (anonymousCheckbox.checked) {
    donorNameField.style.display = 'none';
  } else {
    donorNameField.style.display = 'block';
  }
});
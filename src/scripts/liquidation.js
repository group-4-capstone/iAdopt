document.getElementById('submitDonation').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default form submission

    clearErrorMessages(); 

    // Validate fields
    let isValid = true;

    const amount = document.querySelector('input[name="amount"]');
    const description = document.querySelector('input[name="description"]');
    const donator = document.querySelector('input[name="donator"]');

    isValid &= validateAmountField(amount);
    isValid &= validateField(description, "This field is required.");
    isValid &= validateField(donator, "This field is required.");


    if (isValid) {
        var donationForm = document.getElementById('donationForm');
        var formData = $(donationForm).serialize();

        $.ajax({
            type: 'POST',
            url: 'includes/submit-liquidation.php',
            data: formData,
            success: function(response) {
                $('#donationModal').modal('hide');
                $('#successDonationModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error occurred:", xhr.responseText);
            }
        });
    }
});

function validateAmountField(inputElement) {
    const value = inputElement.value.trim();
    const regex = /^(?!0(\.0+)?$)\d+(\.\d{1,2})?$/; // Positive number > 0, with up to two decimal places
    if (!value) {
        showErrorMessage(inputElement, "This field is required.");
        return false;
    } else if (!regex.test(value)) {
        showErrorMessage(inputElement, "Please enter a valid positive number greater than 0 (up to two decimal places).");
        return false;
    }
    return true;
}

function validateField(inputElement, message) {
    if (!inputElement.value.trim()) {
        showErrorMessage(inputElement, message);
        return false;
    }
    return true;
}

function showErrorMessage(inputElement, message) {
    clearSpecificErrorMessage(inputElement); // Clear any existing error for this field
    const errorMessage = document.createElement('div');
    errorMessage.className = 'error-message text-danger';
    errorMessage.innerText = message;
    inputElement.classList.add('is-invalid'); // Add the 'is-invalid' class to the input
    inputElement.parentNode.appendChild(errorMessage);
}

function clearErrorMessages() {
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(msg => msg.remove());
    const invalidInputs = document.querySelectorAll('.is-invalid');
    invalidInputs.forEach(input => input.classList.remove('is-invalid'));
}

function clearSpecificErrorMessage(inputElement) {
    const errorMessage = inputElement.parentNode.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
    inputElement.classList.remove('is-invalid'); // Remove the 'is-invalid' class
}


const amountInput = document.querySelector('input[name="amount"]');

amountInput.addEventListener('input', function() {
    clearSpecificErrorMessage(this);
    const value = this.value;

    const regex = /^(?!0(\.0+)?$)\d*\.?\d{0,2}$/;
    if (value && !regex.test(value)) {
        showErrorMessage(this, "Please enter a valid positive number greater than 0 (up to two decimal places).");
    }
});

// Restrict invalid input for "amount" field
amountInput.addEventListener('keypress', function(event) {
    if (event.key === '-') {
        event.preventDefault(); // Prevent negative numbers
    }

    if (this.value === '' && event.key === '0') {
        event.preventDefault(); // Prevent leading zero
    }

    if (this.value.includes('.') && event.key === '.') {
        event.preventDefault(); // Prevent multiple decimal points
    }

    if (this.value.split('.')[0].length >= 5 && !this.value.includes('.')) {
        event.preventDefault(); // Limit whole part of the number to 5 digits
    }

    const decimalPart = this.value.split('.')[1];
    if (decimalPart && decimalPart.length >= 2) {
        event.preventDefault(); // Limit decimal places to two
    }
});


document.querySelectorAll('input').forEach(input => {
    input.addEventListener('input', function() {
        clearSpecificErrorMessage(this); 
    });

    input.addEventListener('keypress', function(event) {
        if (this !== amountInput && this.value.length === 0 && !/^[a-zA-Z]$/.test(event.key)) {
            event.preventDefault(); // Prevent numbers or spaces as the first character in non-amount fields
        }
    });
});


// Handle expense form submission
document.getElementById('submitExpense').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default form submission

    clearExpenseErrorMessages();

    // Validate fields
    let isValid = true;

    const expenseAmount = document.getElementById('expenseAmount');
    const expensePurpose = document.getElementById('expensePurpose');

    // Validate each field and accumulate the validity status
    isValid &= validateExpenseField(expenseAmount, "This field is required.", true); // Allows decimal validation for the amount
    isValid &= validateExpenseField(expensePurpose, "This field is required.", false);

    // If the form is valid, submit via AJAX
    if (isValid) {
        var expenseForm = document.getElementById('expenseForm');
        var formData = new FormData(expenseForm);

        $.ajax({
            type: 'POST',
            url: 'includes/submit-liquidation.php',
            data: formData,
            processData: false, 
            contentType: false, 
            success: function(response) {
                $('#expenseModal').modal('hide');
                $('#successExpenseModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error occurred:", xhr.responseText);
            }
        });
    }
});

function validateExpenseField(inputElement, message, allowDecimal) {
    const value = inputElement.value.trim();
    
    if (!value) {
        showExpenseErrorMessage(inputElement, message);
        return false;
    } else if (allowDecimal && (isNaN(value) || value <= 0)) {
        showExpenseErrorMessage(inputElement, "Please enter a valid amount greater than 0.");
        return false;
    }
    return true;
}

function showExpenseErrorMessage(inputElement, message) {
    clearSpecificExpenseErrorMessage(inputElement); 
    const errorMessage = document.createElement('div');
    errorMessage.className = 'error-message text-danger';
    errorMessage.innerText = message;
    inputElement.classList.add('is-invalid'); 
    inputElement.parentNode.appendChild(errorMessage);
}

function clearExpenseErrorMessages() {
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(msg => msg.remove());
    const invalidInputs = document.querySelectorAll('.is-invalid');
    invalidInputs.forEach(input => input.classList.remove('is-invalid'));
}

function clearSpecificExpenseErrorMessage(inputElement) {
    const errorMessage = inputElement.parentNode.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
    inputElement.classList.remove('is-invalid'); 
}

// Dynamically remove error message once user starts typing
document.querySelectorAll('#expenseForm input').forEach(input => {
    input.addEventListener('input', function() {
        clearSpecificExpenseErrorMessage(this); 
    });
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

            if(response.data.length > 0)
            {
                for(var count = 0; count < response.data.length; count++)
                {
                    html += '<tr>';
                    html += '<td>'+response.data[count].liquidation_id+'</td>';
                    html += '<td>'+response.data[count].date+'</td>';
                    html += '<td><span class="badge text-bg-' + (response.data[count].type === 'donation' ? 'success' : 'danger') + '">' + response.data[count].type.charAt(0).toUpperCase() + response.data[count].type.slice(1) + '</span></td>';
                    html += '<td>'+response.data[count].amount+'</td>';
                    html += '<td>'+response.data[count].description+'</td>';
                    if (response.data[count].type === 'expense') {
                      html += '<td>N/A</td>';
                  } else {
                      html += '<td>' + (response.data[count].donator ? response.data[count].donator : '') + '</td>';
                  }
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
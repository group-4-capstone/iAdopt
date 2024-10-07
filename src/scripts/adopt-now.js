

const occupationSelect = document.getElementById('occupation');
const professionField = document.getElementById('professionField');

occupationSelect.addEventListener('change', function() {
    if (occupationSelect.value === 'Employee') {
        professionField.style.display = 'block';
    } else {
        professionField.style.display = 'none';
    }
});

const residenceSelect = document.getElementById('residence');
const fencedYardField = document.getElementById('fencedYardField');
const nofencedYardField = document.getElementById('nofencedYardField');

residenceSelect.addEventListener('change', function() {
    if (residenceSelect.value === 'Detached House (with fence/gate)' || residenceSelect.value === 'Townhouse (with fence/gate)') {
        fencedYardField.style.display = 'block';
        nofencedYardField.style.display = 'none';
    } else {
        fencedYardField.style.display = 'none';
        nofencedYardField.style.display = 'block';
    }
});


const rentSelect = document.getElementById('rent');
const writtenLetterField = document.getElementById('writtenLetterField');

rentSelect.addEventListener('change', function() {
    if (rentSelect.value === 'Yes') {
        writtenLetterField.style.display = 'block';
    } else {
        writtenLetterField.style.display = 'none';
    }
});

const moveSelect = document.getElementById('move');
const specificAddressField = document.getElementById('specificAddressField');

moveSelect.addEventListener('change', function() {
    if (moveSelect.value === 'Yes') {
        specificAddressField.style.display = 'block';
    } else {
        specificAddressField.style.display = 'none';
    }
});


const involveSelect = document.getElementById('involve');
const familyInvolveField = document.getElementById('familyInvolveField');

involveSelect.addEventListener('change', function() {
    if (involveSelect.value === 'No') {
        familyInvolveField.style.display = 'block';
    } else {
        familyInvolveField.style.display = 'none';
    }
});

const objectionSelect = document.getElementById('objection');
const familyObjectionField = document.getElementById('familyObjectionField');

objectionSelect.addEventListener('change', function() {
    if (objectionSelect.value === 'Yes') {
        familyObjectionField.style.display = 'block';
    } else {
        familyObjectionField.style.display = 'none';
    }
});

const allergySelect = document.getElementById('allergy');
const familyAllergyField = document.getElementById('familyAllergyField');

allergySelect.addEventListener('change', function() {
    if (allergySelect.value === 'Yes') {
        familyAllergyField.style.display = 'block';
    } else {
        familyAllergyField.style.display = 'none';
    }
});

const companionSelect = document.getElementById('companion');
const companionField = document.getElementById('companionField');

companionSelect.addEventListener('change', function() {
    if (companionSelect.value === 'Yes') {
        companionField.style.display = 'block';
    } else {
        companionField.style.display = 'none';
    }
});

const veterinarianSelect = document.getElementById('veterinarian');
const veterinarianField = document.getElementById('veterinarianField');

veterinarianSelect.addEventListener('change', function() {
    if (veterinarianSelect.value === 'Yes') {
        veterinarianField.style.display = 'block';
    } else {
        veterinarianField.style.display = 'none';
    }
});


var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
    var x = document.getElementsByClassName("step");
    for (let i = 0; i < x.length; i++) {
        x[i].style.display = "none"; // Hide all steps
    }
    x[n].style.display = "block"; // Show the current step

    document.getElementById("prevBtn").style.display = n === 0 ? "none" : "inline";
    document.getElementById("nextBtn").innerHTML = n === (x.length - 1) ? "Submit" : "Next";
    
    fixStepIndicator(n);
}

function nextPrev(n) {
    var x = document.getElementsByClassName("step");

    if (n === 1) { // Going to the next step
        var requiredFields = x[currentTab].querySelectorAll('[required]');
        var allFilled = true;

        requiredFields.forEach(function(field) {
            removeError(field); // Clear previous error messages
            if (!field.value) {
                allFilled = false;
                showError(field, "This is required.");
            }
        });

        const professionInput = professionField.querySelector('input[name="profession"]');
        if (occupationSelect.value === 'Employee' && !professionInput.value) {
            allFilled = false;
            showError(professionInput, "This is required.");
        }

        const fenceInput = fencedYardField.querySelector('input[name="fence"]');
        const noFenceInput = nofencedYardField.querySelector('input[name="no_fence"]');

        if (residenceSelect.value === 'Detached House (with fence/gate)' || residenceSelect.value === 'Townhouse (with fence/gate)') {
            if (fencedYardField.style.display === 'block' && !fenceInput.value) {
                allFilled = false;
                showError(fenceInput, "This is required.");
            }
        } else {
            if (nofencedYardField.style.display === 'block' && !noFenceInput.value) {
                allFilled = false;
                showError(noFenceInput, "This is required.");
            }
        }

        const newAddressInput = specificAddressField.querySelector('input[name="new_address"]');
        if (moveSelect.value === 'Yes' && !newAddressInput.value) {
            allFilled = false;
            showError(newAddressInput, "This is required.");
        }

        const involveReasonInput = familyInvolveField.querySelector('input[name="involve_reason"]');
        if (involveSelect.value === 'No' && !involveReasonInput.value) {
            allFilled = false;
            showError(involveReasonInput, "This is required.");
        }

        const objectionReasonInput = familyObjectionField.querySelector('input[name="objection_reason"]');
        if (objectionSelect.value === 'Yes' && !objectionReasonInput.value) {
            allFilled = false;
            showError(objectionReasonInput, "This is required.");
        }

        const memberAllergyInput = familyAllergyField.querySelector('input[name="member_allergy"]');
        if (allergySelect.value === 'Yes' && !memberAllergyInput.value) {
            allFilled = false;
            showError(memberAllergyInput, "This is required.");
        }

        const otherAnimalsInput = companionField.querySelector('input[name="other_animals"]');
        
        if (companionSelect.value === 'Yes') {
            if (!otherAnimalsInput.value) {
                allFilled = false;
                showError(otherAnimalsInput, "This is required.");
            }
        
            if (!veterinarianSelect.value) {
                allFilled = false;
                showError(vetInput, "This is required.");
            }
        }
        

        if (!allFilled) {
            return; // Prevent moving to the next step
        }
    }

    x[currentTab].style.display = "none"; // Hide the current tab
    currentTab += n; // Increase or decrease the current tab by 1

    if (currentTab >= x.length) {
        // If you have reached the end of the form, submit via AJAX
        var applicationForm = document.getElementById('applicationForm');
        var formData = new FormData(applicationForm);

        $.ajax({
            type: 'POST',
            url: 'includes/submit-application.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#successApplicationModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
        return false; // Prevent default form submission
    }

    showTab(currentTab); // Otherwise, display the correct tab
}

function fixStepIndicator(n) {
    var i, x = document.getElementsByClassName("stepIndicator");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    x[n].className += " active";
}

function showError(field, message) {
    field.classList.add('is-invalid');
    var error = document.createElement("div");
    error.className = "error-message";
    error.innerText = message;
    field.parentNode.insertBefore(error, field.nextSibling);
    field.style.border = "1px solid red";

    field.addEventListener('input', function() {
        removeError(field);
    }, { once: true });
}

function removeError(field) {
    var errorMessage = field.parentNode.querySelector(".error-message");
    if (errorMessage) {
        errorMessage.remove();
    }
    field.classList.remove('is-invalid');
    field.style.border = ""; // Reset the border
}
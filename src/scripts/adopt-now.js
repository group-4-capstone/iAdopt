

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



document.getElementById('applicationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission
    
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
            // Handle errors here
            console.error(xhr.responseText);
        }
    });
});


//================================================= Adopted Table ======================================================//
load_data_adopted();

function load_data_adopted(query = '', page_number = 1) {
    var form_data = new FormData();
    form_data.append('query', query);
    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'includes/fetch-adopted.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function () {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);
            var html = '';
            var serial_no = 1;

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {
                    
                    var adoption_date = response.data[count].adoption_date;
                    var animal_id = response.data[count].animal_id;
                    var name = response.data[count].name;
                    var first_name = response.data[count].first_name;
                    var last_name = response.data[count].last_name;
                    var application_id = response.data[count].application_id;
                    var image = response.data[count].image;
                    var user_image = response.data[count].user_image;

                    // Use default image if none is provided for user or animal
                    if (!user_image || user_image.trim() === '') {
                        user_image = 'styles/assets/person-circle.png'; // Default user image
                    }

                 html += '<tr onclick="window.location.href=\'animal-record.php?animal_id=' + response.data[count].animal_id + '\'">';

                    html += '<td>' + first_name + " " + last_name + '</td>';
                    html += '<td>' + adoption_date + '</td>';
                    html += '<td>' + name + '</td>';
                    html += '</tr>';

                    serial_no++;
                }
            } else {
                html += '<tr><td colspan="5" class="text-center">No Data Found</td></tr>';
            }

            document.getElementById('adopted_data').innerHTML = html;
            document.getElementById('adopted_pagination_link').innerHTML = response.pagination;

            // Reattach event listeners for the new rows
            attachRowClickEvent();
        }
    };
}
//========================== Call modal for adopted table =========================//
// Function to handle row click and populate modal
function attachRowClickEvent() {
    var rows = document.querySelectorAll('#adopted_data tr');
    rows.forEach(function(row) {
        row.addEventListener('click', function() {
            var petName = this.getAttribute('data-pet-name');
            var adoptedBy = this.getAttribute('data-adopted-by');
            var adoptionDate = this.getAttribute('data-adoption_date');
            var image = this.getAttribute('data-image');
            var userImage = this.getAttribute('data-user-image'); // Retrieve user image from data attribute

            // Update the modal content
            document.getElementById('petName').innerText = petName;
            document.getElementById('rescuer').innerText = adoptedBy;
            document.getElementById('rescueDate').innerText = adoptionDate;
            
            // Set the image sources in the modal
            document.getElementById('data-image').src = 'styles/assets/' + image;
            document.getElementById('data-user-image').src = userImage; // Ensure correct image path
        });
    });
}



//========================================= Rest Table ===============================================//
// Load data for the Rest Table
load_data();

function load_data(query = '', page_number = 1) {
    var form_data = new FormData();
    form_data.append('query', query);
    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'includes/fetch-rest.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function () {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);
            var html = '';
            var serial_no = 1;

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {
                    
                    var date_of_rest = response.data[count].date_of_rest;
                    var animal_id = response.data[count].animal_id;
                    var name = response.data[count].name;
                    var addition_date = response.data[count].addition_date;
                    var image = response.data[count].image; // Image for the pet

                    // Add data attributes to store information for the modal
                    html += '<tr data-bs-toggle="modal" data-bs-target="#restModal" ' +
                            'data-pet-name="' + name + '" ' +
                            'data-date-of-rest="' + date_of_rest + '" ' +
                            'data-addition-date="' + addition_date + '" ' +
                            'data-image="' + image + '">'; // Include the image data
                    
                    html += '<td>' + date_of_rest + '</td>';
                    html += '<td>' + name + '</td>';
                    html += '<td>' + addition_date + '</td>';
                    html += '</tr>';
                    serial_no++;
                }
            } else {
                html += '<tr><td colspan="5" class="text-center">No Data Found</td></tr>';
            }

            document.getElementById('rest_data').innerHTML = html;
            document.getElementById('rest_pagination_link').innerHTML = response.pagination;

            // Reattach event listeners for the new rows
            attachRestRowClickEvent();
        }
    };
}

// Function to handle row click and populate the Rest modal
function attachRestRowClickEvent() {
    var rows = document.querySelectorAll('#rest_data tr');
    rows.forEach(function(row) {
        row.addEventListener('click', function() {
            var petName = this.getAttribute('data-pet-name');
            var dateOfRest = this.getAttribute('data-date-of-rest');
            var additionDate = this.getAttribute('data-addition-date');
            var image = this.getAttribute('data-image');

            // Update the modal content
            document.getElementById('restPetName').innerText = petName;
            document.getElementById('restDate').innerText = dateOfRest;
            document.getElementById('restRescueDate').innerText = additionDate;
            
            // Set the image source in the modal
            document.getElementById('restPetImage').src = 'styles/assets/' + image;
        });
    });
}

// Load data for the Reports Log Table
load_data_deny();

function load_data_deny(query = '', page_number = 1) {
    var form_data = new FormData();
    form_data.append('query', query);
    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'includes/fetch-deny-reports.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function () {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);
            var html = '';
            var serial_no = 1;

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {
                    
                    var report_date = response.data[count].report_date;
                    var first_name = response.data[count].first_name;
                    var last_name = response.data[count].last_name;
                    var location = response.data[count].location;
                    var deny_reason = response.data[count].deny_reason;
                    var animal_id = response.data[count].animal_id;
                    var name = response.data[count].name;
                    var addition_date = response.data[count].addition_date;
                    var animal_image = response.data[count].animal_image; 

                    html += '<tr data-bs-toggle="modal" data-bs-target="#denyReportsModal" ' +
                    'data-location="' + location + '" ' +
                    'data-report-date="' + report_date + '" ' +
                    'data-reporter="' + first_name + " " + last_name + '" ' +
                    'data-reason="' + deny_reason + '" ' +
                    'data-animal-image="' + animal_image + '">';
                    html += '<td>' + report_date + '</td>';
                    html += '<td>' + first_name + " " + last_name + '</td>';
                    html += '<td>' + location + '</td>';
                    html += '<td>' + deny_reason + '</td>';
                    html += '</tr>';
                    serial_no++;
                }
            } else {
                html += '<tr><td colspan="5" class="text-center">No Data Found</td></tr>';
            }

            document.getElementById('reported_data').innerHTML = html;
            document.getElementById('reported_pagination_link').innerHTML = response.pagination;

            // Reattach event listeners for the new rows
            attachDenytRowClickEvent();
        }
    };
}

// Function to handle row click and populate the Deny Reports modal
function attachDenytRowClickEvent() {
    var rows = document.querySelectorAll('#reported_data tr');
    rows.forEach(function(row) {
        row.addEventListener('click', function() {
            var location = this.getAttribute('data-location');
            var reportDate = this.getAttribute('data-report-date');
            var reporter = this.getAttribute('data-reporter');
            var denyReason = this.getAttribute('data-reason');
            var animalImage = this.getAttribute('data-animal-image');

            console.log(animalImage);

            // Update the modal content
            document.getElementById('denyLocation').innerText = location;
            document.getElementById('denyReportDate').innerText = reportDate;
            document.getElementById('denyReporter').innerText = reporter;
            document.getElementById('denyReason').innerText = denyReason;

            // Set the image source in the modal
            document.getElementById('denyAnimalImage').src = 'styles/assets/rescue-reports/' + animalImage;
        });
    });
}


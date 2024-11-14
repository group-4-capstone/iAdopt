


    let selectedUserId;
    let selectedStatus;
    let selectedUserFullName;
    const modal = new bootstrap.Modal(document.getElementById('statusConfirmModal'));
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));

    load_data();

    function load_data(query = '', page_number = 1) {
        var form_data = new FormData();
        form_data.append('query', query);
        form_data.append('page', page_number);

        var ajax_request = new XMLHttpRequest();
        ajax_request.open('POST', 'includes/fetch-users.php');
        ajax_request.send(form_data);

        ajax_request.onreadystatechange = function() {
            if (ajax_request.readyState == 4 && ajax_request.status == 200) {
                var response = JSON.parse(ajax_request.responseText);
                var html = '';
                var serial_no = 1;

                if (response.data.length > 0) {
                    function ucwords(str) {
                        return str.replace(/\w\S*/g, function(word) {
                            return word.charAt(0).toUpperCase() + word.substr(1).toLowerCase();
                        });
                    }

                    for (var count = 0; count < response.data.length; count++) {
                        // Construct the full name before generating HTML
                        var fullName = ucwords(response.data[count].first_name + ' ' + response.data[count].last_name);
                        
                       
                        html += '<tr>';
                        
                        html += '<td class="text-center align-middle">' + response.data[count].email + '</td>';
                        html += '<td class="text-center align-middle">' + response.data[count].acc_creation + '</td>';

                        // Fix: Use backticks for template literals
                        if (response.data[count].status === "Active") {
                            html += `
                                <td class="text-center align-middle">
                                    <div class="dropdown">
                                        <span class="badge bg-green text-dark dropdown-toggle status-toggle" data-user-id="${response.data[count].user_id}"  data-full-name="${fullName}"  data-status="Inactive" data-bs-toggle="dropdown" aria-expanded="false">
                                            Active
                                        </span>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" class="dropdown-item status-update" data-user-id="${response.data[count].user_id}"  data-full-name="${fullName}"  data-status="Inactive">Inactive</a></li>
                                        </ul>
                                    </div>
                                </td>`;
                        } else {
                            html += `<td class="text-center align-middle"><span class="badge bg-red text-dark">Inactive</span></td>`;
                        }

                        var fullName = ucwords(response.data[count].first_name + ' ' + response.data[count].last_name);
                        html += '<td class="text-center align-middle">' + fullName + '</td>';
                        html += '</tr>';
                      
                        serial_no++;
                    }
                } else {
                    html += '<tr><td colspan="4" class="text-center">No Data Found</td></tr>';
                }

                document.getElementById('post_data').innerHTML = html;
                document.getElementById('pagination_link').innerHTML = response.pagination;

                // Attach click event to the status update links
                document.querySelectorAll('.status-update').forEach(function(element) {
                    element.addEventListener('click', function(e) {
                        e.preventDefault();
                        selectedUserId = this.getAttribute('data-user-id');
                        selectedStatus = this.getAttribute('data-status');
                        selectedUserFullName = this.getAttribute('data-full-name');
                        document.getElementById('userNameDisplay').innerText = selectedUserFullName;
                        modal.show(); // Show the confirmation modal
                    });
                });
            }
        }
    }

    // Confirmation button for status change
    const confirmButton = document.getElementById('confirmButton');
    confirmButton.addEventListener('click', function() {
        updateStatus(selectedUserId, selectedStatus); // Call updateStatus on confirmation
        modal.hide(); // Hide the modal after confirmation
    });

    function updateStatus(userId, status) {
        console.log("Updating status for user ID:", userId, "to status:", status); // Debugging line
    
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'includes/update-accstatus.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                console.log("Response from server:", response); // Debugging line
                if (response.success) {
                    load_data(); // Reload data to reflect the status update
                    successModal.show(); // Show success modal if update was successful
                } else {
                    console.error("Error updating status:", response.error); // Log any errors for debugging
                }
            }
        };
        xhr.send('user_id=' + userId + '&status=' + status);
    }



//========================= For Adding Account ===================================//
document.addEventListener("DOMContentLoaded", function() {
    // Handle form submission
    document.getElementById('addAdminModal').querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Create a FormData object from the form
        var formData = new FormData(this);

        // Send the AJAX request
        fetch('includes/add-acc.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                 // Hide the addAdminModal before showing the success modal
                 var addAdminModal = bootstrap.Modal.getInstance(document.getElementById('addAdminModal'));
                 addAdminModal.hide();
                // Show the success modal
                var successModal = new bootstrap.Modal(document.getElementById('successAddModal'));
                successModal.show();

                // Optionally reset the form here
                this.reset();

                // Redirect after a short delay to allow modal to be seen
                setTimeout(function() {
                    window.location.href = 'account-management.php'; // Redirect to account-management.php
                }, 2000); // Adjust delay as needed
            } else {
                alert(data.error); // Show error if any
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

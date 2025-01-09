<header>
  <nav class="navbar">
    <div class="logo"><img src="styles/assets/secaspi-logo.png"><span>iAdopt-SECASPI</span></div>
    <ul class="menu-links">
      <span id="close-menu-btn" class="material-symbols-outlined">Close</span>
      <li><a href="home.php">Home</a></li>
      <li><a href="adopt.php">Adopt</a></li>
      <li><a href="report.php">Report</a></li>
      <li><a href="donate.php">Donate</a></li>
      <li><a href="shop.php">Shop</a></li>
      <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) { ?>
        <li class="nav-item dropdown">
          <a class="nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle pe-2"></i>Hi, <?php echo $_SESSION['first_name'] ?>
            <i class="bi bi-chevron-down ps-2"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person-circle pe-2"></i>Profile</a></li>
            <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-left pe-2"></i>Logout</a></li>
          </ul>
        </li>
        <!-- Notification Icon -->
        <div class="notification-item" id="notification">
          <a href="#" role="button" data-bs-toggle="modal" data-bs-target="#notificationModal">
            <i class="bi bi-bell-fill notification-icon"></i>
            <span class="badge"></span>
          </a>
        </div>
      <?php } else { ?>
        <li><a href="login.php">Login</a></li>
      <?php  } ?>
    </ul>
    <span id="hamburger-btn" class="material-symbols-outlined">Menu</span>
  </nav>
</header>

<!-- Modal Structure for Notifications -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-center w-100" id="notificationModalLabel">NOTIFICATIONS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="list-unstyled" id="post_data">
          <!-- Notifications will be populated here -->
        </ul>
      </div>
      <div class="pb-3 text-center">
        <a class="text-danger" id="clearNotificationsBtn" onclick="clearNotifications()">Clear Notifications</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal Structure for Notification Details -->
<div class="modal fade" id="notificationDetailModal" tabindex="-1" aria-labelledby="notificationDetailModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="notificationDetailModalLabel">
          <i class="bi bi-bell-fill me-2"></i>Notification Details
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="window.location.reload();" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6 id="notificationType" class="text-primary fw-bold mb-3"></h6>
        <div class="mb-2">
          <p id="notificationMessage" class="mb-1 fs-5"></p>
        </div>
        <div>
          <p id="notificationDate" class="text-muted small fst-italic"></p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="window.location.reload();">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Post-Adoption -->
<div class="modal fade" id="postAdoptionModal" tabindex="-1" aria-labelledby="postAdoptionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="postAdoptionModalLabel">Post-Adoption Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="postAdoptionForm" method="post">
            <!-- Current Situation Description -->
            <div class="mb-3">
              <label for="currentDescription" class="form-label">Current Situation Description:</label>
              <textarea class="form-control" id="currentDescription" name="currentDescription" placeholder="Briefly describe the current situation of your pet." rows="3" ></textarea>
            </div>

            <!-- File Upload -->
            <div class="mb-3">
              <label for="uploadFiles" class="form-label">Upload Pictures/Videos:</label>
              <input type="file" class="form-control" id="uploadFiles" name="uploadFiles[]" accept=".jpg,.jpeg,.png,.mp4,.mov" multiple>
            </div>

            <input type="hidden" id="application_id" name="application_id" readonly>
            <input type="hidden" id="notification_id" name="notification_id" readonly>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
    </div>
  </div>
</div>

<!-- Adoption Modal -->
<div class="modal fade" id="adoptionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-body d-flex">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="row p-5">
          <div class="col-12 col-md-12 col-sm-12 col-lg-6">
            <img src="styles/assets/success.gif" alt="Adoption Approved GIF" style="width:85%; transform: scaleX(-1);">
          </div>
          <div class="col-12 col-md-12 col-sm-12 col-lg-6">
            <h4 class="mt-5 mb-3"><i class="bi bi-check-circle-fill pe-3" style="color: green; font-size:30px"></i>Adoption Application Approved!</h4>
            <p>Congratulations! Your adoption application has been reviewed and you may now proceed to the next step:</p>
            <p><strong>Online Interview</strong></p>
            <p><strong>Date:</strong> <span id="applicationDate"></span></p>
            <p><strong>Time:</strong> <span id="applicationTime"></span></p>
            <p><em>Note: Meeting link will be sent on the day of the interview.</em></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center">
          <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
          <p class="mt-4 px-2">Your response has been successfully recorded. Thank you</p>
        </div>
      </div>
    </div>
  </div>
</div>



<script>
  const currentPath = window.location.pathname.split("/").pop();

  const menuLinks = document.querySelectorAll('.menu-links a');

  menuLinks.forEach(link => {
    const href = link.getAttribute('href');
    const currentPath = window.location.pathname.split('/').pop();

    if ((href === 'adopt.php' && ['adopt.php', 'adopt-know-more.php', 'adopt-now.php'].includes(currentPath)) ||
      href === currentPath) {
      link.classList.add('active');
    }
  });

  const header = document.querySelector("header");
  const hamburgerBtn = document.querySelector("#hamburger-btn");
  const closeMenuBtn = document.querySelector("#close-menu-btn");
  const notifBtn = document.querySelector("#notification");

  hamburgerBtn.addEventListener("click", () => header.classList.toggle("show-mobile-menu"));
  closeMenuBtn.addEventListener("click", () => hamburgerBtn.click());
  notifBtn.addEventListener("click", () => hamburgerBtn.click());

  load_data();

  function load_data(query = '') {
    var form_data = new FormData();
    form_data.append('query', query);

    var ajax_request = new XMLHttpRequest();

    ajax_request.open('POST', 'includes/fetch-notifications.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function() {
      if (ajax_request.readyState == 4 && ajax_request.status == 200) {
        var response = JSON.parse(ajax_request.responseText);

        var html = '';

        if (response.data.length > 0) {
          for (var count = 0; count < response.data.length; count++) {
            var notificationClass = response.data[count].css_class; // 'read' or 'unread'
            html += '<li class="notification-item pt-3 ' + notificationClass + '" data-id="' + response.data[count].notification_id + '">';
            html += '<a href="#">';
            html += '<p>' + response.data[count].message + '</p>';
            html += '</a>';
            html += '</li>';
          }

          // Show the "Clear Notifications" button if there are notifications
          document.getElementById('clearNotificationsBtn').style.display = 'none';
        } else {
          // Add a <li> with a class for styling when there are no notifications
          html += '<li class="no-notifications px-5 py-2 text-muted"> -- No Notifications Yet -- </li>';

          // Hide the "Clear Notifications" button when there are no notifications
          document.getElementById('clearNotificationsBtn').style.display = 'none';
        }


        document.getElementById('post_data').innerHTML = html;
        const unreadBadge = document.querySelector('.notification-item .badge');
        if (unreadBadge) {
          unreadBadge.innerText = response.unread_count;
          unreadBadge.style.display = response.unread_count > 0 ? 'inline-block' : 'none';
        }

        // Add event listeners to open the detail modal on click
        var notificationItems = document.querySelectorAll('.notification-item');
        notificationItems.forEach(function(item) {
          item.addEventListener('click', function() {
            var notificationId = this.getAttribute('data-id');
            $('#notificationModal').modal('hide');
            markAsRead(notificationId);
            showNotificationDetails(notificationId);
          });
        });
      }
    }
  }

  document.getElementById('postAdoptionForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    // Get the form element and initialize FormData
    var postAdoptionForm = document.getElementById('postAdoptionForm');
    var formData = new FormData(postAdoptionForm);

    // Clear previous error messages
    clearErrorMessages();

    // Validate form fields
    let isValid = true;

    const description = document.getElementById('currentDescription');
    const uploadFiles = document.getElementById('uploadFiles');
    const applicationId = document.getElementById('application_id');
    const notificationId = document.getElementById('notification_id');

    // Validate inputs
    isValid = isValid && validateField(description, "This field is required.");
    isValid = isValid && validateFileField(uploadFiles, "Please upload at least one file.");
    isValid = isValid && validateField(applicationId, "Invalid application ID.");
    isValid = isValid && validateField(notificationId, "Invalid notification ID.");

    // Debugging logs
    console.log("Application ID:", applicationId.value);
    console.log("Notification ID:", notificationId.value);

    // If validation passes, submit form via AJAX
    if (isValid) {
        // Append files (already added by FormData due to 'postAdoptionForm')
        for (let i = 0; i < uploadFiles.files.length; i++) {
            formData.append('uploadFiles[]', uploadFiles.files[i]);
        }

        // Debug FormData content
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // AJAX request
        $.ajax({
            url: 'includes/submit-post-adoption.php', // PHP handler
            type: 'POST',
            data: formData,
            processData: false, // Important for FormData
            contentType: false, // Important for FormData
            success: function (response) {
              console.log("Form submitted successfully:", response);
              // Hide the modal and show a success message
             $(`#postAdoptionModal`).modal('hide');
            $('#successModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error('Error:', xhr.responseText);
                showErrorMessage(uploadFiles, 'An unexpected error occurred.');
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

function validateFileField(inputElement, message) {
    if (!inputElement.files.length) {
        showErrorMessage(inputElement, message);
        return false;
    }
    return true;
}

// Show Error Message
function showErrorMessage(inputElement, message) {
    clearSpecificErrorMessage(inputElement);

    const errorMessage = document.createElement('div');
    errorMessage.className = 'error-message text-danger';
    errorMessage.innerText = message;

    inputElement.classList.add('is-invalid');
    inputElement.parentNode.appendChild(errorMessage);
}

// Clear Error Messages
function clearErrorMessages() {
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(msg => msg.remove());
    const invalidInputs = document.querySelectorAll('.is-invalid');
    invalidInputs.forEach(input => input.classList.remove('is-invalid'));
}

// Clear Specific Error Message
function clearSpecificErrorMessage(inputElement) {
    const errorMessage = inputElement.parentNode.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
    inputElement.classList.remove('is-invalid');
}

// Attach event listeners to clear errors dynamically
document.querySelectorAll('input, textarea').forEach(element => {
    element.addEventListener('input', function () {
        clearSpecificErrorMessage(this);
    });

    element.addEventListener('change', function () {
        clearSpecificErrorMessage(this);
    });
});


 

  function showNotificationDetails(notificationId) {
    var form_data = new FormData();
    form_data.append('notification_id', notificationId);

    var ajax_request = new XMLHttpRequest();

    ajax_request.open('POST', 'includes/fetch-notification-details.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function() {
      if (ajax_request.readyState == 4 && ajax_request.status == 200) {
        var response = JSON.parse(ajax_request.responseText);

        if (response.success) {
          var applicationId = response.data.application_id;
          document.getElementById('notificationMessage').innerText = response.data.message;
          document.getElementById('notificationDate').innerText = response.data.created_at;
          document.getElementById('notificationType').innerText = response.data.notification_type;

          // Open specific modal based on notification type
          if (response.data.notification_type === "Application Approved") {
            var myModal2 = new bootstrap.Modal(document.getElementById('adoptionModal'));
            myModal2.show();
            fetchApplicationDetails(applicationId);
          } else if (response.data.notification_type === "Post-Adoption Form Reminder") {
            var myModal3 = new bootstrap.Modal(document.getElementById('postAdoptionModal'));
            document.getElementById('application_id').value = applicationId;
            document.getElementById('notification_id').value = notificationId;
            myModal3.show();
          } else {
            var myModal = new bootstrap.Modal(document.getElementById('notificationDetailModal'));
            myModal.show();
          }
        }
      }
    }
  }

  function fetchApplicationDetails(applicationId) {
    var form_data = new FormData();
    form_data.append('application_id', applicationId);

    var ajax_request = new XMLHttpRequest();

    ajax_request.open('POST', 'includes/fetch-application-details.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function() {
      if (ajax_request.readyState == 4 && ajax_request.status == 200) {
        var response = JSON.parse(ajax_request.responseText);

        if (response.success) {
          document.getElementById('applicationDate').innerText = formatDate(response.data.sched_interview);
          document.getElementById('applicationTime').innerText = formatTime(response.data.sched_interview);


          function formatDate(datetime) {
            var date = new Date(datetime);

            // Array of month names
            var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

            var month = months[date.getMonth()]; // Get the full month name
            var day = date.getDate(); // Get the day of the month
            var year = date.getFullYear(); // Get the full year

            return month + ' ' + day + ', ' + year;
          }

          function formatTime(datetime) {
            var date = new Date(datetime);
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var period = hours >= 12 ? 'PM' : 'AM'; // Determine AM or PM

            // Convert to 12-hour format
            hours = hours % 12;
            hours = hours ? hours : 12; // Convert '0' to '12'
            minutes = minutes < 10 ? '0' + minutes : minutes; // Add leading zero to minutes if needed

            return hours + ':' + minutes + ' ' + period; // Return formatted time
          }

        } else {
          console.log("Error: " + response.message);
        }
      }
    }
  }

  function markAsRead(notificationId) {
    var form_data = new FormData();
    form_data.append('notification_id', notificationId);

    var ajax_request = new XMLHttpRequest();

    ajax_request.open('POST', 'includes/mark-as-read.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function() {
      if (ajax_request.readyState == 4 && ajax_request.status == 200) {
        var response = JSON.parse(ajax_request.responseText);
        if (response.success) {
          var notificationItem = document.querySelector('.notification-item[data-id="' + notificationId + '"]');
          if (notificationItem && notificationItem.classList.contains('unread')) {
            notificationItem.classList.remove('unread');
            notificationItem.classList.add('read');
          }
        } else {
          notificationItem.classList.add('read');
          alert('Failed to mark as read');
        }
      }
    }
  }
</script>
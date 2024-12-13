<header>
  <nav class="navbar">
    <div class="logo"><img src="styles/assets/secaspi-logo.png"><span>iAdopt-SECASPI</span></div>
    <ul class="menu-links">
      <span id="close-menu-btn" class="material-symbols-outlined">Close</span>
      <li><a href="home.php">Home</a></li>
      <li><a href="adopt.php">Adopt</a></li>
      <li><a href="report-stray.php">Report</a></li>
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
        <button type="button" class="btn-close"  data-bs-dismiss="modal" onclick="window.location.reload();" aria-label="Close"></button>
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
        <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal" onclick="window.location.reload();">Close</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal Structure for Post-Adoption
<div class="modal fade" id="postAdoptionModal" tabindex="-1" aria-labelledby="postAdoptionModalLabel" aria-hidden="true">
  <div class="modal-dialog py-4">
    <div class="modal-content">
      <div class="modal-body">
      <section class="form-section">
      <div class="content">
      <h4 class="text-center"><img src="styles/assets/secaspi-logo.png">POST- ADOPTION FORM</h4>
        <form id="signUpForm" action="#!">
        <div class="step">
            <p class="text-center mb-4">Kindly upload the current picture/ video of your adopted pet.</p>
            <div class="mb-3">
                <label>Current situation description:</label>
                  <input type="text" placeholder="Briefly describe the current situation of your pet." name="address1">
            </div>
            <div class="mb-3">
                <label for="placeUploads">Upload video and pictures of the place where dogs/cats will be kept</label>
                <input type="file" id="placeUploads" name="place_uploads[]" accept=".jpg,.jpeg,.png,.mp4,.mov" multiple required>
            </div>
          </div>
        <div class="form-footer d-flex">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
    </form>
      </div>
    </div>
  </section>
      </div>
    </div>
  </div>
</div> -->

<div class="modal fade" id="adoptionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-body d-flex">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
        <!-- Left side: GIF -->
        <div class="row p-5">
          <div class="col-12 col-md-12 col-sm-12 col-lg-6">
            <img src="styles/assets/success.gif" alt="Adoption Approved GIF" style="width:85%; transform: scaleX(-1);">
          </div>
          <!-- Right side: Text content -->
          <div class="col-12 col-md-12 col-sm-12 col-lg-6">
            <h4 class="mt-5 mb-3"><i class="bi bi-check-circle-fill pe-3" style="color: green; font-size:30px"></i>Adoption Application Approved!</h4>
            <p>Congratulations! Your adoption application has been reviewed and you may now proceed to the next step:</p>
            <p><strong>Online Interview</strong></p>
            <p><strong>Date:</strong> September 20, 2024</p>
            <p><strong>Time:</strong> 8pm</p>
            <p><em>Note: Meeting link will be sent on the day of the interview.</em></p>
          </div>
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
    var notificationClass = response.data[count].css_class;  // 'read' or 'unread'
    html += '<li class="notification-item pt-3 ' + notificationClass + '" data-id="' + response.data[count].notification_id + '">';
    html += '<a href="#">';
    html += '<p>' + response.data[count].message + '</p>';
    html += '</a>';
    html += '</li>';
  }

  // Show the "Clear Notifications" button if there are notifications
  document.getElementById('clearNotificationsBtn').style.display = 'block';
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

// Function to clear notifications
function clearNotifications() {
 
  var currentUserId = <?php echo $_SESSION['user_id']; ?>;  // Pass the user_id from PHP to JavaScript
  console.log(currentUserId);
  var form_data = new FormData();
  form_data.append('user_id', currentUserId);  // Append the user_id to FormData

  var ajax_request = new XMLHttpRequest();
  
  ajax_request.open('POST', 'includes/clear-notifications.php');
  ajax_request.send(form_data);

  ajax_request.onreadystatechange = function() {
    if (ajax_request.readyState == 4 && ajax_request.status == 200) {
      var response = JSON.parse(ajax_request.responseText);
      if (response.success) {
        // Optionally reload the notifications
        load_data(); // Reload notifications to reflect the update
      } else {
        alert('Failed to clear notifications');
      }
    }
  };
}

  // Function to show notification details in a new modal
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
          document.getElementById('notificationMessage').innerText = response.data.message;
          document.getElementById('notificationDate').innerText = response.data.created_at;
          document.getElementById('notificationType').innerText = response.data.notification_type;

          // Open the modal
          var myModal = new bootstrap.Modal(document.getElementById('notificationDetailModal'));
          myModal.show();
         
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
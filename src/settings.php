<?php

include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

// Check session and role
if (isset($_SESSION['email']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'head_admin')) {

  // Fetch user details from the database based on email
  $email = $_SESSION['email'];
  $query = "SELECT * FROM users WHERE email = ?";
  $stmt = $db->prepare($query);

  if ($stmt) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
      // Assign the fetched data to variables
      $first_name = $user['first_name'];
      $last_name = $user['last_name'];
      $middle_initial = $user['middle_initial'];
      $birthdate = $user['birthdate'];
      $address = $user['address'];
      $fb_link = $user['fb_link'];
      $contact_num = $user['contact_num'];
    }

    $stmt->close();
  }
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iADOPT | SECASPI</title>
    <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
    <link rel="stylesheet" href="styles/sidebar.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/profile.css">

    <!-- Google Fonts Links For Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="scripts/settings.js"></script>
  </head>

  <body>

    <?php include_once 'components/sidebar.php'; ?>

    <div class="admin-content">
      <section class="profile-section">
        <div class="container rounded bg-white mt-5 mb-5">
          <div class="row">
            <div class="col-md-3 border-right">
              <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                <span class="font-weight-bold">Hi, <?= ucwords(htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name'])) ?>!</span>
                <span>
                <button class="btn edit-button" id="edit-button"><i class="bi bi-pencil-square me-2"></i>Edit Information</button>
                  <button class="btn d-none" id="save-button"><i class="bi bi-save me-2"></i>Save Changes</button>
                </span>
                <span><button id="change-password-button" class="btn"><i class="bi bi-pencil-square me-2"></i>Change Password</button></span>
              </div>
            </div>
            <div class="col-md-9 border-right">
              <div class="p-3 py-5">
                <div class="d-flex align-items-center mb-3">
                  <div class="vertical-line me-3"></div>
                  <h4>MY ACCOUNT</h4>
                </div>
                <div class="row mt-2">
                  <div class="col-md-5"><label class="labels">Last Name</label><input type="text" class="form-control" placeholder="Last Name" value="<?= htmlspecialchars($last_name); ?>"></div>
                  <div class="col-md-6"><label class="labels">First Name</label><input type="text" class="form-control" value="<?= htmlspecialchars($first_name); ?>" placeholder="First Name"></div>
                  <div class="col-md-1"><label class="labels">M.I</label><input type="text" class="form-control" value="<?= htmlspecialchars($middle_initial); ?>" placeholder="Middle Initial"></div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-12"><label class="labels">Birthday</label><input type="date" class="form-control" value="<?= htmlspecialchars($birthdate); ?>"></div>
                  <div class="col-md-6 mt-3"><label class="labels">City/Municipality</label><input type="text" class="form-control" placeholder="enter address line 1" value="<?= htmlspecialchars($address); ?>"></div>
                  <div class="col-md-6 mt-3"><label class="labels">Province</label><input type="text" class="form-control" placeholder="enter address line 2" value="<?= htmlspecialchars($address); ?>"></div>
                  <div class="col-md-12 mt-3"><label class="labels">Facebook Profile Link</label><input type="text" class="form-control" placeholder="" value="<?= htmlspecialchars($fb_link); ?>"></div>
                  <div class="col-md-4 mt-3"><label class="labels">Contact Number</label><input type="text" class="form-control" placeholder="enter phone number" value="<?= htmlspecialchars($contact_num); ?>"></div>
                  <div class="col-md-8 mt-3"><label class="labels">Email</label><input type="text" class="form-control" placeholder="enter email id" value="<?= htmlspecialchars($email); ?>"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

    
    </section>
    </div>
    <!-- Change Password Modal -->
<!-- Modal Structure -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="new-password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new-password" aria-describedby="password-help">
                        <div id="password-help" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="save-password-button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Success Modal Structure -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <!-- Close button on the left -->
        <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
        <!-- Bootstrap check icon and success message -->
        <div class="text-center">
          <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
          <p class="mt-3">Changed successfully!</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Change Password Modal Structure -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form for changing password -->
        <form>
          <div class="mb-3">
            <label for="new-password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="new-password">
            <small id="password-help" class="form-text"></small>
          </div>
          <div class="mb-3">
            <label for="confirm-password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm-password">
          </div>
          <button type="button" id="save-password-button" class="btn btn-primary">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>




  </body>

  </html>
<?php
} else {
  header("Location: home.php");
}
?>
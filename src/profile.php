<?php

include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

// Check session and role
if (isset($_SESSION['email']) && ($_SESSION['role'] == 'user')) {

  // Fetch user details from the database based on email
  $user_id = $_SESSION['user_id'];
  $query = "SELECT * FROM users WHERE user_id = ?";
  $stmt = $db->prepare($query);

  if ($stmt) {
    $stmt->bind_param('i', $user_id);
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
      $email = $user['email'];
    }
  ;

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
    <link rel="stylesheet" href="styles/topnavbar.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="stylesheet" href="styles/settings.css">

    <!-- Google Fonts Links For Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
         <script src="scripts/settings.js"></script>
  </head>
  <body>

   <?php include_once 'components/topnavbar.php'; ?>

   <div class="admin-content"  style="margin-left: 0 !important;">
      <section class="profile-section">
        <div class="container rounded bg-white mt-5 mb-5">
         
          <div class="row">
            
            <div class="col-md-12 border-right">
              <div class="p-3 py-5">
                <form action="includes/update-profile.php" method="POST" enctype="multipart/form-data">
                      <div class="d-flex align-items-center mb-3">
                          <div class="vertical-line me-3"></div>
                          <h4>MY ACCOUNT</h4>
                      </div>
                      <div class="row mt-2">
                          <div class="col-md-5">
                              <label class="labels">Last Name</label>
                              <input type="text" class="form-control" id="last-name" name="last_name" placeholder="Last Name" value="<?= htmlspecialchars($last_name); ?>">
                              <div class="invalid-feedback d-none">Please enter a valid name. Only letters, spaces, hyphens, and apostrophes are allowed.</div>
                          </div>
                          <div class="col-md-6">
                              <label class="labels">First Name</label>
                              <input type="text" class="form-control" id="first-name"  name="first_name" value="<?= htmlspecialchars($first_name); ?>" placeholder="First Name">
                              <div class="invalid-feedback d-none">Please enter a valid name. Only letters, spaces, hyphens, and apostrophes are allowed.</div>
                          </div>
                          <div class="col-md-1">
                              <label class="labels">M.I</label>
                              <input type="text" class="form-control" id="middle-initial"  name="middle_initial" value="<?= htmlspecialchars($middle_initial); ?>" placeholder="Middle Initial">
                              <div class="invalid-feedback d-none"></div>
                          </div>
                      </div>
                      <div class="row mt-3">
                          <div class="col-md-12">
                              <label class="labels">Email</label>
                              <input type="email" class="form-control" id="email" name="email" placeholder="Enter email id" value="<?= htmlspecialchars($email); ?>" required>
                              <div class="invalid-feedback d-none"></div>
                            </div>
                          <div class="col-md-2 mt-3">
                              <label class="labels">Birthday</label>
                              <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?= htmlspecialchars($birthdate); ?>">
                          </div>
                          <div class="col-md-4 mt-3">
                              <label class="labels">Contact Number</label>
                              <input type="text" class="form-control" id="contact-number" name="contact_num" minlength="11" maxlength="11"  placeholder="Enter phone number" value="<?= htmlspecialchars($contact_num); ?>"  pattern="^[0-9]{11}$" inputmode="numeric" >
                              <div class="invalid-feedback">Please enter a valid contact number (11 digits).</div>
                          </div>
                          <div class="col-md-6 mt-3">
                              <label class="labels">Facebook Profile Link</label>
                              <input type="text" class="form-control" name="fb_link" placeholder="Facebook Link" value="<?= htmlspecialchars($fb_link); ?>">
                          </div>
                      </div>

                  </form>
               <!-- buttons -->
              
               <div class="d-flex justify-content-end align-items-end text-center mt-5">
                <span>
                  <button id="change-password-button" class="btn me-2"><i class="bi bi-pencil-square me-2"></i>Change Password</button> 
                </span>
                <span>
                <button class="btn edit-button" id="edit-button"><i class="bi bi-pencil-square me-2"></i>Edit Information</button>
                  <button class="btn d-none" id="save-button"><i class="bi bi-save me-2"></i>Save Changes</button>
                  
                </span>
               </div> 
            
               <!-- buttons end-->
              </div>
             
            </div>
          </div>
          
        </div>
        
    
    </section>
    </div>
    
    <!-- Verify Password Modal -->
      <div class="modal fade" id="verifyPasswordModal" tabindex="-1" aria-labelledby="verifyPasswordModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="verifyPasswordModalLabel">Verify Password</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <form>
                          <div class="mb-3">
                              <label for="current-password" class="form-label">Current Password</label>
                              <input type="password" class="form-control" id="current-password">
                          </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" id="verify-password-button" class="btn btn-primary">Verify</button>
                  </div>
              </div>
          </div>
      </div>


    <!-- Change Password Modal -->
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

     


        
        <!-- Success Modal Structure  without Timer-->
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

        <!-- Success Modal Structure  with Timer -->
        <div class="modal fade" id="successModal2" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-body">
                <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center">
                  <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                  <p class="mt-3">Changed successfully!</p>
                  <p id="logoutTimer">You will be logged out in 5 seconds...</p>
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

   
   <?php include_once 'components/footer.php'; ?>

</body>
</html>

<?php
} else {
    header("Location: home.php");
}
?>
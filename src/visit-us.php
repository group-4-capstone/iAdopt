<?php include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'head_admin')) {

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
    <link rel="stylesheet" href="styles/visit.css">
    <link rel="stylesheet" href="styles/adopt.css">

    <!-- Google Fonts Links For Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>

  <body>

    <?php include_once 'components/topnavbar.php'; ?>

    <section class="user-banner-section">
      <div class="content">
        <h2>Visit the Shelter</h2>
        <h4>Get to visit the SECASPI.</h4>
        <p>
          Schedule your visit and see the exact address of the shelter for you to easily find!
        </p>
      </div>
    </section>

    <section class="map-section">
      <div class="content">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2934.468720201099!2d121.0928155412557!3d14.190819482137053!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd63bf9006e371%3A0x4fb03f5ad32d6acd!2sSECASPI%20(Second%20Chance%20Aspin%20Shelter%20Philippines)!5e0!3m2!1sen!2sph!4v1725117849467!5m2!1sen!2sph"
          width="100%" height="600px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <i class="bi bi-pin-map-fill"></i>
        <h2>#428 Purok 7, Tibagan Road, Majada, Calamba, Laguna</h2>
      </div>
    </section>


    <!-- Success Modal -->
    <div class="modal fade" id="successVisitModal" tabindex="-1" aria-labelledby="successVisitModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="btn-close d-flex ms-auto" onclick="window.location.href='visit-us.php'"></button>
            <div class="text-center">
              <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
              <p class="mt-4 px-2">Your visit form has been successfully submitted. Thank you.</p>
            </div>
          </div>
        </div>
      </div>
    </div>


    <section class="form-section pb-5">
      <div class="content">
        <h4></h4>
        <?php
        $isDisabled = !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true ? 'disabled' : '';
        ?>
        <form id="visitForm" method="post">
          <div class="step">
            <h4 class="text-center"><img src="styles/assets/secaspi-logo.png">Visit Form</h4>
            <p class="text-center mb-4">Kindly fill out this form if you will visit the shelter.</p>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="visit_date" class="mb-1">Date of Visit<span class="asterisk"> *</span></label>
                <input type="date" class="form-control" id="visit_date" name="visit_date" <?php echo $isDisabled; ?>>
              </div>
              <div class="col-md-6">
                <label for="visit_time" class="mb-1">Time of Visit<span class="asterisk"> *</span></label>
                <select id="visit_time" name="visit_time" class="form-control" <?php echo $isDisabled; ?>>
                  <option value="" selected disabled>-- Kindly select visit time --</option>
                  <option value="10:00:00">10:00 AM</option>
                  <option value="11:00:00">11:00 AM</option>
                  <option value="12:00:00">12:00 PM</option>
                  <option value="13:00:00">1:00 PM</option>
                  <option value="14:00:00">2:00 PM</option>
                  <option value="15:00:00">3:00 PM</option>
                  <option value="16:00:00">4:00 PM</option>
                  <option value="17:00:00">5:00 PM</option>
                </select>
              </div>
            </div>

            <input type="hidden" id="visitDateTime" name="visitDateTime">
            <div class="mb-3">
              <label>Name/s<span class="asterisk"> *</span></label>
              <input type="text" placeholder="e.g Juan Dela Cruz" name="names" <?php echo $isDisabled; ?>>
            </div>
            <div class="mb-3">
              <label>Group Name<span class="asterisk"> *</span></label>
              <input type="text" name="group_name" placeholder="e.g. ABC Students" <?php echo $isDisabled; ?>>
            </div>
            <div class="row">
              <div class="col-lg-2 col-12 mb-3">
                <label>No. of Pax<span class="asterisk"> *</span></label>
                <input type="number" name="pax" id="pax" placeholder="Number of Visitors" min="0" <?php echo $isDisabled; ?>>
              </div>
              <div class="col-lg-10 col-12 mb-4">
                <label>Purpose<span class="asterisk"> *</span></label>
                <input type="text" name="purpose" placeholder="Indicate your purpose of visit." <?php echo $isDisabled; ?>>
              </div>
            </div>
          </div>

          <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { ?>
            <div class="mb-3">
              <i>Note: You must be <a href="login.php"> logged into your account </a> to schedule a visit. Thank you.</i>
            </div>
          <?php } ?>

          <div class="form-footer d-flex">
            <button type="button" id="submitVisitBtn" class="ms-auto mt-2" <?php echo $isDisabled; ?>>Submit</button>
          </div>
        </form>
      </div>
    </section>



    <section class="grid-section">
      <div class="content">
        <h2>Second Chance Aspin Shelter Philippines</h2>
        <p>Take a sneak peek of the shelter!</p>
        <div class="row">
          <div class="col-lg-6 d-flex">
            <img src="styles/assets/aspin-1.png" class="img-fluid w-100" alt="Aspin 1">
          </div>
          <div class="col-lg-3 d-flex flex-column">
            <div class="row mb-3 flex-grow-1">
              <div class="col-12">
                <img src="styles/assets/aspin-2.png" class="img-fluid w-100 h-100" alt="Aspin 2">
              </div>
            </div>
            <div class="row flex-grow-1">
              <div class="col-12">
                <img src="styles/assets/aspin-1.png" class="img-fluid w-100 h-100" alt="Aspin 1">
              </div>
            </div>
          </div>
          <div class="col-lg-3 d-flex flex-column">
            <div class="row mb-3 flex-grow-1">
              <div class="col-12">
                <img src="styles/assets/puspin.jpg" class="img-fluid w-100 h-100" alt="Puspin">
              </div>
            </div>
            <div class="row flex-grow-1">
              <div class="col-12">
                <img src="styles/assets/aspin-2.png" class="img-fluid w-100 h-100" alt="Aspin 2">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <script src="scripts/form.js"></script>
    <script src="scripts/visit-us.js"></script>

    <?php include_once 'components/footer.php'; ?>

  </body>

  </html>

<?php
} else {
  header("Location: home.php");
}
?>
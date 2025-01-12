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
    <link rel="stylesheet" href="styles/report.css">

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
        <h2>Report Animal Abuse</h2>
        <h4>Every Report Can Save a Life</h4>
        <p>By notifying us when an animal is in danger, you play a vital role in protecting them and offering a chance at a better life.
        We collaborate with trusted organizations, including the <b>Animal Welfare Society</b>, <b>Animal Kingdom Foundation</b>, and <b>CARA Welfare Philippines</b>, to forward cases and provide timely assistance for animals in need. </p>
      </div>
    </section>

    <section class="form-section pb-5">
      <div class="content">
        <h4><img src="styles/assets/secaspi-logo.png">Report Animal Abuse Form</h4>
        <?php
        $isDisabled = !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true ? 'disabled' : '';
        ?>
        <form id="rescueForm" method="post" class="mx-lg-5">
          <div class="step p-2">
            <h5 class="text-center">Report Details</h5>
            <p class="text-center mb-4">Kindly supply the following details of the dog/cat you want to be rescued.</p>

            <div class="mb-3">
              <label for="animalType">Type of Animal: <span class="asterisk"> *</span></label>
              <select id="animalType" name="type" class="form-select" <?php echo $isDisabled; ?>>
                <option value="" disabled selected>Select the type of animal</option>
                <option value="Dog">Dog</option>
                <option value="Cat">Cat</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="mb-3">Current location of the animal:</label>
              <div class="row">
                <div class="col-sm-12 col-lg-6 mb-3">
                  <label>Region<span class="asterisk"> *</span></label>
                  <select name="region" id="region" <?php echo $isDisabled; ?> required></select>
                  <input type="hidden" class="form-control form-control-md" name="region" id="region-text" required>
                </div>
                <div class="col-sm-6 mb-3">
                  <label>Province<span class="asterisk"> *</span></label>
                  <select name="province" id="province" required <?php echo $isDisabled; ?>></select>
                  <input type="hidden" class="form-control form-control-md" name="province" id="province-text" required>
                </div>
                <div class="col-sm-6 mb-3">
                  <label>City / Municipality<span class="asterisk"> *</span></label>
                  <select name="city" id="city" required <?php echo $isDisabled; ?>></select>
                  <input type="hidden" class="form-control form-control-md" name="municipality" id="city-text">
                </div>
                <div class="col-sm-6 mb-3">
                  <label>Barangay<span class="asterisk"> *</span></label>
                  <select name="barangay" id="barangay" required <?php echo $isDisabled; ?>></select>
                  <input type="hidden" class="form-control form-control-md" name="barangay" id="barangay-text">
                </div>
                <div class="col-lg-12 mb-3">
                  <label for="street-text">Street, Subdivision/Village<span class="asterisk"> *</span></label>
                  <input type="text" class="form-control form-control-md" name="specific" <?php echo $isDisabled; ?> id="street-text" required>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label>Rescue Report Details: <span class="asterisk"> *</span></label>
              <input type="text" name="rescue_description" placeholder="Input details regarding the rescue of the animal" <?php echo $isDisabled; ?>>
            </div>

            <div class="mb-4">
              <label for="placeUploads">Upload video or pictures of the dog/cat that will be rescued: <span class="asterisk"> *</span></label>
              <input type="file" id="placeUploads" name="animal_image" accept=".jpg,.jpeg,.png,.mp4,.mov" <?php echo $isDisabled; ?>>
            </div>
          </div>

          <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { ?>
            <div class="mb-3">
              <small class="text-muted fst-italic">
                Note: You must be <a href="login.php">logged into your account</a> to submit a rescue report. Please log in to continue.
              </small>
            </div>
          <?php } ?>

          <div class="form-footer d-flex">
            <button type="submit" id="submitVisitBtn" class="ms-auto mt-2" <?php echo $isDisabled; ?>>Submit</button>
          </div>
        </form>
      </div>
    </section>

    <!-- Success Modal -->
    <div class="modal fade" id="successRescueModal" tabindex="-1" aria-labelledby="successRescueModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="btn-close d-flex ms-auto" onclick="window.location.href='report.php'"></button>
            <div class="text-center">
              <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
              <p class="mt-4 px-2"> Your rescue report has been submitted successfully! Thank you.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Wrong file type Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="text-center">
              <i class="bi bi-exclamation-triangle-fill" style="font-size: 8rem; color: #dc3545;"></i>
              <p class="mt-4 px-2">Invalid file type! Please upload only .jpg, .jpeg, .png, .mp4, or .mov files.</p>
            </div>
          </div>
        </div>
      </div>
    </div>




    <script src="scripts/form.js"></script>
    <script src="scripts/report-stray.js"></script>
    <script src="scripts/ph-address-selector.js"></script>

    <?php include_once 'components/footer.php'; ?>

  </body>

  </html>

<?php
} else {
  header("Location: home.php");
}
?>
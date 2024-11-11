<?php include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';
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
        <h2>Report Stray Animal</h2>
        <h4>Every report can save a life.</h4>
        <p>
        Your report will help get animals the care and safety they need. By letting us know when an animal is in danger, you are
        helping to protect them and give them a chance 
        at a better life.
        </p>
      </div>
    </section>

    <section class="form-section pb-5">
  <div class="content">
    <h4><img src="styles/assets/secaspi-logo.png">Report Stray Form</h4>
    <?php 
      $isDisabled = !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true ? 'disabled' : '';
    ?>
    <form id="rescueForm" method="post">
      <div class="step">
        <h5 class="text-center">Report Details</h5>
        <p class="text-center mb-4">Kindly supply the following details of the dog/cat you want to be rescued.</p>

        <div class="mb-3">
          <label for="animalType">Type of Animal:</label>
          <select id="animalType" name="type" class="form-select" <?php echo $isDisabled; ?>>
            <option value="" disabled selected>Select the type of animal</option>
            <option value="Dog">Dog</option>
            <option value="Cat">Cat</option>
          </select>
        </div>

        <div class="mb-3">
          <label>Current location of the animal:</label>
          <div class="row">
            <div class="col-lg-3 col-12 col-sm-12">
              <input type="text" placeholder="Gumamela Village" name="specific" <?php echo $isDisabled; ?>>
            </div>
            <div class="col-lg-3 col-12 col-sm-12">
              <input type="text" placeholder="Brgy. Malitlit" name="barangay" <?php echo $isDisabled; ?>>
            </div>
            <div class="col-lg-3 col-12 col-sm-12">
              <input type="text" placeholder="Calamba" name="municipality" <?php echo $isDisabled; ?>>
            </div>
            <div class="col-lg-3 col-12 col-sm-12">
              <input type="text" placeholder="Laguna" name="province" <?php echo $isDisabled; ?>>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label>Rescue Report Details:</label>
          <input type="text" name="rescue_description" placeholder="Input details regarding the rescue of the animal" <?php echo $isDisabled; ?>>
        </div>

        <div class="mb-4">
          <label for="placeUploads">Upload video or pictures of the dog/cat that will be rescued:</label>
          <input type="file" id="placeUploads" name="animal_image" accept=".jpg,.jpeg,.png,.mp4,.mov" <?php echo $isDisabled; ?>>
        </div>
      </div>

      <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { ?>
        <div class="mb-3">
          <i>Note: You must be <a href="login.php"> logged into your account </a> submit a rescue report. Please log in to continue.</i>
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
        <button type="button" class="btn-close d-flex ms-auto" onclick="window.location.href='report-stray.php'"></button>
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
   
   <?php include_once 'components/footer.php'; ?>

</body>
</html>
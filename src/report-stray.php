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
    <link rel="stylesheet" href="styles/adopt.css">

    <!-- Google Fonts Links For Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        <form id="signUpForm" action="#!">

        <!-- Step one -->
        <div class="step">
        <h5 class="text-center">Report Details</h5>
            <p class="text-center mb-4">Kindly supply the following details of the dog/cat you wanted to be rescued.</p>
            <div class="mb-3">
                <label>Current location of dog/cat:</label>
                <div class="row">
                    <div class="col-lg-3 col-12 col-sm-12">
                        <input type="text" placeholder="Blk 12 L7 San Lorenzo Ph 1C" name="address1">
                    </div>
                    <div class="col-lg-3 col-12 col-sm-12">
                        <input type="text" placeholder="Brgy. Malitlit" name="address2">
                    </div>
                    <div class="col-lg-3 col-12 col-sm-12">
                        <input type="text"  placeholder="Calamba" name="address3">
                    </div>
                    <div class="col-lg-3 col-12 col-sm-12">
                        <input type="text"  placeholder="Laguna" name="address4">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label>Characteristics of the animal to rescue:</label>
                <input type="text" name="facebook" placeholder=" Input characteristics of the animal ">
            </div>
            <div class="mb-3">
                <label>Other Details:</label>
                <input type="text" name="facebook" placeholder="Input other details regarding for the rescue of the animal">
            </div>
            <div class="mb-3">
                <label for="placeUploads">Upload video or pictures of the dog/cat that will be rescued:</label>
                <input type="file" id="placeUploads" name="place_uploads[]" accept=".jpg,.jpeg,.png,.mp4,.mov" multiple required>
            </div>
        </div>


        <!-- Form Footer: Previous/Next buttons -->
        <div class="form-footer d-flex">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
    </form>
      </div>
    </div>
  </section>

  <script src="scripts/adoption-form.js"></script>
   
   <?php include_once 'components/footer.php'; ?>

</body>
</html>
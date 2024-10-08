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
        <h2>Visit the Shelter</h2>
        <h4>Get to visit the SECASPI.</h4>
          <p>
           Here is the exact address of the shelter for you to easily find and visit us!
          </p>
      </div>
    </section>

    <section class="map-section">
      <div class="content">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2934.468720201099!2d121.0928155412557!3d14.190819482137053!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd63bf9006e371%3A0x4fb03f5ad32d6acd!2sSECASPI%20(Second%20Chance%20Aspin%20Shelter%20Philippines)!5e0!3m2!1sen!2sph!4v1725117849467!5m2!1sen!2sph" 
          width="100%" height="600px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          <i class="bi bi-pin-map-fill"></i><h2>#428 Purok 7, Tibagan Road, Majada, Calamba, Laguna</h2>
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



   
   <?php include_once 'components/footer.php'; ?>

</body>
</html>
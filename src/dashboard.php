<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iADOPT | SECASPI</title>
    <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
    <link rel="stylesheet" href="styles/sidebar.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/dashboard.css">

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
    <?php include_once 'components/sidebar.php'; ?>

    <!-- Admin content -->
    <div class="admin-content">
      <div class="welcome-section">
        <div class="welcome-title">
          <h1>Hi! ADMIN <img src="styles/assets/paw.png" alt="paw"></h1>
        </div>
        <p>Bring joy and love into your life by adopting a furry friend. Explore our <br> wide selection of lovable pets ready to find their forever home.</p>
        <img src="styles/assets/dashpin.png" alt="Cute Puppies">
      </div>

      <div class="statistics col-lg-12">
        <h5>Statistics</h5>
        <div class="row mb-3">
        <!-- Existing chart area -->
        <div class="d-flex flex-column position-relative min-vh-10">
          <div class="mt-auto mb-3 me-3 text-end">
            <div class="dropdown">
              <button class="months-btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Monthly
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#">Option 1</a></li>
                <li><a class="dropdown-item" href="#">Option 2</a></li>
                <li><a class="dropdown-item" href="#">Option 3</a></li>
              </ul>
            </div>
          </div>
          <!-- Canvas for chart -->
          <canvas id="barChart" width="800" height="300"></canvas>
        </div>
      </div>

      <div class="row">
        <!-- Current Animals Box -->
        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="stat-box p-4">
              <h6>Statistics</h6>
              <h3>Current Animals</h3>
              <br>
              <h2 class="display-4">75</h2>
            </div>
          </div>
          <!-- For Adoption Box -->
          <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="stat-box p-4">
              <h6>Statistics</h6>
              <h3>For Adoption</h3>
              <br>
              <h2 class="display-4">32</h2>
              <!--<img src="styles/assets/aspin-dash2.png" alt="Dog Image" class="img-fluid">-->
            </div>
          </div>
        </div>
        <!-- Image Box Buttons -->
        <div class="row">
          <!-- Rescue Records -->
          <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <a href="rescue-records.php" class="text-decoration-none">
                <div class="img-box p-4">
                    <img src="styles/assets/rescue-records-button.png" alt="Rescue Icon" class="img-fluid">
                    <h3>Rescue Records</h3>
                    <br>
                    <p>Bring joy and love into your life by adopting a furry friend. Explore our wide selection.</p>
                </div>
            </a>
          </div>
          <!-- Adoption Records -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <a href="adoption-records.php" class="text-decoration-none">
                    <div class="img-box p-4">
                        <img src="styles/assets/adoption-records-button.png" alt="Adoption Icon" class="img-fluid">
                        <h3>Adoption Records</h3>
                        <br>
                        <p>Selection of lovable pets ready to find their forever home.</p>
                    </div>
                </a>
            </div>
          <!-- Manage Profiles -->
          <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <a href="manage-profile.php" class="text-decoration-none">
              <div class="img-box p-4">
                <img src="styles/assets/manage-profile.png" alt="Manage Profiles Icon" class="img-fluid">
                <h3>Manage Profiles</h3>
                <br>
                <p>Selection of lovable pets ready to find their forever home.</p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts/dashboard.js"></script>
  </body>
</html>
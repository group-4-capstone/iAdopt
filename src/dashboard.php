<?php include_once 'includes/session-handler.php'; 
include_once 'includes/db-connect.php';


// Check session and role
if (isset($_SESSION['email']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'head_admin')) {
  


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
  <link rel="stylesheet" href="styles/dashboard.css">

  <!-- Google Fonts Links For Icon -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- Bootstrap Icons-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <!-- JS CDN-->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@latest"></script>
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
      <!-- Existing chart area -->
      <div class="row mb-3">
        <!-- Existing chart area -->
        <div class="d-flex flex-column position-relative min-vh-10">
          <div class="mt-auto mb-3 me-3 text-end">
            <div class="dropdown">
              <button class="months-btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Monthly
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#">Quarterly</a></li>
                <li><a class="dropdown-item" href="#">Yearly</a></li>
              </ul>
            </div>
          </div>
          <!-- Canvas for chart -->
          <canvas id="barChart" width="800" height="300"></canvas>
        </div>
      </div>
    </div>
    <!-- Statistics Section -->
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
    <!-- Donations Overview Section -->
    <div class="donations-overview">
      <h2>Donations Overview</h2>
      <div class="row">
        <!-- Donation Stat Boxes -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <div class="donate-stat-box p-4 d-flex align-items-center">
            <img src="styles/assets/balance.png" alt="Icon" class="donate-stat-icon me-3">
            <div class="stat-content">
              <p class="mb-0 balance-text">Balance</p>
              <h3 class="mb-0">₱ 41,210</h3>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <div class="donate-stat-box p-4 d-flex align-items-center">
            <img src="styles/assets/donation.png" alt="Icon" class="donate-stat-icon">
            <div class="stat-content">
              <p class="mb-0 balance-text">Donations</p>
              <h3 class="mb-0">₱ 41,210</h3>

            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <div class="donate-stat-box p-4">
            <img src="styles/assets/expenses.png" alt="Icon" class="donate-stat-icon">
            <div class="stat-content">
              <p class="mb-0 balance-text">Expenses</p>
              <h3 class="mb-0">₱ 41,210</h3>

            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <div class="donate-stat-box p-4">
            <img src="styles/assets/overall.png" alt="Icon" class="donate-stat-icon">
            <div class="stat-content">
              <p class="mb-0 balance-text">Overall Donation</p>
              <h3 class="mb-0">₱ 41,210</h3>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="chart-container">
    <div class="dropdown" style="display: flex; justify-content: flex-end;">
    <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        Monthly
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li><a class="dropdown-item" href="#">Monthly</a></li>
        <li><a class="dropdown-item" href="#">Quarterly</a></li>
        <li><a class="dropdown-item" href="#">Yearly</a></li>
    </ul>
</div>

      <!-- Donations Chart -->
      <div class="donationchart">
          <canvas id="donationChart" width="800" height="300"></canvas>
          <button class="btn-liquidation-report">Generate Liquidation Report</button>
      </div>
    </div>
    <!-- FAQ Section with Dog Image -->

    <div class="wave-container"></div>
      <div class="faq-section">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12">
            <img src="styles/assets/faqdog.png" alt="Dog Image" class="faq-dog-image">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 faq-content">
            <h2>Frequently Asked Questions</h2>
            <p>Bring joy and love into your life by adopting a furry friend. Explore our wide selection of pets ready to find their forever home.</p>
            <a href="faq.php" class="btn btn-primary">Read More</a>
          </div>
        </div>
      </div>



  </div>

  <!-- JS Files -->
  
  <script src="scripts/dashboard.js"></script>
 

</body>

</html>

<?php
} else {
    header("Location: login.php");
}
?>
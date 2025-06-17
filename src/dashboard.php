<?php include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

// Check session and role
if (isset($_SESSION['email']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'head_admin')) {

  // Query to count animals excluding 'waitlist' and 'rest' statuses
  $current_sql = "SELECT COUNT(*) AS current_count FROM animals WHERE animal_status NOT IN ('waitlist', 'rest', 'adopted', 'denied')";
  $current_result = $db->query($current_sql);
  $current_count = ($current_result->num_rows > 0) ? $current_result->fetch_assoc()['current_count'] : 0;

  // Query to count animals marked as 'Adoptable'
  $adoption_sql = "SELECT COUNT(*) AS adoption_count FROM animals WHERE animal_status = 'Adoptable'";
  $adoption_result = $db->query($adoption_sql);
  $adoption_count = ($adoption_result->num_rows > 0) ? $adoption_result->fetch_assoc()['adoption_count'] : 0;

  // Query to calculate the donation balance
  $sql_donations = "SELECT SUM(amount) as total_donations FROM liquidation WHERE type = 'Donation'";
  $sql_expenses = "SELECT SUM(amount) as total_expenses FROM liquidation WHERE type = 'Expense'";

  $result_donations = $db->query($sql_donations);
  $result_expenses = $db->query($sql_expenses);

  // Initialize balance
  $total_donations = 0;
  $total_expenses = 0;

  // Fetch donation total
  if ($result_donations->num_rows > 0) {
    $row = $result_donations->fetch_assoc();
    $total_donations = $row['total_donations'] ?? 0;
  }

  // Fetch expense total
  if ($result_expenses->num_rows > 0) {
    $row = $result_expenses->fetch_assoc();
    $total_expenses = $row['total_expenses'] ?? 0;
  }

  // Calculate the balance
  $donation_balance = $total_donations - $total_expenses;

?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iADOPT | Dashboard</title>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

  </head>

  <body>
    <?php include_once 'components/sidebar.php'; ?>

    <!-- Admin content -->
    <div class="admin-content">
      <div class="row px-4">
        <!-- Chart Section -->
        <div class="statistics col-lg-9 mb-4">
          <h5>Adoption Statistics</h5>
          <div class="d-flex flex-column position-relative min-vh-10">
            <div class="mt-auto mb-3 me-3 text-end">
              <div class="dropdown">
                <button class="months-btn dropdown-toggle" type="button" id="dropdownAdoptionButton" data-bs-toggle="dropdown" aria-expanded="false">
                  Monthly
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownAdoptionButton">
                  <li><a class="dropdown-item adoption" href="#" data-period="monthly">Monthly</a></li>
                  <li><a class="dropdown-item adoption" href="#" data-period="quarterly">Quarterly</a></li>
                  <li><a class="dropdown-item adoption" href="#" data-period="yearly">Yearly</a></li>
                </ul>
              </div>
            </div>
            <!-- Canvas for chart -->
            <canvas id="barChart" width="800" height="280"></canvas>
          </div>
        </div>

        <!-- Statistics Section -->
        <div class="col-lg-3">
          <div class="row">
            <!-- Current Animals Box -->
            <div class="col-md-12 mb-4">
              <div class="stat-box p-4 bg-light border rounded">
                <h6>Statistics</h6>
                <h3>Current Animals</h3>
                <br>
                <h2 class="display-4"><?php echo $current_count; ?></h2>
              </div>
            </div>
            <!-- For Adoption Box -->
            <div class="col-md-12 mb-4">
              <div class="stat-box p-4 bg-light border rounded">
                <h6>Statistics</h6>
                <h3>Adoptable Animals</h3>
                <br>
                <h2 class="display-4"><?php echo $adoption_count; ?></h2>
              </div>
            </div>
          </div>
        </div>
        <!-- Donations Overview Section -->
        <?php

        ?>
        <div class="donations-overview px-4">
          <h2>Donations Overview</h2>
          <div class="row">
            <!-- Stats and Chart Side by Side -->
            <div class="col-lg-3 my-3">
              <!-- Donation Stat Boxes -->

              <div class="donate-stat-box p-4 d-flex align-items-center mb-4">
                <img src="styles/assets/donation.png" alt="Icon" class="donate-stat-icon me-3">
                <div class="stat-content">
                  <p class="mb-0 balance-text">Donations</p>
                  <h3 class="mb-0">₱ <?php echo number_format($total_donations, 2); ?></h3>
                </div>
              </div>

              <div class="donate-stat-box p-4 d-flex align-items-center mb-4">
                <img src="styles/assets/expenses.png" alt="Icon" class="donate-stat-icon me-3">
                <div class="stat-content">
                  <p class="mb-0 balance-text">Expenses</p>
                  <h3 class="mb-0">₱ <?php echo number_format($total_expenses, 2); ?></h3>
                </div>
              </div>

              <div class="donate-stat-box p-4 d-flex align-items-center mb-4">
                <img src="styles/assets/balance.png" alt="Icon" class="donate-stat-icon me-3">
                <div class="stat-content">
                  <p class="mb-0 balance-text">Balance</p>
                  <h3 class="mb-0">₱ <?php echo number_format($donation_balance, 2); ?></h3>
                </div>
              </div>
            </div>

            <!-- Chart Section -->
            <div class="col-lg-9 d-flex flex-column">
              <div class="chart-container">
                <div class="dropdown d-flex justify-content-end">
                  <button class="months-btn donation-btn dropdown-toggle" type="button" id="dropdownLiquidationButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Monthly
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownLiquidationButton">
                    <li><a class="dropdown-item liquidation" href="#" data-period="monthly">Monthly</a></li>
                    <li><a class="dropdown-item liquidation" href="#" data-period="quarterly">Quarterly</a></li>
                    <li><a class="dropdown-item liquidation" href="#" data-period="yearly">Yearly</a></li>
                  </ul>
                </div>

                <!-- Donations Chart -->
                <div class="donationchart mb-1">
                  <canvas id="lineChart" width="800" height="235"></canvas>
                </div>
              </div>

              <!-- Button to generate the Liquidation Report -->
              <div class="mt-4 d-flex justify-content-end">
                <button class="btn btn-primary d-flex align-items-center btn-liquidation-report" type="button">
                  <i class="bi bi-download me-2"></i>
                  Generate Monthly Liquidation Report
                </button>
              </div>
            </div>

          </div>
        </div>


      <!-- Image Box Buttons -->
      <div class="row mb-5 px-4">
        <!-- Rescue Records -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
          <a href="rescue-records.php" class="text-decoration-none">
            <div class="img-box p-4">
              <img src="styles/assets/rescue-records-button.png" alt="Rescue Icon" class="img-fluid">
              <h3>Rescue Records</h3>
              <br>
              <p>Track and manage records of rescued animals, ensuring they receive the care they need.</p>
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
              <p>View and manage records of successful adoptions, connecting pets with loving homes.</p>
            </div>
          </a>
        </div>
        <!-- Manage Profiles -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
          <a href="animal-profiles.php" class="text-decoration-none">
            <div class="img-box p-4">
              <img src="styles/assets/manage-profile.png" alt="Manage Profiles Icon" class="img-fluid">
              <h3>Manage Profiles</h3>
              <br>
              <p>Create, edit, and update profiles of animals to ensure accurate information is available.</p>
            </div>
          </a>
        </div>
      </div>


        <!-- FAQ Section with Dog Image -->

        <div class="wave-container px-4"></div>
        <div class="faq-section">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
              <img src="styles/assets/faqdog.png" alt="Dog Image" class="faq-dog-image">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 faq-content">
              <h2>Frequently Asked Questions</h2>
              <p>Bring joy and love into your life by adopting a furry friend. Explore our wide selection of pets ready to find their forever home.</p>
              <a href="adopter-faqs.php" class="btn btn-primary">Read More</a>
            </div>
          </div>
        </div>



      </div>

      <!-- JS Files -->

      <script src="scripts/dashboard.js"></script>
      <script>
        document.querySelector('.btn-liquidation-report').addEventListener('click', function() {
            // Get the current date
            const currentDate = new Date();

            // Get the month and year
            const month = currentDate.toLocaleString('default', { month: 'long' }).toLowerCase(); // e.g., december
            const year = currentDate.getFullYear(); // e.g., 2024

            // Redirect to the desired URL with both month and year
            window.location.href = `liquidation-report.php?month=${month}&year=${year}`;
        });
    </script>

  </body>

  </html>

<?php
} else {
  header("Location: login.php");
}
?>
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
    <link rel="stylesheet" href="styles/donate.css">

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
        <h2>Donation</h2>
        <h4>Make a Donation. For SECASPI.</h4>
        <p>
          Every amount will help. Your donations will help provide food, medical care, and a safe environment for animals
          in need as they await their forever homes.
        </p>
      </div>
    </section>

    <section class="donate-section">
      <div class="content">
        <div class="row pb-5">
          <div class="col-lg-6 col-sm-12 pb-5">
            <img src="styles/assets/donation-details/donate-1.png">
          </div>
          <div class="col-lg-6 col-sm-12">
            <img src="styles/assets/donation-details/donate-2.png">
          </div>
        </div>
        <div class="row pb-3">
          <div class="col-lg-5 col-sm-12 pb-5">
            <img src="styles/assets/donation-details/donate-3.png">
          </div>
          <div class="col-lg-7 col-sm-12">
            <img src="styles/assets/donation-details/donate-4.png">
          </div>
        </div>
        <div class="line"></div>
        <div class="card mt-4 mb-4 p-4">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Expenses Allocation for <?php echo date('F Y', strtotime('first day of last month')); ?></h5>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Allocation</th>
                  <th>Total Amount</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Get the last month and year
                $lastMonth = date('m', strtotime('first day of last month'));
                $lastYear = date('Y', strtotime('first day of last month'));

                // Query to calculate total expenses per allocation for the last month, grouping consistently
                $expenseAllocationQuery = "
                    SELECT LOWER(TRIM(description)) AS allocation, SUM(amount) AS total_amount
                    FROM liquidation
                    WHERE type = 'Expense'
                    AND MONTH(date) = '$lastMonth'
                    AND YEAR(date) = '$lastYear'
                    GROUP BY LOWER(TRIM(description))
                    ORDER BY total_amount DESC
                ";

                // Execute the query
                $expenseAllocationResult = $db->query($expenseAllocationQuery);

                // Initialize total expenses
                $totalExpenses = 0;

                // Check and display results
                if ($expenseAllocationResult->num_rows > 0) {
                  while ($row = $expenseAllocationResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars(ucwords($row['allocation'])) . "</td>";
                    echo "<td>" . number_format($row['total_amount'], 2) . "</td>";
                    echo "</tr>";

                    // Add to total expenses
                    $totalExpenses += $row['total_amount'];
                  }
                } else {
                  echo "<tr><td colspan='2'>No expense records found for last month.</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
          <div class="card-footer text-end">
            <strong>Total Expenses for <?php echo date('F Y', strtotime('first day of last month')); ?>:</strong>
            <?php echo number_format($totalExpenses, 2); ?> PHP
          </div>
        </div>

      </div>
    </section>

    <?php include_once 'components/footer.php'; ?>

  </body>

  </html>

<?php
} else {
  header("Location: home.php");
}
?>
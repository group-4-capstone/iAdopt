<?php include_once 'includes/db-connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iADOPT | SECASPI</title>
    <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
    <link rel="stylesheet" href="styles/sidebar.css">
    <link rel="stylesheet" href="styles/liquidation.css">
    <link rel="stylesheet" href="styles/styles.css">

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

  <?php 
      // Set the number of records per page
      $limit = 10;

      // Get the current page number from the URL, default to page 1 if not set
      $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

      // Calculate the offset for the SQL query
      $offset = ($page - 1) * $limit;

      // Query to get the total number of records
      $sql_total = "SELECT COUNT(*) as total FROM liquidation";
      $result_total = $db->query($sql_total);
      $total_rows = $result_total->fetch_assoc()['total'];

      // Calculate the total number of pages
      $total_pages = ceil($total_rows / $limit);

      // Query to fetch the limited set of data
      $sql = "SELECT * FROM liquidation ORDER BY date DESC LIMIT $limit OFFSET $offset";
      $result = $db->query($sql);
      
      // Query to calculate the donation balance
      $sql_donations = "SELECT SUM(amount) as total_donations FROM liquidation WHERE type = 'donation'";
      $sql_expenses = "SELECT SUM(amount) as total_expenses FROM liquidation WHERE type = 'expense'";

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

   <?php include_once 'components/sidebar.php'; ?>
   
   <div class="admin-content">

    <section class="banner-section">
      <div class="content">
        <div class="head-title">
          <h1><u><b>LIQUIDATION MONITORING</b></u></h1>
        </div>
        <p>
          Efficiently track and manage donations and expenditures, ensuring transparency in the liquidation process.
        </p>
      </div>
    </section>

    <section class="number-section">
      <div class="content">
       <center>
          <p class="pt-4">Donation Balance</p>
          <h1 class="pb-4">₱ <?php echo number_format($donation_balance, 2); ?></h1>
      </center>
          <button class="btn" data-bs-toggle="modal" data-bs-target="#donationModal">Record Donation</button>
          <button class="btn" data-bs-toggle="modal" data-bs-target="#expenseModal">Record Expense</button>
      </div>
    </section>

    <!-- Record Donation Modal -->
<div class="modal fade" id="donationModal" tabindex="-1" aria-labelledby="donationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="donationModalLabel">Record Donation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="donationForm" action="includes/submit-liquidation.php">
          <div class="mb-3">
            <label for="donationAmount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="donationAmount" name="amount" placeholder="Enter amount">
          </div>
          <div class="mb-3">
            <label for="donationPurpose" class="form-label">Purpose</label>
            <input type="text" class="form-control" id="donationPurpose" name="description" placeholder="Enter purpose">
          </div>
          <div class="mb-3">
            <label for="donatorName" class="form-label">Donator</label>
            <input type="text" class="form-control" id="donatorName" name="donator" placeholder="Enter donator's name">
          </div>
          <input type="hidden" name="button_id" value="submitDonation">
          <button type="submit" id="submitDonation" class="btn">Submit Donation</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Record Expense Modal -->
<div class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="expenseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="expenseModalLabel">Record Expense</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="expenseForm">
          <div class="mb-3">
            <label for="expenseAmount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="expenseAmount"name="amount" placeholder="Enter amount">
          </div>
          <div class="mb-3">
            <label for="expensePurpose" class="form-label">Purpose</label>
            <input type="text" class="form-control" id="expensePurpose" name="description" placeholder="Enter purpose">
          </div>
          <input type="hidden" name="button_id" value="submitExpense">
          <button type="submit" id="submitExpense" class="btn">Submit Expense</button>
        </form>
      </div>
    </div>
  </div>
</div>

    <!-- Success Modal -->
    <div class="modal fade" id="successDonationModal" tabindex="-1" aria-labelledby="successDonationModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close d-flex ms-auto" onclick="window.location.href='liquidation-monitoring.php'"></button>
          <div class="text-center">
            <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
            <p class="mt-4 px-2"> <b> Donation </b> amount has been listed!
            </p>
          </div>
        </div>     
      </div>
    </div>
  </div>

     <!-- Success Modal -->
     <div class="modal fade" id="successExpenseModal" tabindex="-1" aria-labelledby="successExpenseModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close d-flex ms-auto" onclick="window.location.href='liquidation-monitoring.php'"></button>
          <div class="text-center">
            <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
            <p class="mt-4 px-2"> <b> Expense </b> amount has been listed!
            </p>
          </div>
        </div>     
      </div>
    </div>
  </div>

  <div class="container">
    <div class="table-responsive mt-4">
        <table id="monitoring" class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Purpose</th>
                    <th>Person Responsible</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['liquidation_id'] . "</td>";
                        echo "<td>" . date('m/d/Y', strtotime($row['date'])) . "</td>";
                        echo "<td><span class='badge text-bg-" . ($row['type'] == 'donation' ? 'success' : 'danger') . "'>" . ucfirst($row['type']) . "</span></td>";
                        echo "<td>" . number_format($row['amount'], 2) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";

                        if ($row['type'] == 'expense') {
                            echo "<td>N/A</td>";
                        } else {
                            echo "<td>" . htmlspecialchars($row['donator']) . "</td>";
                        }

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No data available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&lt;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&gt;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?php
// Close connection
$db->close();
?>

 </div>

 <script src="scripts/liquidation.js"></script>
</body>
</html>
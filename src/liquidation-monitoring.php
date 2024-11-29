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
    <title>iADOPT | Liquidation Monitoring</title>
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
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="donationModalLabel">Record Donation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post" id="donationForm">
            <div class="mb-3 row">
              <div class="col-md-6">
                  <label for="donationAmount" class="form-label">Amount</label>
                  <input type="number" class="form-control" id="donationAmount" name="amount" placeholder="Enter amount" min="0.01" step="0.01">
              </div>
              <div class="col-md-6">
                  <label for="donationMode" class="form-label">Mode of Donation</label>
                  <select class="form-select" id="donationMode" name="mode_of_donation">
                      <option value="" selected disabled>Select a mode</option>
                      <option value="Bank Transfer">Bank Transfer</option>
                      <option value="GCASH">GCASH</option>
                      <option value="Maya">Maya</option>
                      <option value="Cash">Cash</option>
                  </select>
              </div>
          </div>
              <div class="mb-3">
                <label for="donationProof" class="form-label">Proof of Donation</label>
                <input type="file" class="form-control" id="donationProof" name="proof_of_donation" accept=".jpg, .jpeg, .png, .webp">
              </div>
              <input type="hidden" name="button_id" value="submitDonation">
              <button type="button" id="submitDonation" class="btn yellow-btn">Submit Donation</button>
            </form>
          </div>
        </div>
      </div>
    </div>


<!-- Record Expense Modal -->
<div class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="expenseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="expenseModalLabel">Record Expense</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="expenseForm">
          <div class="mb-3">
            <label for="expenseAmount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="expenseAmount"name="amount" placeholder="Enter amount" step="0.01" min="0.01">
          </div>
          <div class="mb-3">
            <label for="expensePurpose" class="form-label">Purpose</label>
            <select class="form-select" id="expensePurpose" name="description" required>
              <option value="" selected disabled>Select a purpose</option>
              <option value="Rent">Rent</option>
              <option value="Salary (Renato Corpuz Jr.)">Salary (Renato Corpuz Jr.)</option>
              <option value="Salary (Monalisa Villar)">Salary (Monalisa Villar)</option>
              <option value="PhilHealth & SSS">PhilHealth & SSS</option>
              <option value="Rental E VAT">Rental E VAT</option>
              <option value="Professional Fee of Filer">Professional Fee of Filer</option>
              <option value="Tricycle Gasoline">Tricycle Gasoline</option>
              <option value="Bus Fare">Bus Fare</option>
              <option value="Van Rental for Dog Food">Van Rental for Dog Food</option>
              <option value="Electric and Water Bill">Electric and Water Bill</option>
              <option value="Dog Food">Dog Food</option>
              <option value="Sawdust, Liver">Sawdust, Liver</option>
              <option value="Honey, Cleaning Materials, Reno, Bar Soap, Powder Soap">
                Honey, Cleaning Materials, Reno, Bar Soap, Powder Soap
              </option>
              <option value="Vinegar">Vinegar</option>
              <option value="Dishwashing Liquid">Dishwashing Liquid</option>
              <option value="Bleach">Bleach</option>
              <option value="Gasul">Gasul</option>
              <option value="BPI Loan for Shelter Transfer">BPI Loan for Shelter Transfer</option>
              <option value="Others">Others</option>
            </select>
          </div>
          <div class="mb-3 d-none" id="otherPurposeWrapper">
            <label for="otherPurpose" class="form-label">Please specify</label>
            <input type="text" class="form-control" id="otherPurpose" name="other_description" placeholder="Enter purpose">
          </div>
          <div class="mb-3">
                <label for="expenseProof" class="form-label">Proof of Expense:</label>
                <input type="file" class="form-control" id="expenseProof" name="proof_of_expense" accept=".jpg, .jpeg, .png, .webp">
           </div>
          <input type="hidden" name="button_id" value="submitExpense">
          <button type="submit" id="submitExpense" class="btn yellow-btn">Submit Expense</button>

        </form>
      </div>
    </div>
  </div>
</div>

  <?php
      $liquidation_query = "SELECT * FROM liquidation";
      $liquidation_result = $db->query($liquidation_query);
      if ($liquidation_result->num_rows > 0) {
        while ($row = $liquidation_result->fetch_assoc()) { ?>

        <div class="modal fade" id="liquidationModal_<?php echo $row['liquidation_id']; ?>" tabindex="-1" aria-labelledby="modalLabel_<?php echo $row['liquidation_id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel_<?php echo $row['liquidation_id']; ?>">Liquidation Details - ID <?php echo $row['liquidation_id']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <table class="table table-bordered">
                          <tbody>
                              <tr>
                                  <th style="width: 25%;">Date</th>
                                  <td style="width: 25%;"><?php echo date('F j, Y', strtotime($row['date'])); ?></td>
                                  <th style="width: 25%;">Type</th>
                                  <td style="width: 25%;"><?php echo $row['type']; ?></td>
                              </tr>
                              <tr>
                                  <th>Amount</th>
                                  <td><?php echo number_format($row['amount'], 2); ?></td>
                                  <th>Mode</th>
                                  <td><?php echo $row['mode'] ?: 'N/A'; ?></td>
                              </tr>
                              <?php if ($row['type'] == "Expense" ) { ?>
                              <tr>
                                  <th>Description</th>
                                  <td colspan="3"><?php echo $row['description'] ?: 'N/A'; ?></td>
                              </tr>
                              <?php } ?>
                              <tr>
                                  <th>Proof</th>
                                  <td colspan="3">
                                      <?php if ($row['proof'] && $row['type'] == "Donation" ) { ?>
                                          <a href="styles/assets/donations/<?php echo $row['proof']; ?>" target="_blank">View</a>
                                      <?php } else { ?>
                                        <a href="styles/assets/expenses/<?php echo $row['proof']; ?>" target="_blank">View</a>
                                      <?php } ?>
                                  </td>
                              </tr>
                              <tr>
                              <?php if ( $row['type'] == "Donation" ) { ?>
                                  <th>Status</th>
                                  <td colspan="3">
                                  <?php 
                                    if ($row['liquidation_status'] === 'For Verification') {
                                        echo '<span class="badge bg-warning text-dark oval-badge">For Verification</span>';
                                    } else if ($row['liquidation_status'] === 'Verified') {
                                        echo '<span class="badge bg-success oval-badge">Verified</span>';
                                        if ($row['last_updated']) {
                                            $date = new DateTime($row['last_updated']);
                                            echo '<br><i><small class="text-muted">Status updated at: ' . $date->format('F j, Y g:i A') . '</small></i>';
                                        }
                                    } else if ($row['liquidation_status'] === 'Invalid') {
                                        echo '<span class="badge bg-danger oval-badge">Invalid</span>';
                                        if ($row['last_updated']) {
                                            $date = new DateTime($row['last_updated']);
                                            echo '<br><i><small class="text-muted">Status updated at: ' . $date->format('F j, Y g:i A') . '</small></i>';
                                        }
                                    }
                                    ?>
                                </td>
                                <?php } ?>
                              </tr>
                          </tbody>
                      </table>
                  </div>
                    <div class="modal-footer">
                    <form id="updateLiquidationForm_<?php echo $row['liquidation_id']; ?>" class="d-flex">
                    <?php if ($_SESSION['role'] == 'head_admin' && $row['type'] == "Donation" && $row['liquidation_status'] == "For Verification") { ?>
                            <input type="hidden" name="liquidation_id" value="<?php echo $row['liquidation_id']; ?>">
                            <button type="button" class="btn btn-success me-2" onclick="updateLiquidationStatus(<?php echo $row['liquidation_id']; ?>, 'approve')">Approve</button>
                            <button type="button" class="btn btn-danger me-2" onclick="updateLiquidationStatus(<?php echo $row['liquidation_id']; ?>, 'reject')">Reject</button>
                        <?php } ?>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    <?php }
} else { ?>
    <p>No liquidation records found.</p>
<?php } ?>


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
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successDonationModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close d-flex ms-auto" onclick="window.location.href='liquidation-monitoring.php'"></button>
          <div class="text-center">
            <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
            <p class="mt-4 px-2"> This donation status has been successfully updated!
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
    <div class="card p-4">
      <div class="table-responsive mt-4">
          <table id="monitoring" class="table table-hover mb-5">
              <thead>
                  <tr>
                      <th width="5%">#</th>
                      <th width="20%">Date</th>
                      <th width="20%">Type</th>
                      <th width="5%">Amount</th>
                      <th width="30%">Purpose</th>
                      <th width="25%">Status</th>
                  </tr>
              </thead>
              <tbody>
                <tbody id="post_data"></tbody>
              </tbody>
          </table>
          <div class="d-flex justify-content-end">
                <div id="pagination_link"></div>
          </div>
      </div>
    </div>
</div>

 </div>

 <script src="scripts/liquidation.js"></script>
 

</body>
</html>
<?php
} else {
    header("Location: login.php");
}
?>
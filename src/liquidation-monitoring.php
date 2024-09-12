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
  </head>
  <body>

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
        <center><p class="pt-4">Donation Balance</p>
        <h1 class="pb-4"> ₱ 3,021.50 </h1></center>
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
        <form>
          <div class="mb-3">
            <label for="donationAmount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="donationAmount" placeholder="Enter amount">
          </div>
          <div class="mb-3">
            <label for="donationPurpose" class="form-label">Purpose</label>
            <input type="text" class="form-control" id="donationPurpose" placeholder="Enter purpose">
          </div>
          <div class="mb-3">
            <label for="donatorName" class="form-label">Donator</label>
            <input type="text" class="form-control" id="donatorName" placeholder="Enter donator's name">
          </div>
          <button type="submit" class="btn">Submit Donation</button>
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
        <form>
          <div class="mb-3">
            <label for="expenseAmount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="expenseAmount" placeholder="Enter amount">
          </div>
          <div class="mb-3">
            <label for="expensePurpose" class="form-label">Purpose</label>
            <input type="text" class="form-control" id="expensePurpose" placeholder="Enter purpose">
          </div>
          <div class="mb-3">
            <label for="responsiblePerson" class="form-label">Person Responsible</label>
            <input type="text" class="form-control" id="responsiblePerson" placeholder="Enter responsible person's name">
          </div>
          <button type="submit" class="btn">Submit Expense</button>
        </form>
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
                    <tr>
                        <td>1</td>
                        <td>09/02/2024</td>
                        <td><span class="badge text-bg-success">Donation</span></td>
                        <td>2000.00</td>
                        <td>For Vet Bills of Andres</td>
                        <td>Olivia Rodrigo</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>09/02/2024</td>
                        <td><span class="badge text-bg-danger">Expense</span></td>
                        <td>2000.00</td>
                        <td>For Vet Bills of Andres</td>
                        <td>Olivia Rodrigo</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>09/02/2024</td>
                        <td><span class="badge text-bg-danger">Expense</span></td>
                        <td>2000.00</td>
                        <td>For Vet Bills of Andres</td>
                        <td>Olivia Rodrigo</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>09/02/2024</td>
                        <td><span class="badge text-bg-success">Donation</span></td>
                        <td>2000.00</td>
                        <td>For Vet Bills of Andres</td>
                        <td>Olivia Rodrigo</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>09/02/2024</td>
                        <td> <span class="badge text-bg-danger">Expense</span></td>
                        <td>2000.00</td>
                        <td>For Vet Bills of Andres</td>
                        <td>Olivia Rodrigo</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&lt;</span>
                    </a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&gt;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

 </div>

</body>
</html>
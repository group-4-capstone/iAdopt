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
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/sidebar.css">
    <link rel="stylesheet" href="styles/history-rest.css">
    <!-- Google Fonts Links For Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

</head>

<body>

    <?php include_once 'components/sidebar.php'; ?>

    <div class="admin-content">

    <section class="banner-section">
      <div class="content">
        <div class="head-title">
          <h1><u><b>AT REST LOG</b></u></h1>
        </div>
            <p>
                 View list of animals that are at peaceful rest .
            </p>
        </div>
    </section>


        <div class="container mt-5">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0" id="rescueTable">
                        <thead>
                            <tr>
                                <th>Date of Rest</th>
                                <th>Name of Pet</th>
                                <th>Date Rescued</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-pet-name="Fluffy" data-rest-date="2024/01/10" data-rescue-date="2024/01/15">
                                <td>2024/01/15</td>
                                <td>Fluffy</td>
                                <td>2024/01/10</td>
                            </tr>
                            <!-- Repeat rows as needed -->
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
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
        </div>
        <br><br>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="informationModal" tabindex="-1" aria-labelledby="informationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content info-card">
                <div class="modal-header">
                    <h5 class="modal-title" id="informationModalLabel">More Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <!-- Pet Picture Section -->
                            <div class="col-md-4 text-center">
                                <img src="styles/assets/aspin-2.png" class="at-rest" alt="Pet Image">
                            </div>

                            <!-- Name of Pet Section -->
                            <div class="col-md-4">
                                <strong>Name of Pet:</strong>
                                <p id="petName">Fluffy</p>
                                <strong>Date of Rest:</strong>
                                <p id="restDate">2024/01/10</p>
                            </div>
                            <br>
                            <br>
                            <br>
                            <!-- Date Rescued Section -->
                            <div class="col-md-4">
                            <br>
                            <br>
                            <br>
                                <strong>Date Rescued:</strong>
                                <p id="rescueDate">2024/01/15</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ok" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get all rows from the table
            const tableRows = document.querySelectorAll("#rescueTable tbody tr");

            // Add click event listener to each row
            tableRows.forEach(row => {
                row.addEventListener("click", function() {
                    // Fetch data from row attributes
                    const petName = this.dataset.petName;
                    const restDate = this.dataset.restDate;
                    const rescueDate = this.dataset.rescueDate;

                    // Populate modal fields with row data
                    document.getElementById('petName').innerText = petName;
                    document.getElementById('restDate').innerText = restDate;
                    document.getElementById('rescueDate').innerText = rescueDate;

                    // Show the modal
                    const informationModal = new bootstrap.Modal(document.getElementById('informationModal'));
                    informationModal.show();
                });
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>

</html>

<?php
} else {
  header("Location: login.php");
}
?>
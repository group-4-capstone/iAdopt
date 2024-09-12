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
    <link rel="stylesheet" href="styles/visitor-log.css">
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
          <h1><u><b>VISITOR LOG</b></u></h1>
        </div>
            <p>
                    View list of visitors that came by to see the shelter.
            </p>
        </div>
    </section>

        <div class="container mt-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center ms-auto">
                        <button class="btn btn-add d-flex align-items-center" id="addRecordButton">
                            <span class="badge text-bg-success"><i class="bi bi-plus me-1"></i><span>Add</span></span>
                        </button>
                        <button class="btn btn-delete d-flex align-items-center">
                            <span class="badge text-bg-danger"><i class="bi bi-trash-fill me-1"></i><span>Delete</span></span>
                        </button>
                        <button class="btn btn-sort d-flex align-items-center" style="white-space: nowrap;">
                            <span class="badge text-bg-secondary"> <i class="bi bi-arrow-down-up me-1"></i><span>Sort By</span></span>
                        </button>

                        <div class="input-group input-group-md">
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-text search-icon"><i class="bi bi-search"></i></span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table table-hover mb-0" id="visitorTable">
                        <thead>
                            <tr>
                                <th>Name of Pet</th>
                                <th>Date of Visit</th>
                                <th>Purpose</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-visitor-name="Juan Bartolome" data-visit-date="2023/12/13" data-purpose="If the world was ending I'd wanna be next to you If the party ...">
                                <td>Juan Bartolome</td>
                                <td>2023/12/13</td>
                                <td>If the world was ending I'd wanna be next to you If the party ...</td>
                            </tr>
                            <tr data-visitor-name="Juan Bartolome" data-visit-date="2023/12/13" data-purpose="If the world was ending I'd wanna be next to you If the party ...">
                                <td>Juan Bartolome</td>
                                <td>2023/12/13</td>
                                <td>If the world was ending I'd wanna be next to you If the party ...</td>
                            </tr>
                            <tr data-visitor-name="Juan Bartolome" data-visit-date="2023/12/13" data-purpose="If the world was ending I'd wanna be next to you If the party ...">
                                <td>Juan Bartolome</td>
                                <td>2023/12/13</td>
                                <td>If the world was ending I'd wanna be next to you If the party ...</td>
                            </tr>
                            <tr data-visitor-name="Juan Bartolome" data-visit-date="2023/12/13" data-purpose="If the world was ending I'd wanna be next to you If the party ...">
                                <td>Juan Bartolome</td>
                                <td>2023/12/13</td>
                                <td>If the world was ending I'd wanna be next to you If the party ...</td>
                            </tr>
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
        <br>
        <br>
    </div>

    <!-- Modal for Viewing Visitor Details -->
    <div class="modal fade" id="informationModal" tabindex="-1" aria-labelledby="informationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="d-flex">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="informationModalLabel">VISITOR'S DETAILS</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form>
                            <div class="row">
                            <div class="col-md-4">
                                    
                                    </div>                                <div class="col-md-8">
                                    <div class="mb-3 mt-5">
                                        <div class="row mb-3">
                                            <div class="col-lg-8">
                                                <label for="visitorName" class="form-label">Name of Visitor:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-center" id="visitorName" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="visitDate" class="form-label">Date of Visit:</label>
                                                <input type="date" class="form-control text-center" id="visitDate" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3">
                                                <label for="purpose" class="form-label">Purpose:</label>
                                                <textarea class="form-control" id="purpose" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="paw-prints-down"><img src="styles/assets/paw-down.png" alt="Paws"></div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding a New Record -->
    <div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="d-flex">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="addRecordModalLabel">ADD VISITOR</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form id="addRecordForm">
                            <div class="row">
                            <div class="col-md-4">
                                    
                                    </div>
                                <div class="col-md-8">
                                    <div class="mb-3 mt-5">
                                        <div class="row mb-3">
                                            <div class="col-lg-8">
                                                <label for="visitorNameInput" class="form-label">Name of Visitor:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-center" id="visitorNameInput" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="visitDateInput" class="form-label">Date of Visit:</label>
                                                <input type="date" class="form-control text-center" id="visitDateInput" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3">
                                                <label for="purposeInput" class="form-label">Purpose:</label>
                                                <textarea class="form-control" id="purposeInput" rows="3" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit"  class="btn btn-save">Add</button>
                </div>
                <div class="paw-prints-down"><img src="styles/assets/paw-down.png" alt="Paws"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get all rows from the table
            const tableRows = document.querySelectorAll("#visitorTable tbody tr");

            // Add click event listener to each row
            tableRows.forEach(row => {
                row.addEventListener("click", function() {
                    // Fetch data from row attributes
                    const visitorName = this.dataset.visitorName;
                    const visitDate = this.dataset.visitDate;
                    const purpose = this.dataset.purpose;

                    // Populate modal fields with row data
                    document.getElementById('visitorName').value = visitorName;
                    document.getElementById('visitDate').value = visitDate;
                    document.getElementById('purpose').value = purpose || ''; // Handle empty remarks

                    // Initialize and show the modal
                    const informationModal = new bootstrap.Modal(document.getElementById('informationModal'));
                    informationModal.show();
                });
            });

            // Trigger new modal for adding record
            const addRecordButton = document.getElementById("addRecordButton");
            addRecordButton.addEventListener("click", function() {
                const addRecordModal = new bootstrap.Modal(document.getElementById('addRecordModal'));
                addRecordModal.show();
            });

            // Example functionality for form submission (you can customize the save logic)
            const addRecordForm = document.getElementById("addRecordForm");
            addRecordForm.addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent actual form submission

                // Get input values
                const visitorName = document.getElementById("visitorNameInput").value;
                const visitDate = document.getElementById("visitDateInput").value;
                const purpose = document.getElementById("purposeInput").value;

                // Example: Insert new row into the visitor table (you can replace this with actual backend logic)
                const visitorTable = document.getElementById("visitorTable").getElementsByTagName("tbody")[0];
                const newRow = visitorTable.insertRow();
                newRow.innerHTML = `
                    <tr data-visitor-name="${visitorName}" data-visit-date="${visitDate}" data-purpose="${purpose}">
                        <td>${visitorName}</td>
                        <td>${visitDate}</td>
                        <td>${purpose}</td>
                    </tr>
                `;

                // Hide the modal after adding the record
                const addRecordModal = bootstrap.Modal.getInstance(document.getElementById('addRecordModal'));
                addRecordModal.hide();

                // Reset the form fields
                addRecordForm.reset();
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>

</html>

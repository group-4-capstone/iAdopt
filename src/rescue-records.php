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
    <link rel="stylesheet" href="styles/rescue-records.css">
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
          <h1><u><b>RESCUE RECORDS</b></u></h1>
        </div>
            <p>
                View list of rescued animals and manage their details.
            </p>
        </div>
    </section>

        <div class="container mt-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center ms-auto">
                        <button class="btn btn-add d-flex align-items-center" onclick="window.location.href='add-record.php'">
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
                    <table class="table table-hover mb-0 " id="rescueTable">
                        <thead>
                            <tr>
                                <th>Date Rescued</th>
                                <th>Name of Pet</th>
                                <th>Rescued By</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-pet-name="Juan" data-rescued-by="Juan Bartolome" data-rescue-date="2023/12/13" data-status="Unadoptable" data-type="Dog" data-gender="Male" data-rescued-at="Shelter A">
                                <td>2023/12/13</td>
                                <td>Juan</td>
                                <td>Juan Bartolome</td>
                                <td><span class="badge bg-red text-dark">Unadoptable</span></td>
                            </tr>
                            <tr data-pet-name="Juan" data-rescued-by="Juan Bartolome" data-rescue-date="2023/12/13" data-status="Unadoptable" data-type="Dog" data-gender="Male" data-rescued-at="Shelter A">

                                <td>2023/12/13</td>
                                <td>Juan</td>
                                <td>Juan Bartolome</td>
                                <td><span class="badge bg-red text-dark">Unadoptable</span></td>
                            </tr>
                            <tr data-pet-name="Juan" data-rescued-by="Juan Bartolome" data-rescue-date="2023/12/13" data-status="Unadoptable" data-type="Dog" data-gender="Male" data-rescued-at="Shelter A">

                                <td>2023/12/13</td>
                                <td>Juan</td>
                                <td>Juan Bartolome</td>
                                <td><span class="badge bg-red text-dark">Unadoptable</span></td>
                            </tr>
                            <tr data-pet-name="Juan" data-rescued-by="Juan Bartolome" data-rescue-date="2023/12/13" data-status="Unadoptable" data-type="Dog" data-gender="Male" data-rescued-at="Shelter A">

                                <td>2023/12/13</td>
                                <td>Juan</td>
                                <td>Juan Bartolome</td>
                                <td><span class="badge bg-red text-dark">Unadoptable</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">
                                        < </span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">></span>
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
    <!-- Modal -->
    <div class="modal fade" id="informationModal" tabindex="-1" aria-labelledby="informationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="informationModalLabel">INFORMATION SHEET</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form>
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="styles/assets/aspin-2.png" class="img-fluid rounded" alt="Pet Image">
                                    <button type="button" class="btn btn-edit mt-3 d-block mx-auto" id="updateButton"><i class="bi bi-pencil-square"></i> Update Information</button>
                                </div>
                                <div class="col-md-8">
                                    <!-- Stacked form fields -->
                                    <div class="mb-3">
                                        <label for="petName" class="form-label">Name:</label>
                                        <input type="text" class="form-control text-center" id="petName" disabled>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-lg-4">
                                            <label for="rescueDate" class="form-label">Date Rescued:</label>
                                            <input type="date" class="form-control text-center" id="rescueDate" disabled>
                                        </div>
                                        <div class="mb-3 col-lg-8">
                                            <label for="rescuer" class="form-label">Rescued By:</label>
                                            <input type="text" class="form-control" id="rescuer" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-lg-12">
                                            <label for="rescued-at" class="form-label">Rescued At:</label>
                                            <input type="text" class="form-control" id="rescued-at" disabled>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <div class="mb-3 col-lg-4 text-center">
                                            <label for="type" class="form-label">Type:</label>
                                            <select class="form-select text-center" id="type" disabled>
                                                <option>Dog</option>
                                                <option>Cat</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-lg-4 text-center">
                                            <label for="gender" class="form-label">Gender:</label>
                                            <select class="form-select text-center" id="gender" disabled>
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-lg-4 text-center">
                                            <label for="status" class="form-label">Status:</label>
                                            <select class="form-select text-center" id="status" disabled>
                                                <option>Rescued</option>
                                                <option>Adopted</option>
                                                <option>Fostered</option>
                                                <option>Unadoptable</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="remarks" class="form-label">Remarks:</label>
                                        <textarea class="form-control" id="remarks" rows="3" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-save">Save</button>
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
                    const rescuedBy = this.dataset.rescuedBy;
                    const rescueDate = this.dataset.rescueDate;
                    const type = this.dataset.type;
                    const status = this.dataset.status;
                    const gender = this.dataset.gender;
                    const rescuedAt = this.dataset.rescuedAt; // New field
                    const remarks = this.dataset.remarks; // Assuming remarks data is also available in the row attributes

                    // Populate modal fields with row data
                    document.getElementById('petName').value = petName;
                    document.getElementById('rescuer').value = rescuedBy;
                    document.getElementById('rescueDate').value = rescueDate;
                    document.getElementById('type').value = type;
                    document.getElementById('status').value = status;
                    document.getElementById('gender').value = gender;
                    document.getElementById('rescued-at').value = rescuedAt; // New field
                    document.getElementById('remarks').value = remarks || ''; // Handle empty remarks

                    // Initialize and show the modal
                    const informationModal = new bootstrap.Modal(document.getElementById('informationModal'));
                    informationModal.show();
                });
            });

            const updateButton = document.getElementById("updateButton");
            const inputs = document.querySelectorAll("#petName, #rescueDate, #rescuer, #type, #status, #gender, #rescued-at, #remarks");

            updateButton.addEventListener("click", function() {
                inputs.forEach(input => {
                    input.removeAttribute("disabled");
                });
            });
        });
    </script>






    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>

</html>
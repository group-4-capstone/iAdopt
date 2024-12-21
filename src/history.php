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
        <title>iADOPT | History Records</title>
        <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
        <link rel="stylesheet" href="styles/footer.css">
        <link rel="stylesheet" href="styles/styles.css">
        <link rel="stylesheet" href="styles/sidebar.css">
        <link rel="stylesheet" href="styles/history.css">
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
                        <h1><u><b>HISTORY LOG</b></u></h1>
                    </div>
                    <p>
                        View list of animals that are up for adoption and manage their profiles.
                    </p>
                </div>
            </section>

            <!-- Adopted log table -->
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>ADOPTED LOG</div>
                        <div class="d-flex align-items-center ms-auto">
                            <div class="dropdown">
                                <button class="btn btn-sort d-flex align-items-center" id="adoptedSortToggle"
                                    data-bs-toggle="dropdown" aria-expanded="false" style="white-space: nowrap;">
                                    <span class="badge text-bg-secondary">
                                        <i class="bi bi-arrow-down-up me-1"></i><span id="sortLabel">Sort By</span>
                                    </span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="adoptedSortToggle">
                                    <li><a class="dropdown-item adopted-sort-option" data-sort="desc" href="#">Newest to Oldest</a></li>
                                    <li><a class="dropdown-item adopted-sort-option" data-sort="asc" href="#">Oldest to Newest</a></li>
                                </ul>
                            </div>

                            <div class="input-group input-group-md">
                                <input type="text" class="form-control" placeholder="Search" onkeyup="load_data_adopted(this.value);">
                                <span class="input-group-text search-icon"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-hover mb-5" id="adoptedTable">
                            <thead>
                                <tr>
                                    <th width="25%">Date of Adoption</th>
                                    <th width="25%">Name of Adoptor</th>
                                    <th width="25%">Adopted Pet</th>
                                </tr>
                            </thead>
                            <tbody id="adopted_data"></tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <div id="adopted_pagination_link"></div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- At Rest Log Table -->
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>AT REST LOG</div>
                        <div class="d-flex align-items-center ms-auto">
                            <div class="dropdown">
                                <button class="btn btn-sort d-flex align-items-center" id="restSortToggle"
                                    data-bs-toggle="dropdown" aria-expanded="false" style="white-space: nowrap;">
                                    <span class="badge text-bg-secondary">
                                        <i class="bi bi-arrow-down-up me-1"></i><span id="sortLabel">Sort By</span>
                                    </span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="restSortToggle">
                                    <li><a class="dropdown-item rest-sort-option" data-sort="desc" href="#">Newest to Oldest</a></li>
                                    <li><a class="dropdown-item rest-sort-option" data-sort="asc" href="#">Oldest to Newest</a></li>
                                </ul>
                            </div>
                            <div class="input-group input-group-md">
                                <input type="text" class="form-control" placeholder="Search" onkeyup="rest_data(this.value);">
                                <span class="input-group-text search-icon"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table id="rescueTable" class="table table-hover mb-5">
                            <thead>
                                <tr>
                                    <th width="30%">Date of Rest</th>
                                    <th width="40%">Name of Pet</th>
                                    <th width="30%">Date Rescued</th>
                                </tr>
                            </thead>
                            <tbody id="rest_data"></tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <div id="rest_pagination_link"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report table -->
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>REPORTED LOG</div>
                        <div class="d-flex align-items-center ms-auto">
                            <div class="dropdown">
                                <button class="btn btn-sort d-flex align-items-center" id="reportsSortToggle"
                                    data-bs-toggle="dropdown" aria-expanded="false" style="white-space: nowrap;">
                                    <span class="badge text-bg-secondary">
                                        <i class="bi bi-arrow-down-up me-1"></i><span id="sortLabel">Sort By</span>
                                    </span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="reportsSortToggle">
                                    <li><a class="dropdown-item reports-sort-option" data-sort="desc" href="#">Newest to Oldest</a></li>
                                    <li><a class="dropdown-item reports-sort-option" data-sort="asc" href="#">Oldest to Newest</a></li>
                                </ul>
                            </div>

                            <div class="input-group input-group-md">
                                <input type="text" class="form-control" placeholder="Search" onkeyup="load_data_deny(this.value);">
                                <span class="input-group-text search-icon"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-hover mb-5" id="denyTable">
                            <thead>
                                <tr>
                                    <th width="25%">Report Date</th>
                                    <th width="25%">Reporter</th>
                                    <th width="25%">Location</th>
                                    <th width="25%">Status</th>
                                </tr>
                            </thead>
                            <tbody id="reported_data"></tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <div id="reported_pagination_link"></div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- Deny Reports Modal -->
        <div class="modal fade" id="denyReportsModal" tabindex="-1" aria-labelledby="denyReportsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="denyReportsModalLabel">Deny Report Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Left Column: Animal Image -->
                            <div class="col-md-4 mb-3">
                                <img id="denyAnimalImage" class="img-fluid" alt="Animal Image">
                            </div>

                            <!-- Right Column: Report Details -->
                            <div class="col-md-8 mb-3">
                                <div>
                                    <strong>Location:</strong>
                                    <p id="denyLocation"></p>
                                </div>
                                <div>
                                    <strong>Report Date:</strong>
                                    <p id="denyReportDate"></p>
                                </div>
                                <div>
                                    <strong>Reporter:</strong>
                                    <p id="denyReporter"></p>
                                </div>
                                <div>
                                    <strong>Reason for Denial:</strong>
                                    <p id="denyReason"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!--Adopted Modal -->
        <div class="modal fade" id="informationModal" tabindex="-1" aria-labelledby="informationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content info-card">
                    <div class="modal-header">
                        <h5 class="modal-title" id="informationModalLabel">More Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <!-- Three Sections Layout -->
                            <div class="row text-center">
                                <!-- Adopter Section -->
                                <div class="col-md-4">
                                    <div class="adopter-section">
                                        <img src="" id="data-user-image" class="img-fluid rounded-circle adopter-img" alt="Adopter Image">
                                        <h6>Adopter:</h6>
                                        <p id="rescuer"></p>
                                    </div>
                                </div>

                                <!-- Date of Adoption Section -->
                                <div class="col-md-4 mb-3">
                                    <br><strong>Date of Adoption: </strong><br><br>
                                    <p id="rescueDate"></p><br>
                                    <strong>Approved By: </strong><br><br>
                                    <p id="rescued-at">Shelter A</p>
                                </div>

                                <!-- Adoption Section -->
                                <div class="col-md-4">
                                    <div class="adopted-section">
                                        <img src="" id="data-image" class="img-fluid rounded adopted-img" alt="Adopted Pet Image">
                                        <h6>Adopted:</h6>
                                        <p id="petName"></p>
                                    </div>
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



        <!--Rest Modal -->

        <div class="modal fade" id="restModal" tabindex="-1" aria-labelledby="restModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content info-card">
                    <div class="modal-header">
                        <h5 class="modal-title" id="restModalLabel">More Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <!-- Pet Picture Section -->
                                <div class="col-md-4 text-center">
                                    <img src="" id="restPetImage" class="img-fluid at-rest" alt="Pet Image">
                                </div>

                                <!-- Name of Pet Section -->
                                <div class="col-md-4">
                                    <strong>Name of Pet:</strong>
                                    <p id="restPetName"></p>
                                    <strong>Date of Rest:</strong>
                                    <p id="restDate"></p>
                                </div>

                                <!-- Date Rescued Section -->
                                <div class="col-md-4">
                                    <strong>Date Rescued:</strong>
                                    <p id="restRescueDate"></p>
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




        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="scripts/history.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: login.php");
}
?>
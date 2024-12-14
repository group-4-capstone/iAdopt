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
        <title>iADOPT | Rescue Records</title>
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
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

            <!-- Rescue Request table -->
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Rescue Reports</h4>
                    <div class="d-flex align-items-center ms-auto">
                        <div class="dropdown">
                            <button
                                class="btn btn-sort d-flex align-items-center"
                                id="sortDropdown"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                style="white-space: nowrap;"
                            >
                                <span class="badge text-bg-secondary">
                                    <i class="bi bi-arrow-down-up me-1"></i><span id="sortLabel">Sort By</span>
                                </span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                <li><a class="dropdown-item sort-option" data-sort="desc" href="#">Newest to Oldest</a></li>
                                <li><a class="dropdown-item sort-option" data-sort="asc" href="#">Oldest to Newest</a></li>
                            </ul>
                        </div>
                        <div class="input-group input-group-md ms-3">
                            <input type="text" class="form-control" id="searchInput" placeholder="Search">
                            <span class="input-group-text search-icon"><i class="bi bi-search"></i></span>
                        </div>
                    </div>

                    </div>

                    <div class="card-body p-0">
                        <table class="table table-hover mb-5" id="reportTable">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Report Date</th>
                                    <th width="10%">Type</th>
                                    <th width="35%">Location</th>
                                    <th width="20%">Reporter</th>
                                </tr>
                            </thead>
                            <tbody id="report_data"></tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <div id="report_pagination_link"></div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Rescue Records table -->
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h4>Rescue Records</h4>
                        <div class="d-flex align-items-center ms-auto">
                            <button class="btn btn-add d-flex align-items-center" onclick="window.location.href='add-record.php'">
                                <span class="badge text-bg-success"><i class="bi bi-plus me-1"></i><span>Add</span></span>
                            </button>
                            <button class="btn btn-sort d-flex align-items-center" style="white-space: nowrap;">
                                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-down-up me-1"></i><span>Sort By</span></span>
                            </button>

                            <div class="input-group input-group-md">
                                <input type="text" class="form-control" placeholder="Search" onkeyup="load_data(this.value);">
                                <span class="input-group-text search-icon"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <table id="rescueTable" class="table table-hover mb-5">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Date Rescued</th>
                                    <th width="20%">Name of Pet</th>
                                    <th width="5%">Type</th>
                                    <th width="30%">Rescued By</th>
                                    <th width="25%">Status</th>
                                </tr>
                            </thead>
                            <tbody id="post_data"></tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <div id="pagination_link"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    
      <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <p id="confirmationText">Are you sure you want to proceed with this action?</p>
                    <div id="denyReasonContainer" class="row align-items-center" style="display: none;">
                        <label for="denyReason" class="col-3 form-label">Reason:<span class="asterisk"> *</span></label>
                        <div class="col-9">
                            <select id="denyReason" class="form-select" name="deny_reason">
                                <option selected disabled>--- Select a reason ---</option>
                                <option value="Shelter is in full capacity">Shelter is in full capacity</option>
                                <option value="Unable to rescue due to the animal's condition">Unable to rescue due to the animal's condition</option>
                                <option value="Invalid report">Invalid report</option>
                                <option value="Duplicate report">Duplicate report</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmActionButton">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal" onclick="location.reload();"></button>
                        <div class="text-center">
                            <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                            <p class="mt-4 px-2" id="successMessage">Report has been accepted!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $report_query = "SELECT * FROM rescue INNER JOIN animals ON rescue.animal_id = animals.animal_id INNER JOIN users ON rescue.user_id = users.user_id
        WHERE animals.animal_status IN ('waitlist')";

        $report_result = $db->query($report_query);
        if ($report_result->num_rows > 0) {
            while ($row = $report_result->fetch_assoc()) { ?>

                <!-- View rescue details modal -->
                <div class="modal fade" id="reportModal_<?php echo $row['rescue_id']; ?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rescueDetailModalLabel">Rescue Report Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mt-2 px-4">
                                    <div class="col-lg-6">
                                        <p class="text-center"><strong>Rescue ID:</strong> <?php echo $row['rescue_id'] ?></p>
                                        <div class="ratio ratio-4x3" style="max-width: 90%; overflow: hidden;">
                                            <img id="modalAnimalImage" src="styles/assets/rescue-reports/<?php echo $row['animal_image'] ?>" alt="Animal Image" class="img-fluid object-fit-cover" style="width: 100%; height: 100%;">
                                        </div>

                                    </div>
                                    <div class="col-lg-6  d-flex flex-column justify-content-center">
                                        <?php
                                        $date = new DateTime($row['report_date']);
                                        $formattedDate = $date->format('F j, Y g:i A');
                                        ?>
                                        <p><strong>Report Date:</strong> <?php echo $formattedDate; ?> </p>
                                        <p><strong>Type:</strong> <?php echo $row['type'] ?></p>
                                        <p><strong>Location:</strong> <?php echo $row['location'] ?> </p>
                                        <p><strong>Reporter:</strong> <?php echo $row['first_name'] . ' ' . $row['last_name'] ?> </p>
                                        <p><strong>Report Description:</strong> <?php echo $row['rescue_description'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <form method="post" id="updateStatusForm_<?php echo $row['rescue_id'] ?>">
                                <input type="hidden" name="rescue_id" value="<?php echo $row['rescue_id'] ?>" readonly>
                                <button type="submit" class="btn btn-primary me-2 mb-2" onclick="$('#reportModal_<?php echo $row['rescue_id']; ?>').modal('hide');" id="acceptButton_<?php echo $row['rescue_id'] ?>">
                                    Accept
                                </button>
                                <button type="submit" class="btn btn-danger mb-2" onclick="$('#reportModal_<?php echo $row['rescue_id']; ?>').modal('hide');" id="denyButton__<?php echo $row['rescue_id'] ?>">
                                    Deny
                                </button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div><?php }
                } ?>

        <script src="scripts/rescue-records.js"></script>


    </body>

    </html>

<?php
} else {
    header("Location: login.php");
}
?>
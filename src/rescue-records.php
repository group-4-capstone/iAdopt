
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
                    <div class="d-flex align-items-center ms-auto">
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
                    <table class="table table-hover mb-5" id="reportTable">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="20%">Report Date</th>
                                <th width="5%">Type</th>
                                <th width="35%">Location</th>
                                <th width="20%">Reporter</th>
                                <th width="15%">Status</th>
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
   
  <!-- Report Details Modal -->
<div class="modal fade" id="rescueDetailModal" tabindex="-1" role="dialog" aria-labelledby="rescueDetailModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rescueDetailModalLabel">Rescue Report Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center pb-2">
                    <p><strong>Rescue ID:</strong> <span id="modalRescueId"></span></p>
                    <img id="modalAnimalImage" src="" alt="Animal Image" class="img-fluid" style="max-width: 70%; height: auto;">
                </div>
                <div class="row mt-2 px-4">
                    <div class="col-lg-6">
                        <p><strong>Report Date:</strong> <span id="modalReportDate"></span></p>
                    </div>
                    <div class="col-lg-6">
                        <p><strong>Type:</strong> <span id="modalType"></span></p>
                    </div>
                    <div class="col-lg-6">
                        <p><strong>Location:</strong> <span id="modalLocation"></span></p>
                    </div>
                    <div class="col-lg-6">
                        <p><strong>Reporter:</strong> <span id="modalRescuer"></span></p>
                    </div>
                    <div class="col-lg-6">
                        <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary me-4 mb-2" id="acceptButton">Accept</button>
            </div>
        </div>
    </div>
</div>



    <!-- Rescue Request Modal -->
    <div class="modal fade" id="rescueRequestModal" tabindex="-1" aria-labelledby="rescueRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rescueRequestModalLabel">RESCUE REQUEST DETAILS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form>
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="styles/assets/aspin-2.png" class="img-fluid rounded" alt="Pet Image">
                                </div>
                                <div class="col-md-8">
                                    <!-- Stacked form fields -->
                                    <div class="row">
                                        <div class="mb-3 col-lg-4">
                                            <label for="rescueDate" class="form-label">Date Rescued:</label>
                                            <input type="text" class="form-control text-center" id="rescueDate" disabled>
                                        </div>
                                        <div class="mb-3 col-lg-8">
                                            <label for="characteristics" class="form-label">Characteristics:</label>
                                            <input type="text" class="form-control" id="characteristics" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-lg-12">
                                            <label for="reporter" class="form-label">Reporter:</label>
                                            <input type="text" class="form-control" id="reporter" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-lg-12">
                                            <label for="address" class="form-label">Address:</label>
                                            <input type="text" class="form-control" id="address" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="remarks" class="form-label">Other Details:</label>
                                        <textarea class="form-control" id="remarks" rows="3" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Reject</button>
                    <button type="button" class="btn btn-save">Approve</button>
                </div>
                <div class="paw-prints-down"><img src="styles/assets/paw-down.png" alt="Paws"></div>
            </div>
        </div>
    </div>


    <!-- Rescue Records Modal -->
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
                <div class="paw-prints-down"><img src="styles/assets/paw-down.png" alt="Paws"></div>
            </div>
        </div>
    </div>




    <script src="scripts/rescue-records.js"></script>
   

</body>

</html>

<?php
} else {
    header("Location: home.php");
}
?>

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
    <title>iADOPT | Visitor Log</title>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    		    <div class="card-header">
                    <div class="d-flex align-items-center ms-auto">
                            <button class="btn btn-add d-flex align-items-center" id="addRecordButton" data-bs-toggle="modal" data-bs-target="#addRecordModal">
                                <span class="badge text-bg-success"><i class="bi bi-plus me-1"></i><span>Add</span></span>
                            </button>
                            <button class="btn btn-sort d-flex align-items-center" style="white-space: nowrap;">
                                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-down-up me-1"></i><span>Sort By</span></span>
                            </button>
                        <div class="col-md-6">
                        <div class="input-group input-group-md">
                                <input type="text" class="form-control" placeholder="Search" onkeyup="load_data(this.value);">
                                <span class="input-group-text search-icon"><i class="bi bi-search"></i></span>
                            </div>
                        
                        </div>
                    </div>
    		    </div>

    		<div class="card-body">
    			<table class="table table-hover">
    				<thead>
    					<tr>
                            <th width="5%">#</th>
    						<th width="20%">Name</th>
    						<th width="20%">Group Name</th>
                            <th width="5%">Pax</th>
                            <th width="30%">Purpose</th>
                            <th width="25%">Date & Time of Visit</th>
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

    <!-- Modal for Viewing Visitor Details -->
    <div class="modal fade" id="informationModal" tabindex="-1" aria-labelledby="informationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="d-flex p-3">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="informationModalLabel">VISITOR'S DETAILS</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                    <form>
                        <div class="row">
                            <div class="col-md-4"></div>                                
                            <div class="col-md-8">
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
                                    <div class="row mb-3">
                                        <div class="col-lg-8">
                                            <label for="group_name" class="form-label">Group Name:</label>
                                            <input type="text" class="form-control" id="group_name">
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="num_pax" class="form-label">Num of Pax:</label>
                                            <input type="text" class="form-control" id="num_pax">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
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
                    <form id="visitForm" method="post">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                        <div class="mb-3 mt-5">
                            <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="visit_date" class="mb-1">Date of Visit<span class="asterisk"> *</span></label>
                                <input type="date" class="form-control" id="visit_date" name="visit_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="visit_time" class="mb-1">Time of Visit<span class="asterisk"> *</span></label>
                                <select id="visit_time" name="visit_time" class="form-control" required>
                                <option value="" selected disabled>-- Kindly select visit time --</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="11:00:00">11:00 AM</option>
                                <option value="12:00:00">12:00 PM</option>
                                <option value="13:00:00">1:00 PM</option>
                                <option value="14:00:00">2:00 PM</option>
                                <option value="15:00:00">3:00 PM</option>
                                <option value="16:00:00">4:00 PM</option>
                                <option value="17:00:00">5:00 PM</option>
                                </select>
                            </div>
                            </div>
                            
                            <input type="hidden" id="visitDateTime" name="visitDateTime">
                            
                            <div class="mb-3">
                            <label>Name/s<span class="asterisk"> *</span></label>
                            <input type="text" class="form-control" placeholder="e.g Juan Dela Cruz" name="names" required>
                            </div>
                            
                            <div class="mb-3">
                            <label>Group Name<span class="asterisk"> *</span></label>
                            <input type="text" class="form-control" name="group_name" placeholder="e.g. ABC Students" required>
                            </div>
                            
                            <div class="row">
                            <div class="col-lg-3 col-12 mb-3">
                                <label>No. of Pax<span class="asterisk"> *</span></label>
                                <input type="number" class="form-control" name="pax" placeholder="Number of Visitors" required>
                            </div>
                            <div class="col-lg-9 col-12 mb-3">
                                <label>Purpose<span class="asterisk"> *</span></label>
                                <input type="text" class="form-control" name="purpose" placeholder="Indicate your purpose of visit." required>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="submitVisitBtn" class="btn btn-save">Add</button>
                </div>
              </form>
             </div>
            </div>
                <div class="paw-prints-down"><img src="styles/assets/paw-down.png" alt="Paws"></div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
  <div class="modal fade" id="successVisitModal" tabindex="-1" aria-labelledby="successVisitModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close d-flex ms-auto" onclick="window.location.href='visitor-log.php'"></button>
          <div class="text-center">
            <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
            <p class="mt-4 px-2">Visit Details Has Been Added!</p>
          </div>
        </div>     
      </div>
    </div>
  </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="scripts/visitor-log.js"></script>


</body>

</html>
<?php
} else {
    header("Location: login.php");
}
?>
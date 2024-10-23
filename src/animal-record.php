<?php
include_once 'includes/db-connect.php';

if (isset($_GET['animal_id'])) {
    $animal_id = $_GET['animal_id'];

    $report_query = "
    SELECT rescue.*, animals.*, users.first_name, users.last_name
    FROM rescue
    INNER JOIN animals ON rescue.animal_id = animals.animal_id
    INNER JOIN users ON rescue.user_id = users.user_id
    WHERE animals.animal_id = ?  AND rescue.report_type = 'report'
    ";

    $report_stmt = $db->prepare($report_query);
    $report_stmt->bind_param("i", $animal_id);
    $report_stmt->execute();
    $report_result = $report_stmt->get_result();

    // Check if the animal was found
    if ($report_result->num_rows > 0) {
        $animal = $report_result->fetch_assoc();
    } else {
        $query = "
            SELECT rescue.*, animals.*
            FROM rescue
            INNER JOIN animals ON rescue.animal_id = animals.animal_id
            WHERE animals.animal_id = ? AND rescue.report_type = 'rescue'
        ";

        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $animal_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the animal was found
        if ($result->num_rows > 0) {
            $animal = $result->fetch_assoc();
        } else {
            $error_message = 'Animal not found';
        }
    }
} else {
    $error_message = 'Invalid request';
}

$status = htmlspecialchars($animal['animal_status']);
$badgeClass = '';

switch ($status) {
    case 'Waitlist':
        $badgeClass = 'bg-warning';
        break;
    case 'Unadoptable':
        $badgeClass = 'bg-dark';
        break;
    case 'Adoptable':
        $badgeClass = 'bg-success';
        break;
    case 'Rest':
        $badgeClass = 'bg-primary';
        break;
    case 'Under Review':
        $badgeClass = 'bg-danger';
        break;
    default:
        $badgeClass = 'bg-secondary'; // Fallback color for unknown statuses
        break;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iADOPT | SECASPI</title>
    <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
    <link rel="stylesheet" href="styles/sidebar.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/add-record.css">

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

    <?php include_once 'components/sidebar.php'; ?>

    <div class="admin-content">

        <section class="banner-section">
            <div class="content">
                <div class="head-title">
                    <h1><u><b>ANIMAL RECORD #<?php echo $animal_id ?></b></u></h1>
                </div>
                <p>
                    View animal information.
                </p>
            </div>
        </section>

        <!-- Toast Container -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="editToast" class="toast align-items-center text-bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        Editing Mode
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <div class="container mt-5 mb-5">
        <form id="animalInfoForm">
            <div class="card info-card p-4">
                <h2 class="title">> INFORMATION SHEET</h2> 
                <p class="d-flex justify-content-end mt-1 mb-2 me-4">
                    Status: <span class="ms-2 badge <?php echo $badgeClass; ?>"><?php echo $status; ?></span>
                </p>

                <div class="row mt-2">
                    <div class="col-md-4 col-sm-12">
                        <div class="ms-4">
                        <?php if (!empty($animal['image'])) { ?>
                            <div class="image-container">
                                <img src="styles/assets/animals/<?php echo htmlspecialchars($animal['image']); ?>" alt="Animal Image" class="animal-image">
                            </div>
                            <?php } else { ?>
                                <img src="styles/assets/secaspi-logo.png" alt="Animal Image">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="left-side pe-4">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" id="name" class="form-control" name="name" value="<?php echo htmlspecialchars($animal['report_type'] == 'rescue' ? $animal['name'] : '---- No name yet ----'); ?>" readonly>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="gender" class="form-label">Gender:</label>
                                    <input type="text" id="gender" class="form-control" name="gender" value="<?php echo htmlspecialchars($animal['gender']); ?>" readonly>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="type" class="form-label">Type:</label>
                                    <input type="text" id="type" class="form-control" name="type" value="<?php echo htmlspecialchars($animal['type']); ?>" readonly>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="rescuedBy" class="form-label"><?php echo $animal['report_type'] == 'rescue' ? 'Rescued By:' : 'Reported By:'; ?></label>
                                    <input type="text" id="rescuedBy" class="form-control" name="rescued_by" value="<?php echo htmlspecialchars($animal['report_type'] == 'rescue' ? $animal['rescued_by'] : $animal['first_name'] . ' ' . $animal['last_name']); ?>" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="rescuedAt" class="form-label"><?php echo $animal['report_type'] == 'rescue' ? 'Rescued At:' : 'Report Location:'; ?></label>
                                    <input type="text" id="rescuedAt" class="form-control" name="rescued_at" value="<?php echo htmlspecialchars($animal['report_type'] == 'rescue' ? $animal['rescued_at'] : $animal['location']); ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label for="remarks" class="form-label"><?php echo $animal['report_type'] == 'rescue' ? 'Remarks:' : 'Description:'; ?></label>
                                    <textarea id="remarks" class="form-control" name="description" readonly><?php echo htmlspecialchars($animal['report_type'] == 'rescue' ? $animal['description'] : '---- To be filled out ----'); ?></textarea>
                                </div>
                            </div>
                                
                            <label for="tags" class="form-label">Tags:</label>
                             <div class="mt-2 row text-center form-group">    
                                <div class="col-md-4 mb-2">
                                    <button type="button" id="tag1" class="btn btn-tags" disabled data-value="Great Companion">Great Companion</button>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <button type="button" id="tag2" class="btn btn-tags" disabled data-value="<?php echo ($animal['gender'] == 'Male') ? 'Neutered' : 'Spayed'; ?>">
                                        <?php echo ($animal['gender'] == 'Male') ? 'Neutered' : 'Spayed'; ?>
                                    </button>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <button type="button" id="tag3" class="btn btn-tags" disabled data-value="Friendly to Humans">Friendly to Humans</button>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <button type="button" id="tag4" class="btn btn-tags py-1 px-4" disabled data-value="Friendly to Cats">Friendly to Cats</button>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <button type="button" id="tag5" class="btn btn-tags" disabled data-value="Friendly to Dogs">Friendly to Dogs</button>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <button type="button" id="tag6" class="btn btn-tags" disabled data-value="No food aggression">No food aggression</button>
                                </div>
                            </div>

                         
                            <div class="d-flex justify-content-end mt-5 mb-3">
                                <button type="button" class="btn btn-primary me-4" id="editBtn"><i class="bi bi-pencil-square pe-2"></i>Edit Information</button>
                                <button type="button" class="btn btn-cancel" id="backBtn" onclick="window.location.href='rescue-records.php'">Back to Records</button>
                                <button type="submit" class="btn btn-cancel me-4" id="cancelBtn" style="display: none;" onclick="window.location.href='animal-record.php?animal_id=<?php echo $animal_id?>#animalInfoForm'">Cancel</button>
                                <button type="submit" class="btn btn-success" id="applyBtn" style="display: none;">Apply Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="paw-prints-down"><img src="styles/assets/paw-down.png" alt="Paws"></div>
            </div>
        </form>

            <!-- Card -->
            <div class="card mt-4 p-4">
                <div class="accordion" id="animalDetailsAccordion">
                    <?php if ($animal['report_type'] == 'report') { ?>
                        <!-- Report Details -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingQuestionnaire">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseQuestionnaire" aria-expanded="true" aria-controls="collapseQuestionnaire">
                                    <b> Report Details </b>
                                </button>
                            </h2>
                            <div id="collapseQuestionnaire" class="accordion-collapse collapse show" aria-labelledby="headingQuestionnaire" data-bs-parent="#adoptionDetailsAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <p class="mt-2"><b>Report Image</b></p>
                                            <img src="styles/assets/rescue-reports/<?php echo htmlspecialchars($animal['animal_image']); ?>" alt="Animal Image" class="img-fluid mb-3" style="max-width: 100%;">
                                        </div>

                                        <div class="col-lg-5">
                                            <p class="mt-2"><b>Date of Report:</b> <?php echo htmlspecialchars($animal['report_date']); ?></p>
                                            <p class="mt-2"><b>Description:</b> <?php echo htmlspecialchars($animal['rescue_description']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php  } ?>
                    <!-- Medical History -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingProof">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProof" aria-expanded="true" aria-controls="collapseProof">
                                <b>Medical History</b>
                            </button>
                        </h2>
                        <div id="collapseProof" class="accordion-collapse collapse show" aria-labelledby="headingProof" data-bs-parent="#adoptionDetailsAccordion">
                            <div class="accordion-body">
                                <div class="row mt-3 px-4">
                                    <div class="col-md-6">
                                        <h5>General Health Information:</h5>
                                        <p><i class="ps-5">No records yet.</i></p>
                                        <u><i class="text-end d-block mt-2" style="font-size: 0.9em;">> Update General Health Information</i></u>
                                        <hr class="my-4">
                                        <h5 class="pt-3">Vaccinations:</h5>
                                        <i class="ps-5">No records yet.</i>
                                        <u><i class="text-end d-block mt-2" style="font-size: 0.9em;">> Update Vaccination</i></u>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Medical Treatments/Procedures</h5>
                                        <i class="ps-5"> No records. </i>
                                        <u><i class="text-end d-block mt-3" style="font-size: 0.9em;">> Update Medical Treatments/Procedures</i></u>
                                        <hr class="my-4">
                                        <h5 class="pt-3">Illnesses/Injuries</h5>
                                        <i class="ps-5"> No records. </i>
                                        <u><i class="text-end d-block mt-2" style="font-size: 0.9em;">> Update Illnesses/ Injuries</i></u>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Success Modal -->
        <div class="modal fade" id="successRecordModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close d-flex ms-auto" onclick="window.location.href='rescue-records.php'"></button>
                        <div class="text-center">
                            <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                            <p class="mt-4 px-2"> Record has been successfully added!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <script src="scripts/rescue-records.js"></script>
        <script src="scripts/animal-profile.js"></script>
</body>

</html>
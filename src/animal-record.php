<?php
include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

// Check session and role
if (isset($_SESSION['email']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'head_admin')) {

    if (isset($_GET['animal_id'])) {
        $animal_id = $_GET['animal_id'];

        $report_query = "
            SELECT rescue.*, animals.*, users.first_name, users.last_name
            FROM rescue
            INNER JOIN animals ON rescue.animal_id = animals.animal_id
            INNER JOIN users ON rescue.user_id = users.user_id
            WHERE animals.animal_id = ? AND rescue.report_type = 'report'
        ";

        $report_stmt = $db->prepare($report_query);
        $report_stmt->bind_param("i", $animal_id);
        $report_stmt->execute();
        $report_result = $report_stmt->get_result();

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

            if ($result->num_rows > 0) {
                $animal = $result->fetch_assoc();
            } else {
                // Redirect to not-found.php if the animal is not found
                header("Location: not-found.php");
                exit(); // Ensure no further code is executed
            }
        }
    } else {
        // Redirect to not-found.php if the request is invalid
        header("Location: not-found.php");
        exit();
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
        case 'On Process':
            $badgeClass = 'bg-danger';
            break;
        case 'Adopted':
            $badgeClass = 'bg-info';
            break;
        default:
            $badgeClass = 'bg-secondary';
            break;
    }

    $tags = isset($animal['tags']) ? explode(',', $animal['tags']) : [];
    $hasSixTags = count($tags) === 6;

    $vaccineQuery = "SELECT COUNT(*) as count 
                    FROM vaccines 
                    WHERE animal_id = ? AND vaccine_name IN ('5-in-1 Vaccine', 'Anti-Rabies Vaccine')";

    $stmt = $db->prepare($vaccineQuery);
    $stmt->bind_param('i', $animal_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $vaccineData = $result->fetch_assoc();

    $hasRequiredVaccines = $vaccineData['count'] == 2;
    $showAdoptable = $hasSixTags && $hasRequiredVaccines;
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>iADOPT | Animal Records</title>
        <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
        <link rel="stylesheet" href="styles/sidebar.css">
        <link rel="stylesheet" href="styles/styles.css">
        <link rel="stylesheet" href="styles/add-record.css">

        <!-- Google Fonts Links For Icon -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Bootstrap Icons-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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

            <!-- QR Code Modal -->
            <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="qrModalLabel">Animal QR Code</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <!-- QR Code Image -->
                            <img id="qrCodeImage" src="styles/assets/qr_images/animal_<?php echo $animal_id ?>.png" alt="QR Code" class="img-fluid">
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-success me-2" onclick="downloadQRCode()">
                                <i class="bi bi-download pe-2"></i>Download PNG
                            </button>
                            <button type="button" class="btn btn-primary" onclick="printQRCode()">
                                <i class="bi bi-printer pe-2"></i>Print QR Code
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container mt-5 mb-5">
                <form method="post" id="animalInfoForm">
                    <div class="card info-card p-4">
                        <h2 class="title">> INFORMATION SHEET</h2>
                        <p class="d-flex justify-content-end align-items-center mt-1 mb-2 me-4">
                            Status: <span class="badge <?php echo $badgeClass; ?> w-25 ms-2"> <?php echo $status; ?> </span>
                        </p>

                        <div class="row mt-2">
                            <div class="col-md-4 col-sm-12 d-flex justify-content-center">
                                <div class="text-center" id="animal_image">
                                    <?php if (!empty($animal['image'])) { ?>
                                        <img src="styles/assets/animals/<?php echo htmlspecialchars($animal['image']); ?>" alt="Animal Image" class="img-fluid animal-image">
                                    <?php } else { ?>
                                        <img src="styles/assets/secaspi-logo.png" alt="Animal Image" class="img-fluid">
                                    <?php } ?>

                                    <!-- File upload placeholder -->
                                    <div id="fileUploadContainer" style="display: none;">
                                        <label for="animalImageUpload" class="form-label mt-2">Upload New Image:</label>
                                        <input type="file" id="animalImageUpload" name="image" class="form-control">
                                    </div>

                                    <!-- QR Code Button -->
                                    <div id="qrContainer" class="text-center mt-2">
                                        <button type="button" class="btn btn-primary" id="qrBtn" data-animal-id="<?php echo $animal_id ?>">
                                            <i class="bi bi-qr-code-scan pe-2"></i>Generate QR Code
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 col-sm-12">
                                <div class="left-side pe-4">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="name" class="form-label">Name:</label>
                                            <input type="text" id="name" class="form-control" name="name"
                                                value="<?php echo !empty($animal['name']) ? htmlspecialchars($animal['name']) : ''; ?>"
                                                placeholder="---- No name yet ----"
                                                readonly>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="gender" class="form-label">Gender:</label>
                                            <select id="gender" class="form-select" name="gender" disabled>
                                                <option value="Male" <?php echo $animal['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                                                <option value="Female" <?php echo $animal['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="type" class="form-label">Type:</label>
                                            <select id="type" class="form-select" name="type" disabled>
                                                <option value="Dog" <?php echo $animal['type'] === 'Dog' ? 'selected' : ''; ?>>Dog</option>
                                                <option value="Cat" <?php echo $animal['type'] === 'Cat' ? 'selected' : ''; ?>>Cat</option>
                                            </select>
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
                                            <label for="remarks" class="form-label">
                                                Description:
                                            </label>
                                            <textarea id="remarks" class="form-control" name="description" readonly
                                                placeholder="---- To be filled out ----"><?php echo htmlspecialchars($animal['description']); ?></textarea>
                                        </div>
                                    </div>
                                    <?php
                                    // Convert the tags string into an array
                                    $animalTags = explode(',', $animal['tags']);
                                    ?>

                                    <label for="tags" class="form-label">Tags:</label>
                                    <div class="mt-2 row text-center form-group">
                                        <div class="col-md-4 mb-2">
                                            <button type="button" id="tag1" class="btn btn-tags <?php echo in_array('Great Companion', $animalTags) ? 'btn-selected' : ''; ?>" data-value="Great Companion" onclick="toggleButton(this)" disabled>Great Companion</button>
                                            <input type="checkbox" id="checkbox1" name="tags[]" value="Great Companion" style="display: none;" <?php echo in_array('Great Companion', $animalTags) ? 'checked' : ''; ?>>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <button type="button" id="tag2" class="btn btn-tags <?php echo in_array($animal['gender'] == 'Male' ? 'Neutered' : 'Spayed', $animalTags) ? 'btn-selected' : ''; ?>" data-value="<?php echo ($animal['gender'] == 'Male') ? 'Neutered' : 'Spayed'; ?>" onclick="toggleButton(this)" disabled>
                                                <?php echo ($animal['gender'] == 'Male') ? 'Neutered' : 'Spayed'; ?>
                                            </button>
                                            <input type="checkbox" id="checkbox2" name="tags[]" value="<?php echo ($animal['gender'] == 'Male') ? 'Neutered' : 'Spayed'; ?>" style="display: none;" <?php echo in_array($animal['gender'] == 'Male' ? 'Neutered' : 'Spayed', $animalTags) ? 'checked' : ''; ?>>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <button type="button" id="tag3" class="btn btn-tags <?php echo in_array('Friendly to Humans', $animalTags) ? 'btn-selected' : ''; ?>" data-value="Friendly to Humans" onclick="toggleButton(this)" disabled>Friendly to Humans</button>
                                            <input type="checkbox" id="checkbox3" name="tags[]" value="Friendly to Humans" style="display: none;" <?php echo in_array('Friendly to Humans', $animalTags) ? 'checked' : ''; ?>>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <button type="button" id="tag4" class="btn btn-tags <?php echo in_array('Friendly to Cats', $animalTags) ? 'btn-selected' : ''; ?>" data-value="Friendly to Cats" onclick="toggleButton(this)" disabled>Friendly to Cats</button>
                                            <input type="checkbox" id="checkbox4" name="tags[]" value="Friendly to Cats" style="display: none;" <?php echo in_array('Friendly to Cats', $animalTags) ? 'checked' : ''; ?>>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <button type="button" id="tag5" class="btn btn-tags <?php echo in_array('Friendly to Dogs', $animalTags) ? 'btn-selected' : ''; ?>" data-value="Friendly to Dogs" onclick="toggleButton(this)" disabled>Friendly to Dogs</button>
                                            <input type="checkbox" id="checkbox5" name="tags[]" value="Friendly to Dogs" style="display: none;" <?php echo in_array('Friendly to Dogs', $animalTags) ? 'checked' : ''; ?>>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <button type="button" id="tag6" class="btn btn-tags <?php echo in_array('No food aggression', $animalTags) ? 'btn-selected' : ''; ?>" data-value="No food aggression" onclick="toggleButton(this)" disabled>No food aggression</button>
                                            <input type="checkbox" id="checkbox6" name="tags[]" value="No food aggression" style="display: none;" <?php echo in_array('No food aggression', $animalTags) ? 'checked' : ''; ?>>
                                        </div>
                                    </div>
                                    <?php if (!in_array($status, ['Unadoptable', 'Adoptable', 'Rest'])): ?>
                                        <div style="display: none;" id="status_input">
                                            <div class="row align-items-center form-group">
                                                <div class="col-md-3">
                                                    <label for="remarks" class="form-label">
                                                        Update Status:
                                                    </label>
                                                </div>
                                                <input type="hidden" name="current_animal_status" value="<?= htmlspecialchars($status) ?>">
                                                <div class="col-md-9">
                                                    <select id="status" class="form-select" name="animal_status" disabled>
                                                        <option selected disabled>----- Kindly select a new status -----</option>
                                                        <?php if ($showAdoptable): ?>
                                                            <option value="Adoptable">Adoptable</option>
                                                        <?php endif; ?>
                                                        <option value="Unadoptable">Unadoptable</option>
                                                        <option value="Rest">Rest</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <input type="hidden" name="animal_id" value="<?php echo $animal_id ?>" readonly>

                                    <?php if ($showAdoptable): ?>
                                        <i class="small form-group" id="adoptableInfo">*** Can be tagged as <b>Adoptable</b>, click on Edit Information to update status.</i>
                                    <?php endif; ?>

                                    <div class="d-flex justify-content-end mt-5 mb-3">
                                        <button type="button" class="btn btn-primary me-4" id="editBtn"><i class="bi bi-pencil-square pe-2"></i>Edit Information</button>
                                        <button type="button" class="btn btn-danger" id="backBtn" onclick="window.location.href='rescue-records.php'">Back to Records</button>
                                        <button type="submit" class="btn btn-danger me-4" id="cancelBtn" style="display: none;" onclick="window.location.href='animal-record.php?animal_id=<?php echo $animal_id ?>#animalInfoForm'">Cancel</button>
                                        <button type="button" class="btn btn-success" id="applyBtn" style="display: none;">Apply Changes</button>
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
                                            <div class="row mt-2 px-4">

                                                <div class="col-lg-6">
                                                    <p class="text-center"><strong>Rescue ID:</strong> <?php echo $animal['rescue_id'] ?></p>
                                                    <div class="ratio ratio-4x3" style="max-width: 90%; overflow: hidden;">
                                                        <img id="modalAnimalImage" src="styles/assets/rescue-reports/<?php echo $animal['animal_image'] ?>" alt="Animal Image" class="img-fluid object-fit-cover" style="width: 100%; height: 100%;">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 d-flex flex-column justify-content-center">
                                                    <?php
                                                    $date = new DateTime($animal['report_date']);
                                                    $formattedDate = $date->format('F j, Y g:i A');
                                                    ?>
                                                    <p><strong>Report Date:</strong> <?php echo $formattedDate; ?> </p>
                                                    <p><strong>Type:</strong> <?php echo $animal['type'] ?></p>
                                                    <p><strong>Location:</strong> <?php echo $animal['location'] ?> </p>
                                                    <p><strong>Reporter:</strong> <?php echo $animal['first_name'] . ' ' . $animal['last_name'] ?> </p>
                                                    <p><strong>Report Description:</strong> <?php echo $animal['rescue_description'] ?></p>
                                                </div>
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

                                            <?php
                                            $query_health = "SELECT * FROM medical WHERE animal_id = '$animal_id'";
                                            $result_health = $db->query($query_health);

                                            // Check if there are records
                                            $weight = '';
                                            $age = '';
                                            $medical_treatments = '';
                                            $illness_injuries = '';

                                            if ($result_health && $result_health->num_rows > 0) {
                                                // Fetch the latest record
                                                $row = $result_health->fetch_assoc();
                                                $weight = $row['weight'];
                                                $age = $row['age'];
                                                $medical_treatments = $row['medical_treatments'];
                                                $illness_injuries = $row['illness_injuries'];
                                                $last_updated = date('F j, Y, g:i a', strtotime($row['last_updated'])); // Format timestamp
                                                $age_added = date('F j, Y, g:i a', strtotime($row['age_added'])); // Format timestamp

                                                echo "<ul class='list-unstyled ps-5'>";
                                                echo "<li><strong>Weight:</strong> $weight kg</li>";
                                                echo "<li><strong>Age:</strong> $age months</li>";
                                                echo "<li><strong>Illness/Injuries:</strong> " . (!empty($illness_injuries) ? $illness_injuries : "<i>No record found.</i>") . "</li>";
                                                echo "<li><strong>Medical Treatment(s):</strong> " . (!empty($medical_treatments) ? $medical_treatments : "<i>No record found.</i>") . "</li>";
                                                echo "</ul>";
                                                echo "<span class='small text-muted mt-1'>Last Updated: </strong>$last_updated</span>";
                                            } else {
                                                // No records found
                                                echo "<p><i class='ps-5'>No records yet.</i></p>";
                                            }
                                            ?>

                                            <!-- Link to open the modal -->
                                            <a href="" data-bs-toggle="modal" data-bs-target="#updateHealthInfoModal">
                                                <i class="text-end d-block mt-2" style="font-size: 0.9em;">> Update General Health Information</i>
                                            </a>

                                            <!-- Modal for Updating General Health Information -->
                                            <div class="modal fade" id="updateHealthInfoModal" tabindex="-1" aria-labelledby="updateHealthInfoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="updateHealthInfoModalLabel">Update General Health Information</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="healthInfoForm" method="POST">
                                                                <input type="hidden" id="animal_id" name="animal_id" value="<?php echo $animal_id; ?>" readonly>
                                                                <div class="mb-3">
                                                                    <label for="weight" class="form-label">Weight (kg)</label>
                                                                    <input type="number" step="0.1" class="form-control" id="weight" name="weight"
                                                                        placeholder="Enter weight" value="<?php echo $weight; ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="age" class="form-label">Age (months)</label>
                                                                    <input type="number" class="form-control" id="age" name="age"
                                                                        placeholder="Enter age in months" value="<?php echo $age; ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="illness_injuries" class="form-label">Illness/Injuries</label>
                                                                    <input type="text" class="form-control" id="illness_injuries" name="illness_injuries"
                                                                        placeholder="Enter details about illness or injuries" value="<?php echo $illness_injuries; ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="medical_treatments" class="form-label">Medical Treatments</label>
                                                                    <input type="text" class="form-control" id="medical_treatments" name="medical_treatments"
                                                                        placeholder="Enter details about medical treatments" value="<?php echo $medical_treatments; ?>">
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="button" id="submitHealthInfoBtn" class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Vaccinations:</h5>
                                            <?php
                                            $sql = "SELECT * FROM vaccines WHERE animal_id = '$animal_id'";
                                            // Execute the query
                                            $result = $db->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $vaccine_id = $row['vaccine_id'];
                                                    $vaccine_name = htmlspecialchars($row['vaccine_name']);
                                                    $vaccination_date = htmlspecialchars($row['vaccination_date']);
                                                    $next_due_date = htmlspecialchars($row['next_due_date']);
                                                    $vet_name = htmlspecialchars($row['vet_name']);
                                                    $vet_contact = htmlspecialchars($row['vet_contact']);
                                                    $remarks = htmlspecialchars($row['remarks']);

                                                    echo "<p> > <a href='#' data-bs-toggle='modal' data-bs-target='#vaccineModal' 
                                                        data-vaccine-name='$vaccine_name' 
                                                        data-vaccination-date='$vaccination_date' 
                                                        data-next-due-date='$next_due_date' 
                                                        data-vet-name='$vet_name' 
                                                        data-vet-contact='$vet_contact' 
                                                        data-remarks='$remarks'>$vaccine_name</a></p>";
                                                }
                                            } else {
                                                // No records found
                                                echo "<i class='ps-5'>No records yet.</i>";
                                            }

                                            // Close the database connection
                                            $db->close();
                                            ?>

                                            <!-- Modal for displaying vaccine details -->
                                            <div class="modal fade" id="vaccineModal" tabindex="-1" aria-labelledby="vaccineModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="vaccineModalLabel">Vaccine Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div>
                                                                <strong>Vaccine Name: </strong><span id="modalVaccineName"></span>
                                                            </div>
                                                            <div>
                                                                <strong>Vaccination Date: </strong><span id="modalVaccinationDate"></span>
                                                            </div>
                                                            <div>
                                                                <strong>Next Due Date: </strong><span id="modalNextDueDate"></span>
                                                            </div>
                                                            <div>
                                                                <strong>Vet Name: </strong><span id="modalVetName"></span>
                                                            </div>
                                                            <div>
                                                                <strong>Vet Contact: </strong><span id="modalVetContact"></span>
                                                            </div>
                                                            <div>
                                                                <strong>Remarks: </strong><span id="modalRemarks"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="" data-bs-toggle="modal" data-bs-target="#addVaccineModal"><i class="text-end d-block mt-2" style="font-size: 0.9em;">> Update Vaccination</i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vaccine Information Modal -->
            <div class="modal fade" id="addVaccineModal" tabindex="-1" aria-labelledby="addVaccineModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addVaccineModalLabel">Add Vaccine Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="vaccineForm" method="POST">
                                <input type="hidden" class="form-control" id="animal_id" name="animal_id" readonly value="<?php echo $animal_id ?>">
                                <div class="mb-3">
                                    <label for="vaccine_name" class="form-label">Vaccine Name</label>
                                    <select class="form-select" id="vaccine_name" name="vaccine_name" required onchange="toggleOtherInput()">
                                        <option value="" disabled selected>----- Select Vaccine -----</option>
                                        <option value="5-in-1 Vaccine">5-in-1 Vaccine</option>
                                        <option value="Anti-Rabies Vaccine">Anti-Rabies Vaccine</option>
                                        <option value="Other">Others</option>
                                    </select>
                                </div>

                                <!-- Text input for "Other" vaccine -->
                                <div class="mb-3" id="other_vaccine_input" style="display:none;">
                                    <label for="other_vaccine_name" class="form-label">Other Vaccine Name</label>
                                    <input type="text" class="form-control" id="other_vaccine_name" name="other_vaccine_name">
                                </div>
                                <div class="mb-3">
                                    <label for="vaccination_date" class="form-label">Vaccination Date</label>
                                    <input type="date" class="form-control" id="vaccination_date" name="vaccination_date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="next_due_date" class="form-label">Vaccine Expiration</label>
                                    <input type="date" class="form-control" id="next_due_date" name="next_due_date">
                                </div>

                                <!-- Vet Name and Vet Contact on the same line -->
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label for="vet_name" class="form-label">Vet Name</label>
                                        <input type="text" class="form-control" id="vet_name" name="vet_name">
                                    </div>
                                    <div class="col-6">
                                        <label for="vet_contact" class="form-label">Vet Contact</label>
                                        <input type="text" class="form-control" id="vet_contact" name="vet_contact">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks"></textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary" id="submitVaccineBtn">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Success Edit Modal -->
            <div class="modal fade" id="successEditModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn-close d-flex ms-auto" onclick="location.reload();"></button>
                            <div class="text-center">
                                <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                                <p class="mt-4 px-2"> Record has been successfully edited!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Record Modal -->
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

            <!-- Success Record Modal -->
            <div class="modal fade" id="successVaccineModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn-close d-flex ms-auto" onclick="window.location.reload();"></button>
                            <div class="text-center">
                                <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                                <p class="mt-4 px-2"> Vaccine record has been successfully added!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Record Modal -->
            <div class="modal fade" id="successHealthModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn-close d-flex ms-auto" onclick="window.location.reload();"></button>
                            <div class="text-center">
                                <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                                <p class="mt-4 px-2" id="healthStatusMessage"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <script src="scripts/rescue-records.js"></script>
            <script src="scripts/animal-profile.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: login.php");
}
?>
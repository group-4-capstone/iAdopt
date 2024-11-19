<?php include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';


if (isset($_SESSION['email']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'head_admin')) {

    if (isset($_GET['id'])) {
        $application_id = $_GET['id'];
    
        $query = "
            SELECT *
            FROM applications 
            INNER JOIN users ON applications.user_id = users.user_id
            INNER JOIN animals ON applications.animal_id = animals.animal_id
            WHERE applications.application_id = ? 
        ";
    
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $application_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $application = $result->fetch_assoc();
        } else {
            // Redirect to not-found.php if the application is not found
            header("Location: not-found.php");
            exit(); // Ensure no further code is executed
        }
    } else {
        // Redirect to not-found.php if the request is invalid
        header("Location: not-found.php");
        exit();
    }

    $status = $application['animal_status'];
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
        case 'Adopted': // New case for Adopted status
            $badgeClass = 'bg-info'; // Assign a badge class, e.g., bg-info
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
        <title>iADOPT | Adoption Details</title>
        <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
        <link rel="stylesheet" href="styles/sidebar.css">
        <link rel="stylesheet" href="styles/styles.css">
        <link rel="stylesheet" href="styles/content-management.css">

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
                        <h1><u><b>ADOPTION DETAILS</b></u></h1>
                    </div>
                    <p>
                        Review the adoption application of <strong> ADOPTION #<?php echo $application['application_id'] ?> </strong>.
                    </p>
                </div>
            </section>
            

            <div class="container my-5">
                <!-- Selected Dog Details -->
                <div class="row dog-details mb-4">
                  <form id="statusForm" method="post" class="d-flex justify-content-end align-items-center mt-1 mb-2 me-4">
                        <label for="status" class="me-2">Status:</label>
                        <select 
                            id="status" class="form-select badge <?php echo $badgeClass; ?> w-25" name="animal_status" 
                            <?php echo $status === 'Adopted' ? 'disabled' : ''; ?>>
                            <option value="Adopted" <?php echo $status === 'Adopted' ? 'selected' : ''; ?>>Adopted</option>
                            <option value="Adoptable" <?php echo $status === 'Adoptable' ? 'selected' : ''; ?>>Adoptable</option>
                        </select>
                        <input type="hidden" id="animalId" value="<?php echo $application['animal_id'] ?>" readonly>
                    </form>

                    <!-- Modal -->
                    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Status Change</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to change the status to <span id="newStatus"></span>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" id="confirmBtn" class="btn btn-primary">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>

                     <!-- Success Modal -->
                    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                            <button type="button" class="btn-close d-flex ms-auto" onclick="window.location.reload();" ></button>
                            <div class="text-center">
                                <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                                <p class="mt-4 px-2"> Status has been updated successfully to <b>ADOPTED</b> !
                                </p>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>


                    <div class="col-lg-4 text-center">
                        <img src="styles/assets/animals/<?php echo $application['image'] ?>" class="img-fluid rounded-circle" alt="Selected Dog" style="width: 200px; height: 200px; object-fit: cover;">
                    </div>
                    <div class="col-lg-8">
                        <h2 class="mb-3"><?php echo $application['type'] ?> Name: <strong><?php echo $application['name'] ?></strong></h2>
                        <p><strong>Date Rescued:</strong>
                            <?php
                            $originalDate = $application['addition_date'];
                            echo date("F j, Y", strtotime($originalDate));
                            ?></p>
                        <p><strong>Description:</strong> <?php echo $application['description'] ?></p>
                    </div>
                </div>

                <div class="adopter-info">
                    <div class="row">
                        <!-- First Column: Header and Status -->
                        <div class="col-lg-4 col-md-5">
                            <h4 class="mt-2">Adopter Information</h4>
                            <p class="mt-3 ps-3">Application Status:
                                <span class="badge 
                    <?php
                    if ($application['application_status'] === 'Under Review') echo 'bg-warning text-dark';
                    elseif ($application['application_status'] === 'Rejected') echo 'bg-danger';
                    elseif ($application['application_status'] === 'Approved') echo 'bg-success';
                    ?>">
                                    <?php echo $application['application_status']; ?>
                                </span>
                            </p>
                            <?php if ($application['application_status'] === 'Rejected') echo 'Reason: ' . $application['status_message']; ?>
                            <p class="ps-2">
                                <?php
                               if ($application['application_status'] === 'Approved') {
                                   $interviewDate = new DateTime($application['sched_interview']);
                                   echo '<br>Scheduled Interview:<br> ' . $interviewDate->format('d F Y, h:i A');
                                   echo ' <i class="bi bi-pencil-square edit-interview-icon" data-bs-toggle="modal" data-bs-target="#scheduleInterviewModal" 
                                       data-application-id="' . $application['application_id'] . '"
                                       data-interview-date="' . $interviewDate->format('Y-m-d') . '"
                                       data-interview-time="' . $interviewDate->format('H:i') . '"
                                       style="cursor:pointer;"></i>';
                               }
                               ?>
                            </p>

                        </div>

                        <!-- Second Column: Adopter Details -->
                        <div class="col-lg-8 col-md-7">
                            <div class="ps-3">
                                <p class="mt-3"><strong>Name:</strong> <?php echo $application['first_name'] . ' ' . $application['last_name']; ?></p>
                                <p><strong>Email:</strong> <?php echo $application['email'] ?></p>
                                <p><strong>Phone:</strong> <?php echo $application['contact_num'] ?></p>
                                <p><strong>Address:</strong> <?php echo $application['complete_address'] ?></p>
                                <p><strong>Work:</strong> <?php echo $application['profession'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>




                <!-- Accordion for Questionnaire Response and Proof -->
                <div class="accordion" id="adoptionDetailsAccordion">
                    <!-- Questionnaire Response -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingQuestionnaire">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseQuestionnaire" aria-expanded="true" aria-controls="collapseQuestionnaire">
                                Questionnaire Response
                            </button>
                        </h2>
                        <div id="collapseQuestionnaire" class="accordion-collapse collapse show" aria-labelledby="headingQuestionnaire" data-bs-parent="#adoptionDetailsAccordion">
                            <div class="accordion-body">
                                <p><strong>Why did you decide to adopt an animal?</strong></p>
                                <p class="ps-2">> <?php echo $application['purpose'] ?></p>
                                <p><strong>What type of residence do you live in?</strong></p>
                                <p class="ps-2">> <?php echo $application['residence'] ?></p>
                                <p><strong>Please specify the height and type of your fence.</strong></p>
                                <p><strong>How will you handle the dog's exercise and toilet duties if there is no fence?</strong></p>
                                <!---
                    <p><strong>If adopting a cat, where will be the litter box be kept?</strong></p> -->
                                <p><strong>Is the residence for RENT?</strong></p>
                                <p><strong>Please upload a written letter from your landlord that pets are allowed.</strong></p>
                                <p><strong>In which part of the house will the animal stay?</strong></p>
                                <p class="ps-2">> <?php echo $application['house_part'] ?></p>
                                <p><strong>Where will this animal be kept during the day and during night? Please specify.</strong></p>
                                <p><strong>Who do you live with? Please be specific.</strong></p>
                                <p class="ps-2">> <?php echo $application['household_members'] ?></p>
                                <p><strong>How long have you lived in the address registered here?</strong></p>
                                <p class="ps-2">> <?php echo $application['reg_years'] ?> years</p>
                                <p><strong>Are you planning to move in the next six (6) months?</strong></p>
                                <p><strong>Please leave a specific address.</strong></p>
                                <p><strong>Will the whole family be involved in the care of the animal?</strong></p>
                                <p><strong>Please explain why no.</strong></p>
                                <p><strong>Is there anyone in your household who has objection(s) to the arrangement?</strong></p>
                                <p><strong>Please explain why yes.</strong></p>
                                <p><strong>Are there any children who visit your home frequently?</strong></p>
                                <p><strong>Are there any other regular visitors on your home which your new companion (pet) must get along?</strong></p>
                                <p><strong>Are there any member of your household who has an allergy to cats and dogs?</strong></p>
                                <p><strong>Who?</strong></p>
                                <p><strong>What will happen to this animal if you have to move unexpectedly?</strong></p>
                                <p class="ps-2">> <?php echo $application['move_unexpectedly'] ?></p>
                                <p><strong>What kind of behavior(s) of the dog do you feel you will be unable to accept?</strong></p>
                                <p class="ps-2">> <?php echo $application['unacceptable_behavior'] ?></p>
                                <p><strong>How many hours in an average work day will your companion animal spend without a human?</strong></p>
                                <p class="ps-2">> <?php echo $application['no_human_hours'] ?> hours</p>
                                <p><strong>What will happen to your companion animal when you go on vacation or in case of emergency?</strong></p>
                                <p class="ps-2">> <?php echo $application['emergency'] ?></p>
                                <p><strong>Do you have other companion animals?</strong></p>
                                <p><strong>Please specify what type and the total number.</strong></p>
                                <p><strong>Do you have a regular veterinarian?</strong></p>
                                <p><strong>Veterinarian Name</strong></p>
                                <p><strong>Veterinarian Address/Location</strong></p>
                                <p><strong>Veterinarian Contact Number</strong></p>
                            </div>
                        </div>
                    </div>
                    <!-- Proof -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingProof">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProof" aria-expanded="false" aria-controls="collapseProof">
                                Proof
                            </button>
                        </h2>
                        <div id="collapseProof" class="accordion-collapse collapse" aria-labelledby="headingProof" data-bs-parent="#adoptionDetailsAccordion">
                            <div class="accordion-body">
                                <p class="mt-2">Proof of identity and home address will be required during the adoption process.</p>

                                <!-- Row for Images -->
                                <div class="row mt-3">
                                    <!-- Sample ID Image -->
                                    <div class="col-md-6">
                                        <h5>Valid ID:</h5>
                                        <img src="styles/assets/applications/ids/<?php echo $application['valid_id'] ?>" alt="Sample ID" class="img-fluid mb-3" style="max-width: 100%;">
                                    </div>

                                    <!-- Picture of the Place where Pet will be Staying -->
                                    <div class="col-md-6">
                                        <h5>Picture of the Pet's New Home:</h5>
                                        <img src="styles/assets/house.jpg" alt="Pet's New Home" class="img-fluid mb-3" style="max-width: 100%;">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Approve and Reject Buttons -->

                <?php if ($application['application_status'] == 'Under Review') { ?>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-success me-2" id="approveBtn" data-bs-toggle="modal" data-bs-target="#scheduleInterviewModal">Approve</button>
                        <button type="button" class="btn btn-danger" id="rejectBtn" data-bs-toggle="modal" data-bs-target="#rejectReasonModal">Reject</button>
                    </div>
                <?php } else { ?>

                <?php } ?>


                <!-- Modal for Scheduling Interview -->
                <div class="modal fade" id="scheduleInterviewModal" tabindex="-1" aria-labelledby="scheduleInterviewModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="scheduleInterviewModalLabel">Schedule Interview</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="scheduleInterviewForm" method="post">
                                    <input type="hidden" name="application_id" id="interview_application_id" value="<?php echo $application['application_id']; ?>" readonly>
                                    <input type="hidden" name="application_status" value="Approved" readonly>

                                    <!-- Hidden input to store concatenated date and time -->
                                    <input type="hidden" id="sched_interview" name="sched_interview">

                                    <!-- Date Selection -->
                                    <div class="mb-3">
                                        <label for="interviewDate" class="form-label">Select Interview Date:</label>
                                        <input type="date" id="interviewDate" class="form-control" required>
                                    </div>

                                    <!-- Time Selection -->
                                    <div class="mb-3">
                                        <label for="interviewTime" class="form-label">Select Interview Time:</label>
                                        <select id="interviewTime" class="form-select" required>
                                            <option value="" selected disabled>-- Kindly select a time --</option>
                                            <!-- Generate Time Options from 8:00 AM to 10:00 PM at 30-minute intervals -->
                                            <?php
                                            $startTime = strtotime('08:00 AM');
                                            $endTime = strtotime('10:00 PM');
                                            while ($startTime <= $endTime) {
                                                echo '<option value="' . date('H:i', $startTime) . '">' . date('h:i A', $startTime) . '</option>';
                                                $startTime = strtotime('+30 minutes', $startTime);
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="submitInterviewBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal for Reject Reason -->
                <div class="modal fade" id="rejectReasonModal" tabindex="-1" aria-labelledby="rejectReasonModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rejectReasonModalLabel">Enter Reject Reason</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="rejectReasonForm" method="post" action="includes/update-adoption-status.php">
                                    <input type="hidden" name="application_id" id="reject_application_id" value="<?php echo $application['application_id']; ?>" readonly>
                                    <input type="hidden" name="application_status" value="Rejected" readonly>
                                    <textarea id="rejectReason" class="form-control" rows="4" required placeholder="Enter reason for rejection" name="status_message"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="submitRejectBtn">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                
      <!-- Success Status Update Modal -->
<div class="modal fade" id="statusUpdateModal" tabindex="-1" aria-labelledby="statusUpdateModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal" onclick="location.reload();"></button>
                <div class="text-center">
                    <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                    <p class="mt-4 px-2"> The application status has been updated successfully!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


            </div>
        </div>
        <script src="scripts/adoption-details.js"></script>
    </body>

    </html>

<?php
} else {
    header("Location: login.php");
}
?>
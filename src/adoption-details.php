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

            // Additional query for post_adoption table
            $queryPostAdoption = "
            SELECT *
            FROM post_adoption
            WHERE application_id = ?
        ";

            $stmtPostAdoption = $db->prepare($queryPostAdoption);
            $stmtPostAdoption->bind_param("i", $application_id);
            $stmtPostAdoption->execute();
            $resultPostAdoption = $stmtPostAdoption->get_result();
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
                    <div class="d-flex justify-content-end align-items-center mt-1 mb-2 me-4">
                        <label for="status" class="me-2">Status:</label>
                        <span class="badge <?php echo $badgeClass; ?> w-25">
                            <?php echo $status; ?>
                        </span>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Adoption</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Do you confirm that <strong><?php echo $application['name'] ?></strong> is adopted?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="confirmBtn" class="btn btn-warning text-white">Yes</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Success Modal -->
                    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <button type="button" class="btn-close d-flex ms-auto" onclick="window.location.reload();"></button>
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
                        <h2 class="mb-3">
                            <?php echo $application['type'] ?> Name: <strong><?php echo $application['name'] ?></strong>
                        </h2>
                        <p><strong>Date Rescued:</strong>
                            <?php
                            $originalDate = $application['addition_date'];
                            echo date("F j, Y", strtotime($originalDate));
                            ?>
                        </p>
                        <p><strong>Description:</strong> <?php echo $application['description'] ?></p>
                        <p><a href="animal-record.php?animal_id=<?php echo $application['animal_id']; ?>">View Profile</a></p>

                        <?php if ($application['application_status'] === 'Approved' && $application['animal_status'] !== 'Adopted') { ?>
                            <div style="text-align: right; margin-top: 20px;">
                                <form id="markAdoptedForm">
                                    <input type="hidden" id="animalId" value="<?php echo $application['animal_id'] ?>" readonly>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                                        <span><i class="fa-solid fa-check me-1"></i> Mark as Adopted</span>
                                    </button>
                                </form>
                            </div>
                        <?php }  ?>
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
                                    if ($application['animal_status'] !== 'Adopted') {
                                        echo ' <i class="bi bi-pencil-square edit-interview-icon" data-bs-toggle="modal" data-bs-target="#scheduleInterviewModal" 
                                        data-application-id="' . $application['application_id'] . '"
                                        data-interview-date="' . $interviewDate->format('Y-m-d') . '"
                                        data-interview-time="' . $interviewDate->format('H:i') . '"
                                        style="cursor:pointer;"></i>';
                                    }
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
                                <p><strong>Work:</strong> <?php echo !empty($application['profession']) ? $application['profession'] : 'No Work'; ?></p>
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
                            <div class="accordion-body px-5">
                                <p><strong>Why did you decide to adopt an animal?</strong></p>
                                <p class="ps-2">> <?php echo $application['purpose'] ?></p>
                                <p><strong>What type of residence do you live in?</strong></p>
                                <p class="ps-2">> <?php echo $application['residence'] ?></p>

                                <?php if (
                                    $application['residence'] === 'Detached House (with fence/gate)' ||
                                    $application['residence'] === 'Townhouse (with fence/gate)'
                                ): ?>
                                    <p><strong>Please specify the height and type of your fence.</strong></p>
                                    <p class="ps-2">> <?php echo $application['fence']; ?></p>
                                <?php else: ?>
                                    <p><strong>How will you handle the dog's exercise and toilet duties if there is no fence?</strong></p>
                                    <p class="ps-2">> <?php echo $application['no_fence']; ?></p>
                                <?php endif; ?>

                                <?php if ($application['type'] === 'Cat'): ?>
                                    <p><strong>If adopting a cat, where will the litter box be kept?</strong></p>
                                    <p class="ps-2">> <?php echo $application['litter_place']; ?></p>
                                <?php endif; ?>

                                <p><strong>Is the residence for RENT?</strong></p>
                                <?php if (!empty($application['rent_letter'])): ?>
                                    <p class="ps-2">> Yes.

                                    <p><strong>Please upload a written letter from your landlord that pets are allowed.</strong></p>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#rentLetterModal" class="text-primary">View File</a></p>

                                    <!-- Modal for viewing rent letter -->
                                    <div class="modal fade" id="rentLetterModal" tabindex="-1" aria-labelledby="rentLetterModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="rentLetterModalLabel">Rent Letter</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php
                                                    $fileExtension = strtolower(pathinfo($application['rent_letter'], PATHINFO_EXTENSION)); // Ensure case insensitivity
                                                    $rentLetterPath = 'styles/assets/applications/letter/' . htmlspecialchars($application['rent_letter'], ENT_QUOTES, 'UTF-8'); // Construct safe file path

                                                    if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'webp'])) {
                                                        // Display image
                                                        echo '<img src="' . $rentLetterPath . '" alt="Rent Letter" class="img-fluid">';
                                                    } elseif ($fileExtension === 'pdf') {
                                                        // Embed PDF
                                                        echo '<embed src="' . $rentLetterPath . '" type="application/pdf" width="100%" height="600px">';
                                                    } else {
                                                        echo '<p>Unable to preview this file type.</p>';
                                                    }
                                                    ?>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p class="ps-2">> No</p>
                                <?php endif; ?>

                                <p><strong>In which part of the house will the animal stay?</strong></p>
                                <p class="ps-2">> <?php echo $application['house_part'] ?></p>
                                <p><strong>Where will this animal be kept during the day and during night? Please specify.</strong></p>
                                <p class="ps-2">> <?php echo $application['stay_place'] ?></p>
                                <p><strong>Who do you live with? Please be specific.</strong></p>
                                <p class="ps-2">> <?php echo $application['household_members'] ?></p>
                                <p><strong>How long have you lived in the address registered here?</strong></p>
                                <p class="ps-2">> <?php echo $application['reg_years'] ?> years</p>
                                <p><strong>Are you planning to move in the next six (6) months?</strong></p>

                                <?php if (!empty($application['new_address'])): ?>
                                    <p class="ps-2">> Yes</p>
                                    <p><strong>Please leave a specific address.</strong></p>
                                    <p class="ps-2">> <?php echo htmlspecialchars($application['new_address'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php else: ?>
                                    <p class="ps-2">> No</p>
                                <?php endif; ?>

                                <p><strong>Will the whole family be involved in the care of the animal?</strong></p>
                                <?php if (!empty($application['involved_reason'])): ?>
                                    <p class="ps-2">> No</p>
                                    <p><strong>Please explain why no.</strong></p>
                                    <p class="ps-2">> <?php echo htmlspecialchars($application['involved_reason'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php else: ?>
                                    <p class="ps-2">> Yes</p>
                                <?php endif; ?>

                                <p><strong>Is there anyone in your household who has objection(s) to the arrangement?</strong></p>
                                <?php if (!empty($application['object_reason'])): ?>
                                    <p class="ps-2">> Yes</p>
                                    <p><strong>Please explain why yes.</strong></p>
                                    <p class="ps-2">> <?php echo htmlspecialchars($application['object_reason'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php else: ?>
                                    <p class="ps-2">> No</p>
                                <?php endif; ?>

                                <p><strong>Are there any children who visit your home frequently?</strong></p>
                                <p class="ps-2">> <?php echo ucfirst($application['children_visit']); ?></p>

                                <p><strong>Are there any other regular visitors to your home which your new companion (pet) must get along?</strong></p>
                                <p class="ps-2">> <?php echo ucfirst($application['other_visit']); ?></p>

                                <p><strong>Are there any members of your household who have an allergy to cats and dogs?</strong></p>
                                <?php if (!empty($application['member_allergy'])): ?>
                                    <p class="ps-2">> Yes</p>
                                    <p><strong>Who?</strong></p>
                                    <p class="ps-2">> <?php echo htmlspecialchars($application['member_allergy'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php else: ?>
                                    <p class="ps-2">> No</p>
                                <?php endif; ?>

                                <p><strong>What will happen to this animal if you have to move unexpectedly?</strong></p>
                                <p class="ps-2">> <?php echo $application['move_unexpectedly'] ?></p>
                                <p><strong>What kind of behavior(s) of the dog do you feel you will be unable to accept?</strong></p>
                                <p class="ps-2">> <?php echo $application['unacceptable_behavior'] ?></p>
                                <p><strong>How many hours in an average work day will your companion animal spend without a human?</strong></p>
                                <p class="ps-2">> <?php echo $application['no_human_hours'] ?> hours</p>
                                <p><strong>What will happen to your companion animal when you go on vacation or in case of emergency?</strong></p>
                                <p class="ps-2">> <?php echo $application['emergency'] ?></p>
                                <p><strong>Do you have other companion animals?</strong></p>
                                <?php if (!empty($application['other_animals'])): ?>
                                    <p class="ps-2">> Yes</p>
                                    <p><strong>Please specify what type and the total number.</strong></p>
                                    <p class="ps-2">> <?php echo htmlspecialchars($application['other_animals'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php else: ?>
                                    <p class="ps-2">> No</p>
                                <?php endif; ?>

                                <p><strong>Do you have a regular veterinarian?</strong></p>
                                <?php if (!empty($application['vet_name']) && !empty($application['vet_address']) && !empty($application['vet_number'])): ?>
                                    <p class="ps-2">> Yes</p>
                                    <p><strong>Veterinarian Name</strong></p>
                                    <p class="ps-2">> <?php echo htmlspecialchars($application['vet_name'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p><strong>Veterinarian Address/Location</strong></p>
                                    <p class="ps-2">> <?php echo htmlspecialchars($application['vet_address'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p><strong>Veterinarian Contact Number</strong></p>
                                    <p class="ps-2">> <?php echo htmlspecialchars($application['vet_number'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php else: ?>
                                    <p class="ps-2">> None</p>
                                <?php endif; ?>

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
                    <?php
                    if ($resultPostAdoption->num_rows > 0) {
                        // Initialize counter
                        $counter = 1; ?>
                        <br>
                        <h4 class="mb-2"> > Post- Adoption Forms</h4>
                        <?php  // Loop through all rows
                        while ($postAdoption = $resultPostAdoption->fetch_assoc()) { ?>
                            <!-- Post Adoption Section -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingPost<?php echo $postAdoption['post_id']; ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePost<?php echo $postAdoption['post_id']; ?>" aria-expanded="false" aria-controls="collapsePost<?php echo $postAdoption['post_id']; ?>">
                                        Post-Adoption Form No. <?php echo $counter; ?>
                                    </button>
                                </h2>
                                <div id="collapsePost<?php echo $postAdoption['post_id']; ?>" class="accordion-collapse collapse" aria-labelledby="headingPost<?php echo $postAdoption['post_id']; ?>" data-bs-parent="#adoptionPostAccordion">
                                    <div class="accordion-body">
                                        <p><strong>Submitted Date:</strong> <?php
                                                                            // Format the date
                                                                            $date = new DateTime($postAdoption['submit_date']);
                                                                            echo $date->format('F j, Y');
                                                                            ?></p>
                                        <p><strong>Description:</strong> <?php echo htmlspecialchars($postAdoption['adoption_description']); ?></p>
                                        <div class="row">
                                            <?php
                                            $images = json_decode($postAdoption['adoption_image']);
                                            if (!empty($images)) {
                                                foreach ($images as $image) { ?>
                                                    <div class="col-md-4 mb-3">
                                                        <img src="styles/assets/post-adoption/<?php echo htmlspecialchars($image); ?>" class="img-fluid rounded" alt="Adoption Image">
                                                    </div>
                                            <?php }
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    <?php
                            // Increment counter for the next post
                            $counter++;
                        }
                    } else {
                        $postAdoption = null; // No post-adoption data found
                    }
                    ?>




                </div>

                <!-- Approve and Reject Buttons -->

                <?php if ($application['application_status'] == 'Under Review') { ?>
                    <div class="d-flex justify-content-end mt-4">
                    <?php if ($application['animal_status'] !== 'Adopted') { ?>
                        <button type="button" class="btn btn-success me-2" id="approveBtn" data-bs-toggle="modal" data-bs-target="#scheduleInterviewModal">Approve</button>
                        <?php } ?>
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
                                    <?php
                                    // Extract date and time from 'sched_interview'
                                    $schedInterview = $application['sched_interview'] ?? null; // Example: '2025-01-03 09:30:00'
                                    $interviewDate = $schedInterview ? date('Y-m-d', strtotime($schedInterview)) : ''; // Extract date if available
                                    $interviewTime = $schedInterview ? date('H:i', strtotime($schedInterview)) : ''; // Extract time if available
                                    ?>

                                    <input type="hidden" name="application_id" id="interview_application_id" value="<?php echo $application['application_id']; ?>" readonly>
                                    <input type="hidden" name="application_status" value="Approved" readonly>

                                    <!-- Hidden input to store concatenated date and time -->
                                    <input type="hidden" id="sched_interview" name="sched_interview">

                                    <!-- Date Selection -->
                                    <div class="mb-3">
                                        <label for="interviewDate" class="form-label">Select Interview Date:</label>
                                        <input type="date" id="interviewDate" class="form-control" value="<?php echo $interviewDate; ?>" required>
                                    </div>

                                    <!-- Time Selection -->
                                    <div class="mb-3">
                                        <label for="interviewTime" class="form-label">Select Interview Time:</label>

                                        <select id="interviewTime" class="form-select" required>
                                            <option value="" disabled selected>-- Kindly select a time --</option>
                                            <?php
                                            $startTime = strtotime('08:00 AM');
                                            $endTime = strtotime('10:00 PM');
                                            while ($startTime <= $endTime) {
                                                $formattedTime = date('H:i', $startTime); // Value format 'HH:mm'
                                                $displayTime = date('h:i A', $startTime); // Display format 'hh:mm AM/PM'
                                                $selected = ($formattedTime === $interviewTime) ? 'selected' : ''; // Pre-select if matches
                                                echo '<option value="' . $formattedTime . '" ' . $selected . '>' . $displayTime . '</option>';
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

                    <!-- Predefined Reasons -->
                    <label for="rejectReasonDropdown" class="form-label">Select a reason for rejection:</label>
                    <select id="rejectReasonDropdown" class="form-select" name="status_message" required>
                        <option value="" disabled selected>Select a reason</option>
                        <option value="Inadequate living space">Inadequate living space</option>
                        <option value="Financial constraints">Financial constraints</option>
                        <option value="Lack of experience with pets">Lack of experience with pets</option>
                        <option value="Concerns about commitment">Concerns about commitment</option>
                        <option value="Other">Other</option>
                    </select>

                    <!-- Custom Reason -->
                    <div id="customReasonContainer" class="mt-3 d-none">
                        <label for="customRejectReason" class="form-label">Enter custom reason:</label>
                        <textarea id="customRejectReason" class="form-control" rows="4" name="custom_status_message" placeholder="Enter custom reason"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="submitRejectBtn">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Show/hide custom reason input based on dropdown selection
    const rejectReasonDropdown = document.getElementById('rejectReasonDropdown');
    const customReasonContainer = document.getElementById('customReasonContainer');
    const customRejectReason = document.getElementById('customRejectReason');

    rejectReasonDropdown.addEventListener('change', () => {
        if (rejectReasonDropdown.value === 'Other') {
            customReasonContainer.classList.remove('d-none');
            customRejectReason.setAttribute('required', 'required');
        } else {
            customReasonContainer.classList.add('d-none');
            customRejectReason.removeAttribute('required');
        }
    });
</script>



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
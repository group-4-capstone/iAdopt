<?php include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

if (isset($_SESSION['email']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'head_admin')) {

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iADOPT | SECASPI</title>
    <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
    <link rel="stylesheet" href="styles/sidebar.css">
    <link rel="stylesheet" href="styles/content-management.css">
    <link rel="stylesheet" href="styles/styles.css">

    <!-- Google Fonts Links For Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  </head>

  <body>

    <?php include_once 'components/sidebar.php'; ?>

    <div class="admin-content">

      <section class="banner-section">
        <div class="content">
          <div class="head-title">
            <h1><u><b>CONTENT MANAGEMENT</b></u></h1>
          </div>
          <p>
            Manage contents seen in the user side and keep these information updated.
          </p>
        </div>
      </section>

      <?php
      $announcement_query = "SELECT * FROM announcements";
      $announcement_result = $db->query($announcement_query);
      if ($announcement_result->num_rows > 0) {
        while ($row = $announcement_result->fetch_assoc()) { ?>

          <!-- View announcement details modal -->
          <div class="modal fade" id="announcementModal_<?php echo $row['announcement_id']; ?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addAnnouncementModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="card p-2">
                    <div class="card-body">
                      <h4 class="pb-4"> <?php echo "ANNOUNCEMENT ID #" . $row['announcement_id']; ?></h4>
                      <form method="post" id="announcementForm_<?php echo $row['announcement_id']; ?>" enctype="multipart/form-data">
                        <div class="row mb-3">
                          <label for="announcementTitle" class="col-3 col-form-label">Title<span class="asterisk">*</span></label>
                          <div class="col-9">
                            <input type="text" class="form-control" name="title" id="announcementTitle_<?php echo $row['announcement_id']; ?>" value="<?php echo $row['title']; ?>" readonly>
                          </div>
                        </div>
                        <input type="hidden" name="announcement_id" value="<?php echo $row['announcement_id']; ?>" readonly>
                        <div class="row mb-3">
                          <label for="announcementStatus" class="col-3 col-form-label">Status<span class="asterisk">*</span></label>
                          <div class="col-3">
                            <select class="form-select" id="announcementStatus_<?php echo $row['announcement_id']; ?>" name="status" disabled>
                              <option value="" disabled>Kindly select an option</option>
                              <option value="Draft" <?php echo ($row['status'] == 'Draft') ? 'selected' : ''; ?>>Draft</option>
                              <option value="Scheduled Post" <?php echo ($row['status'] == 'Scheduled Post') ? 'selected' : ''; ?>>Scheduled Post</option>
                              <option value="Published" <?php echo ($row['status'] == 'Published') ? 'selected' : ''; ?>>Publish Now</option>
                            </select>
                          </div>
                          <label for="publishDate" class="col-3 col-form-label">Date to be Published<span class="asterisk">*</span></label>
                          <div class="col-3">
                            <input type="date" class="form-control" id="publishDate_<?php echo $row['announcement_id']; ?>" name="announcement_date" value="<?php echo $row['publish_date']; ?>" readonly>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="announcementContent" class="col-3 col-form-label">Content<span class="asterisk">*</span></label>
                          <div class="col-9 mb-3">
                            <div id="announcementContent_<?php echo $row['announcement_id']; ?>" style="border: 2px solid #ced4da; border-radius: 5px; padding: 10px; background-color: #f8f9fa;">
                              <?php echo ($row['description']); ?>
                            </div>
                            <input type="hidden" name="description" id="announcementContentHidden_<?php echo $row['announcement_id']; ?>" value="<?php echo htmlspecialchars($row['description']); ?>">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="announcementImage" class="col-3 col-form-label">Current Image<span class="asterisk">*</span></label>
                          <div class="col-9">
                            <img src="styles/assets/announcement/<?php echo htmlspecialchars($row['image']); ?>" alt="Announcement Image" class="img-fluid mb-3" id="announcementImageDisplay_<?php echo $row['announcement_id']; ?>" style="max-height: 250px; object-fit: cover;">
                            <input type="file" class="form-control" name="new_image" id="annImageInput_<?php echo $row['announcement_id']; ?>" accept="image/*" style="display: none;">
                          </div>
                        </div>
                        <div class="row mb-1">
                          <div class="col-9 offset-3 d-flex justify-content-end">
                            <button type="button" class="btn me-2" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="editAnnouncementBtn_<?php echo $row['announcement_id']; ?>" onclick="toggleEditAnnouncement(<?php echo $row['announcement_id']; ?>)">Edit Post</button>
                            <button type="submit" class="btn btn-success" id="saveAnnouncementBtn_<?php echo $row['announcement_id']; ?>" disabled style="display:none;">Save Changes</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><?php }
            } ?>

<?php
$merch_query = "SELECT * FROM merchandise";
$merch_result = $db->query($merch_query);
if ($merch_result->num_rows > 0) {
  while ($row = $merch_result->fetch_assoc()) { ?>
    <!-- View merchandise details modal -->
    <div class="modal fade" id="merchModal_<?php echo $row['merch_id']; ?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="merchModalLabel_<?php echo $row['merch_id']; ?>" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <div class="card p-3">
              <div class="card-body">
                <h4 class="pb-4"> <?php echo "MERCHANDISE ID #" . $row['merch_id']; ?></h4>
                <form method="post" id="merchForm_<?php echo $row['merch_id']; ?>" action="includes/edit-merchandise.php" enctype="multipart/form-data">
                  <div class="row mb-3">
                    <!-- Merchandise Item Label -->
                    <label for="merchItem_<?php echo $row['merch_id']; ?>" class="col-3 col-form-label">Merchandise Item<span class="asterisk">*</span></label>
                    <div class="col-9">
                      <input type="text" class="form-control" name="item" id="merchItem_<?php echo $row['merch_id']; ?>" value="<?php echo $row['item']; ?>" readonly>
                    </div>
                  </div>
                  <input type="hidden" name="merch_id" value="<?php echo $row['merch_id']; ?>" readonly>
                  <div class="row mb-3">
                    <!-- Link Label -->
                    <label for="itemLink_<?php echo $row['merch_id']; ?>" class="col-3 col-form-label">Link<span class="asterisk">*</span></label>
                    <div class="col-9">
                      <input type="text" class="form-control" name="link" id="itemLink_<?php echo $row['merch_id']; ?>" value="<?php echo $row['link']; ?>" readonly>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <!-- Image Label -->
                    <label for="merchImage_<?php echo $row['merch_id']; ?>" class="col-3 col-form-label">Image<span class="asterisk">*</span></label>
                    <div class="col-9">
                      <img src="styles/assets/merchandise/<?php echo $row['image']; ?>" alt="Merchandise Image" class="img-fluid mb-3" style="max-height: 250px; object-fit: cover;">
                      <input type="file" class="form-control" name="new_image" id="newImageInput_<?php echo $row['merch_id']; ?>" accept="image/*" style="display: none;">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <!-- Status Label -->
                    <label for="merchStatus_<?php echo $row['merch_id']; ?>" class="col-3 col-form-label">Status<span class="asterisk">*</span></label>
                    <div class="col-9">
                      <select class="form-select" id="merchStatus_<?php echo $row['merch_id']; ?>" name="status" disabled>
                        <option value="Draft" <?php echo ($row['status'] == 'Draft') ? 'selected' : ''; ?> disabled>Draft</option>
                        <option value="Published" <?php echo ($row['status'] == 'Published') ? 'selected' : ''; ?>>Publish Now</option>
                        <option value="Unpublished" <?php echo ($row['status'] == 'Unpublished') ? 'selected' : ''; ?>>Unpublish </option>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-9 offset-3 d-flex justify-content-end">
                      <button type="button" class="btn me-2" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" id="editMerchandiseBtn_<?php echo $row['merch_id']; ?>" onclick="toggleEditMode(<?php echo $row['merch_id']; ?>)">Edit Post</button>
                      <button type="submit" class="btn btn-success" id="saveMerchandiseBtn_<?php echo $row['merch_id']; ?>" disabled style="display:none;">Save Changes</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php }
}
?>
     <?php
$volunteer_query = "SELECT * FROM volunteers";
$volunteer_result = $db->query($volunteer_query);
if ($volunteer_result->num_rows > 0) {
  while ($row = $volunteer_result->fetch_assoc()) { ?>
    <!-- View volunteer details modal -->
    <div class="modal fade" id="volunteerModal_<?php echo $row['volunteer_id']; ?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="volunteerModalLabel_<?php echo $row['volunteer_id']; ?>" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body p-4">
            <div class="card p-3">
              <h3 class="pb-4">Volunteer ID #<?php echo $row['volunteer_id']; ?></h3>
              <form method="post" id="volunteerForm_<?php echo $row['volunteer_id']; ?>" action="includes/edit-volunteer.php">
                <div class="row mb-3">
                  <label for="volunteerName_<?php echo $row['volunteer_id']; ?>" class="col-3 col-form-label">Name<span class="asterisk">*</span></label>
                  <div class="col-5">
                    <input type="text" class="form-control" id="volunteerFName_<?php echo $row['volunteer_id']; ?>" name="first_name" value="<?php echo $row['first_name']; ?>" readonly>
                  </div>
                  <div class="col-4">
                    <input type="text" class="form-control" id="volunteerLName_<?php echo $row['volunteer_id']; ?>" name="last_name" value="<?php echo $row['last_name']; ?>" readonly>
                  </div>
                </div>
                <input type="hidden" name="volunteer_id" value="<?php echo $row['volunteer_id']; ?>" readonly>
                <div class="row mb-3">
                  <label for="volunteerRole_<?php echo $row['volunteer_id']; ?>" class="col-3 col-form-label">Role<span class="asterisk">*</span></label>
                  <div class="col-9">
                    <select class="form-select" id="volunteerRole_<?php echo $row['volunteer_id']; ?>" name="role" disabled>
                      <option value="Caretaker" <?php echo ($row['role'] == 'Caretaker') ? 'selected' : ''; ?>>Caretaker</option>
                      <option value="Assistant" <?php echo ($row['role'] == 'Assistant') ? 'selected' : ''; ?>>Assistant</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="volunteerStatus_<?php echo $row['volunteer_id']; ?>" class="col-3 col-form-label">Status<span class="asterisk">*</span></label>
                  <div class="col-9">
                    <select class="form-select" id="volunteerStatus_<?php echo $row['volunteer_id']; ?>" name="status" disabled>
                      <option value="active" <?php echo ($row['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                      <option value="inactive" <?php echo ($row['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-9 offset-3 d-flex justify-content-end">
                      <button type="button" class="btn me-2" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" id="editVolunteerBtn_<?php echo $row['volunteer_id']; ?>" onclick="toggleEditVolunteer(<?php echo $row['volunteer_id']; ?>)">Edit Post</button>
                      <button type="submit" class="btn btn-success" id="saveVolunteerBtn_<?php echo $row['volunteer_id']; ?>" disabled style="display:none;">Save Changes</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php }
}
?>


<?php
$faq_query = "SELECT * FROM faqs";
$faq_result = $db->query($faq_query);
if ($faq_result->num_rows > 0) {
  while ($row = $faq_result->fetch_assoc()) { ?>
    <!-- View FAQ details modal -->
    <div class="modal fade" id="FAQModal_<?php echo $row['faq_id']; ?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="faqModalLabel_<?php echo $row['faq_id']; ?>" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body p-4">
            <div class="card p-3">
              <h3 class="pb-4">FAQ ID #<?php echo $row['faq_id']; ?></h3>
              <form method="post" id="FAQForm_<?php echo $row['faq_id']; ?>">
                <div class="row mb-3">
                  <label for="question_<?php echo $row['faq_id']; ?>" class="col-3 col-form-label">Question<span class="asterisk">*</span></label>
                  <div class="col-9">
                    <input type="text" class="form-control" id="question_<?php echo $row['faq_id']; ?>" name="question" value="<?php echo $row['question']; ?>" readonly>
                  </div>
                </div>
                <input type="hidden" name="faq_id" value="<?php echo $row['faq_id']; ?>" readonly>
                <div class="row mb-3">
                  <label for="faqContent_<?php echo $row['faq_id']; ?>" class="col-3 col-form-label">Answer<span class="asterisk">*</span></label>
                  <div class="col-9 mb-3">
                    <div id="faqContent_<?php echo $row['faq_id']; ?>" style="border: 2px solid #ced4da; border-radius: 5px; padding: 10px; background-color: #f8f9fa;">
                          <?php echo ($row['answer']); ?>
                    </div>
                    <input type="hidden" name="answer" id="faqContentHidden_<?php echo $row['faq_id']; ?>" value="<?php echo htmlspecialchars($row['answer']); ?>">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="faqStatus_<?php echo $row['faq_id']; ?>" class="col-3 col-form-label">Status<span class="asterisk">*</span></label>
                  <div class="col-9">
                    <select class="form-select" id="faqStatus_<?php echo $row['faq_id']; ?>" name="status" disabled>
                      <option value="Draft" <?php echo ($row['status'] == 'Draft') ? 'selected' : ''; ?> disabled>Draft</option>
                      <option value="Published" <?php echo ($row['status'] == 'Published') ? 'selected' : ''; ?>>Publish</option>
                      <option value="Unpublished" <?php echo ($row['status'] == 'Unpublished') ? 'selected' : ''; ?>>Unpublish</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-9 offset-3 d-flex justify-content-end">
                  <button type="button" class="btn me-2" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="editFAQBtn_<?php echo $row['faq_id']; ?>" class="btn btn-primary me-2" onclick="toggleEditFAQ(<?php echo $row['faq_id']; ?>)">Edit Post</button>
                    <button type="button" id="saveFAQBtn_<?php echo $row['faq_id']; ?>" class="btn btn-success me-2" style="display: none;" disabled>Save Changes</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php }
}
?>

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

        <div class="card">
      <div class="text-bold mt-4">
        <button class="tablink" onclick="openPage('Home', this, '#ffdb5a')" id="defaultOpen">Announcement</button>
        <button class="tablink" onclick="openPage('News', this, '#ffdb5a')" id="merchtab">Merchandise</button>
        <button class="tablink" onclick="openPage('Contact', this, '#ffdb5a')" id="volunteertab">Volunteers</button>
        <button class="tablink" onclick="openPage('About', this, '#ffdb5a')" id="faqtab">FAQs</button>
      </div>


      
       <!-- Success Edit Modal -->
       <div class="modal fade" id="successEditAnnouncementModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal"></button>
              <div class="text-center">
                <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                <p class="mt-4 px-2"> Content has been successfully updated!
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>


       <!-- Success Edit Modal -->
       <div class="modal fade" id="successEditMerchModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal"></button>
              <div class="text-center">
                <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                <p class="mt-4 px-2"> Content has been successfully updated!
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

       <!-- Success Edit Modal -->
       <div class="modal fade" id="successEditVolunteerModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal"></button>
              <div class="text-center">
                <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                <p class="mt-4 px-2"> Content has been successfully updated!
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

         <!-- Success Edit Modal -->
         <div class="modal fade" id="successEditFAQModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal"></button>
              <div class="text-center">
                <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                <p class="mt-4 px-2"> Content has been successfully updated!
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- Success Modal -->
      <div class="modal fade" id="successAnnouncementModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal"></button>
              <div class="text-center">
                <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                <p class="mt-4 px-2"> Content has been successfully added!
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Success Modal -->
      <div class="modal fade" id="successMerchModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal"></button>
              <div class="text-center">
                <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                <p class="mt-4 px-2"> Content has been successfully added!
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- Success Modal -->
      <div class="modal fade" id="successVolunteerModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal"></button>
              <div class="text-center">
                <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                <p class="mt-4 px-2"> Content has been successfully added!
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- Success Modal -->
      <div class="modal fade" id="successFAQModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal"></button>
              <div class="text-center">
                <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
                <p class="mt-4 px-2"> Content has been successfully added!
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Wrong file type Modal -->
      <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="text-center">
                <i class="bi bi-exclamation-triangle-fill" style="font-size: 8rem; color: #dc3545;"></i>
                <p class="mt-4 px-2">Invalid file type! Please upload only .jpg, .jpeg, .png, & .webp files.</p>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- Add announcement modal -->
      <div class="modal fade" id="addAnnouncementModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addAnnouncementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <div class="card p-2">
                <div class="card-body">
                  <h3 class="pb-4">Add Announcement</h3>
                  <form method="post" id="announcementForm">
                    <div class="row mb-3">
                      <label for="announcementTitle" class="col-3 col-form-label">Title<span class="asterisk">*</span></label>
                      <div class="col-9">
                        <input type="text" class="form-control" name="title" id="announcementTitle" placeholder="Enter title" required>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="announcementStatus" class="col-3 col-form-label">Status<span class="asterisk">*</span></label>
                      <div class="col-3">
                        <select class="form-select" id="announcementStatus" name="status">
                          <option value="" selected disabled>Kindly select an option</option>
                          <option value="Draft">Draft</option>
                          <option value="Scheduled Post">Scheduled Post</option>
                          <option value="Published">Publish Now</option>
                        </select>
                      </div>
                      <label for="publishDate" class="col-3 col-form-label">Date to be Published<span class="asterisk">*</span></label>
                      <div class="col-3">
                        <input type="date" class="form-control" id="publishDate" name="announcement_date">
                      </div>
                    </div>
                    <div class="row mb-5">
                      <label for="announcementContent" class="col-3 col-form-label">Content<span class="asterisk">*</span></label>
                      <div class="col-9 mb-3">
                        <div id="announcementContent" style="border: 2px solid #ced4da; border-radius: 5px; margin-bottom:150px"></div>
                        <!-- Hidden input to store the Quill content -->
                        <input type="hidden" name="description" id="announcementContentHidden">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="announcementImage" class="col-3 col-form-label">Add Image<span class="asterisk">*</span></label>
                      <div class="col-9">
                        <input type="file" class="form-control mt-2" id="imageUpload" name="image" accept=".jpg,.jpeg,.png">
                      </div>
                    </div>
                    <div class="row mb-1">
                      <div class="col-9 offset-3 d-flex justify-content-end">
                        <button type="button" class="btn me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveAnnouncementBtn">Save Post</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Add merchandise modal -->
      <div class="modal fade" id="addMerchandiseModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addMerchandiseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <div class="card p-3">
                <div class="card-body">
                  <h3 class="pb-4">Add Merchandise</h3>
                  <form method="post" id="merchandiseForm">
                    <div class="row mb-3">
                      <!-- Merchandise Item Label -->
                      <label for="merchandiseItem" class="col-3 col-form-label">Merchandise Item<span class="asterisk">*</span></label>
                      <div class="col-9">
                        <input type="text" class="form-control" name="item" id="merchandiseItem" placeholder="Enter merchandise item">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <!-- Insert Link Label -->
                      <label for="itemLink" class="col-3 col-form-label">Insert Link<span class="asterisk">*</span></label>
                      <div class="col-9">
                        <input type="text" class="form-control" name="link" id="itemLink" placeholder="Enter item link">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <!-- Image Label -->
                      <label for="merchandiseImage" class="col-3 col-form-label">Add Image<span class="asterisk">*</span></label>
                      <div class="col-9">
                        <div class="border p-4 text-center" id="imageUploadContainer" style="border: 2px dashed #ced4da; border-radius: 5px;">
                          <input type="file" class="form-control mt-2" name="image" id="merchupload" accept=".jpg,.jpeg,.png">
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <!-- Status Label -->
                      <label for="merchandiseStatus" class="col-3 col-form-label">Status<span class="asterisk">*</span></label>
                      <div class="col-9">
                        <select class="form-select" id="merchandiseStatus" name="status">
                          <option value="" selected disabled>Kindly select an option</option>
                          <option value="draft">Draft</option>
                          <option value="publish">Publish Now</option>
                        </select>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-9 offset-3 d-flex justify-content-end">
                        <button type="button" class="btn me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="saveMerchandiseBtn" class="btn btn-primary">Save Post</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Add volunteer modal -->
      <div class="modal fade" id="addVolunteerModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addVolunteerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body p-4">
              <div class="card p-3">
                <h3 class="pb-4">Add Volunteer</h3>
                <form method="post" id="volunteerForm">
                  <div class="row mb-3">
                    <label for="volunteerName" class="col-3 col-form-label">Name<span class="asterisk">*</span></label>
                    <div class="col-5">
                      <input type="text" class="form-control" id="volunteerFName" placeholder="Enter first name" name="first_name">
                    </div>
                    <div class="col-4">
                      <input type="text" class="form-control" id="volunteerLName" placeholder="Enter last name" name="last_name">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="volunteerRole" class="col-3 col-form-label">Role<span class="asterisk">*</span></label>
                    <div class="col-9">
                      <select class="form-select" id="volunteerRole" name="role">
                        <option value="" selected disabled>Kindly select an option</option>
                        <option value="Caretaker">Caretaker</option>
                        <option value="Assistant">Assistant</option>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="volunteerStatus" class="col-3 col-form-label">Status<span class="asterisk">*</span></label>
                    <div class="col-9">
                      <select class="form-select" id="volunteerStatus" name="status">
                        <option value="" selected disabled>Kindly select an option</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-9 offset-3 d-flex justify-content-end">
                      <button type="button" class="btn me-2" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" id="saveVolunteerBtn" class="btn btn-primary">Save Info</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Add FAQ modal -->
      <div class="modal fade" id="addFAQModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addFAQModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body p-4">
              <div class="card p-3">
                <h3 class="pb-4">Add FAQ</h3>
                <form method="post" id="FAQForm">
                  <div class="row mb-3">
                    <label for="question" class="col-3 col-form-label">Question<span class="asterisk">*</span></label>
                    <div class="col-9">
                      <input type="text" class="form-control" id="question" name="question" placeholder="Enter question">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="faqContent" class="col-3 col-form-label">Answer<span class="asterisk">*</span></label>
                    <div class="col-9 mb-3">
                      <div id="faqContent" style="border: 2px solid #ced4da; border-radius: 5px; height: 200px; overflow: auto;"></div>
                      <!-- Hidden input to store the Quill content -->
                      <input type="hidden" name="answer" id="faqContentHidden">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="announcementStatus" class="col-3 col-form-label">Status<span class="asterisk">*</span></label>
                    <div class="col-9">
                      <select class="form-select" id="faqStatus" name="status">
                        <option value="" selected disabled>Kindly select an option</option>
                        <option value="draft">Draft</option>
                        <option value="publish">Publish</option>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-9 offset-3 d-flex justify-content-end">
                      <button type="button" class="btn me-2" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" id="saveFAQBtn" class="btn btn-primary">Save Post</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="Home" class="tabcontent">
        <!-- Content -->
         
        <div class="mx-4">
          <table id="announcementTable" class="table table-striped mb-5">
            <thead>
              <tr>
                <th width="5%">#</th>
                <th width="25%">Title</th>
                <th width="20%">Created</th>
                <th width="15%">Status</th>
                <th width="20%">Author</th>
                <th scope="col" class="text-center">
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
                    <i class="bi bi-file-earmark-plus-fill pe-2"></i>Add New
                  </button>
                </th>
              </tr>
            </thead>
            <tbody>
            <tbody id="announcements_data"></tbody>
            </tbody>
          </table>
          <div class="d-flex justify-content-end">
            <div id="announcements_pagination_link"></div>
          </div>
        </div>
        <!-- End Content -->
      </div>

      <div id="News" class="tabcontent">
        <!-- Content -->
        <div class="mx-4">
          <table id="merchTable" class="table table-striped mb-5">
            <thead>
              <tr>
                <th width="5%">#</th>
                <th width="25%">Merchandise Name</th>
                <th width="20%">Created</th>
                <th width="10%">Status</th>
                <th width="15%">Link</th>
                <th scope="col" class="text-center">
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMerchandiseModal">
                    <i class="bi bi-file-earmark-plus-fill pe-2"></i>Add New
                  </button>
                </th>
              </tr>
            </thead>
            <tbody>
            <tbody id="merchandise_data"></tbody>
            </tbody>
          </table>
          <div class="d-flex justify-content-end">
            <div id="merchandise_pagination_link"></div>
          </div>
        </div>

      </div>

      <div id="Contact" class="tabcontent">
        <!-- Content -->
        <div class="mx-4">
          <table id="volunteerTable" class="table table-striped mb-5">
            <thead>
              <tr>
                <th width="5%">#</th>
                <th width="30%">Name</th>
                <th width="20%">Date Joined</th>
                <th width="10%">Status</th>
                <th width="10%">Role</th>
                <th scope="col" class="text-center">
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVolunteerModal">
                    <i class="bi bi-file-earmark-plus-fill pe-2"></i>Add New
                  </button>
                </th>
              </tr>
            </thead>
            <tbody>
            <tbody id="volunteer_data"></tbody>
            </tbody>
          </table>
          <div class="d-flex justify-content-end">
            <div id="volunteer_pagination_link"></div>
          </div>
        </div>
        <!-- End Content -->
      </div>

      <div id="About" class="tabcontent">
        <!-- Content -->
        <div class="mx-4">
          <table id="faqTable" class="table table-striped mb-5">
            <thead>
              <tr>
                <th width="5%">#</th>
                <th width="45%">Question</th>
                <th width="15%">Status</th>
                <th width="20%">Author</th>
                <th scope="col" class="text-center">
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFAQModal">
                    <i class="bi bi-file-earmark-plus-fill pe-2"></i>Add New
                  </button>
                </th>
              </tr>
            </thead>
            <tbody>
            <tbody id="faq_data"></tbody>
            </tbody>
          </table>
          <div class="d-flex justify-content-end">
            <div id="faq_pagination_link"></div>
          </div>
        </div>
        </div>

        <!-- End Content -->
      </div>
    </div>

    <script src="scripts/content-management.js"></script>
    <script src="scripts/announcement-management.js"></script>
    <script src="scripts/merch-management.js"></script>
    <script src="scripts/faq-management.js"></script>
    <script src="scripts/volunteer-management.js"></script>
    <script src="scripts/modal-tab.js"></script>

  </html>
<?php
} else {
  header("Location: home.php");
}
?>
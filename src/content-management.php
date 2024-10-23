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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

    <div class="mt-4">
        <button class="tablink" onclick="openPage('Home', this, '#ffdb5a')" id="defaultOpen">Announcement</button>
        <button class="tablink" onclick="openPage('News', this, '#ffdb5a')" >Merchandise</button>
        <button class="tablink" onclick="openPage('Contact', this, '#ffdb5a')">Volunteers</button>
        <button class="tablink" onclick="openPage('About', this, '#ffdb5a')" id="faqtab">FAQs</button>
    </div>

   <!-- Success Modal -->
  <div class="modal fade" id="successContentModal" tabindex="-1" aria-labelledby="successContentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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
                    <p class="mt-4 px-2">Invalid file type! Please upload only .jpg, .jpeg, .png files.</p>
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
                  <button type="submit" class="btn btn-primary" id="saveAnnouncementBtn" >Save Post</button>
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
                <option value="caretaker">Caretaker</option>
                <option value="assistant">Assistant</option>
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
              <button type="submit"  id="saveVolunteerBtn" class="btn btn-primary">Save Info</button>
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
                      <th width="20%">Status</th>
                      <th width="15%">Author</th>
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
                        <th width="15%">Author</th>
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

   <!-- End Content -->
</div>
 </div>

</body>

  <script src="scripts/content-management.js"></script>
</html>
<?php
} else {
    header("Location: home.php");
}
?>
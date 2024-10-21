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
    <link rel="stylesheet" href="styles/account-management.css">
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
  </head>
  <body>

   <?php include_once 'components/sidebar.php'; ?>

   <div class="admin-content">

    <section class="banner-section">
      <div class="content">
        <div class="head-title">
          <h1><u><b>ACCOUNT MANAGEMENT</b></u></h1>
        </div>
        <p>
          Manage contents seen in the user side and keep these information updated.
        </p>
      </div>
    </section>


 <!-- Add Admin modal -->
<div class="modal fade" id="addAdminModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4">
      <div class="card p-3">
        <h3 class="pb-4">Create New Admin Account</h3>
        <form>
          <div class="row mb-3">
            <label for="publishDate" class="col-3 col-form-label">Date</label>
            <div class="col-9">
              <input type="date" class="form-control" id="publishDate" required>
            </div>
          </div>
          <div class="row mb-3">
            <label for="question" class="col-3 col-form-label">Volunteer Name<span class="asterisk">*</span></label>
            <div class="col-9">
              <input type="text" class="form-control" id="question" placeholder="Enter the volunteer's name" required>
            </div>
          </div>
          <div class="row mb-3">
            <label for="question" class="col-3 col-form-label">Email<span class="asterisk">*</span></label>
            <div class="col-9">
              <input type="text" class="form-control" id="question" placeholder="Enter their email" required>
            </div>
          </div>
          <div class="row mb-3">
            <label for="question" class="col-3 col-form-label">Status</label>
            <div class="col-9">
              <input type="text" class="form-control" id="question" value="Active" readonly>
            </div>
          </div>
          <div class="row pt-4 me-5 pe-5"><i>Note: For the admin to login to his/her account, the initial password is sent to the email provided and once logged in, 
            they may change their password in the profile section.</i></div>
          <div class="row mb-3">
            <div class="col-9 offset-3 d-flex justify-content-end">
              <button type="button" class="btn me-2" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Add</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    </div>
  </div>
</div>

<!-- Confirm Disable Modal -->
<div class="modal fade" id="confirmDisableModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <!-- Bootstrap icon -->
        <i class="bi bi-question-circle-fill" style="font-size: 8rem; color: #808080;"></i>

        <!-- Modal text -->
        <p class="mt-3">Are you sure you want to disable this account: <strong>annareyes@gmail.com</strong>?</p>

        <!-- Yes and No buttons -->
        <div class="d-flex justify-content-center mb-5">
          <button type="button" class="btn btn-danger px-5 me-2" data-bs-toggle="modal" data-bs-target="#successModal">Yes</button>
          <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal">No</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Success Modal Structure -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <!-- Close button on the left -->
        <button type="button" class="btn-close d-flex ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>

        <!-- Bootstrap check icon and success message -->
        <div class="text-center">
          <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
          <p class="mt-3">Account disabled successfully!</p>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="table-section">
<div class="d-flex justify-content-end my-4">
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdminModal">
    <i class="bi bi-file-earmark-plus-fill pe-2"></i>Add Admin Account
  </button>
</div>
  <!-- Content -->
    <table class="table mt-2">
     <thead>
        <tr>
          <th scope="col" class="text-center">Email</th>
          <th scope="col" class="text-center">Account Creation Date</th>
          <th scope="col" class="text-center">Status</th>
          <th scope="col" class="text-center">Name</th>
        </tr>
      </thead>
      <tbody>
  <tr>
    <th class="blank text-center align-middle"> </th>
    <td class="blank text-center align-middle"> </td>
    <td class="blank text-center align-middle"> </td>
    <td class="blank text-center align-middle"> </td>
  </tr>
  <tr>
    <th scope="row" class="text-center align-middle">annareyes@gmail.com</th>
    <td class="text-center align-middle">August 21, 2024</td>
    <td class="text-center align-middle">
      <div class="dropdown">
        <span class="badge bg-green text-dark dropdown-toggle" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          Active
        </span>
      <ul class="dropdown-menu" aria-labelledby="statusDropdown">
        <li><a href="#" data-bs-toggle="modal" data-bs-target="#confirmDisableModal" class="dropdown-item">Inactive</a></li>
      </ul>
    </div>
</td>
    <td class="text-center align-middle">Anna Reyes</td>
  </tr>
  <tr>
    <th class="blank text-center align-middle"> </th>
    <td class="blank text-center align-middle"> </td>
    <td class="blank text-center align-middle"> </td>
    <td class="blank text-center align-middle"> </td>
  </tr>
  <tr>
    <th scope="row" class="text-center align-middle">johncruz123@gmail.com</th>
    <td class="text-center align-middle">August 21, 2024</td>
    <td class="text-center align-middle">
    <div class="dropdown">
        <span class="badge bg-green text-dark dropdown-toggle" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          Active
        </span>
      <ul class="dropdown-menu" aria-labelledby="statusDropdown">
        <li><a href="#" data-bs-toggle="modal" data-bs-target="#confirmDisableModal" class="dropdown-item">Inactive</a></li>
      </ul>
    </div>
    </td>
    <td class="text-center align-middle">John Cruz</td>
  </tr>
  <tr>
    <th class="blank text-center align-middle"> </th>
    <td class="blank text-center align-middle"> </td>
    <td class="blank text-center align-middle"> </td>
    <td class="blank text-center align-middle"> </td>
  </tr>
  <tr>
    <th scope="row" class="text-center align-middle">jane_saniel@gmail.com</th>
    <td class="text-center align-middle">August 21, 2024</td>
    <td class="text-center align-middle"><span class="badge bg-red text-dark">Inactive</span></td>
    <td class="text-center align-middle">Janelle Jane Saniel</td>
  </tr>
  <tr>
    <th class="blank text-center align-middle"> </th>
    <td class="blank text-center align-middle"> </td>
    <td class="blank text-center align-middle"> </td>
    <td class="blank text-center align-middle"> </td>
  </tr>
  <tr>
    <th scope="row" class="text-center align-middle">alyssavillanueva@gmail.com</th>
    <td class="text-center align-middle">August 21, 2024</td>
    <td class="text-center align-middle">
    <div class="dropdown">
        <span class="badge bg-green text-dark dropdown-toggle" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          Active
        </span>
      <ul class="dropdown-menu" aria-labelledby="statusDropdown">
        <li><a href="#" data-bs-toggle="modal" data-bs-target="#confirmDisableModal" class="dropdown-item">Inactive</a></li>
      </ul>
    </div>
    </td>
    <td class="text-center align-middle">Alyssa Villanueva</td>
  </tr>
  <tr>
    <th class="blank text-center align-middle"> </th>
    <td class="blank text-center align-middle"> </td>
    <td class="blank text-center align-middle"> </td>
    <td class="blank text-center align-middle"> </td>
  </tr>
  <tr>
    <th scope="row" class="text-center align-middle">oliviarodrigo@gmail.com</th>
    <td class="text-center align-middle">August 21, 2024</td>
    <td class="text-center align-middle"><span class="badge bg-red text-dark">Inactive</span></td>
    <td class="text-center align-middle">Olivia Rodrigo</td>
  </tr>
  <tr>
    <th class="blank text-center align-middle"> </th>
    <td class="blank text-center align-middle"> </td>
    <td class="blank text-center align-middle"> </td>
    <td class="blank text-center align-middle"> </td>
  </tr>
</tbody>

    </table>

    <!-- Pagination Component -->
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-end">
        <li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1">Previous</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#">Next</a>
        </li>
      </ul>
    </nav>

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
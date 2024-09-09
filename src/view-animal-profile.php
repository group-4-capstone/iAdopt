<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iADOPT | SECASPI</title>
    <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
    <link rel="stylesheet" href="styles/sidebar.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/animal-profiles.css">


    <!-- Google Fonts Links For Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>

   <?php include_once 'components/sidebar.php'; ?>

   <div class="admin-content">
    <section class="banner-section">
        <div class="content">
        <div class="head-title">
          <h1><u><b>View Animal Profile</b></u></h1>
        </div>
          <p>
           View their profile and update information about them.
          </p>
        </div>
      </section>

      <!-- Modal Structure -->
<div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <!-- Modal Title -->
        <h5 class="mb-4">Animal ID QR Code</h5>
        
        <!-- Centered QR Code Image -->
        <img src="styles/assets/qr_code.svg" alt="Animal QR Code" class="img-fluid mb-4" style="max-width: 200px;">
        
        <!-- Print and Cancel Buttons -->
        <div class="d-flex justify-content-center gap-3">
          <button class="btn btn-update" onclick="window.print()">Print</button>
          <button class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>

   <div class="card info-card">
    <div class="row">
        <h2 class="title">INFORMATION SHEET</h2>
        <div class="col-md-4 col-sm-12 mt-4 align-items-center">
            <img src="styles/assets/aspin-2.png" alt="Rescued Pet" style="width: 350px;">
              <div class="row mt-2">
                <div class="col">
                    <button class="btn btn-update ms-3"><i class="bi bi-pencil-square pe-2"></i>Edit Profile</button>
                </div>
                <div class="col">
                 <button class="btn btn-update" data-bs-toggle="modal" data-bs-target="#qrCodeModal">
                  <i class="bi bi-info-circle pe-2"></i>QR Code
              </button>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="col-md-12 form-group mb-4">
                <label for="name" class="form-label">Name:</label>
                <input type="text" id="name" class="form-control" value="Juan">
            </div>
            <div class="row mb-4">
                <div class="col-md-4 form-group">
                    <label for="rescuedDate" class="form-label">Date Rescued:</label>
                    <input type="date" id="rescuedDate" class="form-control" value="2023-12-13">
                </div>
                <div class="col-md-8 form-group">
                    <label for="rescuedBy" class="form-label">Rescued By:</label>
                    <input type="text" id="rescuedBy" class="form-control" value="Pedro Balagtas">
                </div>
            </div>
            <div class="form-group mb-4">
                <label for="rescuedAt" class="form-label">Rescued At:</label>
                <input type="text" id="rescuedAt" class="form-control" value="City of Santa Rosa">
            </div>
            <div class="row mb-4">
                <div class="col-md-4 form-group">
                    <label for="type" class="form-label">Type:</label>
                    <select id="type" class="form-select">
                        <option selected>Dog</option>
                        <option>Cat</option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label for="gender" class="form-label">Gender:</label>
                    <select id="gender" class="form-select">
                        <option selected>Male</option>
                        <option>Female</option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label for="vaccine" class="form-label">Vaccine:</label>
                    <input type="text" id="vaccine" class="form-control" value="w/ Anti-rabies, 5 in 1">
                </div>
            </div>
            <div class="form-group mb-4">
                <label for="remarks" class="form-label">Remarks:</label>
                <textarea id="remarks" class="form-control">If the world was ending I'd wanna be next to you...</textarea>
            </div>
            <div class="row">
                <label for="tags" class="form-label">Tags:</label>
                <div class="col-md-4 mb-2">
                    <input type="text" id="tag1" class="form-control" value="great companion">
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" id="tag2" class="form-control" value="friendly">
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" id="tag3" class="form-control" value="loyal">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4 mb-2">
                    <input type="text" id="tag4" class="form-control" value="playful">
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" id="tag5" class="form-control" value="loving">
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" id="tag6" class="form-control" value="energetic">
                </div>
            </div>
        </div>
    </div>
</div>



   </div>

</body>
</html>
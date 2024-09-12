<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iADOPT | SECASPI</title>
    <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
    <link rel="stylesheet" href="styles/topnavbar.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/profile.css">

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

   <?php include_once 'components/topnavbar.php'; ?>

 <section class="profile-section pt-5">
    <div class="container rounded bg-white mb-5">
      <div class="row">
          <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
              <span class="font-weight-bold">Hi, Juan Dela Cruz!</span>
              <span><button class="btn"><i class="bi bi-pencil-square me-2"></i>Update Information</button></span>
              <span><button class="btn"><i class="bi bi-pencil-square me-2"></i>Change Password</button></span>
            </div>
          </div>
          <div class="col-md-9 border-right">
              <div class="p-3 py-5">
                  <div class="d-flex align-items-center mb-3">
                     <div class="vertical-line me-3"></div><h4>MY ACCOUNT</h4> 
                  </div>
                  <div class="row mt-2">
                      <div class="col-md-5"><label class="labels">Last Name</label><input type="text" class="form-control" placeholder="Last Name" value="Dela Cruz"></div>
                      <div class="col-md-6"><label class="labels">First Name</label><input type="text" class="form-control" value="Juan" placeholder="First Name"></div>
                      <div class="col-md-1"><label class="labels">M.I</label><input type="text" class="form-control" value="A." placeholder="Middle Initial"></div>
                  </div>
                  <div class="row mt-3">
                      <div class="col-md-12"><label class="labels">Birthday</label><input type="date" class="form-control" value=""></div>
                      <div class="col-md-6 mt-3"><label class="labels">City/Municipality</label><input type="text" class="form-control" placeholder="enter address line 1" value="City of Santa Rosa"></div>
                      <div class="col-md-6 mt-3"><label class="labels">Province</label><input type="text" class="form-control" placeholder="enter address line 2" value="Laguna"></div>
                      <div class="col-md-12 mt-3"><label class="labels">Facebook Profile Link</label><input type="text" class="form-control" placeholder="" value="www.facebook.com/juandelacruz"></div>
                      <div class="col-md-4 mt-3"><label class="labels">Contact Number</label><input type="text" class="form-control" placeholder="enter phone number" value="091242134124"></div>
                      <div class="col-md-8 mt-3"><label class="labels">Email</label><input type="text" class="form-control" placeholder="enter email id" value="juandelacruz@gmail.com"></div>
                  </div>
              </div>
            </div>
        </div>
      </div>
   <div class="pb-5">
      <div class="container rounded bg-white mt-5">
        <div class="row px-3">
          <div class="col-md-6">
              <ul id="progressbar">
                  <li class="step0 active" id="step1" data-step="1">Submit application form</li>
                  <li class="step0 active" id="step2" data-step="2">Wait for verification of your application</li>
                  <li class="step0 active" id="step3" data-step="3">Set online interview</li>
                  <li class="step0 active" id="step4" data-step="4">Wait for the adoption approval</li>
                  <li class="step0 text-muted" id="step5" data-step="5">Visit the shelter and get your pet</li>
              </ul>
          </div>
          <div class="col-md-6 mt-4">
          <center><img src="styles/assets/aspin-1.png" width="90%">
             <h5 class="pt-4">Andres</h5></center>
          </div>
        </div>
      </div>
   </div>
    </div>
  </div>
</section>
   
   <?php include_once 'components/footer.php'; ?>

</body>
</html>
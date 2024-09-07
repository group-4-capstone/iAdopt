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
  </head>
  <body>

   <?php include_once 'components/sidebar.php'; ?>

   <div class="admin-content">

<div class="head-title">
    <h1><u><b>ADD RESCUED PET</b> </u></h1>
</div>


<div class="container mt-5">
            <div class="card info-card">
                <div class="row">
                <h2 class="title">INFORMATION SHEET</h2>
                    <div class="col-md-4 col-sm-12  d-flex justify-content-center align-items-center">
                        <img src="styles/assets/aspin-2.png" alt="Rescued Pet">
                        
                    </div>
                    <div class="col-md-8 col-sm-12 ">
                        <br>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" id="name" class="form-control" value="Juan">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="gender" class="form-label">Gender:</label>
                                <select id="gender" class="form-select">
                                    <option selected>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="type" class="form-label">Type:</label>
                                <select id="type" class="form-select">
                                    <option selected>Dog</option>
                                    <option>Cat</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="rescuedDate" class="form-label">Date Rescued:</label>
                                <input type="date" id="rescuedDate" class="form-control" value="2023-12-13">
                            </div>
                            <div class="col-md-8 form-group">
                                <label for="rescuedBy" class="form-label">Rescued By:</label>
                                <input type="text" id="rescuedBy" class="form-control" value="Pedro Balagtas">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rescuedAt" class="form-label">Rescued At:</label>
                            <input type="text" id="rescuedAt" class="form-control" value="City of Santa Rosa">
                        </div>
                        <div class="form-group">
                            <label for="remarks" class="form-label">Remarks:</label>
                            <textarea id="remarks" class="form-control remarks">If the world was ending I'd wanna be next to you...</textarea>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button class="btn btn-cancel me-2">Cancel</button>
                            <button class="btn btn-add">Add</button>
                        </div>
                    </div>
                </div>
              
            </div>
        </div>

</body>
</html>
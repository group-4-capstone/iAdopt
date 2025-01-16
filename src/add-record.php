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
                        <h1><u><b>ADD RESCUE</b></u></h1>
                    </div>
                    <p>
                        Add rescued animal information.
                    </p>
                </div>
            </section>

            <div class="container mt-5 mb-5">
                <div class="card info-card p-4">
                    <h2 class="title">INFORMATION SHEET</h2>

                    <form method="post" id="addRecordForm">
                        <div class="row mt-2">
                            <div class="col-md-4 col-sm-12">
                                <div class="upload-placeholder" id="uploadPlaceholder">
                                    <img id="uploadedImage" src="" alt="" style="display: none;">
                                    <div class="overlay text-white" id="overlay" style="display: none;">
                                        <span>Click to reupload a picture</span>
                                    </div>
                                    <i class="bi bi-cloud-upload" id="uploadIcon"></i>
                                    <span id="placeholderText">Click to upload</span>
                                    <input type="file" id="imageUpload" accept="image/*" name="image" style="display: none;">
                                </div>
                                <!-- <span id="fileNameDisplay" style="display: none; margin-top: 10px; font-size: 14px; color: #555;"></span> -->
                            </div>

                            <div class="col-md-8 col-sm-12">
                                <div class="left-side">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="name" class="form-label">Name:</label>
                                            <input type="text" id="name" class="form-control" name="name" required>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="gender" class="form-label">Gender:</label>
                                            <select id="gender" class="form-select" name="gender" required>
                                                <option value="" selected disabled>Kindly select an option</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="type" class="form-label">Type:</label>
                                            <select id="type" class="form-select" name="type" required>
                                                <option value="" selected disabled>Kindly select an option</option>
                                                <option value="Dog">Dog</option>
                                                <option value="Cat">Cat</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="rescuedBy" class="form-label">Rescued By:</label>
                                            <input type="text" id="rescuedBy" class="form-control" name="rescued_by" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="rescuedAt" class="form-label">Rescued At:</label>
                                            <input type="text" id="rescuedAt" class="form-control" name="rescued_at" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="remarks" class="form-label">Remarks:</label>
                                            <textarea id="remarks" class="form-control" name="description"></textarea>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-5 mb-3">
                                        <button type="button" class="btn btn-cancel me-2" onclick="window.location.href='rescue-records.php'">Cancel</button>
                                        <button type="submit" class="btn btn-add" id="addRecordBtn">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="my-2"></div>
                    <div class="paw-prints-down"><img src="styles/assets/paw-down.png" alt="Paws"></div>
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

    </body>

    </html>
    <script src="scripts/add-record.js"></script>

<?php
} else {
    header("Location: login.php");
}
?>
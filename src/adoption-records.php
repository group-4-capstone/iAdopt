<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iADOPT | SECASPI</title>
    <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/sidebar.css">
    <link rel="stylesheet" href="styles/adoption-records.css">
    <!-- Google Fonts Links For Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

</head>

<body>


    <?php include_once 'components/sidebar.php'; ?>


    <div class="admin-content">

    <section class="banner-section">
      <div class="content">
        <div class="head-title">
          <h1><u><b>ADOPTION RECORDS</b></u></h1>
        </div>
            <p>
                 View list of animals that are up for adoption and manage their profiles.
            </p>
        </div>
    </section>

        <div class="container mt-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center ms-auto">
                        
                        <button class="btn btn-delete d-flex align-items-center">
                            <span class="badge text-bg-danger"><i class="bi bi-trash-fill me-1"></i><span>Delete</span></span>
                        </button>
                        <button class="btn btn-sort d-flex align-items-center" style="white-space: nowrap;">
                            <span class="badge text-bg-secondary"> <i class="bi bi-arrow-down-up me-1"></i><span>Sort By</span></span>
                        </button>

                        <div class="input-group input-group-md">
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-text search-icon"><i class="bi bi-search"></i></span>
                        </div>
                    </div>
                </div>



                <div class="card-body p-0">
                    <table class="table table-hover mb-0 " id="rescueTable">
                        <thead>
                            <tr>
                                <th>Date of Adoption</th>
                                <th>Name of Adoptor</th>
                                <th>Email</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
    <tr data-href="adoption-details.php">
        <td>2023/12/13</td>
        <td>Juan Bartolome</td>
        <td>juanbartolome@gmail.com</td>
        <td>Blk 45 Lot 23 Ph 1 Villa Ewan</td>
    </tr>
    <tr data-href="adoption-details.php">
        <td>2023/12/13</td>
        <td>Juan Bartolome</td>
        <td>juanbartolome@gmail.com</td>
        <td>Blk 45 Lot 23 Ph 1 Villa Ewan</td>
    </tr>
    <tr data-href="adoption-details.php">
        <td>2023/12/13</td>
        <td>Juan Bartolome</td>
        <td>juanbartolome@gmail.com</td>
        <td>Blk 45 Lot 23 Ph 1 Villa Ewan</td>
    </tr>
</tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">
                                        < </span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
        <br>
        <br>
    </div>
   
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="scripts/adoption-records.js"></script>
</body>

</html>
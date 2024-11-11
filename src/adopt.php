<?php include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

// Define the number of items per page
  $itemsPerPage = 9;

  // Get the current page from the URL, default is 1
  $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($currentPage - 1) * $itemsPerPage;

  // Get the total count of adoptable animals
  $countQuery = "SELECT COUNT(*) AS total FROM animals WHERE animal_status = 'adoptable'";
  $countStmt = $db->prepare($countQuery);
  $countStmt->execute();
  $countResult = $countStmt->get_result();
  $totalItems = $countResult->fetch_assoc()['total'];
  $totalPages = ceil($totalItems / $itemsPerPage);

  // Prepare and execute the SQL query with pagination
  $query = "SELECT animal_id, type, name, gender, image, tags, description, animal_status 
            FROM animals 
            WHERE animal_status = 'adoptable'
            LIMIT ? OFFSET ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("ii", $itemsPerPage, $offset);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if it's an AJAX request for pagination
  if (isset($_GET['page']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    while ($row = $result->fetch_assoc()) {
      $animalId = htmlspecialchars($row['animal_id']);
      $type = htmlspecialchars($row['type']);
      $name = htmlspecialchars($row['name']);
      $gender = htmlspecialchars($row['gender']);
      $image = htmlspecialchars($row['image']);
      $tags = htmlspecialchars($row['tags']);
      $tagsArray = explode(",", $tags);
?>

<div class="grid_items">
  <img src="styles/assets/animals/<?php echo $image; ?>" alt="Image of <?php echo $name; ?>" />
  <div class="grid_text">
      <h3><?php echo $name; ?></h3>
      <ul class="custom-list">
          <li class="d-flex align-items-center mb-2">
              <i class="bi bi-check-circle-fill me-5 text-success"></i>
              <?php echo ucfirst($gender); ?>
          </li>
          <li class="d-flex align-items-center mb-2">
              <i class="bi bi-check-circle-fill me-5 text-success"></i>
              <?php echo ucfirst($type); ?>
          </li>
          <?php foreach ($tagsArray as $tag): ?>
              <li class="d-flex align-items-center mb-2">
                  <i class="<?php echo (strtolower(trim($tag)) == 'food aggression') ? 'bi bi-x-circle-fill me-5 text-danger' : 'bi bi-check-circle-fill me-5 text-success'; ?>"></i>
                  <?php echo ucfirst(trim($tag)); ?>
              </li>
          <?php endforeach; ?>
      </ul>
      <a href="adopt-know-more.php?animal_id=<?php echo $animalId; ?>">
          <button class="btn btn-primary mt-3">MORE</button>
      </a>
  </div>
</div>

<?php
    }
    exit; // End script for AJAX response
  }
?>


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
    <link rel="stylesheet" href="styles/adopt.css">


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

   <?php include_once 'components/topnavbar.php'; ?>

   <section class="user-banner-section">
      <div class="content">
        <h2>Adoption</h2>
        <h4>We Need Help. So Do They.</h4>
        <p>
          Every animal adopted out means 2 lives saved, the one adopted out and the one replacing 
          its space at the shelter.
        </p>
      </div>
    </section>

    <section class="animals-section">
      <div class="content">
       <div class="end">
            <button class="btn">
              <i class="bi bi-filter"></i>
              <span>Filter</span> 
              <i class="bi bi-chevron-down"></i>
            </button>
       </div>
        <div class="grid">
        <div class="section_container">
          <div class="grid_container">
            <div class="updates" id="animal-cards">
              <?php 
              // Initial load of the animal profiles
              if ($result && $result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()): 
                    $animalId = htmlspecialchars($row['animal_id']);
                    $type = htmlspecialchars($row['type']);
                    $name = htmlspecialchars($row['name']);
                    $gender = htmlspecialchars($row['gender']);
                    $image = htmlspecialchars($row['image']);
                    $tags = htmlspecialchars($row['tags']);
                    $tagsArray = explode(",", $tags);
              ?>
              
              <div class="grid_items">
                <img src="styles/assets/animals/<?php echo $image; ?>" alt="Image of <?php echo $name; ?>" />
                <div class="grid_text">
                    <h3><?php echo $name; ?></h3>
                    <ul class="custom-list">
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill me-5 text-success"></i>
                            <?php echo ucfirst($gender); ?>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill me-5 text-success"></i>
                            <?php echo ucfirst($type); ?>
                        </li>
                        <?php foreach ($tagsArray as $tag): ?>
                            <li class="d-flex align-items-center mb-2">
                                <i class="<?php echo (strtolower(trim($tag)) == 'food aggression') ? 'bi bi-x-circle-fill me-5 text-danger' : 'bi bi-check-circle-fill me-5 text-success'; ?>"></i>
                                <?php echo ucfirst(trim($tag)); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="adopt-know-more.php?animal_id=<?php echo $animalId; ?>">
                        <button class="btn btn-primary mt-3">MORE</button>
                    </a>
                </div>
              </div>

              <?php 
                  endwhile; // End of while loop 
              } else {
                  echo "<p>No animals available for adoption at the moment.</p>";
              }
              ?>
            </div>
          </div>
          </div>
          <nav class="pagination-container mt-4">
            <ul class="pagination justify-content-center">
              <?php if ($currentPage > 1): ?>
                  <li class="page-item">
                      <a class="page-link" data-page="<?php echo $currentPage - 1; ?>">&lt;</a>
                  </li>
              <?php endif; ?>

              <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                  <li class="page-item <?php echo ($page == $currentPage) ? 'active' : ''; ?>">
                      <a class="page-link" data-page="<?php echo $page; ?>"><?php echo $page; ?></a>
                  </li>
              <?php endfor; ?>

              <?php if ($currentPage < $totalPages): ?>
                  <li class="page-item">
                      <a class="page-link" data-page="<?php echo $currentPage + 1; ?>">&gt;</a>
                  </li>
              <?php endif; ?>
            </ul>
          </nav>
        </div>
      </div>
      </div>
    </section>
   
   <?php include_once 'components/footer.php'; ?>

</body>
</html>
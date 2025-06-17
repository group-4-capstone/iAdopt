<?php
include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'head_admin')) {

  $itemsPerPage = 9;
  $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($currentPage - 1) * $itemsPerPage;

  $typeFilter = isset($_GET['type']) && in_array(strtolower($_GET['type']), ['dog', 'cat']) ? ucfirst(strtolower($_GET['type'])) : '';
  $genderFilter = isset($_GET['gender']) && in_array(strtolower($_GET['gender']), ['male', 'female']) ? ucfirst(strtolower($_GET['gender'])) : '';

  // Start building the base count query
  $countQuery = "SELECT COUNT(*) AS total FROM animals WHERE animal_status = 'Adoptable'";
  $params = [];
  $types = "";

  // Add type filter condition if set
  if ($typeFilter) {
    $countQuery .= " AND type = ?";
    $params[] = $typeFilter;
    $types .= "s";
  }

  // Add gender filter condition if set
  if ($genderFilter) {
    $countQuery .= " AND gender = ?";
    $params[] = $genderFilter;
    $types .= "s";
  }

  // Prepare and execute the count query
  $countStmt = $db->prepare($countQuery);
  if ($params) {
    $countStmt->bind_param($types, ...$params);
  }
  $countStmt->execute();
  $countResult = $countStmt->get_result();
  $totalItems = $countResult->fetch_assoc()['total'];
  $totalPages = ceil($totalItems / $itemsPerPage);

  // Main query for fetching animals
  $query = "SELECT animal_id, type, name, gender, image, tags, description, animal_status 
              FROM animals 
              WHERE animal_status = 'Adoptable'";

  // Append filters if set
  if ($typeFilter) {
    $query .= " AND type = ?";
  }
  if ($genderFilter) {
    $query .= " AND gender = ?";
  }

  // Pagination
  $query .= " LIMIT ? OFFSET ?";

  // Prepare the query
  $stmt = $db->prepare($query);
  $params[] = $itemsPerPage;
  $params[] = $offset;
  $types .= "ii";

  // Bind parameters and execute
  $stmt->bind_param($types, ...$params);
  $stmt->execute();
  $result = $stmt->get_result();

  // Handle AJAX request for pagination
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
    exit;
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
          <div class="dropdown">
            <button class="btn" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-filter"></i>
              <span>Filter</span>
              <i class="bi bi-chevron-down"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
              <li><a class="dropdown-item dropdown-item-filter" data-filter="All" href="#"> All</a></li>
              <li><a class="dropdown-item dropdown-item-filter" data-filter="Dog" href="#">Dog</a></li>
              <li><a class="dropdown-item dropdown-item-filter" data-filter="Cat" href="#">Cat</a></li>
              <li><a class="dropdown-item dropdown-item-filter" data-filter="Male" href="#">Male</a></li>
              <li><a class="dropdown-item dropdown-item-filter" data-filter="Female" href="#">Female</a></li>
            </ul>
          </div>
        </div>

        <?php
        // Initial load of the animal profiles
        if ($result && $result->num_rows > 0) { ?>
          <div class="grid">
            <div class="section_container">
              <div class="grid_container">
                <div class="updates" id="animal-cards">

                  <?php while ($row = $result->fetch_assoc()):
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
                } else { ?>
                  <div class="col-lg-12 d-flex justify-content-center align-items-center py-5" style="min-height: 300px;">
                    <p class="fs-4 text-muted text-center">
                      Sorry, there are no animals found. Please check back later.
                    </p>
                  </div>
                <?php }
                ?>
                </div>
              </div>
            </div>
            <div class="pagination-container mt-4">
              <ul class="pagination">
                <!-- "<" Previous Page Link -->
                <li class="page-item">
                  <a class="page-link <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>"
                    data-page="<?php echo $currentPage - 1; ?>">&lt;</a>
                </li>

                <!-- Page Number Links -->
                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                  <li class="page-item">
                    <a class="page-link <?php echo ($page == $currentPage) ? 'active' : ''; ?>"
                      data-page="<?php echo $page; ?>"><?php echo $page; ?></a>
                  </li>
                <?php endfor; ?>

                <!-- ">" Next Page Link -->
                <li class="page-item">
                  <a class="page-link <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>"
                    data-page="<?php echo $currentPage + 1; ?>">&gt;</a>
                </li>
              </ul>
            </div>

          </div>
      </div>
      </div>
    </section>

    <?php include_once 'components/footer.php'; ?>

    <script>
      // When any filter item is clicked
      document.querySelectorAll('.dropdown-item-filter').forEach(item => {
        item.addEventListener('click', function(e) {
          e.preventDefault(); // Prevent the default link behavior

          const filter = e.target.getAttribute('data-filter');
          let url = new URL(window.location.href); // Get the current URL

          // Clear specific filter parameters based on the selected filter
          if (filter === 'All') {
            // Remove 'type' and 'gender' from the URL if 'All' is selected
            url.searchParams.delete('type');
            url.searchParams.delete('gender');
          } else {
            // Add the filter to the URL as query parameters
            if (filter === 'Dog' || filter === 'Cat') {
              url.searchParams.set('type', filter.toLowerCase()); // Add type filter
            } else if (filter === 'Male' || filter === 'Female') {
              url.searchParams.set('gender', filter); // Add gender filter
            }
          }

          // Redirect the page with the updated URL
          window.location.href = url.toString();
        });
      });
    </script>


  </body>

  </html>
<?php
} else {
  header("Location: home.php");
}
?>
<?php include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

if (isset($_GET['animal_id'])) {
  $animal_id = $_GET['animal_id'];

  $query = "SELECT animal_id, type, name, gender, image, tags, description, animal_status 
            FROM animals 
            WHERE animal_id = ? ";

  $stmt = $db->prepare($query);
  $stmt->bind_param("i", $animal_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $animal = $result->fetch_assoc();
  }
}
$tags = htmlspecialchars($animal['tags']);
$tagsArray = explode(",", $tags);
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

  <section class="solo-section">
    <div class="content">
      <div class="solo-box">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="picture-frame">
              <img id="profile-image" src="styles/assets/animals/<?php echo htmlspecialchars($animal['image']); ?>" alt="Profile Picture">
            </div>
          </div>
          
          <div class="col-lg-6 col-md-6 col-sm-12 d-flex flex-column align-items-center">
            <div class="text-center">
              <h2 class="text-center"><?php echo strtoupper(htmlspecialchars($animal['name'])); ?></h2>
              <ul class="custom-list my-4">
                <li class="d-flex align-items-center mb-2">
                  <i class="bi bi-check-circle-fill me-5 text-success"></i>
                  <?php echo htmlspecialchars($animal['gender']); ?>
                </li>
                <li class="d-flex align-items-center mb-2">
                  <i class="bi bi-check-circle-fill me-5 text-success"></i>
                  <?php echo htmlspecialchars($animal['type']); ?>
                </li>
                <?php foreach ($tagsArray as $tag): ?>
                  <li class="d-flex align-items-center mb-2">
                    <i class="<?php echo (strtolower(trim($tag)) == 'food aggression') ? 'bi bi-x-circle-fill me-5 text-danger' : 'bi bi-check-circle-fill me-5 text-success'; ?>"></i>
                    <?php echo ucfirst(trim($tag)); ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>

            <div class="row">
              <p class="text-center">
                <?php echo htmlspecialchars($animal['description']); ?>
              </p>
            </div>
            <div class="text-center mt-1">
              <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) { ?>
                <a href="adopt-now.php?animal_id=<?php echo $animal_id ?>"><button class="btn">ADOPT NOW</button> </a>
              <?php } else {  ?>
                <a href="login.php"><i> Kindly sign in first.</a> <br>You need to be logged in to your account to adopt. </i>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
  </section>

  <section class="animals-section">
    <div class="content">
      <h4>EXPLORE MORE</h4>
      <div class="line"></div>
      <div class="grid">
        <div class="section_container">
          <div class="grid_container">
            <div class="updates">
              <div class="grid_items">
                <img src="styles/assets/aspin-1.png" />
                <div class="grid_text">
                  <h3>Andres</h3>
                  <p class="text-center">
                  <ul class="custom-list">
                    <li><i class="bi bi-check-circle-fill"></i> Male</li>
                    <li><i class="bi bi-check-circle-fill"></i> w/Anti-rabies, 5 in 1</li>
                    <li><i class="bi bi-check-circle-fill"></i> Spayed</li>
                    <li><i class="bi bi-x-circle-fill"></i> Food Aggression</li>
                    <li><i class="bi bi-check-circle-fill"></i> Cats</li>
                    <li><i class="bi bi-check-circle-fill"></i> Dogs</li>
                    <li><i class="bi bi-check-circle-fill"></i> Humans</li>
                    <li><i class="bi bi-check-circle-fill"></i> Great Companion</li>
                  </ul>
                  </p>
                  <button class="btn">KNOW MORE</button>
                </div>
              </div>
              <div class="grid_items">
                <img src="styles/assets/aspin-2.png" />
                <div class="grid_text">
                  <h3>Kitty</h3>
                  <p class="text-center">
                  <ul class="custom-list">
                    <li><i class="bi bi-check-circle-fill"></i> Male</li>
                    <li><i class="bi bi-check-circle-fill"></i> w/Anti-rabies, 5 in 1</li>
                    <li><i class="bi bi-check-circle-fill"></i> Spayed</li>
                    <li><i class="bi bi-x-circle-fill"></i> Food Aggression</li>
                    <li><i class="bi bi-check-circle-fill"></i> Cats</li>
                    <li><i class="bi bi-check-circle-fill"></i> Dogs</li>
                    <li><i class="bi bi-check-circle-fill"></i> Humans</li>
                    <li><i class="bi bi-check-circle-fill"></i> Great Companion</li>
                  </ul>
                  </p>
                  <button class="btn">KNOW MORE</button>
                </div>
              </div>
              <div class="grid_items">
                <img src="styles/assets/aspin-1.png" />
                <div class="grid_text">
                  <h3>Pepper</h3>
                  <p class="text-center">
                  <ul class="custom-list">
                    <li><i class="bi bi-check-circle-fill"></i> Male</li>
                    <li><i class="bi bi-check-circle-fill"></i> w/Anti-rabies, 5 in 1</li>
                    <li><i class="bi bi-check-circle-fill"></i> Spayed</li>
                    <li><i class="bi bi-x-circle-fill"></i> Food Aggression</li>
                    <li><i class="bi bi-check-circle-fill"></i> Cats</li>
                    <li><i class="bi bi-check-circle-fill"></i> Dogs</li>
                    <li><i class="bi bi-check-circle-fill"></i> Humans</li>
                    <li><i class="bi bi-check-circle-fill"></i> Great Companion</li>
                  </ul>
                  </p>
                  <button class="btn">KNOW MORE</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <nav class="pagination-container">
          <ul class="pagination">
            <li><a href="#">&lt;</a></li>
            <li><a href="#" class="active">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">&gt;</a></li>
          </ul>
        </nav>
      </div>
    </div>
    </div>
  </section>

  <?php include_once 'components/footer.php'; ?>

</body>

</html>
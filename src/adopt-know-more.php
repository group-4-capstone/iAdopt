<?php 
include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'head_admin')) {
  
  if (isset($_GET['animal_id'])) {
    $animal_id = $_GET['animal_id'];
    $user_id = $_SESSION['user_id'] ?? null; // Get the logged-in user ID

    // Fetch animal details
    $query = "SELECT animal_id, type, name, gender, image, tags, description, animal_status 
              FROM animals 
              WHERE animal_id = ? AND animal_status ='Adoptable' ";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $animal_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $animal = $result->fetch_assoc();
    } else {
      header("Location: not-found.php");
      exit();
    }

    // Check if the user has already applied for adoption of this animal
    $has_applied = false;
    if ($user_id) {
      $app_query = "SELECT application_id FROM applications WHERE user_id = ? AND animal_id = ?";
      $app_stmt = $db->prepare($app_query);
      $app_stmt->bind_param("ii", $user_id, $animal_id);
      $app_stmt->execute();
      $app_result = $app_stmt->get_result();
      if ($app_result->num_rows > 0) {
        $has_applied = true;
      }
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
      <p>Every animal adopted out means 2 lives saved, the one adopted out and the one replacing its space at the shelter.</p>
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
              <p class="text-center"><?php echo htmlspecialchars($animal['description']); ?></p>
            </div>

            <div class="text-center mt-1">
              <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) { 
                if ($has_applied) { ?>
                  <button class="btn btn-secondary" disabled>Already Applied</button>
                <?php } else { ?>
                  <a href="adopt-now.php?animal_id=<?php echo $animal_id ?>"><button class="btn">ADOPT NOW</button></a>
                <?php } 
              } else { ?>
                <a href="login.php"><i> Kindly sign in first.</a> <br>You need to be logged in to your account to adopt. </i>
              <?php } ?>
            </div>

          </div>
        </div>
      </div>
      <div class="py-4"></div>
    </div>
  </section>

  <?php include_once 'components/footer.php'; ?>

</body>
</html>

<?php 
} else {
  header("Location: home.php");
  exit();
}
?>

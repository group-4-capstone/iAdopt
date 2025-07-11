<?php include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'head_admin')) {
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
  <link rel="stylesheet" href="styles/home.css">
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

  <section class="hero-section">
    <div class="content">
      <h2>TRIAL 1 Adopt a PAW-some friend</h2>
      <p>
        Bring joy and love into your life by adopting a furry friend.
        Explore our wide selection of lovable pets ready to find their forever home.
      </p>
      <a href="adopt.php"><button class="btn1">Adopt Now</button></a>
      <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) { ?>
        <a href="logout.php"><button class="btn2">Log Out</button></a>
      <?php } else {  ?>
        <a href="signup.php"><button class="btn2">Sign Up</button></a>
      <?php } ?>
    </div>
  </section>

  <section class="intro-section">
    <div class="content">
      <div class="intro-box">
        <div class="row">
          <div class="col-lg-8 col-md-8 col-sm-12">
            <div class="title">
              <div class="logo">
                <img src="styles/assets/secaspi-logo.png"><span>Second Chance Aspin Shelter Philippines, Inc.</span>
              </div>
            </div>
            <p class="pt-4 p-2">
              Second Chance Aspin Shelter Philippines Inc. is home to 70 dogs and 30 cats. Aspin or "Asong Pinoy" (directly translated as "Filipino Dogs") are Philippine native dogs.
              Unfortunately, stray dogs are very rampant in the Philippines and there are many of cases of abandonment and animal cruelty.
              Second Chance Aspin Shelter Philippines aims to give these dogs as well as Puspins ("Pusang Pinoy," directly translated as "Filipino Cats")
              a second chance by giving them a home and preparing them for their furrever homes. The costs of treating, rehabilitating, and giving these animals a happy
              life are solely funded by donations.
            </p>
            <a href="visit-us.php"><button class="btn mb-2">Visit Us <i class="bi bi-arrow-up-right"></i></button></a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="intro-pic">
              <img src="styles/assets/aspin-puspin.png">
            </div>
          </div>
        </div>
      </div>
      <!-- Images -->
      <div class="gallery">
        <div class="gallery_container">
          <div class="gallery_items">
            <img src="styles/assets/aspin-1.png" alt="Gallery Image" />
          </div>
          <div class="gallery_items">
            <img src="styles/assets/aspin-2.png" alt="Gallery Image" />
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  $announcement_query = "SELECT * FROM announcements";
  $announcement_result = $db->query($announcement_query);
  if ($announcement_result->num_rows > 0) {
    while ($row = $announcement_result->fetch_assoc()) { ?>

      <!-- View announcement details modal -->
      <div class="modal fade" id="readMoreModal_<?php echo $row['announcement_id']; ?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addAnnouncementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body d-flex py-4">
              <button type="button" class="btn-close position-absolute top-0 end-0 mt-3 me-3 mb-5" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="row d-flex align-items-center">
                <div class="col-lg-6 col-md-12 text-center">
                  <img id="modalAnnouncementImage" src="styles/assets/announcement/<?php echo $row['image']; ?>" class="img-fluid" style="width: 90%;" alt="Announcement Image">
                </div>
                <div class="col-lg-6 col-md-12">
                  <h3 id="modalAnnouncementTitle" class="mt-3 text-center text-bold"><?php echo $row['title']; ?></h3>
                  <p id="modalAnnouncementDescription" class="p-4 mt-2"><?php echo $row['description']; ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><?php }
        } ?>

  <section class="announcement-section">
    <div class="content">
      <div class="title">
        UPDATES AND ANNOUNCEMENTS <div class="vertical-line"></div>
      </div>
      <div class="grid">
        <div class="section_container">
          <div class="grid_container">
            <div class="updates">
            </div>
          </div>
          <div class="d-flex justify-content-end mt-4">
            <div id="announcements_pagination_link"></div>
          </div>

        </div>
      </div>
    </div>
    </div>
  </section>

  <section class="process-section">
    <div class="image-back">
      <img src="styles/assets/paws.png" class="responsive-img">
    </div>
    <div class="content">
      <div class="title">
        How to Adopt Your New Friend
      </div>
      <p>Ready to bring home your new best friend? Explore, meet, adopt, and start your journey of love and joy today!</p>
      <div class="grid">
        <div class="section_container">
          <div class="grid_container">
            <div class="process">
              <div class="grid_items">
                <div class="grid_text">
                  <i class="fa-solid fa-paw"></i>
                  <h3>Find Your Match</h3>
                  <p>
                    Explore our website and find the perfect pet that steals your heart.
                  </p>
                </div>
              </div>
              <div class="grid_items">
                <div class="grid_text">
                  <i class="fa-solid fa-file-lines"></i>
                  <h3>Complete Paperwork</h3>
                  <p>
                    Complete the application and wait for verification of the approval.
                  </p>
                </div>
              </div>
              <div class="grid_items">
                <div class="grid_text">
                  <i class="fa-solid fa-heart"></i>
                  <h3>Contact and Meet</h3>
                  <p>Contact the shelter to meet the pet and see if it's a match.</p>
                </div>
              </div>
              <div class="grid_items">
                <div class="grid_text">
                  <i class="fa-solid fa-house"></i>
                  <h3>Take Them Home</h3>
                  <p>
                    Bring your new furry friend home and start making memories!
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="float-end pt-3"><a href="adopter-faqs.php"> Got some more questions?</a></div>
        </div>
      </div>
    </div>
  </section>

  <section class="otherlinks-section">
    <div class="content">
      <div class="row">
        <div class="col-lg-8 col-12">
          <?php
          $image_query = "SELECT image FROM animals WHERE animal_status = 'Adoptable' ORDER BY addition_date DESC LIMIT 3";
          $image_result = $db->query($image_query);

          $images = [];
          if ($image_result && $image_result->num_rows > 0) {
            while ($image = $image_result->fetch_assoc()) {
              if (!empty($image['image'])) {
                $images[] = $image['image'];
              }
            }
          }
          ?>
          <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <?php
              if (!empty($images)) {
                foreach ($images as $index => $image) {
                  $activeClass = ($index === 0) ? 'active' : '';
                  echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' . $index . '" class="' . $activeClass . '" aria-current="true" aria-label="Slide ' . ($index + 1) . '"></button>';
                }
              } else {
                echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
              }
              ?>
            </div>
            <div class="carousel-inner">
              <?php
              if (!empty($images)) {
                foreach ($images as $index => $image) {
                  $activeClass = ($index === 0) ? 'active' : '';
                  echo '
                    <div class="carousel-item ' . $activeClass . '">
                        <img src="styles/assets/animals/' . htmlspecialchars($image) . '" class="d-block w-100" alt="Animal Image">
                    </div>';
                }
              } else {
                echo '
                <div class="carousel-item active">
                    <img src="styles/assets/no-image.png" class="d-block w-100" alt="No image available">
                </div>';
              }
              ?>
            </div>

            <!-- Carousel controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>

          <div class="card mt-2 p-2">
            <div class="pt-2 ps-3">
              <i class="fa-solid fa-bag-shopping fa-2x"></i>
            </div>
            <h3 class="pt-3 px-3">Check out the SECASPI merchandise!</h3>
            <p class="pt-3 px-3">Please consider purchasing our merchandise as a way to show your support for our shelter.
              You can find our new set of caps and eco bags here:</p>
            <div class="px-3">
              <a href="shop.php"><button class="btn">Explore Merchandises</button></a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-12">
          <div class="row hover">
            <a href="adopt.php">
              <div class="card my-2 mt-2 p-2">
                <div class="pt-2 ps-3">
                  <i class="fa-solid fa-paw fa-2x"></i>
                </div>
                <h5 class="pt-3 px-3">Adopt Now</h5>
                <p class="pt-2 px-3">Explore our website and find the perfect pet that steals your heart.</p>
              </div>
            </a>
          </div>
          <div class="row hover">
            <a href="donate.php">
              <div class="card my-2 mt-2 p-2">
                <div class="pt-2 ps-3">
                  <i class="fa-solid fa-hand-holding-heart fa-2x"></i>
                </div>
                <h5 class="pt-3 px-3">Donate Here</h5>
                <p class="pt-2 px-3">Contact the shelter to meet the pet and see if it's a match.</p>
              </div>
            </a>
          </div>
          <div class="row hover">
            <a href="visit-us.php">
              <div class="card my-2 mt-2 p-2">
                <div class="pt-2 ps-3">
                  <i class="fa-solid fa-house fa-2x"></i>
                </div>
                <h5 class="pt-3 px-3">Visit the Shelter</h5>
                <p class="pt-2 px-3">Bring your new furry friend home and start making memories together!</p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="about-section" id="about-us">
    <div class="content">
      <h2>Second Chance Aspin Shelter Philippines, Inc.</h2>
      <p>
        Second Chance Aspin Shelter Philippines Inc. started out as a halfway home for Ronald De Castro's rescued dog. It was originally known as Deparo Shelter, Ronald rented a small place in Deparo.
        The nos. of rescued dog grew and the team decided to transfer to a bigger and better place in Canlubang-Calamba Laguna. Deparo Shelter was now renamed as Second Chance Aspin Shelter and was 
        Sec Registered July 31, 2018. <br>
        As of today:
        Second Chance Aspin Shelter Philippines Inc. is not only
        Sec Registered but also has approved<br>
        1. Mayors Permit<br>
        2. Health and Sanitation Permit<br>
        3. Fire Safety Clearance<br>
        4. BIR registered wit Cor<br>
        5. Local Government Permit<br>
        SECASPI is managed by team of dedicated volunteers with high
        regards towards integrity<br>
        1. Mary Ann Donasco Duquiatan<br>
        2. Suzette San Miguel David<br>
        3. Mark Anthony Miedes Habal<br>
        4. Bernadine Mahinay<br>
        5. Renz Oliver<br>
        6. Ronald De Castro <br>
        7. Miyuki Madeleine Dimalanta<br>
        8. Cherry Licup<br>
        The shelter being cared for by highly competent
        volunteer caretakers<br>
        Lyssa Villar and Buboy _____.<br>
        Thanks to our individual donors, supporters, Paws for providing for the shelter monthly expenses and dog food.
      </p>
    </div>
  </section>

  <?php include_once 'components/footer.php'; ?>

  <script src="scripts/home.js"></script>
</body>

</html>

<?php
} else {
    header("Location: dashboard.php");
}
?>
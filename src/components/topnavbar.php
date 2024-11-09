<header>
  <nav class="navbar">
    <div class="logo"><img src="styles/assets/secaspi-logo.png"><span>iAdopt-SECASPI</span></div>
    <ul class="menu-links">
      <span id="close-menu-btn" class="material-symbols-outlined">Close</span>
      <li><a href="home.php">Home</a></li>
      <li><a href="adopt.php">Adopt</a></li>
      <li><a href="report-stray.php">Report</a></li>
      <li><a href="donate.php">Donate</a></li>
      <li><a href="shop.php">Shop</a></li>
      <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) { ?>
        <li class="nav-item dropdown">
          <a class="nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle pe-2"></i>Hi, <?php echo $_SESSION['first_name'] ?>
            <i class="bi bi-chevron-down ps-2"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person-circle pe-2"></i>Profile</a></li>
            <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-left pe-2"></i>Logout</a></li>
          </ul>
        </li>
        <!-- Notification Icon -->
      <div class="notification-item" id="notification">
        <a href="#" role="button" data-bs-toggle="modal" data-bs-target="#notificationModal">
          <i class="bi bi-bell-fill notification-icon"></i>
          <span class="badge">2</span>
        </a>
      </div>
      <?php } else { ?>
        <li><a href="login.php">Login</a></li>
      <?php  } ?>
    </ul>
    <span id="hamburger-btn" class="material-symbols-outlined">Menu</span>
  </nav>
</header>

<!-- Modal Structure for Notifications -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-center w-100" id="notificationModalLabel">NOTIFICATIONS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="list-unstyled">
          <li class="notification-item pt-3">
            <a href="#" data-bs-toggle="modal" data-bs-target="#postAdoptionModal">
              <p>Post-Adoption Form</p>
            </a>
          </li>
          <li class="notification-item pt-3">
            <a href="#" data-bs-toggle="modal" data-bs-target="#adoptionModal">
              <p> Congratulations! Your adoption application has been approved!</p>
            </a>
          </li>
          <li class="notification-item pt-3">
            <p>New part of the family: Bella!</p>
          </li>
        </ul>
      </div>
      <div class="pb-3 text-center">
        <a href="#" class="text-danger">Clear Notifications</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal Structure for Post-Adoption
<div class="modal fade" id="postAdoptionModal" tabindex="-1" aria-labelledby="postAdoptionModalLabel" aria-hidden="true">
  <div class="modal-dialog py-4">
    <div class="modal-content">
      <div class="modal-body">
      <section class="form-section">
      <div class="content">
      <h4 class="text-center"><img src="styles/assets/secaspi-logo.png">POST- ADOPTION FORM</h4>
        <form id="signUpForm" action="#!">
        <div class="step">
            <p class="text-center mb-4">Kindly upload the current picture/ video of your adopted pet.</p>
            <div class="mb-3">
                <label>Current situation description:</label>
                  <input type="text" placeholder="Briefly describe the current situation of your pet." name="address1">
            </div>
            <div class="mb-3">
                <label for="placeUploads">Upload video and pictures of the place where dogs/cats will be kept</label>
                <input type="file" id="placeUploads" name="place_uploads[]" accept=".jpg,.jpeg,.png,.mp4,.mov" multiple required>
            </div>
          </div>
        <div class="form-footer d-flex">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
    </form>
      </div>
    </div>
  </section>
      </div>
    </div>
  </div>
</div> -->

<div class="modal fade" id="adoptionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-body d-flex">
        <!-- Close button (X) -->
        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
        <!-- Left side: GIF -->
        <div class="row p-5">
          <div class="col-12 col-md-12 col-sm-12 col-lg-6">
            <img src="styles/assets/success.gif" alt="Adoption Approved GIF" style="width:85%; transform: scaleX(-1);">
          </div>
          <!-- Right side: Text content -->
          <div class="col-12 col-md-12 col-sm-12 col-lg-6">
            <h4 class="mt-5 mb-3"><i class="bi bi-check-circle-fill pe-3" style="color: green; font-size:30px"></i>Adoption Application Approved!</h4>
            <p>Congratulations! Your adoption application has been reviewed and you may now proceed to the next step:</p>
            <p><strong>Online Interview</strong></p>
            <p><strong>Date:</strong> September 20, 2024</p>
            <p><strong>Time:</strong> 8pm</p>
            <p><em>Note: Meeting link will be sent on the day of the interview.</em></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const currentPath = window.location.pathname.split("/").pop();

  const menuLinks = document.querySelectorAll('.menu-links a');

  menuLinks.forEach(link => {
    const href = link.getAttribute('href');
    const currentPath = window.location.pathname.split('/').pop();

    if ((href === 'adopt.php' && ['adopt.php', 'adopt-know-more.php', 'adopt-now.php'].includes(currentPath)) ||
      href === currentPath) {
      link.classList.add('active');
    }
  });

  const header = document.querySelector("header");
  const hamburgerBtn = document.querySelector("#hamburger-btn");
  const closeMenuBtn = document.querySelector("#close-menu-btn");
  const notifBtn = document.querySelector("#notification");

  hamburgerBtn.addEventListener("click", () => header.classList.toggle("show-mobile-menu"));
  closeMenuBtn.addEventListener("click", () => hamburgerBtn.click());
  notifBtn.addEventListener("click", () => hamburgerBtn.click());
</script>
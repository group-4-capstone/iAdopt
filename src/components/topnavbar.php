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
            <li class="nav-item dropdown">
                <a class="nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle pe-2"></i>Hi, Juan
                    <i class="bi bi-chevron-down ps-2"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person-circle pe-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-left pe-2"></i>Logout</a></li>
                </ul>
             </li>
                <li class="notification-item">
                    <a href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell-fill notification-icon"></i>
                        <span class="badge">2</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="width: 300px; overflow-wrap: anywhere;">
                    <li class="text-center fw-bold">NOTIFICATIONS</li>
                    <li><hr class="dropdown-divider"></li>
                    <!-- Notification items -->
                    <li><a class="dropdown-item" href="#">New part of the family: Andres!</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#adoptionModal">Congratulations! Your adoption application has been approved!</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">New part of the family: Bella!</a></li>

                    <li><hr class="dropdown-divider"></li>

                    <!-- Clear notifications link -->
                    <li class="text-center">
                        <a href="#" class="dropdown-item text-danger">Clear Notifications</a>
                    </li>
                    </ul>
                </li>
            </li>
           </ul>
        <span id="hamburger-btn" class="material-symbols-outlined">Menu</span>
    </nav>
</header>

<div class="modal fade" id="adoptionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-body d-flex">
        <!-- Close button (X) -->
        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
        <!-- Left side: GIF -->
         <div class="row p-5">
        <div class="col-6 col-md-12 col-sm-12 col-lg-6">
        <img src="styles/assets/success.gif" alt="Adoption Approved GIF" style="width: 350px; transform: scaleX(-1);">

        </div>

        <!-- Right side: Text content -->
        <div class="col-6 col-md-12 col-sm-12 col-lg-6">
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
    const href = link.getAttribute('href'); // Get the href attribute of the link
    const currentPath = window.location.pathname.split('/').pop(); // Get the current page name

    // Check if the link matches the current page or specific pages
    if ((href === 'adopt.php' && ['adopt.php', 'adopt-know-more.php', 'adopt-now.php'].includes(currentPath)) ||
        href === currentPath) {
        link.classList.add('active'); // Add 'active' class if the condition is met
    }
});


      const header = document.querySelector("header");
      const hamburgerBtn = document.querySelector("#hamburger-btn");
      const closeMenuBtn = document.querySelector("#close-menu-btn");

      // Toggle mobile menu on hamburger button click
      hamburgerBtn.addEventListener("click", () => header.classList.toggle("show-mobile-menu"));

      // Close mobile menu on close button click
      closeMenuBtn.addEventListener("click", () => hamburgerBtn.click());

</script>
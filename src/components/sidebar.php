<header class="top-nav">
  <span id="hamburger-toggle" class="material-symbols-outlined">menu</span>
  <span class="logo-container">
    <img src="styles/assets/secaspi-logo.png" alt="logo" style="height: 40px;" />
    <h2>iAdopt</h2>
  </span>
</header>

<aside class="sidebar">
  <div class="sidebar-header">
    <img src="styles/assets/secaspi-logo.png" alt="logo" />
    <h2>iAdopt</h2>
  </div>
  <ul class="sidebar-links">
    <h4><span>Dashboard</span></h4>
    <li>
      <a href="dashboard.php">
        <i class="bi bi-house-door"></i>
        <span>Overview</span>
      </a>
    </li>
    <h4><span>Records</span></h4>
    <li>
      <a href="rescue-records.php">
        <i class="bi bi-folder"></i>
        <span>Rescue Records</span>
      </a>
    </li>
    <li>
      <a href="adoption-records.php">
        <i class="bi bi-folder"></i>
        <span>Adoption Records</span>
      </a>
    </li>
    <li>
      <a href="animal-profiles.php">
        <i class="bi bi-journals"></i>
        <span>Animal Profiles</span>
      </a>
    </li>
    <li>
      <a href="visitor-log.php">
        <i class="bi bi-person-lines-fill"></i>
        <span>Visitor Log</span>
      </a>
    </li>
    <li>
      <a href="history.php">
        <i class="bi bi-clock-history"></i>
        <span>History Log</span>
      </a>
    </li>
    <li>
      <a href="liquidation-monitoring.php">
        <i class="bi bi-calculator"></i>
        <span>Liquidation Monitoring</span>
      </a>
    </li>
    <h4><span>Setting</span></h4>
    <li>
      <a href="content-management.php">
        <i class="bi bi-flag"></i>
        <span>Content Management</span>
      </a>
    </li>
    <?php if (isset($_SESSION['email']) && $_SESSION['role'] == 'head_admin') { ?>
      <li>
        <a href="account-management.php">
          <i class="bi bi-people-fill"></i>
          <span>Account Management</span>
        </a>
      </li>
    <?php } ?>
  </ul>
  <div class="user-account">
    <div class="user-profile d-flex align-items-center justify-content-between">
      <div class="user-detail">
        <h3>
          <span id="sidebar-fullname" style="font-weight: bold; font-size: 1.10rem;"></span>
        </h3>
        <span><a href="settings.php">Profile</a></span>
      </div>
      <a href="logout.php" class="logout-icon">
        <i class="bi bi-box-arrow-right"></i>
      </a>
    </div>
  </div>
</aside>
<script>
  $(document).ready(function() {
    loadUserData(); // Load user data on page load
  });

  function loadUserData() {
    $.ajax({
      url: 'includes/sidebar-data.php',
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        const fullName = `${response.first_name} ${response.last_name}`.trim() || 'Guest';
        $('#sidebar-fullname').text(fullName);
      },
      error: function() {
        $('#sidebar-fullname').text('Guest');
      }
    });
  }


  const sidebar = document.querySelector(".sidebar");
  const hamburgerToggle = document.querySelector("#hamburger-toggle");
  const body = document.body;
  const hamburgerBtn = document.getElementById("hamburger-btn"); // Hamburger button

  // Listen for the click event to toggle sidebar visibility
  hamburgerToggle?.addEventListener("click", () => {
    sidebar.classList.toggle("show-mobile-menu");
    body.classList.toggle("menu-open");
  });


  // Close sidebar when clicking outside
  window.addEventListener("click", (e) => {
    if (!sidebar.contains(e.target) && e.target !== hamburgerToggle) {
      sidebar.classList.remove("show-mobile-menu");
      body.classList.remove("menu-open");

      // Show hamburger button when menu is closed
      hamburgerBtn.style.display = "block";
    }
  });


  // Highlight active menu link
  const currentPath = window.location.pathname.split("/").pop();
  const menuLinks = document.querySelectorAll(".sidebar-links li a");

  menuLinks.forEach((link) => {
    const href = link.getAttribute("href").split("/").pop();

    const isActive =
      (href === "animal-profiles.php" && ["animal-profiles.php", "animal-record.php"].includes(currentPath)) ||
      (href === "rescue-records.php" && ["rescue-records.php", "add-record.php"].includes(currentPath)) ||
      (href === "adoption-records.php" && ["adoption-records.php", "adoption-details.php"].includes(currentPath)) ||
      href === currentPath;

    if (isActive) {
      link.classList.add("active");
    }
  });
</script>
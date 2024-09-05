<aside class="sidebar">
  <div class="sidebar-header">
    <img src="styles/assets/secaspi-logo.png" alt="logo" />
     <span id="hamburger-btn" class="material-symbols-outlined">Menu</span>
    <h2>iAdopt</h2>
  </div>
  <ul class="sidebar-links">
    <h4>
      <span>Dashboard</span>
    </h4>
    <li>
      <a href="dashboard.php">
        <i class="bi bi-house-door"></i>
        <span>Overview</span>
      </a>
    </li>
    <h4>
      <span>Records</span>
    </h4>
    <li>
      <a href="rescue-records.php">
        <i class="bi bi-folder"></i>
        <span>Rescue Records</span>
      </a>
    </li>
    <li>
      <a href="#">
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
      <a href="#">
        <i class="bi bi-person-lines-fill"></i> 
        <span>Visitor Log</span>
      </a>
    </li>
    <li>
      <a href="#">
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
    <h4>
      <span>Setting</span>
    </h4>
    <li>
      <a href="#">
         <i class="bi bi-flag"></i>
        <span>Content Management</span>
      </a>
    </li>
    <li>
      <a href="#">
        <i class="bi bi-sliders"></i>
        <span>Setting</span>
      </a>
    </li>
  </ul>
  <div class="user-account">
    <div class="user-profile d-flex align-items-center justify-content-between">
        <div class="user-detail">
            <h3>Juan Dela Cruz</h3>
            <span><a href="#">Profile</a></span>
        </div>
        <a href="#" class="logout-icon">
            <i class="bi bi-box-arrow-right"></i> <!-- Logout icon -->
        </a>
    </div>
</div>
</aside>

<script>
        const aside = document.querySelector("aside");
        const hamburgerBtn = document.querySelector("#hamburger-btn");
        const closeMenuBtn = document.querySelector("#close-menu-btn");

        hamburgerBtn.addEventListener("click", () => aside.classList.toggle("show-mobile-menu"));

        if (closeMenuBtn) {
        closeMenuBtn.addEventListener("click", () => aside.classList.remove("show-mobile-menu"));
        }
        const currentPath = window.location.pathname.split("/").pop();
        const menuLinks = document.querySelectorAll('.sidebar-links li a');

        menuLinks.forEach(link => {
        const href = link.getAttribute('href').split("/").pop(); 
        if (href === currentPath) {
            link.classList.add('active');
        }
        });
 </script>

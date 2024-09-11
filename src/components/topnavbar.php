<header>
    <nav class="navbar">
      <div class="logo"><img src="styles/assets/secaspi-logo.png"><span>iAdopt-SECASPI</span></div>
        <ul class="menu-links">
            <span id="close-menu-btn" class="material-symbols-outlined">Close</span>
            <li><a href="home.php">Home</a></li>
            <li><a href="adopt.php">Adopt a Pet</a></li>
            <li><a href="donate.php">Donate Here</a></li>
            <li><a href="shop.php">Shop Merch</a></li>
            <li><a href="home.php#about-us">About us</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
        <span id="hamburger-btn" class="material-symbols-outlined">Menu</span>
    </nav>
</header>

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
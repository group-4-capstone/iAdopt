<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/sidebar.css">
    <!-- Google Fonts Links For Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
     <!-- Bootstrap Icons-->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
    <div class="sidebar">
        <div class="top">
            <div class="logo">
                <img src="../styles/assets/secaspi-logo.png" alt="logo" >
                <span>iAdopt</span>
            </div>
            <i><span class="material-symbols-outlined" id="hamburger-btn"></span>Menu</i>
            
        </div>
        <ul>

            <li>Dashboard</li>
            <li>
                <a href="#">
                    <i>
                        <span class="nav-item">Overview</span>
                    </i>
                </a>
                <span class="tooltip">Overview</span>
            </li>
            <li>Records</li>
            <li>
                <a href="#">
                    <i>
                        <span class="nav-item">Rescue Records</span>
                    </i>
                </a>
                <span class="tooltip">Rescue Records</span>
            </li>
            <li>
                <a href="#">
                    <i>
                        <span class="nav-item">Adoption Records</span>
                    </i>
                </a>
                <span class="tooltip">Adoption Records</span>
            </li>
            <li>
                <a href="#">
                    <i>
                        <span class="nav-item">Animal Profiles</span>
                    </i>
                </a>
                <span class="tooltip">Animal Profiles</span>
            </li>
            <li>
                <a href="#">
                    <i>
                        <span class="nav-item">Visitor Log</span>
                    </i>
                </a>
                <span class="tooltip">Visitor Log</span>
            </li>
            <li>
                <a href="#">
                    <i>
                        <span class="nav-item">Liquidation Monitoring</span>
                    </i>
                </a>
                <span class="tooltip">Liquidation Monitoring</span>
            </li>
            <li>
                <a href="#">
                    <i>
                        <span class="nav-item">History Log</span>
                    </i>
                </a>
                <span class="tooltip">History Log</span>
            </li>

            <li>Content Management</li>
            <li>
                <a href="#">
                    <i>
                        <span class="nav-item">Events</span>
                    </i>
                </a>
                <span class="tooltip">Events</span>
            </li>
            <li>
                <a href="#">
                    <i>
                        <span class="nav-item">List of Volunteers</span>
                    </i>
                </a>
                <span class="tooltip">List of Volunteers</span>
            </li>
            <li>
                <a href="#">
                    <i>
                        <span class="nav-item">Merchandise</span>
                    </i>
                </a>
                <span class="tooltip">Merchandise</span>
            </li>
            <li>
                <a href="#">
                    <i>
                        <span class="nav-item">FAQ</span>
                    </i>
                </a>
                <span class="tooltip">FAQ</span>
            </li>

            <li>
                <a href="#">
                    <i>
                        <span class="nav-item">Settings</span>
                    </i>
                </a>
                <span class="tooltip">Settings</span>
            </li>
        </ul>
        </ul>
        <div class="user">
            <img src="../styles/assets/secaspi-logo.png" alt="profile" class="user-img" >
            <div>
                <p class="bold" >Juan Dela Cruz </p>
                <p>Admin</p>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    let btn = document.querySelector('#hamburger-btn');
    let sidebar = document.querySelector('.sidebar');

    btn.onclick = function() {
        sidebar.classList.toggle('active');
    };
});

</script>
</html>
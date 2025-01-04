<?php
include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

$role = $_SESSION['role'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page Not Found</title>
  <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .empty-state {
      text-align: center;
      padding: 50px;
    }
    .empty-state img {
      width: 35%;
      height: auto;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="empty-state text-center">
    <img src="styles/assets/blank.svg" alt="No Data" class="img-fluid">
    <h1 class="mt-4">No Data Available</h1>
    <p class="text-muted">It seems there's nothing to display here yet.</p>
    <?php if ($role === 'admin' || $role === 'head_admin') { ?>
    <a href="dashboard.php" class="btn btn-primary">Go to Home</a>
    <?php } else { ?>
        <a href="home.php" class="btn btn-primary">Go to Home</a>
    <?php } ?>
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

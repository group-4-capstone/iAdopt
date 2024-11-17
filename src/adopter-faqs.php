<?php include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'head_admin')) { ?>

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
    <link rel="stylesheet" href="styles/faqs.css">

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

   <section class="faq-section">
        <div class="row justify-content-md-center">
          <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
            <b><h2 class="mb-4 text-center"><img src="styles/assets/secaspi-logo.png"> Frequently Asked Questions</h2></b>
            <p class="mb-5 text-center">This page offers quick and clear answers to the most common questions users may have. 
              It serves as a helpful guide for understanding the adoption process, using system features, and accessing support.</p>
            <div class="line"></div>
          </div>
        </div>
      </div>
   </section>

     <!-- FAQs Section -->
<section>
  <div class="my-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-11 col-xl-10">
          <div class="accordion accordion-flush" id="faqs">
            <!-- FAQ items will be loaded here dynamically -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

      
   <script src="scripts/adopter-faqs.js"></script>
   <?php include_once 'components/footer.php'; ?>

</body>
</html>
<?php
} else {
    header("Location: home.php");
}
?>
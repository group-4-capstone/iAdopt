<?php include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';


// Check session and role
if (isset($_SESSION['email']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'head_admin')) {



?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iADOPT | FAQs</title>
    <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
    <link rel="stylesheet" href="styles/sidebar.css">
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

    <?php include_once 'components/sidebar.php'; ?>

    <div class="admin-content">
      <section class="faq-section">
        <div class="row justify-content-md-center">
          <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
            <b>
              <h2 class="mb-4 text-center"><img src="styles/assets/secaspi-logo.png"> Frequently Asked Questions</h2>
            </b>
            <div class="line"></div>
          </div>
        </div>
      </section>

      <!-- FAQs -->
      <section>
        <div class="my-5">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-11 col-xl-10">
                <div class="accordion accordion-flush" id="faqAccordion">
                  <!-- FAQ 1 -->
                  <div class="accordion-item bg-transparent border-top border-bottom py-3">
                    <h2 class="accordion-header" id="faqHeading1">
                      <button class="accordion-button collapsed bg-transparent fw-bold shadow-none link-primary" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="false" aria-controls="faqCollapse1">
                        How do I start the adoption process?
                      </button>
                    </h2>
                    <div id="faqCollapse1" class="accordion-collapse collapse" aria-labelledby="faqHeading1">
                      <div class="accordion-body">
                        You need to submit an application form and wait for the verification by the admin. You will be instructed on the next steps to proceed with the adoption.
                      </div>
                    </div>
                  </div>
                  <!-- FAQ 2 -->
                  <div class="accordion-item bg-transparent border-bottom py-3">
                    <h2 class="accordion-header" id="faqHeading2">
                      <button class="accordion-button collapsed bg-transparent fw-bold shadow-none link-primary" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                        What documents do I need to adopt a pet?
                      </button>
                    </h2>
                    <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2">
                      <div class="accordion-body">
                        You will need to provide a valid government-issued ID and proof of residence. Additional documents, such as a landlord's approval (if renting), may also be required.
                      </div>
                    </div>
                  </div>
                  <!-- FAQ 3 -->
                  <div class="accordion-item bg-transparent border-bottom py-3">
                    <h2 class="accordion-header" id="faqHeading3">
                      <button class="accordion-button collapsed bg-transparent fw-bold shadow-none link-primary" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                        Is there an adoption fee?
                      </button>
                    </h2>
                    <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3">
                      <div class="accordion-body">
                        Yes, there is a minimal adoption fee that helps cover the cost of vaccinations, deworming, and other medical expenses for the pet.
                      </div>
                    </div>
                  </div>

                </div>

                <!-- Bootstrap JS -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-2UzwOBp9x/Vo41kXUytStKu+rnZ/PasLr2PMS1gXtf5v0U7PxaQDmzjUJj9n9tpo" crossorigin="anonymous"></script>

  </body>

  </html>

<?php
} else {
  header("Location: login.php");
}
?>
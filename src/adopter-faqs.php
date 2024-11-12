<?php include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';

if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'head_admin') { ?>

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

      <!-- FAQs -->
    <section>
      <div class="my-5">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-11 col-xl-10">
              <div class="accordion accordion-flush" id="faqRefund">
                <div class="accordion-item bg-transparent border-top border-bottom py-3">
                  <h2 class="accordion-header" id="faqRefundHeading1">
                    <button class="accordion-button collapsed bg-transparent fw-bold shadow-none link-primary" type="button" data-bs-toggle="collapse" data-bs-target="#faqRefundCollapse1" aria-expanded="false" aria-controls="faqRefundCollapse1">
                    How do I start the adoption process?
                    </button>
                  </h2>
                  <div id="faqRefundCollapse1" class="accordion-collapse collapse" aria-labelledby="faqRefundHeading1">
                    <div class="accordion-body">
                    You need to submit an application form and wait for the verification of the admin. You will be instructed with the next steps in order to proceed.
                    </div>
                  </div>
                </div>
                <div class="accordion-item bg-transparent border-bottom py-3">
                  <h2 class="accordion-header" id="faqRefundHeading2">
                    <button class="accordion-button collapsed bg-transparent fw-bold shadow-none link-primary" type="button" data-bs-toggle="collapse" data-bs-target="#faqRefundCollapse2" aria-expanded="false" aria-controls="faqRefundCollapse2">
                    What documents do I need to adopt a pet?
                    </button>
                  </h2>
                  <div id="faqRefundCollapse2" class="accordion-collapse collapse" aria-labelledby="faqRefundHeading2">
                    <div class="accordion-body">
                      <p>Eligible items for a refund or exchange must meet the following criteria:</p>
                      <ul>
                        <li>They are in their original condition, unused, and in their original packaging.</li>
                        <li>The request is made within the specified timeframe.</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="accordion-item bg-transparent border-bottom py-3">
                  <h2 class="accordion-header" id="faqRefundHeading3">
                    <button class="accordion-button collapsed bg-transparent fw-bold shadow-none link-primary" type="button" data-bs-toggle="collapse" data-bs-target="#faqRefundCollapse3" aria-expanded="false" aria-controls="faqRefundCollapse3">
                    Is there an adoption fee?
                    </button>
                  </h2>
                  <div id="faqRefundCollapse3" class="accordion-collapse collapse" aria-labelledby="faqRefundHeading3">
                    <div class="accordion-body">
                      <p>If you receive a damaged or defective item, please contact our customer support team immediately. We will guide you on the return process and offer a refund or replacement, as appropriate.</p>
                    </div>
                  </div>
                </div>
                <div class="accordion-item bg-transparent border-bottom py-3">
                  <h2 class="accordion-header" id="faqRefundHeading4">
                    <button class="accordion-button collapsed bg-transparent fw-bold shadow-none link-primary" type="button" data-bs-toggle="collapse" data-bs-target="#faqRefundCollapse4" aria-expanded="false" aria-controls="faqRefundCollapse4">
                    How long does the adoption process take?
                    </button>
                  </h2>
                  <div id="faqRefundCollapse4" class="accordion-collapse collapse" aria-labelledby="faqRefundHeading4">
                    <div class="accordion-body">
                      <p>Shipping costs for returning the item for an exchange and sending the new item are usually the responsibility of the customer, unless the exchange is due to an error on our part.</p>
                    </div>
                  </div>
                </div>
                <div class="accordion-item bg-transparent border-bottom py-3">
                  <h2 class="accordion-header" id="faqRefundHeading5">
                    <button class="accordion-button collapsed bg-transparent fw-bold shadow-none link-primary" type="button" data-bs-toggle="collapse" data-bs-target="#faqRefundCollapse5" aria-expanded="false" aria-controls="faqRefundCollapse5">
                    Can I adopt more than one pet at a time?
                    </button>
                  </h2>
                  <div id="faqRefundCollapse5" class="accordion-collapse collapse" aria-labelledby="faqRefundHeading5">
                    <div class="accordion-body">
                      <p>If you change your mind about a refund or exchange request, please contact our customer support team as soon as possible. We will do our best to accommodate your request, but once a refund or exchange is processed, it may not be reversible.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
      
   
   <?php include_once 'components/footer.php'; ?>

</body>
</html>
<?php
} else {
    header("Location: home.php");
}
?>
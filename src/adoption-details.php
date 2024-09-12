<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iADOPT | SECASPI</title>
    <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
    <link rel="stylesheet" href="styles/sidebar.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/content-management.css">

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

    <section class="banner-section">
      <div class="content">
        <div class="head-title">
          <h1><u><b>ADOPTION DETAILS</b></u></h1>
        </div>
        <p>
        Review the adoption application of <strong> ADOPTION #12 </strong>.
        </p>
      </div>
    </section>

    <div class="container my-5">
    <!-- Selected Dog Details -->
    <div class="row dog-details mb-4">
        <div class="col-lg-4 text-center">
            <img src="styles/assets/aspin-1.png" class="img-fluid rounded-circle" alt="Selected Dog" style="width: 200px; height: 200px; object-fit: cover;">
        </div>
        <div class="col-lg-8">
            <h2 class="mb-3">Dog Name: <strong>Andres</strong></h2>
            <p><strong>Date Rescued:</strong> August 21, 2024</p>
            <p><strong>Description:</strong> Was rescued just outside Bria Homes at Calamba Laguna. He was a stray and a resident took pity on him along with his playmate. He was being fed regularly up until some residents filed complaints. 
            The feeder/rescuer then sought help for rescue. We named him after his rescuer, and Andres officially became part of the SECASPI family.</p>
        </div>
    </div>

    <!-- Adopter Information -->
    <div class="adopter-info">
        <h4 class="mt-2">Adopter Information</h4>
        <div class="ps-3">
        <p class="mt-3"><strong>Name:</strong> John Doe</p>
        <p><strong>Email:</strong> john.doe@example.com</p>
        <p><strong>Phone:</strong> +123 456 7890</p>
        <p><strong>Address:</strong> 123 Main St, Springfield</p>
        <p><strong>Work:</strong> Web Developer</p>
        </div>
    </div>

    <!-- Accordion for Questionnaire Response and Proof -->
    <div class="accordion" id="adoptionDetailsAccordion">
        <!-- Questionnaire Response -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingQuestionnaire">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseQuestionnaire" aria-expanded="true" aria-controls="collapseQuestionnaire">
                    Questionnaire Response
                </button>
            </h2>
            <div id="collapseQuestionnaire" class="accordion-collapse collapse show" aria-labelledby="headingQuestionnaire" data-bs-parent="#adoptionDetailsAccordion">
                <div class="accordion-body">
                    <p><strong>Why do you want to adopt?</strong></p>
                    <p>We love dogs and want to provide a loving home for Buddy.</p>
                    <p><strong>Do you have prior experience with pets?</strong></p>
                    <p>Yes, we have had pets in the past.</p>
                </div>
            </div>
        </div>
       <!-- Proof -->
      <div class="accordion-item">
          <h2 class="accordion-header" id="headingProof">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProof" aria-expanded="false" aria-controls="collapseProof">
                  Proof
              </button>
          </h2>
          <div id="collapseProof" class="accordion-collapse collapse" aria-labelledby="headingProof" data-bs-parent="#adoptionDetailsAccordion">
            <div class="accordion-body">
                <p class="mt-2">Proof of identity and home address will be required during the adoption process.</p>

                <!-- Row for Images -->
                <div class="row mt-3">
                    <!-- Sample ID Image -->
                    <div class="col-md-6">
                        <h5>Valid ID:</h5>
                        <img src="styles/assets/id.png" alt="Sample ID" class="img-fluid mb-3" style="max-width: 100%;">
                    </div>

                    <!-- Picture of the Place where Pet will be Staying -->
                    <div class="col-md-6">
                        <h5>Picture of the Pet's New Home:</h5>
                        <img src="styles/assets/house.jpg" alt="Pet's New Home" class="img-fluid mb-3" style="max-width: 100%;">
                    </div>
                </div>
            </div>
        </div>

      </div>

    </div>

    <!-- Approve and Reject Buttons -->
    <div class="d-flex justify-content-end mt-4">
        <button class="btn btn-success me-2">Approve</button>
        <button class="btn btn-danger">Reject</button>
    </div>
</div>




 </div>

</body>

  <script src="scripts/content-management.js"></script>
</html>
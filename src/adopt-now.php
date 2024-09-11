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
    <link rel="stylesheet" href="styles/adopt.css">

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

   <section class="user-banner-section">
      <div class="content">
        <h2>Adoption</h2>
        <h4>We Need Help. So Do They.</h4>
        <p>
          Every animal adopted out means 2 lives saved, the one adopted out and the one replacing 
          its space at the shelter.
        </p>
      </div>
    </section>

    <section class="solo-section">
      <div class="content">
      <div class="solo-box">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
             <div class="picture-frame">
                   <img id="profile-image" src="styles/assets/aspin-1.png" alt="Profile Picture">
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 d-flex flex-column align-items-center">
                <div class="row">
                  <h2 class="text-center">ANDRES</h2>
                  <p class="text-center">
                    <ul class="custom-list list-unstyled text-center">
                      <li><i class="bi bi-check-circle-fill"></i> Male</li>
                      <li><i class="bi bi-check-circle-fill"></i> w/Anti-rabies, 5 in 1</li>
                      <li><i class="bi bi-check-circle-fill"></i> Spayed</li>
                      <li><i class="bi bi-x-circle-fill" style="color: red;"></i> Food Aggression</li>
                      <li><i class="bi bi-check-circle-fill"></i> Cats</li>
                      <li><i class="bi bi-check-circle-fill"></i> Dogs</li>
                      <li><i class="bi bi-check-circle-fill"></i> Humans</li>
                      <li><i class="bi bi-check-circle-fill"></i> Great Companion</li>
                    </ul>
                  </p>
                </div>
                <div class="row">
                  <p class="text-center">
                    Was rescued just outside Bria Homes at Calamba Laguna. He was a stray and a resident took pity on him along with his playmate. He was being fed regularly up until some residents filed complaints. The feeder/rescuer then sought help for rescue. We named him after his rescuer, and Andres officially became part of the SECASPI family.
                  </p>
                </div>
              </div>
            </div>
           </div>
          </div>
        </div>
      </div>
    </section>

    <section class="form-section">
      <div class="content">
        <h4>Adoption Form</h4>
        <form id="signUpForm" action="#!">
        <!-- Step indicators -->
        <div class="form-header d-flex mb-4">
            <span class="stepIndicator">Personal Details</span>
            <span class="stepIndicator">Questionnaire</span>
            <span class="stepIndicator">Upload Proof</span>
        </div>

        <!-- Step one -->
        <div class="step">
            <p class="text-center mb-4">We already have your other details upon signing up. Please supply other needed information.</p>
            <div class="mb-3">
                <label>Complete Address</label>
                <div class="row">
                    <div class="col">
                        <input type="text" placeholder="Blk 12 L7 San Lorenzo Ph 1C" name="address1">
                    </div>
                    <div class="col">
                        <input type="text" placeholder="Brgy. Malitlit" name="address2">
                    </div>
                    <div class="col">
                        <input type="text"  placeholder="City of Santa Rosa" name="address3">
                    </div>
                    <div class="col">
                        <input type="text"  placeholder="Laguna" name="address4">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label>Are you a/an:</label>
                <select name="occupation">
                    <option value="" selected>-- Kindly select an option --</option>
                    <option value="student">Student</option>
                    <option value="employee">Employee</option>
                    <option value="none">None of the Above</option>
                </select>
            </div>
            <div class="mb-3">
                <label>What is your profession?</label>
                <input type="text" placeholder="Profession" name="profession">
            </div>
        </div>

        <!-- Step two -->
        <div class="step">
            <p class="text-center mb-4">We want to know if you are fit to adopt. Kindly answer the following truthfully.</p>
            <div class="mb-3">
                <label>Why did you decide to adopt an animal?</label>
                <input type="text" name="facebook">
            </div>
            <div class="mb-3">
                Have you adopted from us before?
                <select name="occupation">
                    <option value="" selected>Yes</option>
                    <option value="student">No</option>
                </select>
            </div>
            <div class="mb-3">
                <label>What type of residence do you live in?</label>
                <select name="occupation">
                    <option value="" selected>-- Kindly select an option --</option>
                    <option value="student">Condominium</option>
                    <option value="employee">Apartment</option>
                    <option value="none">Detached House (with fence/gate)</option>
                    <option value="student">Detached House (without fence/gate)</option>
                    <option value="employee">Townhouse (with fence/gate)</option>
                    <option value="employee">Townhouse (without fence/gate)</option>
                </select>
            </div>
            <div class="mb-3">
                <label>In which part of the house will the animal stay?</label>
                <select name="occupation">
                    <option value="" selected>Inside the house ONLY</option>
                    <option value="student">Inside/Outside the house</option>
                    <option value="employee">Outside the house ONLY</option>
                </select>
            </div>
            <div class="mb-3">
                <label>What will happen to this animal if you have to move unexpectedly?</label>
                <input type="text" name="facebook">
            </div>
            <div class="mb-3">
                <label>What kind of behavior(s) of the dog do you feel you will be unable to accept?</label>
                <input type="text" name="facebook">
            </div>
            <div class="mb-3">
                <label>What will happen to your companion animal when you go on vacation or in case of emergency?</label>
                <input type="text" name="facebook">
            </div>
        </div>

        <!-- Step three -->
        <div class="step">
            <p class="text-center mb-4">Few more things, please upload the following:</p>
            
            <div class="mb-3">
                <label for="validId">Upload a Valid ID (company/government ID)</label>
                <input type="file" id="validId" name="valid_id" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>
            
            <div class="mb-3">
                <label for="placeUploads">Upload video and pictures of the place where dogs/cats will be kept</label>
                <input type="file" id="placeUploads" name="place_uploads[]" accept=".jpg,.jpeg,.png,.mp4,.mov" multiple required>
            </div>
        </div>

        <!-- Form Footer: Previous/Next buttons -->
        <div class="form-footer d-flex">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
    </form>
      </div>
    </div>
  </section>
   
   <?php include_once 'components/footer.php'; ?>
</body>

<script src="scripts/adoption-form.js"></script>
</html>
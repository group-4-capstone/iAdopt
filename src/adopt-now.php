<?php include_once 'includes/session-handler.php';
include_once 'includes/db-connect.php';
?>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    <section class="form-section pb-5">
      <div class="content">
        <h4><img src="styles/assets/secaspi-logo.png">Adoption Form</h4>        
        <form id="applicationForm" method="post">

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
                <label class="mb-3">Complete Address</label>
                <div class="row">
                 <div class="col-sm-12 col-lg-6 mb-3">
                    <label>Region<span class="asterisk"> *</span></label>
                    <select name="region" id="region" required></select>
                    <input type="hidden" class="form-control form-control-md" name="region_text" id="region-text" required>
                </div>
                <div class="col-sm-6 mb-3">
                    <label>Province<span class="asterisk"> *</span></label>
                    <select name="province" id="province" required></select>
                    <input type="hidden" class="form-control form-control-md" name="address4" id="province-text" required>
                </div>
                <div class="col-sm-6 mb-3">
                    <label>City / Municipality<span class="asterisk"> *</span></label>
                    <select name="city" id="city" required></select>
                    <input type="hidden" class="form-control form-control-md" name="address3" id="city-text">
                </div>
                <div class="col-sm-6 mb-3">
                    <label>Barangay<span class="asterisk"> *</span></label>
                    <select name="barangay" id="barangay" required></select>
                    <input type="hidden" class="form-control form-control-md" name="address2" id="barangay-text">
                </div>
                <div class="col-lg-12 mb-3">
                    <label for="street-text">Street, Subdivision/Village<span class="asterisk"> *</span></label>
                    <input type="text" class="form-control form-control-md" name="address1" id="street-text" required>
                </div>
                </div>
            </div>
            <div class="mb-3">
              <label>Are you a/an:<span class="asterisk"> *</span></label>
              <select name="occupation" id="occupation" required>
                  <option value="" selected disabled>-- Kindly select an option --</option>
                  <option value="Student">Student</option>
                  <option value="Employee">Employee</option>
                  <option value="None of the Above">None of the Above</option>
              </select>
          </div>
        <div class="mb-3 ms-4" id="professionField" style="display: none;">
            <label>> What is your profession?<span class="asterisk"> *</span></label>
            <input type="text" placeholder="Profession" name="profession">
        </div>
        </div>

        <!-- Step two -->
        <div class="step">
            <p class="text-center mb-4">We want to know if you are fit to adopt. Kindly answer the following truthfully.</p>
            <div class="mb-3">
                <label>Why did you decide to adopt an animal?</label>
                <input type="text" name="purpose" required>
            </div>
            <div class="mb-3">
                <label>What type of residence do you live in?</label>
                <select name="residence" id="residence" required>
                    <option value="" selected disabled>-- Kindly select an option --</option>
                    <option value="Condominium">Condominium</option>
                    <option value="Apartment">Apartment</option>
                    <option value="Detached House (with fence/gate)">Detached House (with fence/gate)</option>
                    <option value="Detached House (without fence/gate)">Detached House (without fence/gate)</option>
                    <option value="Townhouse (with fence/gate)">Townhouse (with fence/gate)</option>
                    <option value="Townhouse (without fence/gate)">Townhouse (without fence/gate)</option>
                </select>
            </div>
            <div class="mb-3 ms-4" id="fencedYardField" style="display: none;">
              <label>> Please specify the height and type of your fence.</label>
              <input type="text" id="fence" name="fence">
            </div>
            <div class="mb-3 ms-4" id="nofencedYardField" style="display: none;">
              <label>> How will you handle the dog's exercise and toilet duties if there is no fence?</label>
              <input type="text" id="no_fence" name="no_fence">
            </div>

            <!-- If cat selected pet -->
              <div class="mb-3">
              If adopting a cat, where will be the litter box be kept?
              <input type="text" id="litter_place" name="litter_place" required>
              </div>

            <div class="mb-3">
                Is the residence for RENT?
                <select name="rent" id="rent" required>
                    <option value="" selected disabled>-- Kindly select an option --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="mb-3 ms-4" id="writtenLetterField" style="display: none;">
              <label>> Please upload a written letter from your landlord that pets are allowed.</label>
              <input type="file" id="rent_letter" name="rent_letter" accept=".jpg,.jpeg,.png,.pdf">
            </div>
            <div class="mb-3">
                <label>In which part of the house will the animal stay?</label>
                <select name="house_part" required>
           
                    <option value="" selected disabled>-- Kindly select an option --</option>
                    <option value="Inside the house ONLY">Inside the house ONLY</option>
                    <option value="Inside/Outside the house">Inside/Outside the house</option>
                    <option value="Outside the house ONLY">Outside the house ONLY</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Where will this animal be kept during the day and during night? Please specify.</label>
                <input type="text" name="stay_place" required>
            </div>
            <div class="mb-3">
                <label>Who do you live with? Please be specific.</label>
                <input type="text" name="household_members" required>
            </div>
            <div class="mb-3">
                <label>How long have you lived in the address registered here?</label>
                <input type="number" name="reg_years" required>
            </div>
            <div class="mb-3">
              Are you planning to move in the next six (6) months?
                <select name="move" id="move" required>
                    <option value="" selected disabled>-- Kindly select an option --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="mb-3 ms-4" id="specificAddressField" style="display: none;">
              <label>> Please leave a specific address.</label>
              <input type="text" id="new_address" name="new_address">
            </div>
            <div class="mb-3">
              Will the whole family be involved in the care of the animal?
                <select name="involve" id="involve" required>
                    <option value="" selected disabled>-- Kindly select an option --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="mb-3 ms-4" id="familyInvolveField" style="display: none;">
              <label>> Please explain why no.</label>
              <input type="text" id="involve_reason" name="involve_reason">
            </div>

            <div class="mb-3">
             Is there anyone in your household who has objection(s) to the arrangement?
                <select name="objection" id="objection" required>
                    <option value="" selected disabled>-- Kindly select an option --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">None</option>
                </select>
            </div>
            <div class="mb-3 ms-4" id="familyObjectionField" style="display: none;">
              <label>> Please explain why yes.</label>
              <input type="text" id="objection_reason" name="objection_reason">
            </div>

            <div class="mb-3">
            Are there any children who visit your home frequently?
                <select name="children_visit" id="children_visit" required>
                    <option value="" selected disabled>-- Kindly select an option --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>

            <div class="mb-3">
            Are there any other regular visitors on your home which your new companion (pet) must get along?
                <select name="other_visit" id="other_visit" required>
                    <option value="" selected disabled>-- Kindly select an option --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">None</option>
                </select>
            </div>
            
            <div class="mb-3">
            Are there any member of your household who has an allergy to cats and dogs?
                <select name="allergy" id="allergy" required>
                    <option value="" selected disabled>-- Kindly select an option --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">None</option>
                </select>
            </div>
            <div class="mb-3 ms-4" id="familyAllergyField" style="display: none;">
              <label>> Who?</label>
              <input type="text" id="member_allergy" name="member_allergy">
            </div>

            <div class="mb-3">
                <label>What will happen to this animal if you have to move unexpectedly?</label>
                <input type="text" name="move_unexpectedly" required>
            </div>
            <div class="mb-3">
                <label>What kind of behavior(s) of the dog do you feel you will be unable to accept?</label>
                <input type="text" name="unacceptable_behavior" required>
            </div>
            <div class="mb-3">
                <label>How many hours in an average work day will your companion animal spend without a human?</label>
                <input type="number" name="no_human_hours" required>
            </div>
            <div class="mb-3">
                <label>What will happen to your companion animal when you go on vacation or in case of emergency?</label>
                <input type="text" name="emergency" required>
            </div>
            <div class="mb-3">
            Do you have other companion animals?
                <select name="companion" id="companion" required>
                    <option value="" selected disabled>-- Kindly select an option --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">None</option>
                </select>
            </div>
            <div class="mb-3 ms-4" id="companionField" style="display: none;">
              <label>> Please specify what type and the total number.</label>
              <input type="text" id="other_animals" name="other_animals">
              <div class="mt-4 mb-3">
                > Do you have a regular veterinarian?
                    <select name="veterinarian" id="veterinarian">
                        <option value="" selected disabled>-- Kindly select an option --</option>
                        <option value="Yes">Yes</option>
                        <option value="No">None</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 ms-4" id="veterinarianField" style="display: none;">
              <label>> Veterinarian Name</label>
              <input type="text" id="vet_name" name="vet_name" >
              <label>> Veterinarian Address/Location</label>
              <input type="text" id="vet_address" name="vet_address">
              <label>> Veterinarian Contact Number</label>
              <input type="text" id="vet_number" name="vet_number">
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
                <input type="file" id="placeUploads" name="proof_place[]" accept=".jpg,.jpeg,.png,.mp4,.mov" multiple required>
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

  
    <!-- Success Modal -->
    <div class="modal fade" id="successApplicationModal" tabindex="-1" aria-labelledby="successRescueModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close d-flex ms-auto" onclick="window.location.href='adopt.php'"></button>
          <div class="text-center">
            <i class="bi bi-check-circle-fill" style="font-size: 8rem; color: #28a745;"></i>
            <p class="mt-4 px-2"> Your adoption application has been submitted successfully! Kindly check your notifications for the status of your application.
              Thank you!
            </p>
          </div>
        </div>     
      </div>
    </div>
  </div>

   
   <?php include_once 'components/footer.php'; ?>
</body>

<script src="scripts/ph-address-selector.js"></script>
<script src="scripts/adopt-now.js"></script>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" type="image/x-icon" href="styles/assets/secaspi-logo.png">
    <link rel="stylesheet" href="styles/topnavbar.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/signup.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Google Fonts Links For Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
    <!-- Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- JS Script CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php include_once 'components/topnavbar.php'; ?>
    <div class="body">
        <div class="form-left row col-sm-12 d-flex justify-content-center">
            <h1>Adopt a PAW-some friend</h1>
            <p><strong>Sign up</strong> to get started</p>
        </div>

        <!-- Error and Success Message Section -->
        <?php if (isset($_GET['error'])) : ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (explode(',', $_GET['error']) as $error) : ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'true') : ?>
            <div class="alert alert-success">
                Registration successful!
                <?php if (isset($_GET['email_sent']) && $_GET['email_sent'] === 'true') : ?>
                    <br>Your welcome email has been sent to your email address.
                <?php elseif (isset($_GET['email_error'])) : ?>
                    <br>However, we encountered an issue sending the welcome email: <?php echo htmlspecialchars($_GET['email_error']); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <img src="styles/assets/signup.png" alt="Family with pets" class="img-fluid w-100">
            </div>

            <div class="col-12 col-lg-6">
                <form id="signup-form" novalidate>
                    <div class="row mt-4">
                        <!-- Last Name Field -->
                        <div class="col-12 col-sm-5 mb-3">
                            <label for="last-name" class="form-label">Last Name *</label>
                            <input type="text" id="last-name" name="last-name" class="form-control" placeholder="Dela Cruz" maxlength="50" required>
                            <div class="invalid-feedback">Please provide a valid last name. Only letters, spaces, hyphens, and apostrophes are allowed.</div>
                        </div>

                        <!-- First Name Field -->
                        <div class="col-10 col-sm-5 mb-3">
                            <label for="first-name" class="form-label">First Name *</label>
                            <input type="text" id="first-name" name="first-name" class="form-control" placeholder="Juan" maxlength="50" required>
                            <div class="invalid-feedback">Please provide a valid first name. Only letters, spaces, hyphens, and apostrophes are allowed.</div>
                        </div>

                        <div class="col-2 col-sm-2 mb-3">
                            <label for="mi" class="form-label">M.I</label>
                            <input type="text" id="mi" name="mi" class="form-control" placeholder="J" maxlength="2">
                            <div class="invalid-feedback">Please enter only letters for middle initial.</div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 col-sm-6 mb-3">
                            <label for="birthdate" class="form-label">Birthdate *</label>
                            <input type="date" id="birthdate" name="birthdate" class="form-control" required>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <label for="gender" class="form-label">Sex *</label>
                            <select id="gender" name="gender" class="form-select" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="facebook-profile" class="form-label">Facebook Profile Link *</label>
                        <input type="url" id="facebook-profile" name="facebook-profile" class="form-control" placeholder="https://facebook.com/your-profile" maxlength="100" required>
                        <div class="invalid-feedback">Please enter a valid Facebook profile link (e.g., https://facebook.com/your-profile).</div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 mb-3">
                            <label for="contact-number" class="form-label">Contact Number *</label>
                            <input type="tel" id="contact-number" name="contact-number" class="form-control" placeholder="09123456789" minlength="11" maxlength="11" pattern="^[0-9]{11}$" inputmode="numeric" required>
                            <div class="invalid-feedback">Please enter a valid contact number (11 digits).</div>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="juan.delacruz@example.com" maxlength="80" required>
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" maxlength="80" required>
                        <div class="invalid-feedback">Password must be at least 8 characters, include uppercase, lowercase, a number, and a special character.</div>
                    </div>

                    <div class="mb-5">
                        <label for="confirm-password" class="form-label">Confirm Password *</label>
                        <input type="password" id="confirm-password" name="confirm-password" class="form-control" placeholder="Confirm your password" maxlength="80" required>
                        <div class="invalid-feedback">Passwords do not match.</div>
                    </div>
                    <div class="signup-container d-flex justify-content-center">
                        <p>
                            By clicking Sign Up, you agree to our 
                            <a href="#terms" id="openTerms">Terms and Conditions</a> and 
                            <a href="#privacy" id="openPrivacy">Privacy Policy</a>.
                        </p>
                    </div>

                    <div class="d-flex justify-content-center input-container">
                        <button type="button" id="sign-up-btn">Sign Up</button>
                    </div>
                </form>
            </div>

            <!-- Verification Modal -->
            <div class="modal fade" id="verificationModal" tabindex="-1" aria-labelledby="verificationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verificationModalLabel">Enter Verification Code</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>A 6-digit verification code has been sent to your email. Please enter it below to proceed.</p>
                            <div class="mb-3">
                                <label for="verification-code" class="form-label">Verification Code</label>
                                <input type="text" id="verification-code" class="form-control" maxlength="6" pattern="^[0-9]{6}$" required>
                                <div class="invalid-feedback">Please enter a valid 6-digit code.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" id="verify-btn" class="btn btn-primary">Verify</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast for Success -->
        <div class="toast" id="success-toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header">
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                You have successfully signed up! You will be redirected to the login page in 5 seconds.
            </div>
        </div>
    </div>

    <!-- Terms and Conditions Modal -->
    <div id="termsModal" class="modal" style="overflow: hidden !important;">
        <div class="modal-content custom-scroll" style="max-height: 95vh; overflow-y: auto; overflow-x: hidden; margin-top: 20px;">
        <span class="close position-absolute end-0 top-0 me-3 mt-2"  id="closeTerms" data-bs-dismiss="modal" style="font-size: 1.5rem; cursor: pointer;">&times;</span>
            <h2>Terms and Conditions</h2>
            <br>
            <br>
            <p>
                By using or registering for iAdopt: Animal Rescuing to Adoption Management System ("iAdopt" or "the Platform"), 
                you agree to be bound by these Terms and Conditions ("Terms"). These Terms govern your use of the platform 
                and services provided through iAdopt. If you do not agree with these Terms, you should refrain from creating 
                an account or using the platform. iAdopt is designed to assist in rescuing, and adopting animals, and by 
                accessing or using the platform, you acknowledge that you understand and agree to the conditions set forth herein.
            </p>
            <p>
                To access certain features of iAdopt, you must create an account, and by doing so, you agree to provide accurate, 
                up-to-date, and complete information. It is your responsibility to maintain the confidentiality of your account details, 
                including your username and password. You are solely responsible for any activity that occurs under your account, 
                and you agree to notify iAdopt immediately if you suspect any unauthorized access or use of your account.
            </p>
            <p>
                iAdopt facilitates the rescue, and adoption of animals. As a user, whether you are a rescue organization,  or adopter, you agree to use the platform in accordance with applicable laws and regulations, including those related to animal welfare. You are prohibited from using the platform for unlawful purposes or engaging in any activities that could cause harm to animals or other users. You agree to act in good faith when managing animals,  or adopting, and ensure the well-being of the animals involved. Additionally, all animal listings must be accurate, and you agree to update any information promptly.
            </p>
            <p>
                You are responsible for ensuring that any adoption or fostering process you engage in complies with the requirements outlined by the respective rescue organization or foster. iAdopt does not guarantee the availability or condition of animals listed on the platform and makes no representations regarding the adoption or fostering process. Users are responsible for verifying the suitability of adopters or fosters and must adhere to any necessary background checks or paperwork required.
            </p>
            <p>
                iAdopt respects your privacy and is committed to safeguarding your personal information. By using the platform, you consent to our collection and use of your data as described in the Privacy Policy https://policies.google.com/privacy?hl=en-US. You are prohibited from posting misleading or harmful content and must refrain from engaging in behavior that could negatively impact the platform, its users, or the animals being listed. This includes but is not limited to fraud, harassment, or discrimination.
            </p>
            <p>
                iAdopt reserves the right to suspend or terminate your account if we believe you have violated these Terms or engaged in any conduct that undermines the integrity of the platform. If your account is suspended or terminated, you may lose access to any animals or services associated with your account. Additionally, we retain the right to modify or update these Terms at any time, and any changes will be posted on this page with an updated date. Continued use of the platform after these updates constitutes your acceptance of the revised Terms.
            </p>
            <p>
                iAdopt and its affiliates will not be held liable for any direct, indirect, incidental, or consequential damages arising from your use of the platform, including any issues related to animal adoptions or interactions with other users. You agree to indemnify and hold iAdopt, its employees, and affiliates harmless from any claims or damages arising from your use of the platform, violation of these Terms, or any unlawful activities conducted through your account.
            </p>
            <p>
                These Terms are governed by the laws of the Data Privacy Act of 2012, and any disputes arising from these Terms shall 
                be resolved in the courts of the Philippines. If you have any questions about these Terms, please contact us at our 
                email account: 
                <br><br><a href="mailto:araojo1jb@gmail.com">araojo1jb@gmail.com</a>, 
                <br><a href="mailto:ninatamparongvios@gmail.com">ninatamparongvios@gmail.com</a>, 
                <br><a href="mailto:imjanellesaniel@gmail.com">imjanellesaniel@gmail.com</a>, 
                <br><a href="mailto:andreasofiavillalobos26@gmail.com">andreasofiavillalobos26@gmail.com</a>, 
                <br><a href="mailto:patriciajanebato29@gmail.com">patriciajanebato29@gmail.com</a>.
            </p>
        </div>
    </div>

    <!-- Privacy Policy Modal -->
    <div id="privacyModal" class="modal" style="overflow: hidden !important;">
        <div class="modal-content custom-scroll" style="max-height: 95vh; overflow-y: auto; overflow-x: hidden; margin-top: 20px;">
        <span class="close position-absolute end-0 top-0 me-3 mt-2" id="closePrivacy" data-bs-dismiss="modal" style="font-size: 1.5rem; cursor: pointer;">&times;</span>
            <h2>Privacy Policy</h2>
            <br>
            <br>
            <p>
            At iAdopt: Animal Rescuing to Adoption Management System ("iAdopt," "we," "our," or "us"), we are committed to protecting and respecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our platform, including our website, mobile app, or other services ("Platform"). By accessing or using iAdopt, you agree to the collection and use of your information as described in this Privacy Policy.

            <br><br> Please read this policy carefully to understand our views and practices regarding your personal data and how we will treat it.<br> 

            </p>
            <p>
                <strong>Information We Collect:</strong> <br><br>We collect information to provide and improve our services. The types of information we may collect include:

                <br><br>Personal Information: When you create an account on iAdopt, we may collect personal details such as your name, email address, phone number, mailing address, and other contact information. This information is necessary to provide you with access to our platform’s features, such as animal listings, adoption requests, and fostering opportunities.

                <br><br>Animal-Related Information: If you are a rescue organization or foster, we may collect information about the animals you list, such as species, breed, age, health status, and adoption status. This information is essential for listing animals on the platform and matching them with potential adopters or fosters.

                <br><br> Usage Data: We may collect data on how you access and use the platform, such as IP addresses, browser types, device types, pages visited, and other usage-related data. This helps us analyze how users interact with iAdopt and improve the user experience.

            </p>
            <p>
                <strong>How We Use Your Information:</strong>
                <br><br> We use the information we collect for the following purposes:

                <br><br>Account Management: To create and manage your account, communicate with you, and provide support.
                <br>Animal Listings and Matches: To enable rescue organizations and fosters to list animals and to help match animals with potential adopters or fosters.
                <br>Platform Improvements: To analyze usage patterns and improve the features, functionality, and performance of iAdopt.
                <br>Communication: To send you relevant updates, notifications, and information about new animals, events, or changes to the platform.
                <br>Legal Compliance: To comply with applicable laws, regulations, and legal requests.

            </p>
            <p>
                <strong>How We Share Your Information:</strong> 
                <br><br>We may share your information in the following circumstances:<br><br>

                <br>With Third Parties: We may share your information with third-party service providers who help operate our platform, such as payment processors, data hosting services, and email service providers. These third parties are obligated to protect your data and may only use it to provide services to us.
                <br>With Other Users: If you are an adopter, foster, or rescue organization, we may share your contact information with other users of iAdopt for communication and collaboration purposes related to animal rescue and adoption.
                <br>For Legal Reasons: We may disclose your information if required to do so by law or in response to legal requests (e.g., subpoenas, court orders) or if we believe such action is necessary to protect our rights, your safety, or the safety of others.

            </p>
            <p>
                <strong>Data Retention:</strong>
                <br><br>We retain your personal information for as long as necessary to fulfill the purposes outlined in this Privacy Policy, unless a longer retention period is required or permitted by law. If you choose to delete your account, we will retain your information for a period of time to comply with legal obligations, resolve disputes, and enforce agreements.
            </p>
            <p>
                <strong>Your Choices and Rights:</strong>
                <br><br>You have certain rights regarding the personal information we collect:<br><br>
                Access and Update Your Information: You can access and update your personal information by logging into your account on the iAdopt platform. If you need help updating or correcting your information, you can contact us at [Your Contact Information].
                Delete Your Account: You can request to delete your account at any time by contacting us. Note that certain information may be retained for legal or administrative purposes.
                Opt-Out of Communications: You can opt-out of receiving promotional emails or notifications by following the unsubscribe instructions provided in the email or by contacting us.

            </p>
            <p>
                <strong>Data Security:</strong>
                <br><br>We implement reasonable technical and organizational measures to protect your personal information from unauthorized access, disclosure, alteration, or destruction. However, no system can be completely secure, and we cannot guarantee the absolute security of your data.
            </p>
            <p>
                <strong>Cookies and Tracking Technologies:</strong>
                <br><br>We use cookies and similar tracking technologies to enhance your experience on our platform. Cookies are small files stored on your device that help us analyze usage patterns, provide personalized content, and improve our platform. You can control cookie settings through your browser, but disabling cookies may affect the functionality of the platform.
            </p>
            <p>
                <strong>Children’s Privacy:</strong>
                <br><br>iAdopt is not intended for use by individuals under the age of 13. We do not knowingly collect or solicit personal information from children under 13. If we become aware that a child under 13 has provided us with personal information, we will take steps to delete such information.
            </p>
            <p>
                <strong> Changes to This Privacy Policy:</strong>
                <br><br>We may update this Privacy Policy from time to time. Any changes will be posted on this page, and the updated date will be reflected at the top of the policy. We encourage you to review this policy periodically to stay informed about how we are protecting your information.
            </p>
            <p>
                <strong>Contact Us:</strong>
            </p>
            <p>
                If you have any questions about this Privacy Policy, please contact us at: 
                <a href="mailto:ninatamparongvios@gmail.com">ninatamparongvios@gmail.com</a>, 
                <a href="mailto:imjanellesaniel@gmail.com">imjanellesaniel@gmail.com</a>.
            </p>
        </div>
    </div>


    <?php include_once 'components/footer.php'; ?>
    <!-- JS Files -->
    <script src="scripts/ph-address-selector.js"></script>
    <script src="scripts/signup.js"></script>
</body>

</html>
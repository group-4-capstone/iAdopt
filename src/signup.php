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
                <form method="POST" action="includes/signup-process.php" novalidate>
                    <div class="row mt-4 mb-3">
                        <!-- Last Name Field -->
                        <div class="col-12 col-sm-5">
                            <label for="last-name" class="form-label">Last Name *</label>
                            <input type="text" id="last-name" name="last-name" class="form-control" placeholder="Dela Cruz" maxlength="50" required>
                            <div class="invalid-feedback">Please provide a valid last name. Only letters, spaces, hyphens, and apostrophes are allowed.</div>
                        </div>

                        <!-- First Name Field -->
                        <div class="col-10 col-sm-5">
                            <label for="first-name" class="form-label">First Name *</label>
                            <input type="text" id="first-name" name="first-name" class="form-control" placeholder="Juan" maxlength="50" required>
                            <div class="invalid-feedback">Please provide a valid first name. Only letters, spaces, hyphens, and apostrophes are allowed.</div>
                        </div>

                        <div class="col-2 col-sm-2">
                            <label for="mi" class="form-label">M.I</label>
                            <input type="text" id="mi" name="mi" class="form-control" placeholder="J" maxlength="2">
                            <div class="invalid-feedback">Please enter only letters for middle initial.</div>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-12 col-sm-6">
                            <label for="birthdate" class="form-label">Birthdate *</label>
                            <input type="date" id="birthdate" name="birthdate" class="form-control" required>
                        </div>
                        <div class="col-12 col-sm-6">
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
                        <input type="url" id="facebook-profile" name="facebook-profile" class="form-control" placeholder="https://facebook.com/your-profile" maxlength="100" required pattern="https://facebook\.com/.+">
                        <div class="invalid-feedback">Please enter a valid Facebook profile link (e.g., https://facebook.com/your-profile).</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-6">
                            <label for="contact-number" class="form-label">Contact Number *</label>
                            <input type="tel" id="contact-number" name="contact-number" class="form-control" placeholder="09123456789" minlength="11" maxlength="11" pattern="^[0-9]{11}$" inputmode="numeric" required>
                            <div class="invalid-feedback">Please enter a valid contact number (11 digits).</div>
                        </div>
                        <div class="col-12 col-sm-6">
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

                    <div class="d-flex justify-content-center input-container">
                        <button type="submit">Sign Up</button>
                    </div>
                </form>
            </div>


        </div>


    </div>


    <?php include_once 'components/footer.php'; ?>
    <!-- JS Files -->
    <script src="scripts/ph-address-selector.js"></script>
    <script src="scripts/signup.js"></script>
</body>

</html>
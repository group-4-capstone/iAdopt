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
</head>
<body>
<?php include_once 'components/topnavbar.php'; ?>   
    <div class="body">
        <div class="form-left row col-sm-12 d-flex justify-content-center">
            <h1>Adopt a PAW-some friend</h1>
            <p><strong>Sign up</strong> to get started</p>
        </div>
        <div class="row">
            <div class="form-left col-sm-12 col-lg-6 col-6">

                <div class="image-container">
                    <img src="styles/assets/signup.png" alt="Family with pets">
                </div>
            </div>

            <div class="col-sm-12 col-lg-6 col-6">
                <form>
                    <div class="input-group">
                        <div class="input-container col-sm-12 col-lg-12  col-12">
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last-name" name="last-name" placeholder="Dela Cruz">
                        </div>
                        <div class="input-container col-sm-12 col-lg-9 col-9">
                            <label for="first-name">First Name</label>
                            <input type="text" id="first-name" name="first-name" placeholder="Juan">
                        </div>
                        <div class="input-container col-sm-12 col-lg-2 col-2">
                            <label for="mi">M.I</label>
                            <input type="text" id="mi" name="mi" placeholder="J">
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-container">
                            <label for="birthdate">Birthdate</label>
                            <input type="date" id="birthdate" name="birthdate">
                        </div>
                        <div class="input-container">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-container col-sm-12 col-lg-7 col-7">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" placeholder="City of Santa Rosa">
                        </div>
                        <div class="input-container col-sm-12 col-lg-4 col-4">
                            <label for="region">Region</label>
                            <input type="text" id="region" name="region" placeholder="Laguna">
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-container col-sm-12 col-lg-12 col-12">
                            <label for="facebook-profile">Facebook Profile Link</label>
                            <input type="text" id="facebook-profile" name="facebook-profile" placeholder="https://facebook.com/your-profile">
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-container">
                            <label for="contact-number">Contact Number</label>
                            <input type="text" id="contact-number" name="contact-number" placeholder="(555) 555-5555">
                        </div>
                        <div class="input-container">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="juan.delacruz@example.com">
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-container col-sm-12 col-lg-12 col-12">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter your password">
                        </div>
                        <div class="input-container col-sm-12 col-lg-12 col-12">
                            <label for="confirm-password">Confirm Password</label>
                            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <div class="input-container col-sm-12 col-lg-4 col-4 d-flex justify-content-center">
                                <button type="submit">Sign Up</button>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include_once 'components/footer.php'; ?>
</body>

</html>
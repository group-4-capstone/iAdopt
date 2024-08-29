<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
<div class="login-container">
    <div class="image-section">
        <img src="styles/assets/dogologin.png" alt="Dog Image">
    </div>
    <div class="login-form-section">
        <form>
            <div class="logo">
                <img src="styles/assets/secaspi-logo.png" alt="Logo">
            </div>
            <h2>LOGIN</h2>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="juanadelacruz@gmail.com">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="********">
            </div>
            <div class="options">
                <a href="#" class="forgot-password">Forgot Password?</a>
            </div>
            <div class="login-button-container">
                <button type="submit" class="login-btn">Login</button>
            </div>
            
            <div class="signup-option">
                <p>Don't have an account? <a href="#">Sign Up Now</a></p>
            </div>
        </form>
    </div>
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Code Verification</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-bottom: 5px;
            display: none;
        }
        .input-error {
            border-color: red;
        }
        .blocked-message {
            color: darkred;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container mt-5 col-5">
    <h2 class="text-center">Verify Reset Code</h2>
    <form id="verify-code-form" action="includes/verify-code-handler.php" method="POST">
        <div class="mb-3 mt-5">
            <label for="code" class="form-label">Enter the code sent to your email:</label>
            <input type="text" class="form-control" id="code" name="code" maxlength="6">
            <div id="error-message" class="error-message"></div>
        </div>
        <div id="blocked-message" class="error-message blocked-message" style="display:none;">
         You have entered incorrect codes too many times. Access is temporarily blocked.
        </div>
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
        <button type="submit" id="submit-button" class="btn btn-primary">Verify Code</button>
    </form>
    
</div>

<script>
    const codeInput = document.getElementById('code');
    const errorMessage = document.getElementById('error-message');
    const blockedMessage = document.getElementById('blocked-message');
    const submitButton = document.getElementById('submit-button');
    let attemptCount = 0;
    const maxAttempts = 5;
    const blockDuration = 5 * 60 * 1000; // 5 minutes in milliseconds
    const blockKey = 'resetCodeBlock'; // Unique key for storing block info

    function isBlocked() {
        const blockData = JSON.parse(localStorage.getItem(blockKey));
        if (blockData && new Date().getTime() < blockData.expiry) {
            return true;
        } else {
            localStorage.removeItem(blockKey); // Clear expired block
            return false;
        }
    }

    function setBlock() {
        const expiryTime = new Date().getTime() + blockDuration;
        localStorage.setItem(blockKey, JSON.stringify({ expiry: expiryTime }));
        blockedMessage.style.display = 'block';
        submitButton.disabled = true;
        codeInput.disabled = true;
    }

    if (isBlocked()) {
        setBlock(); // Immediately block if already in blocked state
    }

    codeInput.addEventListener('input', function () {
        const value = this.value;
        if (/[^0-9]/.test(value)) {
            errorMessage.textContent = 'Only numeric digits (0-9) are allowed.';
            errorMessage.style.display = 'block';
            codeInput.classList.add('input-error');
            this.value = value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
        } else {
            errorMessage.style.display = 'none';
            codeInput.classList.remove('input-error');
        }
    });

    document.getElementById('verify-code-form').addEventListener('submit', function (event) {
        if (isBlocked()) {
            setBlock();
            event.preventDefault();
            return;
        }

        const codeValue = codeInput.value.trim();
        if (codeValue === '' || !/^\d{6}$/.test(codeValue)) {
            attemptCount++;
            event.preventDefault(); // Prevent form submission on invalid input
            errorMessage.textContent = `Invalid code. Attempt ${attemptCount} of ${maxAttempts}.`;
            errorMessage.style.display = 'block';
            codeInput.classList.add('input-error');

            if (attemptCount >= maxAttempts) {
                setBlock();
            }
        } else {
            attemptCount++;
            event.preventDefault(); // Simulate form handling for demonstration
            fetch('includes/verify-code-handler.php', {
                method: 'POST',
                body: new FormData(this)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'reset-password.php?email=' + encodeURIComponent(data.email);
                    } else {
                        errorMessage.textContent = `Incorrect code. Attempt ${attemptCount} of ${maxAttempts}.`;
                        errorMessage.style.display = 'block';
                        codeInput.classList.add('input-error');
                        if (attemptCount >= maxAttempts) {
                            setBlock();
                        }
                    }
                })
                .catch(() => {
                    errorMessage.textContent = 'An error occurred. Please try again.';
                    errorMessage.style.display = 'block';
                });
        }
    });
</script>

</body>
</html>

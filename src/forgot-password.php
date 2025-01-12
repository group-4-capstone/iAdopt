<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles/topnavbar.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .modal-content,
    .modal-header,
    .modal-footer {
        border: none !important;
    }
    </style>
</head>
<body>

<div class="container mt-5  col-5">
    <h2 class="text-center">Forgot Password</h2>
    <form id="forgot-password-form" action="includes/forgot-password-handler.php" method="POST">
        <div class="mt-5 mb-4">
            <label for="email" class="form-label">Enter your registered email:</label>
            <input type="email" class="form-control" id="email" name="email" maxlength="80" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalMessage">
                <!-- Message will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
    const modalMessageElement = document.getElementById('modalMessage');

    document.getElementById('forgot-password-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        const formData = new FormData(this);

        fetch('includes/forgot-password-handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            modalMessageElement.textContent = data.message; // Set modal message
            messageModal.show(); // Show modal
            if (data.success) {
                messageModal._element.addEventListener('hidden.bs.modal', () => {
                    window.location.href = 'reset-code.php?email=' + encodeURIComponent(formData.get('email'));
                }, { once: true });
            }
        })
        .catch(error => {
            modalMessageElement.textContent = 'An error occurred. Please try again.';
            messageModal.show();
        });
    });
</script>

</body>
</html>

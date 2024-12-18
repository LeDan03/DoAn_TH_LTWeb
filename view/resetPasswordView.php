
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <!-- Add link to Bootstrap 4 -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/myCss.css">
    <style>
       
    </style>
</head>
<body class="newPasswordbody">

    <div class="newPasswordContainer">
        <div class="newPasswordCard shadow-sm">
            <h3 class="text-center mb-4" style="font-size: xx-large; color: #007bff">Reset Your Password</h3>
            <p class="text-center mb-4" style="font-size: large">Please enter your new password below.</p>

            <!-- Reset Password Form -->
            <form action="process-reset-password.php" method="POST">
                <div class="form-group">
                    <label for="new-password">New Password</label>
                    <input type="password" class="form-control" id="new-password" name="new-password" placeholder="Enter your new password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirm your new password" required>
                </div>
                <input type="hidden" name="token" value="<?php ?>"> <!-- Pass the token to the PHP backend -->
                <button type="submit" class="btn newPassword-btn-primary" style="border: 1px solid black">Reset Password</button>
            </form>
            
            <p class="mt-3 text-center">
                <a href="../view/login.php">Back to Login</a>
            </p>
        </div>
    </div>

    <!-- Add Bootstrap 4 JS libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

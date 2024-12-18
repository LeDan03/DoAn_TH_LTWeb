
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Request</title>
    <!-- Add link to Bootstrap 4 -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/myCss.css">
</head>
<body class="resetPassBody">

    <div class="resetPassContainer">
        <div class="card shadow-sm">
            <h3 class="text-center mb-4" id="resetPassTitle">Reset Password</h3>
            <p class="text-center mb-4" id="resetPassContent">Enter your email to receive instructions on how to reset your password.</p>

            <!-- Reset Password Form -->
            <form action="/reset-password" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <button type="submit" class="btn btn-primary">Send request</button>
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

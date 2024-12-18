<?php
session_start();  // Khởi tạo session

include "../db_connect/Db.php";
include "../model/User.php";

$user = new User();
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    if ($user->getUserByEmail($email) == null) {
        $password = $_POST['password'] ?? '';
        $fullName = $_POST['full_name'] ?? '';

        $result = $user->save($email, $password, $fullName);

        if ($result)
            $message = '<div class="alert alert-success text-center">Registration successful! You can now <a href="../view/login.php">Login</a>.</div>';
        else 
            $message = '<div class="alert alert-danger text-center">Registration failed! Please try again later.</div>';
    } else 
        $message = '<div class="alert alert-warning text-center">This email is already registered. Please <a href="../view/login.php">login</a> or use another email.</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/myCss.css">
</head>
<body class="registerBody">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2 class="text-center mb-4" id="registerTitle">Create an Account</h2>

                <?php if ($message != ''): ?>
                    <div class="mb-3">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="register.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                    </div>

                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter full name" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-register" id="registerButton">Register</button>
                    </div>
                    <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

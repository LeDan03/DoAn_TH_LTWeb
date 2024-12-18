<?php
session_start();

include "../db_connect/Db.php";
include "../model/User.php";


$user = new User();
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $email = $_POST['email'] ?? '';
    if ($user->getUserByEmail($email) != null) 
    {
        $password = $_POST['password'] ?? '';
        $result = $user->authenticate($email, $password);
        if ($result)
        {
            $_SESSION['email'] = $email;
            header("Location: ../view/dashboard.php"); 
        }
        else
            $message = '<div class="alert alert-danger text-center">Login failed! Please try again later.</div>';
    } 
    else
        $message = '<div class="alert alert-warning text-center">This email is not registered. Please <a href="../view/register.php">Register</a> here.</div>';     
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/myCss.css">
</head>
<body class="loginBody">
    <div class="login-container">
        <h3 class="login-header">LOGIN</h3>

        <?php if ($message != ''): ?>
            <div class="mb-3">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email của bạn" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
            <button type="submit" class="btn btn-primary btn-login">Login</button>
        </form>

        <p class="mt-3 text-center">
            <a href="../view/resetPasswordRequest.php">Forgot your password?</a>
        </p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

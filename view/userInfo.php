<?php
session_start();
include "../db_connect/Db.php";
include "../model/User.php";

$email = $_SESSION['email'];

require_once '../db_connect/Db.php';  // Bao gồm file chứa lớp Db

// Tạo đối tượng Db
$db = new Db();
$sql = "SELECT imageUrl, full_name FROM user WHERE email = :email";
$user = $db->select($sql, ['email' => $email]);


$userFullName = !empty($user) ? $user[0]['full_name'] : 'User';
$avatarUrl = !empty($user) ? $user[0]['imageUrl'] : '../images/defaultAvatar.png';

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['avatar']['tmp_name'];
    $fileName = $_FILES['avatar']['name'];
    $fileSize = $_FILES['avatar']['size'];
    $fileType = $_FILES['avatar']['type'];

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'File type not allowed.']);
        exit;
    }

    $newFileName = uniqid('avatar_', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

    $uploadDir = '../images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadFilePath = $uploadDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
        $pdo = new PDO('mysql:host=localhost;dbname=ql_chitieu', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Cập nhật URL ảnh vào cơ sở dữ liệu
        $stmt = $pdo->prepare("UPDATE user SET imageUrl = :avatar WHERE email = :email");
        $stmt->execute([
            ':avatar' => $uploadFilePath,
            ':email' => $email
        ]);
        echo json_encode(['status' => 'success', 'avatar' => $uploadFilePath]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload image.']);
    }
}
$user = new User();
$userExpense = $user->getAllExpenseDTO();
$userIncome = $user->getAllIncomeDTO();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <link rel="stylesheet" href="../style/userInfo.css">
</head>

<body>
    <div class="sidebar" data-image="../assets/img/sidebar-5.jpg">
        <div class="sidebar-wrapper">
            <div class="logo">
                V&D
            </div>
            <ul class="nav">
                <li class="">
                    <a class="nav-link" href="./dashboard.php">
                        <i class="nc-icon nc-chart-pie-35"></i>
                        <p style="font-size:medium">Dashboard</p>
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">
                        <i class="nc-icon nc-circle-09"></i>
                        <p style="font-size:medium">User Profile</p>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="./target.php">
                        <i class="nc-icon nc-notes"></i>
                        <p style="font-size:medium">Target</p>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="./notifications.html">
                        <i class="nc-icon nc-bell-55"></i>
                        <p style="font-size:medium">Notifications</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="content" style="margin-left: 250px;">
        <div class="user-info mb-4">
            <div class="d-flex align-items-center">
                <img id="avatar" src="<?php echo $avatarUrl; ?>" alt="Avatar">
                <div class="ms-3">
                    <h2 style="font-family:UVNGiongSong; color:blue"><?php echo $userFullName; ?></h2>
                    <p><strong>Email: </strong><?php echo $email ?></p>
                    <label for="avatar-upload" class="btn btn-primary btn-avatar">Choose Avatar</label>
                    <input type="file" id="avatar-upload" class="d-none" accept="image/*">
                </div>
            </div>
        </div>

        <div class="combo-box-container mb-4" id="combobox-container">
            <select id="income-expense" class="form-select" style="width:150px">
                <option value="expense">Expense</option>
                <option value="income">Income</option>
            </select>
        </div>

        <div id="expense" class="table-container">
            <h3 class="mb-3" id="table-title">Expense Details</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="font-size:16px">STT</th>
                        <th style="font-size:16px">Date & Time</th>
                        <th style="font-size:16px">Description</th>
                        <th style="font-size:16px">Amount Spent</th>
                        <th style="font-size:16px">Payment Method</th>
                        <th style="font-size:16px">Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = 1; // Số thứ tự bắt đầu từ 1
                    foreach ($userExpense as $expense) {
                        echo '<tr>';
                        echo '<td>' . $stt++ . '</td>';
                        echo '<td>' . $expense->getDateTime() . '</td>';
                        echo '<td>' . $expense->getDescription() . '</td>';
                        echo '<td>' . number_format($expense->getAmountSpent(), 2) . '</td>';
                        echo '<td>' . $expense->getPaymentMethod() . '</td>';
                        echo '<td>' . $expense->getCategory() . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="income" class="table-container">
            <h3 class="mb-3" style="text-align:center; color:rgb(0, 28, 113)">Income Details</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="font-size:16px">STT</th>
                        <th style="font-size:16px">Date & Time</th>
                        <th style="font-size:16px">Description</th>
                        <th style="font-size:16px">Amount Received</th>
                        <th style="font-size:16px">Source</th>
                        <th style="font-size:16px">Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = 1; // Số thứ tự bắt đầu từ 1
                    foreach ($userIncome as $income) {
                        echo '<tr>';
                        echo '<td>' . $stt++ . '</td>';
                        echo '<td>' . $income->getDateTime() . '</td>';
                        echo '<td>' . $income->getDescription() . '</td>';
                        echo '<td>' . number_format($income->getAmountReceived(), 2) . '</td>';
                        echo '<td>' . $income->getSource() . '</td>';
                        echo '<td>' . $income->getNote() . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../assets/js/plugins/bootstrap-switch.js"></script>
<script src="../assets/js/light-bootstrap-dashboard.js?v=2.0.0" type="text/javascript"></script>
<script src="../assets/js/demo.js"></script>
<!-- Custom JS -->
<script>
    $(document).ready(function () {
        $('#expense').show();
        $('#income').hide();

        $('#income-expense').on('change', function () {
            if ($(this).val() === 'expense') {
                $('#expense').show();
                $('#income').hide();
            } else {
                $('#income').show();
                $('#expense').hide();
            }
        });

        $('#avatar-upload').on('change', function (event) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#avatar').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });

    // Handle Avatar Upload AJAX
    $('#avatar-upload').on('change', function () {
        var formData = new FormData();
        var avatarFile = $('#avatar-upload')[0].files[0];

        if (!avatarFile) {
            alert("Please choose an avatar image.");
            return;
        }

        formData.append('avatar', avatarFile);

        $.ajax({
            url: '', // Đường dẫn tới tệp PHP xử lý upload
            type: 'POST',
            data: formData,
            processData: false,  // Không xử lý dữ liệu, vì chúng ta đang gửi file
            contentType: false,  // Để jQuery biết chúng ta đang gửi dữ liệu file
            success: function (response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    // Hiển thị ảnh mới lên avatar
                    $('#avatar').attr('src', result.avatar);
                    alert("Avatar uploaded successfully!");
                } else {
                    alert("Error: " + result.message);
                }
            },
            error: function () {
                alert("An error occurred while uploading the image.");
            }
        });
    });
</script>
</body>

</html>
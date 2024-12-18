<?php
session_start();
include "../db_connect/Db.php";
include "../model/Target.php";

$email = $_SESSION['email'];

$month = date('m');
$year = date('Y');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $income_target = $_POST['income_target'];
    $expense_target = $_POST['expense_target'];

    $target = new Target();
    $result = $target->save($income_target, $expense_target);

    // Kiểm tra kết quả
    if ($result) {
        echo "<script>alert('Target saved successfully!');</script>";
    } else {
        echo "<script>alert('Failed to save target.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css?v=2.0.0" rel="stylesheet" />
    <link rel="stylesheet" href="../style/target.css">
    <title>Create Target</title>
</head>

<body style="background-color: #9900FF">
    <div class="container">
        <div class="text-center mt-4">
            <h3 class="text-center mb-4" style="color: white">CREATE THIS MONTH TARGET</h3>
        </div>

        <div class="card mt-4" style="max-width: 500px; margin: 0 auto;">
            <div class="card-header">
                <h4>Enter your income and expense target for <?php echo $month . '/' . $year; ?></h4>
                <hr>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="income_target" style="color:blue">Income Target (VNĐ):</label>
                        <input type="number" class="form-control" id="income_target" name="income_target" required>
                    </div>
                    <div class="form-group">
                        <label for="expense_target" style="color:blue">Expense Target (VNĐ):</label>
                        <input type="number" class="form-control" id="expense_target" name="expense_target" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="btn-save-target">Save Target</button>
                </form>
            </div>
        </div>


        <!-- Nút exit nằm dưới form -->
        <div class="d-flex justify-content-center mt-4">
            <a href="./target.php" class="btn btn-secondary" id="btn-exit">Exit</a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/plugins/bootstrap-switch.js"></script>
    <script src="../assets/js/light-bootstrap-dashboard.js?v=2.0.0" type="text/javascript"></script>
    <script src="../assets/js/demo.js"></script>
</body>

</html>
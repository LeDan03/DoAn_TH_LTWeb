<?php
session_start();
include "../db_connect/Db.php";
include "../model/Target.php";
// Lấy email từ session
$email = $_SESSION['email'];

// Lấy tháng và năm hiện tại
$month = date('m');
$year = date('Y');

$target = new Target();
$userTarget = $target->getUserTargetByTime($month, $year, $email);

$allUserTarget = $target->getAllUserTarget($email);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <link rel="stylesheet" href="../style/target.css">
    <title>Your Target</title>
</head>

<body>
    <div class="sidebar" data-image="../assets/img/sidebar-5.jpg">
        <div class="sidebar-wrapper">
            <div class="logo" style="font-size:30px">
                V&D
            </div>
            <ul class="nav">
                <li>
                    <a class="nav-link" href="./dashboard.php">
                        <i class="nc-icon nc-chart-pie-35"></i>
                        <p style="font-size:medium">Dashboard</p>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="#">
                        <i class="nc-icon nc-circle-09"></i>
                        <p style="font-size:medium">User Profile</p>
                    </a>
                </li>
                <li class="nav-item active">
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

    <div class="main-panel" id="main-panel">
        <div class="content">
            <div class="container-fluid">
                <div id="title-container">
                    <h2 class="text-center mb-4">YOUR TARGET</h2>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3>Target List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" style="border: 1px solid blue;">
                            <thead>
                                <tr>
                                    <th style="font-size:16px; border: 0px; color: blue">STT</th>
                                    <th style="font-size:16px; color: blue">Income Target (VNĐ)</th>
                                    <th style="font-size:16px; color: blue">Expense Target (VNĐ)</th>
                                    <th style="font-size:16px; color: blue">Month</th>
                                    <th style="font-size:16px; color: blue">Year</th>
                                    <th style="font-size:16px; color: blue">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($allUserTarget)): ?>
                                    <?php foreach ($allUserTarget as $index => $target): ?>
                                        <tr>
                                            <td style="font-size:16px"><?php echo $index + 1; ?></td>
                                            <td style="font-size:16px"><?php echo number_format($target['income_target']); ?>
                                            </td>
                                            <td style="font-size:16px"><?php echo number_format($target['expense_target']); ?>
                                            </td>
                                            <td style="font-size:16px"><?php echo $target['month']; ?></td>
                                            <td style="font-size:16px"><?php echo $target['year']; ?></td>
                                            <td style="font-size:16px">
                                                <?php if ($target['month'] == date('m') && $target['year'] == date('Y')): ?>
                                                    <a href="edit_target.php?month=<?php echo $target['month']; ?>&year=<?php echo $target['year']; ?>"
                                                        class="btn btn-primary">Edit</a>
                                                <?php else: ?>
                                                    <button class="btn btn-secondary" disabled>Edit</button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center" style="font-size:16px">No target set for this
                                            user.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
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
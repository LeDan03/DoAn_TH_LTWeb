<?php
session_start();
include "../db_connect/Db.php";
include "../model/Expense.php";
include "../model/Payment_method.php";
include "../model/Category.php";
include "../model/Income.php";
include "../model/Source.php";
include "../model/Chart.php";

$defaultPayment = new PaymentMethod();
$defaultPayment->addDefaultPayment();

$defaultCategory = new Category();
$defaultCategory->addDefaultCategory();
$categories = $defaultCategory->findAll();

$defaultSource = new Source();
$defaultSource->addDefaultSource();
$sources = $defaultSource->findAll();

$categoriesJson = json_encode($categories);
$sourcesJson = json_encode($sources);
?>
<script>
    var categories = <?php echo $categoriesJson; ?>;
    var sources = <?php echo $sourcesJson; ?>;
</script>
<?php
$allPayment = $defaultPayment->findAll();

$email = $_SESSION['email'];

$chart = new Chart();
$month = date('m');

$expense_percent = round($chart->getExpensePercentByMonthAndEmail($month, $email), 2);
$income_percent = round($chart->getIncomePercentByMonthAndEmail($month, $email), 2);
$expense_sum = $chart->getExpenseSumByMonthAndEmail($month, $email);
$income_sum = $chart->getIncomeSumByMonthAndEmail($month, $email);
$total = $chart->getTotalByMonthAndEmail($month, $email);

$type = isset($_POST['income_expense_type']) ? $_POST['income_expense_type'] : 'expense';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['income_expense_type'];
    $amount = $_POST['amount'];
    $time = $_POST['date_time'];
    $description = $_POST['description'];
    $payment = $_POST['payment_method'];
    $note = $_POST['source_note'] ?? '';

    if ($type == 'expense') {
        $category_write = $_POST['category_write'] ?? '';
        $category_select = $_POST['category_select'] ?? '';

        $expense = new Expense();
        $result = $expense->save(
            $category_write,
            $category_select
            ,
            $amount,
            $time,
            $description,
            $payment
        );
    } else {
        $source_write = $_POST['category_write'] ?? '';
        $source_select = $_POST['category_select'] ?? '';

        $income = new Income();
        $result = $income->save(
            $source_select,
            $source_write,
            $note,
            $amount,
            $time,
            $description
        );
        var_dump($result);
    }

    $expense_percent = round($chart->getExpensePercentByMonthAndEmail($month, $email), 2);
    $expense_sum = $chart->getExpenseSumByMonthAndEmail($month, $email);
    $income_percent = round($chart->getIncomePercentByMonthAndEmail($month, $email), 2);
    $income_sum = $chart->getIncomeSumByMonthAndEmail($month, $email);
    $total = $chart->getTotalByMonthAndEmail($month, $email);
}

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/chartist-plugin-tooltip@0.0.17/dist/chartist-plugin-tooltip.min.css">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Home</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <link rel="stylesheet" href="../style/myCss.css">
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-image="../assets/img/sidebar-5.jpg">
            <div class="sidebar-wrapper">
                <div class="logo">
                    V&D
                </div>
                <ul class="nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p style="font-size:medium">Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./userInfo.php">
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
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class="container-fluid">
                    <a class="navbar-brand"> Dashboard </a>
                    <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                        aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="nav navbar-nav mr-auto">
                            <li class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <i class="nc-icon nc-planet"></i>
                                    <span class="notification">5</span>
                                    <span class="d-lg-none">Notification</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Notification 1</a>
                                    <a class="dropdown-item" href="#">Notification 2</a>
                                    <a class="dropdown-item" href="#">Notification 3</a>
                                    <a class="dropdown-item" href="#">Notification 4</a>
                                    <a class="dropdown-item" href="#">Another notification</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nc-icon nc-zoom-split"></i>
                                    <span class="d-lg-block">&nbsp;Search</span>
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <span class="no-icon">Account</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com"
                                    id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <span class="no-icon">Dropdown</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header ">
                                    <h4 class="card-title">Financial Management</h4>
                                    <p class="card-category">Pay attention to your spending!</p>
                                </div>
                                <div class="card-body ">
                                    <div id="chartContainer" style="position: relative;">
                                        <!-- Biểu đồ -->
                                        <div id="chartPreferences" class="ct-chart"></div>
                                        <div id="chartTitle">Biểu đồ so sánh tỉ lệ thu/chi tháng <?php echo $month ?>
                                        </div>
                                        <!-- Legend -->
                                        <div id="legend" class="legend">
                                            <div class="legend-item" id="expenseLegend">
                                                <span class="legend-color" style="background-color: #FF5733;"></span>
                                                <p>Expense</p>
                                            </div>
                                            <div class="legend-item" id="incomeLegend">
                                                <span class="legend-color" style="background-color: #33AFFF;"></span>
                                                <p>Income</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div id="detailChart">
                                            <div class="chart-row">
                                                <div>
                                                    <div class="data-title">Expense:</div>
                                                </div>
                                                <div class="data">
                                                    <div class="value">
                                                        <?php echo number_format($expense_sum) . ' VNĐ' ?>
                                                    </div>
                                                    <div class="percent"> <?php echo '(' . $expense_percent . '%)' ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="chart-row">
                                                <div>
                                                    <div class="data-title">Income:</div>
                                                </div>
                                                <div class="data">
                                                    <div class="value"><?php echo number_format($income_sum) . ' VNĐ' ?>
                                                    </div>
                                                    <div class="percent"> <?php echo '(' . $income_percent . '%)' ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div>
                                                    <p style="font-size: larger">Total:
                                                        <?php echo number_format($total) . ' VNĐ' ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Form nhập -->
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Enter Income/Expense</h4>
                                    <p class="card-category">Enter new income/expense information</p>
                                </div>
                                <div class="card-body">
                                    <form action="dashboard.php" method="POST">
                                        <div class="form-group row">
                                            <label for="income-expense-type" class="col-sm-4 col-form-label">
                                                Transaction Type</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="income-expense-type"
                                                    name="income_expense_type" onchange="handleIncomeExpenseChange()"
                                                    required>
                                                    <option value="expense">Expense</option>
                                                    <option value="income">Income</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Combobox loại chi tiêu -->
                                        <div class="form-group row">
                                            <label for="expense-type" class="col-sm-4 col-form-label"
                                                id="select-category-label">Select category</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="category_select"
                                                    name="category_select">
                                                    <?php
                                                    if ($type == 'expense') {
                                                        foreach ($categories as $cate) {
                                                            echo "<option value=\"{$cate['name']}\">{$cate['name']}</option>";
                                                        }
                                                    } else {
                                                        foreach ($sources as $source) {
                                                            echo "<option value=\"{$source['name']}\">{$source['name']}</option>";
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Nhập loại chi tiêu -->
                                        <div class="form-group row">
                                            <label for="expense-name" class="col-sm-4 col-form-label"
                                                id="write-category-label">Create New Category</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="category_write"
                                                    name="category_write"
                                                    placeholder="Nhập loại chi tiêu nếu loại này chưa có">
                                            </div>
                                        </div>

                                        <!-- Source note -->
                                        <div class="form-group row" style="display: none" id="source-note">
                                            <label for="source-note" class="col-sm-4 col-form-label">Income note</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" id="source-note" name="source_note"
                                                    rows="3" placeholder="Nhập chú thích cho nguồn thu"></textarea>
                                            </div>
                                        </div>
                                        <!-- Số tiền -->
                                        <div class="form-group row">
                                            <label for="amount" class="col-sm-4 col-form-label">Amount</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="amount" name="amount"
                                                    placeholder="Nhập số tiền" required>
                                            </div>
                                        </div>

                                        <!-- Thời gian -->
                                        <div class="form-group row">
                                            <label for="date-time" class="col-sm-4 col-form-label">Time</label>
                                            <div class="col-sm-8">
                                                <input type="datetime-local" class="form-control" id="date-time"
                                                    name="date_time" required>
                                            </div>
                                        </div>

                                        <!-- Mô tả -->
                                        <div class="form-group row">
                                            <label for="description" class="col-sm-4 col-form-label">Description</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" id="description" name="description"
                                                    rows="3" placeholder="Nhập mô tả chi tiết..."></textarea>
                                            </div>
                                        </div>

                                        <!-- Phương thức thanh toán -->
                                        <div class="form-group row" id="payment-method-container">
                                            <label for="payment-method" class="col-sm-4 col-form-label"
                                                id="payment_method">Payment
                                                Method</label>
                                            <div class="col-sm-8">
                                                <select name="payment_method">
                                                    <?php
                                                    foreach ($allPayment as $payment) {
                                                        echo "<option value=\"{$payment['id']}\">{$payment['name']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Nút Nhập -->
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-center">
                                                <button type="submit" class="btn btn-success"
                                                    id="btn-submit-expense-income">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-8">
                            <div class="card ">
                                <div class="card-header ">
                                    <h4 class="card-title">Users Behavior</h4>
                                    <p class="card-category">24 Hours performance</p>
                                </div>
                                <div class="card-body ">
                                    <div id="chartHours" class="ct-chart"></div>
                                </div>
                                <div class="card-footer ">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> Open
                                        <i class="fa fa-circle text-danger"></i> Click
                                        <i class="fa fa-circle text-warning"></i> Click Second Time
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> Updated 3 minutes ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Portfolio
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>
                        </ul>
                        <p class="copyright text-center">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                        </p>
                    </nav>
                </div>
            </footer>
        </div>
    </div>

</body>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/plugins/bootstrap-switch.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartist-plugin-tooltip@0.0.17/dist/chartist-plugin-tooltip.min.js"></script>
<script src="../assets/js/plugins/bootstrap-notify.js"></script>
<script src="../assets/js/light-bootstrap-dashboard.js?v=2.0.0" type="text/javascript"></script>
<script src="../assets/js/demo.js"></script>

<script>
    $(document).ready(function () {
        demo.initDashboardPageCharts();

        // demo.showNotification();

    });
</script>
<script>
    // Lấy thời gian hiện tại theo múi giờ Việt Nam (Asia/Ho_Chi_Minh)
    const currentDateTime = new Date();

    // Chuyển đổi thành định dạng 'YYYY-MM-DDTHH:MM:SS'
    const year = currentDateTime.getFullYear();
    const month = (currentDateTime.getMonth() + 1).toString().padStart(2, '0'); // Thêm 1 vì getMonth() bắt đầu từ 0
    const day = currentDateTime.getDate().toString().padStart(2, '0');
    const hours = currentDateTime.getHours().toString().padStart(2, '0');
    const minutes = currentDateTime.getMinutes().toString().padStart(2, '0');
    const seconds = currentDateTime.getSeconds().toString().padStart(2, '0');

    const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}:${seconds}`;

    document.getElementById('date-time').setAttribute('max', formattedDateTime);
</script>


<script>
    function handleIncomeExpenseChange() {
        var selectedValue = document.getElementById("income-expense-type").value;
        var categorySelect = document.getElementById("category_select");
        categorySelect.innerHTML = "";


        if (selectedValue === "income") {
            document.getElementById("payment_method").innerHTML = "Source";
            document.getElementById("select-category-label").innerHTML = "Select Source";
            document.getElementById("write-category-label").innerHTML = "Create New source";
            document.getElementById("source-note").style.display = "flex";
            document.getElementById("payment-method-container").style.display = "none";
            document.getElementById("category_write").setAttribute("placeholder", "Nhập nguồn thu nhập mới nếu chưa có trước đó");

            sources.forEach(function (source) {
                var option = document.createElement("option");
                option.value = source['name'];
                option.textContent = source['name'];
                categorySelect.appendChild(option);
            });
        }
        else {
            document.getElementById("payment_method").innerHTML = "Payment method";
            document.getElementById("select-category-label").innerHTML = "Select Category";
            document.getElementById("write-category-label").innerHTML = "Create New Category";
            document.getElementById("source-note").style.display = "none";
            document.getElementById("payment-method-container").style.display = "flex";
            document.getElementById("category_write").setAttribute("placeholder", "Nhập loại chi tiêu mới nếu chưa có");

            categories.forEach(function (category) {
                var option = document.createElement("option");
                option.value = category['name'];
                option.textContent = category['name'];
                categorySelect.appendChild(option);
            });
        }
    }
</script>


<script type="text/javascript">
    $(document).ready(function () {

        var expensePercent = <?php echo $expense_percent; ?>;
        var incomePercent = <?php echo $income_percent; ?>;
        var expenseSum = <?php echo $expense_sum; ?>;
        var incomeSum = <?php echo $income_sum; ?>;
        var total = <?php echo $total; ?>;

        if (expensePercent > 0 || incomePercent > 0) {
            var data = {
                labels: [],
                series: []
            };

            if (expensePercent > 0)
                data.series.push(expensePercent);
            if (incomePercent > 0)
                data.series.push(incomePercent);

            var options = {
                donut: false,
                showLabel: false,
                chartPadding: 30,
                labelOffset: 30
            };
            var chart = new Chartist.Pie('#chartPreferences', data, options);

            chart.on('draw', function (data) {
                if (data.type === 'slice') {
                    if (expensePercent > 0 || expensePercent >0 && incomePercent >0) {
                        if (data.index === 0) {
                            data.element.attr({
                                style: 'stroke: #FF5733; fill: #FF5733'
                            });
                        } else if (data.index === 1) {
                            data.element.attr({
                                style: 'stroke: #33AFFF; fill: #33AFFF'
                            });
                        }
                    }
                    else if (incomePercent > 0) {
                        if (data.index === 0) {
                            data.element.attr({
                                style: 'stroke: #33AFFF; fill: #33AFFF'
                            });
                        } else if (data.index === 1) {
                            
                            data.element.attr({
                                style: 'stroke: #FF5733; fill: #FF5733'
                            });
                        }
                    }

                }
            });
        }
    });
</script>

</html>
<?php
session_start();

if(!$_SESSION['login_email'])
{
header("location:../login");
exit();
}

require '../../includes/calculate.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>gPortal - All time Contributions</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.php">gPortal</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger">0</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Group notices</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">My tasks</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-envelope fa-fw"></i>
          <span class="badge badge-danger">0</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
          <a class="dropdown-item" href="#">Read</a>
          <a class="dropdown-item" href="#">Clear all</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Send notice</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="#">Activity Log</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Menu</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Contributions</h6>
	  <a class="dropdown-item" href="contribute.php">Contribute</a>
          <a class="dropdown-item" href="last5conts.php">Last 5</a>
          <a class="dropdown-item" href="alltimeconts.php">All time</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Loans</h6>
          <a class="dropdown-item" href="borrow.php">Borrow</a>
          <a class="dropdown-item" href="last5loans.php">Last 5</a>
	  <a class="dropdown-item" href="alltimeloans.php">All time</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Other:</h6>
          <a class="dropdown-item" href="setlements.php">Settlements</a>
	  <a class="dropdown-item" href="misc.php">Misc Expenses</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="charts.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tables.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Data</span></a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>

        <!-- Page Content -->
        <h1>All Time Contributions</h1>
        <hr>
        <p>Check out your last five contribution records to the group.</p>

      </div>
<!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Your Contribution Data</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Week</th>
                  </tr>
                </thead>
<?php
$login_email = $_SESSION['login_email'];
$sql = "SELECT * FROM members WHERE email='".$login_email."'";
$result = mysqli_query($link,$sql);
while ($row = mysqli_fetch_array($result)){ 
    $my_number=$row['number'];
    $my_contribution_weeks=$row['weeks_to_contribute'];
}

$sql = "SELECT SUM(amount),($my_contribution_weeks*150)-SUM(amount) FROM contributions WHERE number=$my_number;"; 
$result = mysqli_query($link,$sql);
while ($row = mysqli_fetch_array($result)){ 
    $my_contribution=$row['SUM(amount)'];
    $my_contribution_balance=$my_contribution_weeks*150-$my_contribution;
    $my_percentage_contribution=$my_contribution/($my_contribution_weeks*150)*100;
}
echo "<p> <font color=green font face='impact' size='5pt'>Your contribution balance is </font> <font color=red font face='impact' size='5pt'>kes $my_contribution_balance</font> </p>";

$sql = "SELECT amount,date,week,remarks FROM contributions WHERE number=$my_number ORDER BY date DESC";
$result = mysqli_query($link,$sql);


echo "<tbody>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['amount'] . "</td>";
echo "<td>" . $row['date'] . "</td>";
echo "<td>" . $row['week'] . "</td>";
echo "</tr>";
}               
echo "</tbody>";
echo "</table>";

$sql2 = "SELECT UPDATE_TIME FROM   information_schema.tables WHERE  TABLE_SCHEMA = '$db'AND TABLE_NAME = 'contributions'";
$result2 = mysqli_query($link,$sql2);
$row = mysqli_fetch_array($result2);
$timestamp=$row['UPDATE_TIME'];
?>
            </div>
          </div>
          <div class="card-footer small text-muted">Updated <?php echo $timestamp ?> </div>
        </div>

      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Rawle Systems 2018 - 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

</body>

</html>

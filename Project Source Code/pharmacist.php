<?php
session_start();
include_once('connect_db.php');
if(isset($_SESSION['username'])){
$id=$_SESSION['pharmacist_id'];
$fname=$_SESSION['first_name'];
$lname=$_SESSION['last_name'];
$sid=$_SESSION['staff_id'];
$user=$_SESSION['username'];
}else{
header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/index.php");
exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $user;?> - Pharmacy Sys</title>
<link rel="stylesheet" type="text/css" href="style/ms.css">
<link rel="stylesheet" href="style/s.css" type="text/css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="style/ds.css"  media="screen" />
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

<script src="js/function.js" type="text/javascript"></script>
<style>
#left_column{
height: 470px;
}
</style>
</head>
<body>
<div id="content">
<div id="header">
<h1>Pharmacy Management System</h1></div>
<div id="left_column">
<div id="button">
<ul>
			<li><a href="pharmacist.php"><i class="fa fa-home"></i>&nbsp;Dashboard</a></li>
			<li><a href="prescription.php"><i class="fa fa-prescription-bottle-alt"></i>&nbsp; Prescription</a></li>
			<li><a href="stock_pharmacist.php"><i class="fa fa-pills"></i>&nbsp;Stock</a></li>
			<li><a href="logout.php"><i class="fa fa-power-off"></i>&nbsp;Logout</a></li>
		</ul>	
</div>
</div>
<div id="main">
<!-- Dashboard icons -->
            <div class="grid_7">
            	<a href="pharmacist.php" class="dashboard-module">
                	<img src="images/ph-ic.png" width="96" height="96" alt="edit" />
                	<span>Dashboard</span>
                </a>
                             
                <a href="prescription.php" class="dashboard-module">
                	<img src="images/pre.png"  width="96" height="96" alt="edit" />
                	<span>Prescription</span>
                </a>
	            <a href="stock_pharmacist.php" class="dashboard-module">
                	<img src="images/stock_icon.png" width="96" height="96" alt="edit" />
                	<span>Stock</span>
                </a>
              </div>
</div>
<div id="footer" align="Center"> </div>
</div>
</body>
</html>

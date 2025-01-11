<?php
session_start();
include_once('connect_db.php');
if(isset($_SESSION['username'])){
$id=$_SESSION['pharmacist_id'];
$user=$_SESSION['username'];
}else{
header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."index.php");
exit();
}
if(isset($_POST['submit'])){
$sname=$_POST['drug_name'];
$cat=$_POST['category'];
$des=$_POST['description'];
$com=$_POST['company'];
$sup=$_POST['supplier'];
$city=$POST['city'];
$qua=$_POST['quantity'];
$cost=$_POST['cost'];
$sta="Available";

$sql=mysql_query("INSERT INTO stock_np(drug_name,category,description,company,supplier,city,quantity,cost,status,date_supplied)
VALUES('$sname','$cat','$des','$com','$sup','$city','$qua','$cost','$sta',NOW())");

$sql=mysql_query("INSERT INTO stock_dr(drug_name,category,description,company,supplier,city,quantity,cost,status,date_supplied)
VALUES('$sname','$cat','$des','$com','$sup','$city','$qua','$cost','$sta',NOW())");

$sql=mysql_query("INSERT INTO stock_ca(drug_name,category,description,company,supplier,city,quantity,cost,status,date_supplied)
VALUES('$sname','$cat','$des','$com','$sup','$city','$qua','$cost','$sta',NOW())");

if($sql>0) {header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/stock_pharmacist.php");
}else{
$message1="<font color=red>Registration Failed, Try again</font>";
}
	}
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $user;?> - Pharmacy Sys</title>
<link rel="stylesheet" type="text/css" href="style/ms.css">
<link rel="stylesheet" href="style/s.css" type="text/css" media="screen" /> 
<link rel="stylesheet" href="style/ta.css" type="text/css" media="screen" /> 
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

<script src="js/function.js" type="text/javascript"></script>

<style>
#left-column {height: 477px;}
 #main {height: 477px;}
 .scroll
		{
			height:380px;
			/* width:630px; */
			
			overflow: scroll;
		}
 </style>
</head>
<body>
<div id="content">
<div id="header">
<h1> Pharmacy Management System</h1></div>
<div id="left_column">
<div id="button">
<ul>

			<li><a href="admin.php"><i class="fa fa-home"></i>&nbsp; Dashboard</a></li>
			<li><a href="admin_pharmacist.php"><i class="fa fa-prescription-bottle-alt"></i>&nbsp;&nbsp; Pharmacist</a></li>
			<li><a href="admin_manager.php"><i class="fa fa-user-cog"></i>&nbsp;Manager</a></li>
			<li><a href="admin_cashier.php"><i class="fa fa-cash-register"></i>&nbsp; Cashier</a></li>
			<li><a href="admin_localdata.php"><i class="fa fa-database"></i>&nbsp; Local Data</a></li>
			<li><a href="admin_globaldata.php"><i class="fa fa-server"></i>&nbsp; Global Data</a></li>
			<li><a href="logout.php"><i class="fa fa-power-off"></i>&nbsp; Logout</a></li>
		</ul>	
</div>
		</div>
<div id="main">
<div id="tabbed_box" class="tabbed_box">  
    <h4>To find minimum/maximum cost of medicine from different cities globally from global database</h4> 
<hr/>	
    <div class="tabbed_area">  
      
         
	<div class = "scroll"> 
        <div id="content_1" class="content">  
		 



<form action="#" method="post">
<select name="Find">
<option value="Select" selected="selected">----Select----</option>
<option value="All" >All</option>
<option value="Min" >Min</option>
<option value="Max">Max</option>

</select>
<input type="submit" name="findvalue" value="Go" />
</form>
<?php
if(isset($_POST['findvalue'])){
$selected_val = $_POST['Find'];  // Storing Selected Value In Variable
echo 'You have selected:'. $selected_val;
}
?>	 








		 
		 
<?php echo $message;
			  echo $message1;
			  ?>
      
		<?php
		/* 
		View
        Displays all data from 'Stock' tables
		*/

        // connect to the database
        include_once('connect_db.php');

		// get results from database
		
					
		$result = mysql_query("SELECT * FROM stock_np UNION ALL SELECT * FROM stock_ca UNION ALL SELECT * FROM stock_dr  order by stock_id")  or die(mysql_error());

					if($selected_val=="All")
				 	$result = mysql_query("SELECT * FROM stock_np UNION ALL SELECT * FROM stock_ca UNION ALL SELECT * FROM stock_dr  order by stock_id")  or die(mysql_error());
				
					 if($selected_val=="Min")
					 $result = mysql_query("SELECT * 
					 						FROM(
															/*Selecting all the values using Union*/
															SELECT * FROM stock_np 
												UNION ALL 	SELECT * FROM stock_ca 
												UNION ALL 	SELECT * FROM stock_dr
												) AS A
											
											
											WHERE stock_id in(

																/* Finding Minimum cost's of stock id */
																SELECT stock_id
					 											FROM (			
																	 			/* selecting id and cost from minimum value */
																				SELECT stock_id,cost from stock_np where cost = (SELECT MIN(cost) from stock_np) 
					 													UNION  	SELECT stock_id,cost from stock_ca where cost =(SELECT MIN(cost) from stock_ca)
																		UNION  	SELECT stock_id,cost from stock_dr where cost =(SELECT MIN(cost) from stock_dr)
												  					  ) AS M

																WHERE cost in
																(	SELECT MIN(cost)
																	FROM 	(			/* Condition for finding minimum cost from the individual table */
																						SELECT stock_id,cost from stock_np where cost = (SELECT MIN(cost) from stock_np) 
					 															UNION  	SELECT stock_id,cost from stock_ca where cost =(SELECT MIN(cost) from stock_ca)
																				UNION  	SELECT stock_id,cost from stock_dr where cost =(SELECT MIN(cost) from stock_dr)
												  							                                                                         )AS M2)
												
																 
																
																)")or die(mysql_error());
					
					if($selected_val=="Max")
					 $result = mysql_query("SELECT * 
					 						FROM(
															/*Selecting all the values using Union*/
															SELECT * FROM stock_np 
												UNION ALL 	SELECT * FROM stock_ca 
												UNION ALL 	SELECT * FROM stock_dr
												) AS A
											
											
											WHERE stock_id in(

																/* Finding Maximum cost's of stock id */
																SELECT stock_id
					 											FROM (			
																	 			/* selecting id and cost from maximum value */
																				SELECT stock_id,cost from stock_np where cost = (SELECT MAX(cost) from stock_np) 
					 													UNION  	SELECT stock_id,cost from stock_ca where cost =(SELECT MAX(cost) from stock_ca)
																		UNION  	SELECT stock_id,cost from stock_dr where cost =(SELECT MAX(cost) from stock_dr)
												  					  ) AS M

																WHERE cost in
																(	SELECT MAX(cost)
																	FROM 	(			/* Condition for finding maximum cost from the individual table */
																						SELECT stock_id,cost from stock_np where cost = (SELECT MAX(cost) from stock_np) 
					 															UNION  	SELECT stock_id,cost from stock_ca where cost =(SELECT MAX(cost) from stock_ca)
																				UNION  	SELECT stock_id,cost from stock_dr where cost =(SELECT MAX(cost) from stock_dr)
												  				)AS M2)
												
																 
																
																)")or die(mysql_error());

		
		// display data in table
        echo "<table border='1' cellpadding='3'>";
         echo "<tr><th>ID</th><th>Name</th><th>Category</th><th>Description</th><th>Company</th><th>Supplier</th><th>City</th><th>Quantity </th><th>Cost </th><th>Status </th><th>Date </th></tr>";

        // loop through results of database query, displaying them in the table
        while($row = mysql_fetch_array( $result )) {
                
                // echo out the contents of each row into a table
                echo "<tr>";
                echo '<td>' . $row['stock_id'] . '</td>';               
                echo '<td>' . $row['drug_name'] . '</td>';
				echo '<td>' . $row['category'] . '</td>';
				echo '<td>' . $row['description'] . '</td>';
				echo '<td>' . $row['company'] . '</td>';
				echo '<td>' . $row['supplier'] . '</td>';
				echo '<td>' . $row['city'] . '</td>';
				echo '<td>' . $row['quantity'] . '</td>';
				echo '<td>' . $row['cost'] . '</td>';
				echo '<td>' . $row['status'] . '</td>';
				echo '<td>' . $row['date_supplied'] . '</td>';?>


				



				<?php
		 } 
        // close table>
        echo "</table>";
?> 
        </div>  
        
         </div>     
    </div>  
  
</div>
 
</div>
<div id="footer" align="Center"> </div>
</div>
</body>
</html>

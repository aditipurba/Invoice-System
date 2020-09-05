<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testing4";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
session_start();
error_reporting(0);
if(strlen($_SESSION['login'])==0)
{ 
    header('location:index_real.php');
}
else
	    {

  

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Reject</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />


</head>
<body>
  <!------MENU SECTION START-->
      <?php include('includes/header.php');?>
      <br>
      <?php
     		$id = $_GET['id'];
     		//echo $id;
     		$res = true;
     		$sql = "UPDATE tbl_order SET rejected='$res' WHERE order_id='$id'";
			if ($conn->query($sql) === TRUE) {
			    echo "<h4><center><b>Record was rejected!!</b></center></h4>";
			} else {
			    echo "Error updating record: " . $conn->error;
			}

     		/*
     		$res = 'true';
	    	$sql="UPDATE tbl_order set rejected=:res where order_id=:id";
	        $query = $dbh->prepare($sql);
	        $query->bindParam(':rejected',$res);
	        $query->bindParam(':order_id',$id);
	        $updat = $query->execute();
	        if($updat){
	            echo "<h3><center><b>Order has been rejected.</b></center></h3>";
	        }else{
	            echo "<h3><center><b>Unknown error occured. Please try again!!</b></center></h3>";
	        }
	        */
	    }
	    ?>
	    <br>
	    <?php 
  			include('includes/footer.php');
      ?>

  </body>
  </html>



  <?php
	


  ?>
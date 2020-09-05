<?php
session_start();
error_reporting(0);
include('includes/connect.php');
if(strlen($_SESSION['alogin'])==0)
  { 
header('location:index.php');
}
else{?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Billing and Approval System | Admin Dash Board</title>
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
<!-- MENU SECTION END-->
  <div class="container">

    <div class="row pad-botm">
      <div class="col-md-12">
        <br>
        <h4 class="header-line">ADMIN DASHBOARD</h4>
        
      </div>

    </div>
    

    <!-- FIRST ROW-->
    <div class="row">

      <div class="col-md-3 col-sm-3 col-xs-6">
        <div class="alert alert-success back-widget-set text-center">
         <i class="fa fa-book fa-5x"></i>
         <?php 
         $sql ="SELECT order_id from tbl_order ";
         $query = $dbh -> prepare($sql);
         $query->execute();
         $results=$query->fetchAll(PDO::FETCH_OBJ);
         $listdbooks=$query->rowCount();
         ?>


         <h3><?php echo htmlentities($listdbooks);?></h3>
         Bills Created
       </div>
     </div>

     
     <div class="col-md-3 col-sm-3 col-xs-6">
       <div class="alert alert-info back-widget-set text-center">
        <i class="fa fa-bars fa-5x"></i>
        <?php 
        $sql1 ="SELECT order_id from tbl_order ";
        $query1 = $dbh -> prepare($sql1);
        $query1->execute();
        $results1=$query1->fetchAll(PDO::FETCH_OBJ);
        $issuedbooks=$query1->rowCount();
        ?>

        <h3><?php echo htmlentities($issuedbooks);?> </h3>
        Times Bill Issued
      </div>
    </div>
    
    <div class="col-md-3 col-sm-3 col-xs-6">
     <div class="alert alert-warning back-widget-set text-center">
      <i class="fa fa-recycle fa-5x"></i>
      <?php 
      $status=1;
      $sql2 ="SELECT order_id from tbl_order where rejected=true";
      $query2 = $dbh -> prepare($sql2);
      $query2->execute();
      $results2=$query2->fetchAll(PDO::FETCH_OBJ);
      $returnedbooks=$query2->rowCount();
      ?>

      <h3><?php echo htmlentities($returnedbooks);?></h3>
       Bills Returned
    </div>
  </div>


  <div class="col-md-3 col-sm-3 col-xs-6">
    <div class="alert alert-danger back-widget-set text-center">
      <i class="fa fa-users fa-5x"></i>
      <?php 
      $sql3 ="SELECT id from user ";
      $query3 = $dbh -> prepare($sql3);
      $query3->execute();
      $results3=$query3->fetchAll(PDO::FETCH_OBJ);
      $regstds=$query3->rowCount();
      ?>
      <h3><?php echo htmlentities($regstds);?></h3>
      Registered Users
    </div>
  </div>

</div>
</div>
<br>
<br>

<!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php');?>
<!-- FOOTER SECTION END-->
<!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
<!-- CORE JQUERY  -->
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS  -->
<script src="assets/js/bootstrap.js"></script>
<!-- CUSTOM SCRIPTS  -->
<script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>

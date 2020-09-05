<?php

// when send button is pressed
session_start();
error_reporting(0);
include('includes/connect.php');
if(strlen($_SESSION['login'])==0)
{ 
    header('location:index_real.php');
}
  else
    {

      // Steps
      // Fetch level from user table
      // Assign it to variable $l
      // Fetch level[$l] from order table
      // check

      
      // Steps 1,2 and 3
      $email=$_SESSION['login'];
      //echo $_SESSION['login'];
      $sql="SELECT id,FullName,Email,UserName,level from user where Email=:email";
      $query = $dbh -> prepare($sql);
      $query-> bindParam(':email', $email, PDO::PARAM_STR);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);
      $cnt=1;
      foreach($results as $result)
       {
         $l = $result->level;
         //echo $l;
      }

      // Steps 4 and 5
      $statement = $dbh->prepare("
      SELECT * FROM tbl_order 
      WHERE level$l = 1
      ORDER BY order_id DESC
    ");
      $statement->execute();
      $all_result = $statement->fetchAll();
      $total_rows = $statement->rowCount();

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Received Bills</title>
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
      }
      ?>
    </div>
    
  </body>
  
















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


<?php

/* comment hai yahan pr




      $sql = $dbh->prepare("
      SELECT * FROM tbl_order
      ORDER BY order_id DESC
    ");
      $sql->execute();
      $res = $sql->fetchAll();
      $totalrows = $sql->rowCount();


      if($totalrows > 0)
        {
          foreach($all_result as $rows)
          {
          }
        }





  $statement = $dbh->prepare("
    SELECT * FROM tbl_order 
    WHERE level1 = 1
    ORDER BY order_id DESC
  ");

  $statement->execute();

  $all_result = $statement->fetchAll();

  $total_rows = $statement->rowCount();
  ?>






                 <?php 
                    $email=$_SESSION['login'];
                    $sql="SELECT id,FullName,Email,UserName,level from user where Email=:email";
                    $query = $dbh -> prepare($sql);
                    $query-> bindParam(':email', $email, PDO::PARAM_STR);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    $cnt=1;
                    //echo $query->rowCount();
                    // FIRST WE SELECT THE LEVEL AND DISPLAY THE DETAILS ACCORDING TO THE LEVEL OF USER
                    foreach($results as $result)
                    {
                        $l = $result->level;
                        // show data of level l

                    }
                

                    ?>








*/
?>
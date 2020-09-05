<?php
    session_start();
    error_reporting(0);
    include('includes/connect.php');
    if(strlen($_SESSION['alogin'])==0)
    {   
        header('location:index.php');
    }
    else
    {  
	  $statement = $dbh->prepare("
	    SELECT * FROM tbl_order 
	    ORDER BY order_id DESC
	  ");

	  $statement->execute();
      $all_result = $statement->fetchAll();
      $total_rows = $statement->rowCount();

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
         echo $l;
      }

?>


   <!DOCTYPE html>
   
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>View Previous</title>
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
<body>
    <h3><center><b>All Bills</b></center> </h3>
	<table id="data-table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Invoice No.</th>
            <th>Invoice Date</th>
            <th>Receiver Name</th>
            <th>Invoice Total</th>
            <!--<th>PDF</th>-->
            <th>View</th>
            <th>Edit</th>
            <th>Status</th>
            
          </tr>
        </thead>
        <?php
        if($total_rows > 0)
        {
          foreach($all_result as $row)
          {
            echo '
              <tr>
                <td>'.$row["order_no"].'</td>
                <td>'.$row["order_date"].'</td>
                <td>'.$row["order_receiver_name"].'</td>
                <td>'.$row["order_total_after_tax"].'</td>
                
                <td><a href="view.php?csv=1&id='.$row["order_id"].'"><button type="button" class="btn btn-success btn-sm">View</button></a></td>
                <td><a href="create_bill.php?update=1&id='.$row["order_id"].'"><button type="button" class="btn btn-primary btn-sm">Edit</button></a></td>
                <td>Level '.$row["level"].'</td>
                
              </tr>
            ';
          }
        }
    }
        ?>
      </table>
      <?php include("includes/footer.php");  ?>
</body>



<?php //<td><a href="print_invoice.php?pdf=1&id='.$row["order_id"].'">PDF</a></td>?>
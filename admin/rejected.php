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
        WHERE rejected = true
        ORDER BY order_id DESC
	  ");

	  $statement->execute();
      $all_result = $statement->fetchAll();
      $total_rows = $statement->rowCount();
      //echo $total_rows;
?>


   <!DOCTYPE html>
   
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Rejected</title>
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
	<table id="data-table" class="table table-bordered table-striped">
         <?php
        if($total_rows > 0)
        {
            echo '<br><h4><b><center>Please prepare the bill for these again. These bills were rejected.</center></b></h4><br>';
            echo '
            <thead>
              <tr>
                <th>Invoice No.</th>
                <th>Invoice Date</th>
                <th>Receiver Name</th>
                <th>Invoice Total</th>
                <!--<th>PDF</th>-->
                <th>View</th>
              </tr>
            </thead>
            ';
          foreach($all_result as $row)
          {
            echo '
              <tr>
                <td>'.$row["order_no"].'</td>
                <td>'.$row["order_date"].'</td>
                <td>'.$row["order_receiver_name"].'</td>
                <td>'.$row["order_total_after_tax"].'</td>
                
                <td><a href="view.php?csv=1&id='.$row["order_id"].'"><button type="button" class="btn btn-success btn-sm">View</button></a></td>
              </tr>
            ';
          }
        }
        else
        {
            echo'<h3><center><b>No Rejected Bills</b> </center></h3>';
        }
    }
        ?>
      </table>
      <?php include("includes/footer.php");  ?>
</body>



<?php //<td><a href="print_invoice.php?pdf=1&id='.$row["order_id"].'">PDF</a></td>?>
<?php
session_start();
error_reporting(0);
include('includes/connect.php');
if(strlen($_SESSION['login'])==0)
{ 
    header('location:index_real.php');
}

else
{
      $order_id = $_GET['id'];
    // Get level
    // Set value of level+1 = 1
    // show the values in this page of that entry
      $email=$_SESSION['login'];
      $sql="SELECT id,FullName,Email,UserName,level from user where Email=:email";
      $query = $dbh -> prepare($sql);
      $query-> bindParam(':email', $email, PDO::PARAM_STR);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);
      $cnt=1;
      foreach($results as $result)
       {
         $l = $result->level;
        
      }

      // incrementing its value
      $l++;
      $p = $l;
  

      //updating
      $statement = $dbh->prepare("
              UPDATE tbl_order 
              SET level$p = 1
              WHERE order_id = :order_id 
              ");
      $statement -> bindParam(':order_id',$order_id, PDO::PARAM_STR);
      $statement -> execute();
      ?>
      <script type="text/javascript">
        $("#send").attr("disabled", true);
      </script>
      <?php


      // displaying the values in a table
      $stmt = $dbh->prepare("
      SELECT * FROM tbl_order 
      WHERE level$p = 1
      ORDER BY order_id DESC
    ");
      $stmt->execute();
      $all_result = $stmt->fetchAll();
      $total_rows = $stmt->rowCount();

?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sent Bills</title>
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
      <h3 align="center">Billing and Approval System</h3>


    <h3><center><b>Bills Sent</b></center></h3>
     <br>
      <table id="data-table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Invoice No.</th>
            <th>Invoice Date</th>
            <th>Receiver Name</th>
            <th>Invoice Total</th>
            <th>View</th>
            
            <th>Delete</th>
          </tr>
        </thead>
        <?php
        if($total_rows > 0)
        {
          foreach($all_result as $row)
          {
            //echo $row["level$l"];
            // We display only those results where level_of_user==1 && level[i]==1
            if($row["level$p"]==1) {
            echo '
              <tr>
                <td>'.$row["order_no"].'</td>
                <td>'.$row["order_date"].'</td>
                <td>'.$row["order_receiver_name"].'</td>
                <td>'.$row["order_total_after_tax"].'</td>
                <td><a href="view.php?csv=1&id='.$row["order_id"].'"><button type="button" class="btn btn-primary btn-sm">View</button></a></td>
                
                <td><a href="#" id="'.$row["order_id"].'" class="delete"><button type="button" class="btn btn-danger btn-sm">Delete</button></a></td>
              </tr>
            ';
          }  
          }
        }
        ?>
      </table>
      <?php
  }
  
      ?>
    </div>
     <?php include('includes/footer.php');?>
    
  </body>

</html>

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
      // this is user id
      $id = $_SESSION['alogin'];
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
      $x = $l + 1;





// Approve ho chuka hai to
    if($l==4){
    $statement4 = $dbh->prepare("
      SELECT * FROM tbl_order 
      WHERE level4 = 1  and approved = true
      ORDER BY order_id DESC
    ");
      $statement4->execute();
      $all_result4= $statement4->fetchAll();
      $total_rows4 = $statement4->rowCount();

}






// Approve krna hai to
      if($l==4){
      $statement2 = $dbh->prepare("
      SELECT * FROM tbl_order 
      WHERE level4 = 1 and approved = false and rejected = false
      ORDER BY order_id DESC
    ");
      $statement2->execute();
      $all_result2= $statement2->fetchAll();
      $total_rows2 = $statement2->rowCount();

    }





 // Bills jinpar action le liya gaya hai
      $statement = $dbh->prepare("
      SELECT * FROM tbl_order 
      WHERE (level$l = 1 and level$x = 1) OR rejected = true
      ORDER BY order_id DESC
    ");
      $statement->execute();
      $all_result = $statement->fetchAll();
      $total_rows = $statement->rowCount();





    
      // Steps 4 and 5 and reject=0
//Bills jinpar action lena hai
      $statement1 = $dbh->prepare("
      SELECT * FROM tbl_order 
      WHERE level$l = 1 and level$x = 0 and rejected = false
      ORDER BY order_id DESC
    ");
      $statement1->execute();
      $all_result1 = $statement1->fetchAll();
      $total_rows1 = $statement1->rowCount();

      



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
    <script src="assets/js/jquery.min.js"></script>

    

    <style> 
      input[type=submit]{
      background-color: #ce760a;
      border: none;
      color: white;
      padding: auto;
      text-decoration: none;
      margin: auto;
      cursor: pointer;
      border-radius: 5px;
      width: 60px;
      height: 30px;
      font-size: 13px;
    }
    </style>

</head>
<body>
  <!------MENU SECTION START-->
      <?php include('includes/header.php');?>
      <h3 align="center">Billing and Approval System</h3>
    





      <table id="data-table" class="table table-bordered table-striped">
        
        <?php
        if($total_rows > 0)
        {
          echo '<h4><b><center><u>Bills Dealt.</u></center></b></h3>';
          echo '
          <thead>
          <tr>
            <th>Invoice No.</th>
            <th>Invoice Date</th>
            <th>Receiver Name</th>
            <th>Invoice Total</th>
            <th>View</th>
            <th>Send</th>
            <th>Edit</th>
            <th>Reject</th>
          </tr>
        </thead>';
          foreach($all_result as $row)
          {
            //echo $row["level$l"];
            // We display only those results where level_of_user==1 && level[i]==1
            if($row["level$l"]==1) {
            echo '
              <tr>
                <td>'.$row["order_no"].'</td>
                <td>'.$row["order_date"].'</td>
                <td>'.$row["order_receiver_name"].'</td>
                <td>'.$row["order_total_after_tax"].'</td>
                <td><a href="view.php?csv=1&id='.$row["order_id"].'"><button type="button" class="btn btn-success btn-sm">View</button></a></td>
                <td><button type="button" class="btn btn-warning btn-sm" disabled>Send</button></td>
                <td><button type="button" class="btn btn-primary btn-sm " disabled>Edit</button></td>
                <td><button type="button" class="btn btn-danger btn-sm " disabled>Reject</button></td>
              </tr>
            ';
          }  
          }
        }
        ?>
      </table>









      <table id="data-table" class="table table-bordered table-striped">
        <?php
        if($total_rows1 > 0)
        {
          echo '<h4><b><center><u>Bills to be dealt with.</u></center></b></h4>';
          echo '<thead>
          <tr>
            <th>Invoice No.</th>
            <th>Invoice Date</th>
            <th>Receiver Name</th>
            <th>Invoice Total</th>
            <th>View</th>
            <th>Send</th>
            <th>Edit</th>
            <th>Reject</th>
          </tr>
        </thead>
        ';
          foreach($all_result1 as $row1)
          {
            //echo $row["level$l"];
            // We display only those results where level_of_user==1 && level[i]==1
            if($row1["level$l"]==1) {
            echo '
              <tr>
                <td>'.$row1["order_no"].'</td>
                <td>'.$row1["order_date"].'</td>
                <td>'.$row1["order_receiver_name"].'</td>
                <td>'.$row1["order_total_after_tax"].'</td>
                <td><a href="view.php?csv=1&id='.$row1["order_id"].'"><button type="button" class="btn btn-success btn-sm">View</button></a></td>
                <td><form id="formABC" action="sent.php?id='.$row1["order_id"].'" method="POST">
                <input type="submit" id="btnSubmit" value="Send"></input></form></td>
                <td><a href="edit_bill.php?update=1&id='.$row1["order_id"].'"><button type="button" class="btn btn-primary btn-sm" disabled>Edit</button></a></td>
                <td><a href="reject.php?id='.$row1['order_id'].'"><button type="button" id="edit" class="btn btn-sm btn-danger">Reject</button></a></td>
              </tr>
            ';
          }  
          }
        }
        ?>
      </table>










      <table id="data-table" class="table table-bordered table-striped">
        <?php
        if($total_rows2 > 0)
        {
          echo '<h4><b><center><u>Approve these Bills.</u></center></b></h4>';
          echo '<thead>
          <tr>
            <th>Invoice No.</th>
            <th>Invoice Date</th>
            <th>Receiver Name</th>
            <th>Invoice Total</th>
            <th>View</th>
            <th>Approve</th>
            <th>Edit</th>
            <th>Reject</th>
          </tr>
        </thead>
        ';
          foreach($all_result2 as $row2)
          {
            //echo $row["level$l"];
            // We display only those results where level_of_user==1 && level[i]==1
            if($row2["level4"]==1) {
            echo '
              <tr>
                <td>'.$row2["order_no"].'</td>
                <td>'.$row2["order_date"].'</td>
                <td>'.$row2["order_receiver_name"].'</td>
                <td>'.$row2["order_total_after_tax"].'</td>
                <td><a href="view.php?csv=1&id='.$row2["order_id"].'"><button type="button" class="btn btn-success btn-sm">View</button></a></td>
                <td><form id="formABC" action="approve.php?id='.$row2["order_id"].'" method="POST">
                <input type="submit" id="btnSubmit" value="Approve"></input></form></td>
                <td><a href="edit_bill.php?update=1&id='.$row2["order_id"].'"><button type="button" class="btn btn-primary btn-sm" disabled>Edit</button></a></td>
                <td><a href="reject.php?id='.$row2['order_id'].'"><button type="button" id="edit" class="btn btn-sm btn-danger">Reject</button></a></td>
              </tr>
            ';
          }  
          }
        }
        ?>
      </table>







      <table id="data-table" class="table table-bordered table-striped">
        <?php
        if($total_rows4 > 0)
        {
          echo '<h4><b><center><u>Approved Bills.</u></center></b></h4>';
          echo '<thead>
          <tr>
            <th>Invoice No.</th>
            <th>Invoice Date</th>
            <th>Receiver Name</th>
            <th>Invoice Total</th>
            <th>View</th>
            <th>Approve</th>
            <th>Edit</th>
            <th>Reject</th>
          </tr>
        </thead>
        ';
          foreach($all_result4 as $row4)
          {
            //echo $row["level$l"];
            // We display only those results where level_of_user==1 && level[i]==1
            if($row4["level4"]==1) {
            echo '
              <tr>
                <td>'.$row4["order_no"].'</td>
                <td>'.$row4["order_date"].'</td>
                <td>'.$row4["order_receiver_name"].'</td>
                <td>'.$row4["order_total_after_tax"].'</td>
                <td><a href="view.php?csv=1&id='.$row4["order_id"].'"><button type="button" class="btn btn-success btn-sm">View</button></a></td>
                <td><button type="button" class="btn btn-warning btn-sm" disabled>Approve</button></td>
                <td><button type="button" class="btn btn-primary btn-sm " disabled>Edit</button></td>
                <td><button type="button" class="btn btn-danger btn-sm " disabled>Reject</button></td>
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

/*
<script type="text/javascript">
      $(document).ready(function(){
        $("#btnSubmit").click(function(){
          var agree = confirm("Are you sure you want to send this file?");
            if(agree)
            {
            $("#btnSubmit").prop('disabled',true);
            //$("#btnSubmit").prop('value', 'Sent');
            //alert("Button disabled.");
            }
            else
            {
              window.location.reload();
            }
          });
      });
    </script>

*/

?>
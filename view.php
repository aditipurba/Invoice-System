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

     $statement = $dbh->prepare("
     SELECT * FROM tbl_order 
      WHERE order_id = :order_id
    ");

    $statement->execute(
    array(
       ':order_id'       =>  $_GET["id"]
     ));

    $all_result = $statement->fetchAll();

    $total_rows = $statement->rowCount();
?>

<!DOCTYPE html>  
<html>  
<head>  
 <title>View Bill </title>  
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
 <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONT AWESOME STYLE  -->
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLE  -->
        <link href="assets/css/style.css" rel="stylesheet" />
        <!-- GOOGLE FONT -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<body>  
	<?php include('includes/header.php');?>
 <br /><br />  
 <div class="container">  
  <h2 align="center">Your Bill </h2>                
<br/>
  <?php
  // here we have to update the level on order table
  if(isset($_POST["submit"])){
      if($total_rows > 0)
        {
          foreach($all_result as $row)
          {
            //echo $row["order_id"];
            $order_id = $_GET["id"];
            $level1 = $row["level1"];
            $level1 = 1;

            $statement = $dbh->prepare("
              UPDATE tbl_order 
              SET level1 = :level1
              WHERE order_id = :order_id 
              ");
            $statement -> bindParam(':order_id',$order_id, PDO::PARAM_STR);
            $statement -> bindParam(':level1',$level1, PDO::PARAM_STR);
            $statement -> execute();
          }
        }
      }






  if(isset($_GET["csv"]) && isset($_GET["id"]))
  {
    $output = '';
    $statement = $dbh->prepare("
      SELECT * FROM tbl_order 
      WHERE order_id = :order_id
      LIMIT 1
      ");
    $statement->execute(
      array(
       ':order_id'       =>  $_GET["id"]
     )
    );
    $result = $statement->fetchAll();
    foreach($result as $row)
     { ?> 

       <table width="100%" border="1" cellpadding="5" cellspacing="0">
        <tr>
         <td colspan="2" align="center" style="font-size:18px"><b>Invoice</b></td>
       </tr>
       <tr>
         <td colspan="2">
          <table width="100%" cellpadding="5">
           <tr>
            <td width="65%">
             To,<br />
             <b>RECEIVER (BILL TO)</b><br />
             Name : <?php echo $row["order_receiver_name"] ?><br /> 
             Billing Address : <?php echo $row["order_receiver_address"] ?><br />
           </td>
           <td width="35%">
             Reverse Charge<br />
             Invoice No. : <?php echo $row["order_no"]?><br />
             Invoice Date : <?php echo $row["order_date"]?><br />
           </td>
         </tr>
       </table>
       <br />
       <table width="100%" border="1" cellpadding="5" cellspacing="0">
         <tr>
          <th>Sr No.</th>
          <th>Item Name</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Actual Amt.</th>
          <th colspan="2">Tax1 (%)</th>
          <th colspan="2">Tax2 (%)</th>
          <th colspan="2">Tax3 (%)</th>
          <th rowspan="2">Total</th>
        </tr>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th>Rate</th>
          <th>Amt.</th>
          <th>Rate</th>
          <th>Amt.</th>
          <th>Rate</th>
          <th>Amt.</th>
        </tr>
        <?php
        $statement = $dbh->prepare(
         "SELECT * FROM tbl_order_item 
         WHERE order_id = :order_id"
       );
        $statement->execute(
         array(
          ':order_id'       =>  $_GET["id"]
        )
       );
        $item_result = $statement->fetchAll();
        $count = 0;
        foreach($item_result as $sub_row)
        {
         $count++;
         ?>
         <tr>
          <td><?php echo $count ?></td>
          <td><?php echo $sub_row["item_name"] ?></td>
          <td><?php echo $sub_row["order_item_quantity"] ?></td>
          <td><?php echo $sub_row["order_item_price"]?></td>
          <td><?php echo $sub_row["order_item_actual_amount"]?></td>
          <td><?php echo $sub_row["order_item_tax1_rate"]?></td>
          <td><?php echo $sub_row["order_item_tax1_amount"]?></td>
          <td><?php echo $sub_row["order_item_tax2_rate"]?></td>
          <td><?php echo $sub_row["order_item_tax2_amount"]?></td>
          <td><?php echo $sub_row["order_item_tax3_rate"]?></td>
          <td><?php echo $sub_row["order_item_tax3_amount"]?></td>
          <td><?php echo $sub_row["order_item_final_amount"]?></td>
        </tr>
        <?php   
      }
      ?>
      <tr>
       <td align="right" colspan="11"><b>Total</b></td>
       <td align="right"><b><?php echo $row["order_total_after_tax"]?></b></td>
     </tr>
     <tr>
       <td colspan="11"><b>Total Amt. Before Tax :</b></td>
       <td align="right"><?php echo $row["order_total_before_tax"] ?></td>
     </tr>
     <tr>
       <td colspan="11">Add : Tax1 :</td>
       <td align="right"><?php echo $row["order_total_tax1"] ?></td>
     </tr>
     <tr>
       <td colspan="11">Add : Tax2 :</td>
       <td align="right"><?php echo $row["order_total_tax2"] ?></td>
     </tr>
     <tr>
       <td colspan="11">Add : Tax3 :</td>
       <td align="right"><?php echo $row["order_total_tax3"] ?></td>
     </tr>
     <tr>
       <td colspan="11"><b>Total Tax Amt.  :</b></td>
       <td align="right"><?php echo $row["order_total_tax"] ?></td>
     </tr>
     <tr>
       <td colspan="11"><b>Total Amt. After Tax :</b></td>
       <td align="right"><?php echo $row["order_total_after_tax"] ?></td>
     </tr>


   </table>
 </td>
</tr>
</table>
<?php 
}
}
}


?>
<br> 
</div>
 <?php include('includes/footer.php');?>
</body>  
</html>



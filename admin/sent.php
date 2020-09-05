<?php
session_start();
include('includes/connect.php');
include('includes/header.php');
$email=$_SESSION['login']; 

  $statement = $dbh->prepare("
    SELECT * FROM tbl_order 
    ORDER BY order_id DESC
    ");
  $statement->execute();

  $all_result = $statement->fetchAll();

  $total_rows = $statement->rowCount();
  if(isset($_POST["send"]))
  { 
        
        $level=$_POST['level'];
        $level = $level + 1;
        $sql="UPDATE tbl_order set level=:level where Email=:email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':level',$fullname,PDO::PARAM_STR);
        $query->bindParam(':username',$username,PDO::PARAM_STR);
        $query->execute();

        echo '<script>alert("Your profile has been updated")</script>';
  }

    ?>


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


    <?php
    session_start();
    error_reporting(0);
    include('includes/connect.php');
    if(strlen($_SESSION['alogin'])==0)
    {   
        header('location:index.php');
    }
    else{ 

        if(isset($_POST['add']))
        {
            $fullname=$_POST['fullname'];
            $email=$_POST['email'];
            $username=$_POST['username'];
            $password=$_POST['password'];
            $level = $_POST['level'];

            $sql="INSERT INTO  user(FullName,Email,UserName,Password,level) VALUES(:fullname,:email,:username,:password,:level)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':fullname',$fullname,PDO::PARAM_STR);
            $query->bindParam(':email',$email,PDO::PARAM_STR);
            $query->bindParam(':username',$username,PDO::PARAM_STR);
            $query->bindParam(':password',$password,PDO::PARAM_STR);
            $query->bindParam(':level',$level,PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if($lastInsertId)
            {
                $_SESSION['msg']="User Added Successfully";
                header('location:manage-books.php');
            }
            else 
            {
                $_SESSION['error']="Something went wrong. Please try again";
                header('location:manage-books.php');
            }

        }
        ?>
        <!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
            <meta name="description" content="" />
            <meta name="author" content="" />
            <title>Add User</title>
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
          <div class="content-wrapper">
           <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Add User</h4>
                    
                </div>

            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            User Info
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>Full Name<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="fullname" autocomplete="off"  required />
                                </div>

                                <div class="form-group">
                                    <label>Email<span style="color:red;">*</span></label>
                                    <input class="form-control" type="email" name="email"  required="required" autocomplete="off"  />
                                    <!--
                                    <select class="form-control" name="category" required="required">
                                        <option value=""> Select Category</option>
                                        <?php /*
                                        $status=1;
                                        $sql = "SELECT * from  tblcategory where Status=:status";
                                        $query = $dbh -> prepare($sql);
                                        $query -> bindParam(':status',$status, PDO::PARAM_STR);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt=1;
                                        if($query->rowCount() > 0)
                                        {
                                            foreach($results as $result)
                                                {               */?>  
                                                    <option value="<?php //echo htmlentities($result->id);?>"><?php //echo htmlentities($result->CategoryName);?></option>
                                                <?php //}} ?> 
                                            </select>
                                        </div>
                                    -->


                                        
                                        <div class="form-group">
                                            <label>Username<span style="color:red;">*</span></label>
                                            <input class="form-control" type="text" name="username"  required="required" autocomplete="off"  />

                                        </div>

                                        <div class="form-group">
                                         <label>Password<span style="color:red;">*</span></label>
                                         <input class="form-control" type="password" name="password" autocomplete="off"   required="required" />
                                       </div>

                                       <div class="form-group">
                                         <label>Level<span style="color:red;">*</span></label>
                                         <input class="form-control" type="text" name="level" autocomplete="off"   required="required" />
                                       </div>

                                         <button type="submit" name="add" class="btn btn-info">Add </button>

                                           </form>
                                       </div>
                                   </div>
                               </div>

                           </div>

                       </div>
                   </div>
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

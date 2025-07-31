<?php 
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
	
/*if(isset($_GET['del']))
		 {
		 
		 
		 
		 }

    // Get the ID of the row to delete
    $row_id = $_GET['id'];

    // Query to get the file path from tblcomplaints
    $sql = "SELECT file_path FROM tblcomplaints WHERE complaintNumber = '$row_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the file path
        $row = $result->fetch_assoc();
        $file_path = $row['file_path'];
        
        // Delete the file if it exists
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    
		 
		 
		 
		 
		          mysqli_query($bd, "delete from tblcomplaints where complaintNumber = '".$_GET['id']."'");
                  
				  
				   mysqli_query($bd, "delete from amount_detail where request = '".$_GET['id']."'");
                  $_SESSION['delmsg']="All Request info deleted !!";
		  }	
	*/
	
	
	
	
if (isset($_GET['del'])) {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cms";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the ID of the row to delete
    $row_id = $_GET['id'];

    // Query to get the file path from tblcomplaints
    $sql = "SELECT complaintFile, cocdoc FROM tblcomplaints WHERE complaintNumber = '$row_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the file path
        $row = $result->fetch_assoc();  
        $complaintFile = 'complaintdocs/' . $row['complaintFile'];
        $cocdoc = 'cocdocs/' . $row['cocdoc'];
        
        
        // Delete the files if they exist
        if (file_exists($complaintFile)) {
            unlink($complaintFile);
        }
        if (file_exists($cocdoc)) {
            unlink($cocdoc);
        }
    }

    // Delete the row from tblcomplaints
    mysqli_query($conn, "DELETE FROM tblcomplaints WHERE complaintNumber = '$row_id'");
                  
    // Delete the row from amount_detail
    mysqli_query($conn, "DELETE FROM amount_detail WHERE request = '$row_id'");

    $_SESSION['delmsg'] = "All Request info deleted !!";

    $conn->close();
}
?>

	

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>SDS | Request History</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <link href="assets/css/table-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >
<?php include("includes/header.php");?>
<?php include("includes/sidebar.php");?>
  <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i>Your Seed Request History</h3>
			
			<?php if(isset($_GET['del']))
{?>

<div class="alert alert-danger">
  <strong>Removed!</strong> <?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
</div>
									
<?php } ?>
			
			<?php $query=mysqli_query($bd, "select * from users where userEmail='".$_SESSION['login']."'");
 while($rowG=mysqli_fetch_array($query)) 
 {
 ?>  
			
	
	
	
<div class="row mt">
            <label class="col-sm-2 col-sm-2 control-label"><b>Seed Producer :</b></label>
              <div class="col-sm-4">
              <p><?php echo htmlentities($rowG['producer']);?></p>
              </div>
<label class="col-sm-2 col-sm-2 control-label"><b>Person Name :</b> </label>
              <div class="col-sm-4">
              <p><?php echo htmlentities($rowG['fullName']);?></p>
              </div>
            </div>
			<div class="row mt">
            <label class="col-sm-2 col-sm-2 control-label"><b>Telephone:</b></label>
              <div class="col-sm-4">
              <p><?php echo htmlentities($rowG['contactNo']);?></p>
              </div>
			  <label class="col-sm-2 col-sm-2 control-label"><b>E-Mail Address :</b></label>
              <div class="col-sm-4">
              <p><?php echo htmlentities($rowG['userEmail']);?></p>
              </div>
	<?php
	
}?>
    
		  		<div class="row mt">
			  		<div class="col-lg-12">
                      <div class="content-panel">
                          <section id="unseen">
                            <table class="table table-bordered table-striped table-condensed">
                              <thead>
                              <tr>
                                  <th>Request Number</th>
                                  <th>Reg Date</th>
                                  <th>last Updation date</th>
                                  <th >Status</th>
                                  <th>Action</th>
								  
                                  
                              </tr>
                              </thead>
							  
							 
                              <tbody>
  <?php $query=mysqli_query($bd, "select * from tblcomplaints  where userId='".$_SESSION['id']."' ORDER BY `complaintNumber` DESC");
while($row=mysqli_fetch_array($query))
{
  ?>
                              <tr>
                                  <td align="center"><?php echo htmlentities($row['complaintNumber']);?></td>
                                  <td align="center"><?php echo htmlentities($row['regDate']);?></td>
                                 <td align="center"><?php echo  htmlentities($row['lastUpdationDate']);

                                 ?></td>
                                  <td align="center"><?php 
                                    $status=$row['status'];
                                    if($status=="" or $status=="NULL")
                                    { ?>
                                      <button type="button" class="btn btn-warning">Waiting for Decision</button>
                                   <?php }
 if($status=="1"){ ?>
<button type="button" class="btn btn-info">With in Directorate</button>
<?php }
if($status=="3") {
?>
<button type="button" class="btn btn-success">Sent to Concerned Center</button>
<?php } ?>
<?php if($status=="4") {
?>
<button type="button" class="btn btn-danger">Declined</button>
<?php } ?>
                                   <td align="center">
                                   <a href="request-details.php?cid=<?php echo htmlentities($row['complaintNumber']);?>">
<button type="button" class="btn btn-primary">View Details</button></a>
                                   </td> 
								   
								   <td>
								   
								   <?php  
											
												
												if($status=="NULL" || $status=="" )
{
	
	
?>

											<a href="request-history.php?id=<?php echo $row['complaintNumber']?>&del=delete" onClick="return confirm('Are you sure want to delete the entire Request?')"><i class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></i></a>
<?php
} elseif($status=="1"){
   ?>
  
											<a href="request-history.php?id=<?php echo $row['complaintNumber']?>&del=delete" onClick="return confirm('Are you sure you want to delete the entire Request?')"><i class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></i></a>
   
   <?php

}
elseif($status=="3"){
             echo " ";
}
elseif($status=="4"){
             echo "Declined";
}
												
												
												
											?>
											
								   
								   
								   
								   </td>
                                </tr>
                              <?php } ?>
                            
                              </tbody>
                          </table>
                          </section>
                  </div><!-- /content-panel -->
               </div><!-- /col-lg-4 -->			
		  	</div><!-- /row -->
		  	
		  	

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->
<?php include("includes/footer.php");?>
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
    

  </body>
</html>
<?php } ?>

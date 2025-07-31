<?php session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{ ?>


<?php

if(isset($_POST['submit']))
{


$noc=$_POST['noc'];
$agree=$_POST['agree'];


if ($_FILES['compfile']['tmp_name']!='' && $_FILES["cocfile"]["tmp_name"]!='') {
 $compfile=$_FILES["compfile"]["name"];
$cocfile=$_FILES["cocfile"]["name"];

move_uploaded_file($_FILES["compfile"]["tmp_name"],"complaintdocs/".$_FILES["compfile"]["name"]);
move_uploaded_file($_FILES["cocfile"]["tmp_name"],"cocdocs/".$_FILES["cocfile"]["name"]);

$query=mysqli_query($bd, "update tblcomplaints set noc='$noc',mode='$agree',complaintFile='$compfile',cocdoc='$cocfile' where complaintNumber='".$_GET['cid']."'");
} 
elseif($_FILES['compfile']['tmp_name']!=''){
	
$compfile=$_FILES["compfile"]["name"];
move_uploaded_file($_FILES["compfile"]["tmp_name"],"complaintdocs/".$_FILES["compfile"]["name"]);	
	
	
	$query=mysqli_query($bd, "update tblcomplaints set noc='$noc',mode='$agree',complaintFile='$compfile' where complaintNumber='".$_GET['cid']."'");
}
elseif($_FILES["cocfile"]["tmp_name"]!=''){
	
$cocfile=$_FILES["cocfile"]["name"];
move_uploaded_file($_FILES["cocfile"]["tmp_name"],"cocdocs/".$_FILES["cocfile"]["name"]);

$query=mysqli_query($bd, "update tblcomplaints set noc='$noc',mode='$agree',cocdoc='$cocfile' where complaintNumber='".$_GET['cid']."'");
}


//$query=mysqli_query($bd, "update tblcomplaints set noc='$noc',mode='$agree',complaintFile='$compfile',cocdoc='$cocfile' where complaintNumber='".$_GET['cid']."'");
if($query)
{
$successmsg="Request Successfully !!";
}
else
{
$errormsg="Request not updated !!";
}
}




?>




<?php
if(isset($_REQUEST['del']))
		 {
			 $cid=$_GET['cid'];
		          mysqli_query($bd, "delete from amount_detail where id = '".$_GET['id']."'");
				   header("location:request-details.php?cid=$cid");
				   $_SESSION['delmsg']="Seed info deleted !!";
				   
		  }
?>


<?php
include('includes/config.php');
include('includes/connect.php');
$R_id=$_GET['cid'];
if(isset($_POST['submitmodal']))
{

$R_id=$_GET['cid'];
		$category = $_POST['crop_id'];
		$subcategory = $_POST['variety_id'];
		$complaintype = $_POST['class_id'];
		$amount = $_POST['amount'];
		
		if($category!=='' && $subcategory!=='' && $complaintype!=='' && $amount!=='' && $R_id!==''){
$sql="INSERT INTO amount_detail(request,crop,variety,class,amount)VALUES('$R_id','$category','$subcategory','$complaintype','$amount')";
			$stmt=$con->prepare($sql);
			$stmt->execute();
		
		header('location:request-details.php?cid='.$R_id.'');
	

}
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

    <title>SDS | Request Details</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
  </head>

  <body>

  <section id="container" >
<?php include('includes/header.php');?>
<?php include('includes/sidebar.php');?>
 <?php //$query=mysqli_query($bd, "select tblcomplaints.*,category.categoryName as catname from tblcomplaints join category on category.id=tblcomplaints.category where userId='".$_SESSION['id']."' and complaintNumber='".$_GET['cid']."'");?>
 <?php $query=mysqli_query($bd, "select * from tblcomplaints where userId='".$_SESSION['id']."' and complaintNumber='".$_GET['cid']."'");
while($row=mysqli_fetch_array($query))
{?>
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> View Status <i class="fa fa-angle-right" style="margin-left:50%;"></i> <?php $status=$row['status'];
                                    if($status=="" or $status=="NULL")
                                    { ?>
                                      <button type="button" class="btn btn-warning" style="font-size:20px;">Waiting for Decision</button>
                                   <?php }
 if($status=="1"){ ?>
<button type="button" class="btn btn-info" style="font-size:20px;">With in Directorate</button>
<?php }
if($status=="3") {
?>
<button type="button" class="btn btn-success" style="font-size:20px;">Sent to Concerned Center</button>
<?php } ?>
<?php if($status=="4") {
?>
<button type="button" class="btn btn-danger" style="font-size:20px;">Declined</button>
<?php } ?></h3>
            <hr />

          	<div class="row mt">
            <label class="col-sm-2 col-sm-2 control-label"><b>Request Number : </b></label>
          		<div class="col-sm-4">
          		<p><?php echo htmlentities($row['complaintNumber']);?></p>
          		</div>
<label class="col-sm-2 col-sm-2 control-label"><b>Reg. Date :</b></label>
              <div class="col-sm-4">
              <p><?php echo htmlentities($row['regDate']);?></p>
              </div>
          	</div>


<div class="row mt">
            <label class="col-sm-2 col-sm-2 control-label"><b>Seed Producer :</b></label>
              <div class="col-sm-4">
              <p><?php echo htmlentities($row['seed_producer']);?></p>
              </div>
<label class="col-sm-2 col-sm-2 control-label"><b>Person Name :</b> </label>
              <div class="col-sm-4">
              <p><?php echo htmlentities($row['Person_Name']);?></p>
              </div>
            </div>



  <div class="row mt">
            <label class="col-sm-2 col-sm-2 control-label"><b>Telephone:</b></label>
              <div class="col-sm-4">
              <p><?php echo htmlentities($row['telephone']);?></p>
              </div>
<label class="col-sm-2 col-sm-2 control-label"><b>Request Title :</b></label>
              <div class="col-sm-4">
              <p><?php //echo htmlentities($row['noc']);?>
			  
			  <?php if($row['noc']=="1")
											{ echo "For Research & demonstration";
} elseif($row['noc']=="2") {
										 echo "For further Multiplication";
										 }
										 else{
										 echo "Other";
										 }
										 ?></p>
              </div>
            </div>  

<div class="row mt">
  <label class="col-sm-2 col-sm-2 control-label"><b>Region :</b></label>
              <div class="col-sm-4">
            <p><?php echo htmlentities($row['Region']);?></p>
              </div>
            <label class="col-sm-2 col-sm-2 control-label"><b>Woreda:</b></label>
              <div class="col-sm-4">
              <p><?php echo htmlentities($row['woreda']);?></p>
              </div>
<label class="col-sm-2 col-sm-2 control-label"><b>Zone :</b></label>
              <div class="col-sm-4">
            <p><?php echo htmlentities($row['zones']);?></p>
              </div>
			
            </div>  

  <div class="row mt">
            <label class="col-sm-2 col-sm-2 control-label"><b>E-Mail Address :</b></label>
              <div class="col-sm-4">
              <p><?php echo htmlentities($row['email']);?></p>
              </div>
<label class="col-sm-2 col-sm-2 control-label"><b>Support Letter :</b></label>
              <div class="col-sm-4">
              <p><?php $cfile=$row['complaintFile'];
if($cfile=="" || $cfile=="NULL")
{
  echo htmlentities("File NA");
}
else{ ?>
<a href="complaintdocs/<?php echo htmlentities($row['complaintFile']);?>"> View File</a>
<?php } ?>

              </p>
			  
              </div>
			  <label class="col-sm-2 col-sm-2 control-label"><b>COC Document :</b></label>
			   <div class="col-sm-4">
              <p><?php $cocfile=$row['cocdoc'];
if($cocfile=="" || $cocfile=="NULL")
{
  echo htmlentities("File NA");
}
else{ ?>
<a href="cocdocs/<?php echo htmlentities($row['cocdoc']);?>"> View COC File</a>
<?php } ?>

              </p>
			  
              </div>
            </div> 
 <!--<div class="row mt">
            <label class="col-sm-2 col-sm-2 control-label"><b>Seed Request Details </label>
              <div class="col-sm-10">
              <p><?php echo htmlentities($row['complaintDetails']);?></p>
              </div>

            </div> -->
			<div class="row mt">
            <label class="col-sm-2 col-sm-2 control-label"><b>Mode of Request </label>
              <div class="col-sm-10">
              <p><?php if($row['mode']=="0")
{ echo "Contractual";
} elseif($row['mode']=="1") {
 echo "Non-Contractual";
										 }
										
										 
										 ?></p>
              </div>

            </div> 



<?php $ret=mysqli_query($bd, "select complaintremark.remark as remark,complaintremark.status as sstatus,complaintremark.remarkDate as rdate from complaintremark join tblcomplaints on tblcomplaints.complaintNumber=complaintremark.complaintNumber where complaintremark.complaintNumber='".$_GET['cid']."'");
while($rw=mysqli_fetch_array($ret))
{
?>
 <div class="row mt">
            
<label class="col-sm-2 col-sm-2 control-label"><b>Remark:</b></label>
              <div class="col-sm-10">
   <?php echo  htmlentities($rw['remark']); ?>&nbsp;&nbsp; <b>Remark Date: <?php echo  htmlentities($rw['rdate']); ?></b>
              </div>
            </div> 
 <div class="row mt">
            
<label class="col-sm-2 col-sm-2 control-label"><b>Status:</b></label>
              <div class="col-sm-10">
 <?php //echo  htmlentities($rw['sstatus']); ?>
 <?php 

if($rw['sstatus']=="NULL" || $rw['sstatus']=="" )
{
echo "Waiting for Decision";
} elseif($rw['sstatus']=="1"){
             echo "With in Directorate";
}
elseif($rw['sstatus']=="3"){
             echo "Sent to concerned Center";
}
elseif($rw['sstatus']=="4"){
             echo "Declined";
}
              ?>
              </div>
            </div>

<?php } ?>




 <div class="row mt">
            
<!--<label class="col-sm-2 col-sm-2 control-label"><b>Final Status :</b></label>
              <div class="col-sm-4">
              <p style="color:red">
			  <?php 

if($rw['status']=="NULL" || $rw['status']=="" )
{
echo "Waiting for Decision";
} elseif($rw['status']=="1"){
             echo "With in Directorate";
}
elseif($rw['status']=="3"){
             echo "Sent to concerned Center";
}
elseif($rw['status']=="4"){
             echo "Declined";
}
              ?>
			  
			  </p>
              </div>-->
            </div> 
			
			
	 	<!-- BASIC FORM ELELEMNTS -->
		
		<?php  
											
												
												if($status=="NULL" || $status=="" )
{
	
	include('update_mod.php');
	
?>


<?php
} elseif($status=="1"){
	
	include('update_mod.php');
   ?>
  
										
   
   <?php

}
elseif($status=="3"){
             echo " ";
}
elseif($status=="4"){
             echo "Declined";
}
												
												
												
											?>
		
		
          	
		
			
            <div class="module">
							<div class="module-head">
								<h3>Seed Request Details</h3>
									<div class="text-left">
									<p>
									<?php
									
									if($status=="NULL" || $status=="" )
									{
									
									
									?>
  <a href="" class="btn btn-info btn-rounded mb-4" data-toggle="modal" data-target="#modalLoginForm">+ Add more...</a></p>
  
						<?php			}
						
						elseif($status=="1"){
							?>
							
							<a href="" class="btn btn-info btn-rounded mb-4" data-toggle="modal" data-target="#modalLoginForm">+ Add more...</a></p>
							
							
							<?php
						}
						
						elseif($status=="3"){
             echo " ";
}
elseif($status=="4"){
             echo "Declined";
}
						
						
						
						?>
  
</div>
							</div>
							<div class="module-body table">
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Crop Name</th>
											<th>Variety</th>
											<th>Class</th>
											<th>Requested Amount</th>
											<th>Approved amount</th>
											<th>Center</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

<?php 
$req_no=$_GET['cid'];
$query=mysqli_query($bd, "select * from amount_detail where request=$req_no");
//$cnt=1;
while($rowtbl=mysqli_fetch_array($query))
{
?>									
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td><?php 
											$crop_name=htmlentities($rowtbl['crop']);
											$queryc=mysqli_query($bd, "select * from category where id=$crop_name");
//$cnt=1;
while($rwc=mysqli_fetch_array($queryc))
{
											
											
echo htmlentities($rwc['categoryName']);}?></td>
											<td>
											<?php 
											$v_name=htmlentities($rowtbl['variety']);
											$queryc=mysqli_query($bd, "select * from subcategory where id=$v_name");
//$cnt=1;
while($rwc=mysqli_fetch_array($queryc))
{
											
											
echo htmlentities($rwc['subcategory']);}?>
											</td>
											<td>

											<?php
if(htmlentities($rowtbl['class'])=="2"){
	
	echo "Basic";
}
elseif(htmlentities($rowtbl['class'])=="1"){
	echo "Pre-basic";
}
elseif(htmlentities($rowtbl['class'])=="3"){
	echo "Certified";
}
else{
	echo "Breeder Seed";
}
										?></td>
											<td><?php echo htmlentities($rowtbl['amount']);?></td>
											<td><?php echo htmlentities($rowtbl['approved']);?></td>
											<td>
											
											<?php 
											$center=htmlentities($rowtbl['center']);
											$querycn=mysqli_query($bd, "select * from center where C_ID=$center");
//$cnt=1;
while($rwcn=mysqli_fetch_array($querycn))
{
											
											
echo htmlentities($rwcn['C_Name']);}?>
											
											</td>
											<td>
											
											<?php  
											
												
												if($status=="NULL" || $status=="" )
{
	
	
?>
<a href="edit-seed-amount.php?cid=<?php echo $_GET['cid'];  ?>&id=<?php echo $rowtbl['id']?>" ><i class="btn btn-info"><i class="glyphicon glyphicon-edit"></i></i>     </a>
											<a href="request-details.php?cid=<?php echo $_GET['cid'];  ?>&id=<?php echo $rowtbl['id']?>&del=delete" onClick="return confirm('Are you sure want to delete?')"><i class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></i></a>
<?php
} elseif($status=="1"){
   ?>
   <a href="edit-seed-amount.php?cid=<?php echo $_GET['cid'];  ?>&id=<?php echo $rowtbl['id']?>" ><i class="btn btn-info"><i class="glyphicon glyphicon-edit"></i></i>   </a>
											<a href="request-details.php?cid=<?php echo $_GET['cid'];  ?>&id=<?php echo $rowtbl['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')"><i class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></i></a>
   
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
										<?php //$cnt=$cnt+1;

										} ?>
										
								</table>
							</div>
						</div>	



<?php  

include('add_amount.php');


?>




<?php } ?>
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->
<?php include('includes/footer.php');?>
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
    
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>
  
  <script>
  /*window.addEventListener('load', function() {
	  setTimeout(function()) {
		  
		  var e= document.getElementsByClassName("sw.close")[0];
		  e.setAttribute('onclick', "MicroModal.close('modalLoginForm');  location.reload();");
	  }, 1600);
  });*/
  
  </script>
  

  </body>
</html>
<?php } ?>

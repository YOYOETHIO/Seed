
<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin| Request Details</title>
	


	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	<script language="javascript" type="text/javascript">
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
 if(popUpWin)
{
if(!popUpWin.closed) popUpWin.close();
}
popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+800+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}

</script>

</head>
<body>
<?php include('include/header.php');?>

	<div class="wrapper">
		<div class="container">
			<div class="row">
<?php include('include/sidebar.php');?>				
			<div class="span9">
					<div class="content">

						


	<div class="module">
							<div class="module-head">
								<h3>Request Details</h3>
							</div>
							<div class="module-body table">
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
									
									<tbody>

<?php $st='closed';
$query=mysqli_query($bd, "select tblcomplaints.*,users.fullName as name from tblcomplaints join users on users.id=tblcomplaints.userId  where tblcomplaints.complaintNumber='".$_GET['cid']."'");
while($row=mysqli_fetch_array($query))
{

?>									
										<tr>
											<td><b>Request Number</b></td>
											<td><?php echo htmlentities($row['complaintNumber']);?></td>
											<td><b>Requester Name</b></td>
											<td> <?php echo htmlentities($row['name']);?></td>
											<td><b>Reg Date</b></td>
											<td colspan="2"><?php echo htmlentities($row['regDate']);?>
											</td>
										</tr>

<tr>
											<td><b>Requesting Institution </b></td>
											<td><?php echo htmlentities($row['seed_producer']);?></td>
											<td><b>Telephone</b></td>
											<td> <?php echo htmlentities($row['telephone']);?></td>
											<td><b>Region</b></td>
											<td colspan="2"><?php echo htmlentities($row['Region']);?>
											</td>
										</tr>
<tr>
											<td><b>E-mail </b></td>
											<td><?php echo htmlentities($row['email']);?></td>
											<td><b>Request Title</b></td>
											<td colspan="6"> <?php //echo htmlentities($row['noc']);?>
											<?php if($row['noc']=="1")
											{ echo "For Research & demonstration";
} elseif($row['noc']=="2") {
										 echo "For further Multiplication";
										 }
										 else{
										 echo "Other";
										 }
										 ?>
											
											</td>
											
											
										</tr>
										<tr>
										<td ><b>Request Date</b></td>
											<td colspan="6"> <?php echo htmlentities($row['request_date']);?></td>
										</tr>
<tr>
											<td><b>Request Description </b></td>
											
											<td colspan="6"> <?php echo htmlentities($row['complaintDetails']);?></td>
											
											
										</tr>

											</tr>
<tr>
											<td><b>Support letter(if any) </b></td>
											
											<td colspan="6"> <?php $cfile=$row['complaintFile'];
if($cfile=="" || $cfile=="NULL")
{
  echo "File NA";
}
else{?>
<!--<a href="http://knowledgebank.eiar.gov.et/sds/users/complaintdocs/<?php echo htmlentities($row['complaintFile']);?>" ?> View letter</a>-->
<?php $cid=$_GET['cid']; ?>
<a href="#" onclick="window.open('view_letter.php?cid=<?php echo $cid; ?>', 'popupWindow', 'width=900,height=800,toolbar=no,title=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes'); return false;">
  View Letter
</a>
<?php } ?></td>
</tr>
<tr>
											<td><b>COC Document </b></td>
											
											<td colspan="6"> <?php $cocfile=$row['cocdoc'];
if($cocfile=="" || $cfile=="NULL")
{
  echo "File NA";
}
else{?>
<!--<a href="http://knowledgebank.eiar.gov.et/sds/users/cocdocs/<?php echo htmlentities($row['cocdoc']);?>" ?> View COC Document</a>-->

<a href="#" onclick="window.open('view_coc.php?cid=<?php echo $cid; ?>', 'popupWindow', 'width=900,height=800,toolbar=no,title=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes'); return false;">
  View COC
</a>

<?php } ?></td>
</tr>
<?php $ret=mysqli_query($bd, "select complaintremark.remark as remark,complaintremark.status as sstatus,complaintremark.remarkDate as rdate,complaintremark.comment_ddg as ddgc from complaintremark join tblcomplaints on tblcomplaints.complaintNumber=complaintremark.complaintNumber where complaintremark.complaintNumber='".$_GET['cid']."'");
while($rw=mysqli_fetch_array($ret))
{
?>
<tr>
<td><b>Remark</b></td>
<td colspan="7"><?php echo  htmlentities($rw['remark']); ?> <b>Remark Date <?php echo  htmlentities($rw['rdate']); ?></b></td>

</tr>

<tr>
<td><b>Mode of Request</b></td>
<td colspan="7">
<?php if($row['mode']=="0")
{ echo "With Agreement";
} elseif($row['mode']=="1") {
 echo "Without Agreement";
										 }
										
										 
										 ?>


</td>

</tr>

<tr >
<td><b>DDG Comment</b></td>
											
											<td colspan="6"><?php  
											
											 echo  htmlentities($rw['ddgc']); 
										 ?></td>
											
										</tr>

<?php }?>
<tr>
<td><b>Status</b></td>

<td colspan="7"><?php if($row['status']=="")
											{ echo "Waiting for Decision";
} elseif($row['status']=="3") {
										 echo "Sent to Concered Center";
										 }
										 elseif($row['status']=="1") {
										 echo "With in Directorate";
										 }
										  elseif($row['status']=="4") {
											 echo "Declined";
										 }
										 ?></td>
</tr>



<tr>
											<td><b>Action</b></td>
											
											<td> 
											<?php if($row['status']=="1" && $row['status']=="2"){

												} else {?>
<a href="javascript:void(0);" onClick="popUpWindow('http://knowledgebank.eiar.gov.et/sds/EGS_AgriNet/updaterequestact.php?cid=<?php echo htmlentities($row['complaintNumber']);?>');" title="Update order">
											 <button type="button" class="btn btn-danger">Take Action</button></td>
											</a>
											
											
											
											<?php } ?></td>
											<td> 
											<?php if($row['status']=="1" && $row['status']=="2"){

												} else {
													if($_SESSION['role']==1){
													?>
<a href="javascript:void(0);" onClick="popUpWindow('http://knowledgebank.eiar.gov.et/sds/EGS_AgriNet/ddg_comment.php?cid=<?php echo htmlentities($row['complaintNumber']);?>');" title="Update order">
											 <button type="button" class="btn btn-danger">DDG Comment</button></td>
											</a>
											
											
											
													<?php }else{
														
														echo "";
														
													} } ?></td>
											<td colspan="3"> 
											<a href="javascript:void(0);" onClick="popUpWindow('http://knowledgebank.eiar.gov.et/sds/EGS_AgriNet/userprofile.php?uid=<?php echo htmlentities($row['userId']);?>');" title="Update order">
											 <button type="button" class="btn btn-primary">View User Detials</button></a></td>
											 <td> 
											<a href="javascript:void(0);" onClick="popUpWindow('http://knowledgebank.eiar.gov.et/sds/EGS_AgriNet/letterprint.php?uid=<?php echo htmlentities($row['complaintNumber']);?>');" title="Update order">
											 <button type="button" class="btn btn-success">Get Letter</button></a></td>
												<?php if($row['status']=="2"){

												} else {?> <td> 
											<!--<a href="javascript:void(0);" onClick="popUpWindow('http://knowledgebank.eiar.gov.et/sds/admin/crud_bootstrap/index.php?cid=<?php echo htmlentities($row['complaintNumber']);?>');" title="Update order">
										
												<button type="button" class="btn btn-primary">View Request Amount</button></td><?php } ?>
										<td>	</a>--><a href="assign_order.php?cid=<?php echo htmlentities($row['complaintNumber']);?>" class="btn btn-primary"> View Request Amount</a></td> 
											
											
										</tr>
										<?php  } ?>
										
								</table>
								
</div>

								</table>
							</div>
						</div>						
<div class="module">
							<div class="module-head">
								<h3>Requested Amount list</h3>
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
											<!--<th>Unit Price</th>-->
											<th>Approved amount</th>
											<th>Center</th>
										</tr>
									</thead>
									<tbody>

<?php 
$req_no=$_GET['cid'];
$query=mysqli_query($bd, "select * from amount_detail where request=$req_no");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>									
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td><?php 
											$crop_name=htmlentities($row['crop']);
											$queryc=mysqli_query($bd, "select * from category where id=$crop_name");
$cnt=1;
while($rwc=mysqli_fetch_array($queryc))
{
											
											
echo htmlentities($rwc['categoryName']);}?></td>
											<td>
											<?php 
											$v_name=htmlentities($row['variety']);
											$queryc=mysqli_query($bd, "select * from subcategory where id=$v_name");
$cnt=1;
while($rwc=mysqli_fetch_array($queryc))
{
											
											
echo htmlentities($rwc['subcategory']);}?>
											</td>
											<td>

											<?php
if(htmlentities($row['class'])=="1"){
	
	echo "Pre-basic";
}
elseif(htmlentities($row['class'])=="2"){
	echo "Basic";
}
elseif(htmlentities($row['class'])=="3"){
	echo "Certified";
}
else{
	echo "Breeder Seed";
}
										?></td>
											<td><?php echo htmlentities($row['amount']);?></td>
												<!--<td><?php echo htmlentities($row['unit_price']);?></td>-->
											<td><?php echo htmlentities($row['approved']);?></td>
											<td>
											
											<?php 
											$center=htmlentities($row['center']);
											$querycn=mysqli_query($bd, "select * from center where C_ID=$center");
$cnt=1;



while($rwcn=mysqli_fetch_array($querycn))
{
											
											
echo $rwcn['C_Name'];}?>
											
											
											</td>
											
										</tr>
										<?php $cnt=$cnt+1; } ?>
										
								</table>
							</div>
						</div>	
						
						
					</div><!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->
	</div><!--/.wrapper-->

<?php include('include/footer.php');?>
	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
	<script src="scripts/datatables/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
	</script>
</body>
<?php } ?>

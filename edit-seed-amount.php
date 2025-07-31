<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
date_default_timezone_set('Asia/Kolkata');
$currentTime = date( 'd-m-Y h:i:s A', time () );


if(isset($_POST['submit']))
{
$crop_id=$_POST['crop_id'];
$variety_id=$_POST['variety_id'];
$class_id=$_POST['class_id'];
$amount=$_POST['amount'];




$query=mysqli_query($bd, "update amount_detail set crop='$crop_id',variety='$variety_id',class='$class_id',amount='$amount' where id='".$_GET['id']."'");
if($query)
{
$successmsg="Request Amount Successfully !!";
}
else
{
$errormsg="Request Amount not updated !!";
}
}


?>

<script type="text/javascript">
  $(function() {
     $( "#producer" ).autocomplete({
       source: 'autocomplete.php',
     });
  });
  
 
  
  
  
</script>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>SDS | User Change Password</title>
	 <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
 
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
	 <script src="https://code.jquery.com/jquery-1.10.2.js" integrity="sha256-it5nQKHTz+34HijZJQkpNBIHsjpV8b6QzMJs9tmOBSo=" crossorigin="anonymous"></script>
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
 
  
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/table-responsive.css" rel="stylesheet">

  <script>
function getSubcat(val) {
	$.ajax({
	type: "POST",
	url: "get_subcat.php",
	data:'cat_id='+val,
	success: function(data){
		$("#subcategory").html(data);
	}
	});
}
function selectCountry(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}
</script>	
 
 
  <script type="text/javascript">
  $(function() {
     $( "#producer" ).autocomplete({
       source: 'autocomplete.php',
     });
  });
  
 
  
  
  
</script>

 <script type="text/javascript">
 $(function() {
     $( "#person" ).autocomplete({
       source: 'autoperson.php',
     });
  });
  </script>
  
  <script type="text/javascript">
 $(function() {
     $( "#email" ).autocomplete({
       source: 'autoemail.php',
     });
  });
  </script>
 <SCRIPT language=Javascript>
       <!--
       function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
       //-->
    </SCRIPT>
	
  
  </head>

  <body>

  <section id="container" >
     <?php include("includes/header.php");?>
      <?php include("includes/sidebar.php");?>
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Update Seed Amount</h3>
          	
          	<!-- BASIC FORM ELELEMNTS -->
          	<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                  	

                      <?php if($successmsg)
                      {?>
                      <div class="alert alert-success alert-dismissable">
                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <b>Well done!</b> <?php echo htmlentities($successmsg);?></div>
                      <?php }?>

   <?php if($errormsg)
                      {?>
                      <div class="alert alert-danger alert-dismissable">
 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <b>Oh snap!</b> </b> <?php echo htmlentities($errormsg);?></div>
                      <?php }?>
					  
					  
					  
 <?php $query=mysqli_query($bd, "select * from amount_detail where id='".$_GET['id']."'");
 while($row=mysqli_fetch_array($query)) 
 {
 ?>                     

 
   
                      <form class="form-horizontal style-form" method="post" name="profile" >

<div class="form-group">
<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b>  Crop</label>
<div class="col-sm-4">
<select name="crop_id"  class="form-control" onChange="getSubcat(this.value);"  required>
<option value="">Select Crop</option> 


<?php
$crop=htmlentities($row['crop']);


 $query_crop=mysqli_query($bd, "select * from category");
while($row_crop=mysqli_fetch_array($query_crop))
{
$option =$row_crop['categoryName'];
$option_id =$row_crop['id'];	
	
	
	?>
	
	
	 <?php
    if(!empty($crop) && $crop== $option_id){
    ?>
    <option value="<?php echo $option_id; ?>" selected><?php echo $option; ?> </option>
    <?php 
continue;
   }?>
    <option value="<?php echo $option_id; ?>" ><?php echo $option; ?> </option>
   <?php
    }
    ?>
</select>
</div>
<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b> Variety</label>
<div class="col-sm-4">
<select name="variety_id" id="subcategory" class="form-control" required>
<option value="">Select Variety</option>

 
<?php

$variety=htmlentities($row['variety']);

 $query_variety=mysqli_query($bd, "select * from subcategory where categoryid=$crop");
while($row_variety=mysqli_fetch_array($query_variety))
{

$optionv =$row_variety['subcategory'];
$option_v =$row_variety['id'];	
	
	
	?>
	
	
	 <?php
    if(!empty($variety) && $variety== $option_v){
    ?>
    <option value="<?php echo $option_v; ?>" selected><?php echo $optionv; ?> </option>
    <?php 
continue;
   }?>
    <option value="<?php echo $option_v; ?>" ><?php echo $optionv; ?> </option>
   <?php
    }
    ?>
</select>




 </div>

 </div>
 
 <div class="form-group">

<label class="col-sm-2 col-sm-2 control-label">Seed Class </label>
 <div class="col-sm-4">




<?php $option = htmlentities($row['class']);
?>
<select name="class_id" class="form-control" required="">
		<option value="">Select Class</option>
                    <option value="1" <?php if($option == "1") echo 'selected = "selected"'; ?>>Pre-basic</option>
                    <option value="2" <?php if($option == "2") echo 'selected = "selected"'; ?>>Basic</option>
                    <option value="3" <?php if($option == "3") echo 'selected = "selected"'; ?>>Breeder Seed</option>
                    <option value="4" <?php if($option == "4") echo 'selected = "selected"'; ?>>Certified Seed</option>
                </select>
</div>
<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b> Amount (Quintal)</label>
 <div class="col-sm-4">
<input type="number" name="amount" required="required" value="<?php echo htmlentities($row['amount']);?>" class="form-control">
</div>
</div>


<?php } ?>

                          <div class="form-group">
                           <div class="col-sm-10" style="padding-left:25% ">
<button type="submit" name="submit" class="btn btn-primary">Submit</button>
</div>
</div>

                          </form>
                          </div>
                          </div>
                          </div>
                          
          	
          	
		</section>
      </section>
    <?php include("includes/footer.php");?>
  </section>

    <!-- js placed at the end of the document so the pages load faster 
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>

	<!--custom switch
	<script src="assets/js/bootstrap-switch.js"></script>
	
	<!--custom tagsinput
	<script src="assets/js/jquery.tagsinput.js"></script>
	
	<!--custom checkbox & radio
	
	<script type="text/javascript" src="assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
	
	<script type="text/javascript" src="assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
	
	
	<script src="assets/js/form-component.js"></script>    
    -->
	
	
	
	
	
	   <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

  

	<!--custom switch-->
	<script src="assets/js/bootstrap-switch.js"></script>
	
	<!--custom tagsinput-->
	<script src="assets/js/jquery.tagsinput.js"></script>
	
	<!--custom checkbox & radio-->
	
	<script type="text/javascript" src="assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
	
	<script type="text/javascript" src="assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
	
	
	<script src="assets/js/form-component.js"></script>    
  
  
 
	
	
	
	
	
	
	
    
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
<?php } ?>

<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('includes/connect.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{


if(isset($_POST['submit']))
{
    $uid = $_SESSION['id'];
    $producer = $_POST['producer'];
    $person_name = $_POST['person_name'];
    $telephone = $_POST['telephone'];
    $Region = $_POST['Region'];
    $agree = $_POST['agree'];
    $zone = $_POST['zone'];
    $email = $_POST['email'];
    $woreda = $_POST['woreda'];
    $R_date = date('y/m/d');
    $noc = $_POST['noc'];
    $complaintdetials = $_POST['complaindetails'];

    // Get file names
    $compfile = $_FILES["compfile"]["name"];
    $cocfile = $_FILES["cocfile"]["name"];

    // Get file contents
    $compfileContent = file_get_contents($_FILES["compfile"]["tmp_name"]);
    $cocfileContent = file_get_contents($_FILES["cocfile"]["tmp_name"]);

    // Generate MD5 hash of the contents
    $compfileHash = md5($compfileContent);
    $cocfileHash = md5($cocfileContent);

    // Get file extensions
    $compfileExtension = pathinfo($compfile, PATHINFO_EXTENSION);
    $cocfileExtension = pathinfo($cocfile, PATHINFO_EXTENSION);

    // Create new file names
    $newCompfileName = $compfileHash . '.' . $compfileExtension;
    $newCocfileName = $cocfileHash . '.' . $cocfileExtension;

    // Define new file paths
    $newCompfilePath = 'complaintdocs/' . $newCompfileName;
    $newCocfilePath = 'cocdocs/' . $newCocfileName;

    // Move uploaded files to their new locations
    if (move_uploaded_file($_FILES["compfile"]["tmp_name"], $newCompfilePath)) {
        echo "Compfile renamed and moved to $newCompfilePath\n";
    } else {
        echo "Failed to move compfile\n";
    }

    if (move_uploaded_file($_FILES["cocfile"]["tmp_name"], $newCocfilePath)) {
        echo "Cocfile renamed and moved to $newCocfilePath\n";
    } else {
        echo "Failed to move cocfile\n";
    }

    // Insert into tblcomplaints
    $query = mysqli_query($bd, "INSERT INTO tblcomplaints(userId, noc, complaintDetails, complaintFile, request_date, seed_producer, telephone, Person_Name, Region, email, cocdoc, mode, woreda, zones) VALUES('$uid', '$noc', '$complaintdetials', '$newCompfileName', '$R_date', '$producer', '$telephone', '$person_name', '$Region', '$email', '$newCocfileName', '$agree', '$woreda', '$zone')");
    $l_id = mysqli_insert_id($bd);
    $sql = mysqli_query($bd, "SELECT complaintNumber FROM tblcomplaints ORDER BY complaintNumber DESC LIMIT 1");
    while($row = mysqli_fetch_array($sql))
    {
        $cmpn = $row['complaintNumber'];
    }

    for($i = 0; $i < count($_POST['slno']); $i++){
        $R_id = $l_id;
        $category = $_POST['category'][$i];
        $subcategory = $_POST['subcategory'][$i];
        $complaintype = $_POST['complaintype'][$i];
        $amount = $_POST['amount'][$i];

        if($category !== '' && $subcategory !== '' && $complaintype !== '' && $amount !== '' && $R_id !== ''){
            $sql = "INSERT INTO amount_detail(request, crop, variety, class, amount) VALUES('$R_id', '$category', '$subcategory', '$complaintype', '$amount')";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $last_id = $con->insert_id;

            $sqlevnt = mysqli_query($bd, "INSERT INTO inventory(product_id, qty, type, stock_from, form_id) VALUES('$subcategory', '0', '2', 'sales', '$last_id')");
        } else {
            echo '<div class="alert alert-danger" role="alert">Error Submitting in Data</div>';
        }
    }

    $complainno = $cmpn;
    echo '<script> alert("Your Request has been successfully filled and your RequestNo is ' . $complainno . ' ")</script>';
    header('location:dashboard.php');
}
?>





<?php

//index.php

include('database_connection.php');

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>SDS |  Register seed</title>

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
function getCat(val) {
  //alert('val');

  $.ajax({
  type: "POST",
  url: "getsubcat.php",
  data:'catid='+val,
  success: function(data){
    $("#subcategory").html(data);
    
  }
  });
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
          	<h3><i class="fa fa-angle-right"></i> Register Seed Request</h3>
          	
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
					  
					 <?php $query=mysqli_query($bd, "select * from users where userEmail='".$_SESSION['login']."'");
 while($row=mysqli_fetch_array($query)) 
 {
 ?>  

       <form class="form-horizontal style-form" method="post" name="complaint" enctype="multipart/form-data" >


<div class="form-group">
<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b>  Seed Producer / Customer Name</label>
<div class="col-sm-4">
<input type="text" name="producer" id="producer"  required="required" value="<?php echo htmlentities($row['producer']);?>" class="form-control" readonly>

 </div>
<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b>   Person Name </label>
 <div class="col-sm-4">
 <input type="text" name="person_name" id="person" required="required" value="<?php echo htmlentities($row['fullName']);?>" class="form-control" readonly>

</div>
 </div>


<div class="panel panel-default">
      <div class="panel-heading"></i>Address</div>
      <div class="panel-body">
	
<div class="form-group row">
  <div class="col-xs-4">
    <label for="ex4"><b style="color:red;">*</b> Region</label>

<input type="text" name="Region" id="Region"  required="required" value="<?php echo htmlentities($row['State']);?>" class="form-control" readonly>




  </div>
  <div class="col-xs-4">
    <label for="ex4"><b style="color:red;">*</b>  Zone</label>


				<input type="text" name="zone" id="zone" required="required" value="<?php echo htmlentities($row['zones']);?>" class="form-control" readonly>
				

  </div>
  <div class="col-xs-4">
   <label for="ex4"><b style="color:red;">*</b>  Woreda</label>
<input type="text" name="woreda" id="woreda" required="required" value="<?php echo htmlentities($row['woreda']);?>" class="form-control" readonly>
</div>
</div>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b> Telephone</label>
<div class="col-sm-4">
<!--<select name="complaintype" class="form-control" required="">
                <option value=" Complaint"> Pre-basic</option>
                  <option value="General Query">Basic</option>
                </select>-->
				<input type="text" name="telephone" required="required"  value="<?php echo htmlentities($row['contactNo']);?>" class="form-control" readonly>
				
</div>
<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b>  E-mail Address</label>
<div class="col-sm-4">

				<input type="email" name="email" id="email" required="required" value="<?php echo htmlentities($row['userEmail']);?>" class="form-control" readonly>
				
</div>

</div>


<div class="form-group">
<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b> Purpose of seed request</label>
<div class="col-sm-4">
<select name="noc" class="form-control" required="">
                <option value="1">For research & Demonstration</option>
                  <option value="2">For further Multiplication </option>
				<!--  <option value="3">Other</option>-->
                </select>
<!--<input type="text" name="noc" required="required" value="" required="" class="form-control">-->
</div>
<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b>  Mode of Request</label>
<div class="col-sm-4">
<select name="agree" class="form-control" required="">
                <option value="0">Contractual</option>
                  <option value="1">Non-contractual</option>
			
                </select>
<!--<input type="text" name="noc" required="required" value="" required="" class="form-control">-->
</div>
</div>
<div class="form-group">

<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b> COC Document </label>
<div class="col-sm-4">
<input type="file" name="cocfile" id="cocfile"  class="form-control" value="" required>
</div>

<label class="col-sm-2 col-sm-2 control-label">  Request Letter Doc(if any) </label>
<div class="col-sm-4">
<input type="file" name="compfile" id="compfile" class="form-control" value="" required>
</div>

</div>

<div class="form-group">


<div class="col-sm-12">
<h3> <i class="fa fa-angle-right"></i>Request Details</h3>
 
          <span id="error"></span>
          <table class="table table-bordered" id="item_table" >
            <thead>
              <tr>
                <th>#</th>
                <th>Crop Name:</th>
                <th>Variety Name:</th>
				  <th>Class Name:</th>
				  <th>Amount (Quintal):</th>
				
                <th><button type="button" name="add" class="btn btn-success btn-xs add" style="font-size:16px;"><span class="glyphicon glyphicon-plus"></span>Add detail</button></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
          




</div>


</div>
<div id="message"><p style="color:red;">
			<?php echo $password_error; ?>
		</p></div>
		
		<?php }?>

<div class="form-group">
                       <div class="col-sm-6">
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
	

<script>
    $(document).ready(function(){
      
      var count = 0;

      $(document).on('click', '.add', function(){
		  
        count++;
        var html = '';
        html += '<tr>';
       
		html += '<td><input type="text" class="form-control sl" name="slno[]" value="'+count+'" readonly=""></td>';
        html += '<td><select name="category[]" class="form-control item_category" data-sub_category_id="'+count+'" required=""><option value="">Select Category</option><?php echo fill_select_box($connect, "0"); ?></select></td>';
        html += '<td><select name="subcategory[]" class="form-control item_sub_category" id="item_sub_category'+count+'" required=""><option value="">Select Sub Category</option></select></td>';
		 html += '<td><select name="complaintype[]" class="form-control" required=""><option value="1"> Pre-basic</option><option value="2">Basic</option><option value="3">Certified</option><option value="4">Breeder Seed</option></select></td>';
		 html += '<td><input id="txtChar" onkeypress="return isNumberKey(event)" type="text"  class="form-control"  name="amount[]" placeholder="Amount" required=""></td>';
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><span class="glyphicon glyphicon-minus"></span></button></td>';
        $('tbody').append(html);
      });

      $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
      });

      $(document).on('change', '.item_category', function(){
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
          url:"fill_sub_category.php",
          method:"POST",
          data:{id:id},
          success:function(data)
          {
            var html = '<option value="">Select Sub Category</option>';
            html += data;
            $('#item_sub_category'+sub_category_id).html(html);
          }
        })
      });

   
      
    });
</script>
<?php } ?>

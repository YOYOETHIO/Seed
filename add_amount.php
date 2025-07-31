

<script type="text/javascript">
  $(function() {
     $( "#producer" ).autocomplete({
       source: 'autocomplete.php',
     });
  });
</script>
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
	 <script type="text/javascript">
  document.querySelector('input[name=submit]').addEventListener('click', function(e) {
    e.preventDefault();

    window.location.reload();
  });
</script>

<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Add</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        
			<div class="row mt">
          		<div class="col-lg-12">
             
                  	

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
					  
					  
					  
                    

 
   
                      <form action="" class="form-horizontal style-form" method="post" name="profile" >

<div class="form-group">
<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b>  Crop</label>
<div class="col-sm-4">

<select name="crop_id" class="form-control" onChange="getSubcat(this.value);"  required>
<option value="">Select Crop</option> 
<?php $query=mysqli_query($bd, "select * from category");
while($rowm=mysqli_fetch_array($query))
{?>

<option value="<?php echo $rowm['id'];?>"><?php echo $rowm['categoryName'];?></option>
<?php } ?>
</select>


</div>

<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b> Variety</label>
<div class="col-sm-4">


<select name="variety_id" id="subcategory" class="form-control" required="">
<option value="">Select Variety</option> 
<?php $query=mysqli_query($bd, "select * from subcategory");
while($rowmv=mysqli_fetch_array($query))
{?>

<option value="<?php echo $rowmv['id'];?>"><?php echo $rowmv['subcategory'];?></option>
<?php } ?>
</select>




 </div>

 </div>
 
 <div class="form-group">

<label class="col-sm-2 col-sm-2 control-label">Seed Class </label>
 <div class="col-sm-4">
<select name="class_id" class="form-control" required="">
		<option value="">Select Class</option>
		<option value="1"> Pre-basic</option>
		<option value="2">Basic</option>
			<option value="3">Breeder Seed</option>
				<option value="4">Certified Seed</option>
		</select>
</div>
<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b> Amount (Quintal)</label>
 <div class="col-sm-4">
<input type="number" name="amount" required="required" class="form-control">
</div>
</div>



                          <div class="form-group">
                           <div class="col-sm-10" style="padding-left:25% ">
<button type="submit" name="submitmodal"  class="btn btn-primary">Submit</button>
</div>
</div>

                          </form>
                        
                         
                          
		
		
		
		
    </div>
  </div>
</div>
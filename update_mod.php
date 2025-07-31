<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">

 <form class="form-horizontal style-form" method="post" name="complaint" enctype="multipart/form-data" >
 
 <div class="form-group">
<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b> Purpose of seed request</label>
<div class="col-sm-4">


<?php $option_noc = htmlentities($row['noc']);


?>
<select name="noc" class="form-control" required="">
		
                    <option value="1" <?php if($option_noc == "1") echo 'selected = "selected"'; ?>>For research & Demonstration</option>
                    <option value="2" <?php if($option_noc == "2") echo 'selected = "selected"'; ?>>For further Multiplication</option>
                  
                    
                </select>




</div>
<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b>  Mode of Request</label>
<div class="col-sm-4">

<?php $option = htmlentities($row['mode']);


?>
<select name="agree" class="form-control" required="">
		
                    <option value="0" <?php if($option == "0") echo 'selected = "selected"'; ?>>Contractual</option>
                    <option value="1" <?php if($option == "1") echo 'selected = "selected"'; ?>>Non-contractual</option>
                  
                    
                </select>


</div>
</div>
<div class="form-group">

<label class="col-sm-2 col-sm-2 control-label"><b style="color:red;">*</b> COC Document </label>
<div class="col-sm-4">
<input type="file" name="cocfile" id="cocfile"  class="form-control" >
</div>

<label class="col-sm-2 col-sm-2 control-label">  Request Letter Doc(if any) </label>
<div class="col-sm-4">
<input type="file" name="compfile" id="compfile" class="form-control" >
</div>

</div>
 
 <div class="form-group">
                           <div class="col-sm-10" style="padding-left:25% ">
<button type="submit" name="submit" class="btn btn-primary">Update</button>
</div>

<div class="col-sm-4">





</div>

</div>
 
 
 </form>



</div>

</div>
</div>		


<!--edit update model---->		  
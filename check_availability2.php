<?php 
require_once("includes/config.php");
if(!empty($_POST["contactno"])) {
	
		
	$contactno = $_POST['contactno'];

// Remove leading zero if present
   $contactno = preg_replace("/^0/", "", $contactno);

  
   
   if (preg_match("/^[0-9]{9}$/", $contactno)) {
   
     
       
        echo "<span style='color:green'> Phone Number is Correct .</span>";
   echo "<script>$('#submit').prop('disabled',false);</script>";
   
   
  } else {
     echo "<span style='color:red'> Phonenumber is not correct .</span>";
       echo "<script>$('#submit').prop('disabled',true);</script>";
  
  }



  
  
  }


?>

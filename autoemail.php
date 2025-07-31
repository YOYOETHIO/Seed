<?php
require_once('connection.php');

function get_email($conn , $term){	
	$query = "SELECT * FROM tblcomplaints WHERE email LIKE '%".$term."%' ORDER BY email ASC";
	$result = mysqli_query($conn, $query);	
	$dataE = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $dataE;	
}

if (isset($_GET['term'])) {
	$getEmail = get_email($conn, $_GET['term']);
	$emailList = array();
	foreach($getEmail as $email){
		$emailList[] = $email['email'];
	}
	echo json_encode($emailList);
}
?>
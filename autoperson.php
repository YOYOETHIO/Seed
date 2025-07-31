<?php
require_once('connection.php');

function get_person($conn , $term){	
	$query = "SELECT * FROM users WHERE fullName LIKE '%".$term."%' ORDER BY fullName ASC";
	$result = mysqli_query($conn, $query);	
	$datap = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $datap;	
}

if (isset($_GET['term'])) {
	$getPerson = get_person($conn, $_GET['term']);
	$personList = array();
	foreach($getPerson as $city){
		$personList[] = $city['fullName'];
	}
	echo json_encode($personList);
}
?>
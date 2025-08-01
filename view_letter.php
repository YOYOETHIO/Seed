<?php
include('includes/config.php');
include('includes/connect.php');

$id = intval($_GET['cid']); // Always sanitize input!

$result = $con->query("SELECT complaintFile FROM tblcomplaints WHERE complaintNumber = $id");

if ($row = $result->fetch_assoc()) {
  echo '<img src="data:image/jpeg;base64,' . base64_encode($row['complaintFile']) . '"/>';

}
?>

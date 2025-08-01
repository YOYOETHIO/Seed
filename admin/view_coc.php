<?php
include('include/config.php');
include('include/connect.php');

$id = intval($_GET['cid']); // Always sanitize input!

$result = $con->query("SELECT * FROM tblcomplaints WHERE complaintNumber = $id");

if ($row = $result->fetch_assoc()) {
  echo '<img src="data:image/jpeg;base64,' . base64_encode($row['cocdoc']) . '"/>';
?>
<?php
/*$mimeType = "application/pdf"; // gets MIME type of the file content

switch ($mimeType) {
  case 'image/jpeg':
  case 'image/png':
  case 'image/gif':
    echo '<img src="data:' . $mimeType . ';base64,' . base64_encode($row['cocdoc']) . '" />';
    break;
  case 'application/pdf':
    echo '<embed src="data:' . $mimeType . ';base64,' . base64_encode($row['cocdoc']) . '" type="application/pdf" width="800px" height="600px" />';
    break;
  default:
    echo '<p>Unsupported file type: ' . $mimeType . '</p>';
    break;
}*/
}
?>
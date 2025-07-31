<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost; dbname=cms;", "root", "");

function fill_select_box($connect, $id)
{
 $query = "
  SELECT * FROM category ORDER BY categoryName ASC";

 $statement = $connect->prepare($query);

 $statement->execute();

 $result = $statement->fetchAll();

 $output = '';

 foreach($result as $row)
 {
  $output .= '<option value="'.$row["id"].'">'.$row["categoryName"].'</option>';
 }

 return $output;
}


function fill_select_box_two($connect, $id)
{
 $query = "
  SELECT * FROM subcategory WHERE categoryid = '".$id."' ORDER BY subcategory ASC";

 $statement = $connect->prepare($query);

 $statement->execute();

 $result = $statement->fetchAll();

 $output = '';

 foreach($result as $row)
 {
  $output .= '<option value="'.$row["id"].'">'.$row["subcategory"].'</option>';
 }

 return $output;
}

?>
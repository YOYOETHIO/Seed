<?php

//fill_sub_category.php

include('database_connection.php');

echo fill_select_box_two($connect, $_POST["id"]);

?>
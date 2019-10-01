<?php
//database connection
$db_host = "localhost";
$db_user = "id11029219_ganymede";
$db_password = "ganymede2019";
$db_name = "id11029219_ganymede_budget_app";


$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$conn){
    echo ("database not connected". mysqli_error($conn));
}else{
    //echo(" database connected");
}

?>
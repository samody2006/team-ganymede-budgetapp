<?php
//database connection
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "budget_app_hngi6";


$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$conn){
    echo ("database not connected". mysqli_error($conn));
}else{
    //echo(" database connected");
}

?>
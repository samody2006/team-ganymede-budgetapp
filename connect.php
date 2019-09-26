<?php
//database connection
$db_host = "sql101.epizy.com";
$db_user = "epiz_24542305";
$db_password = "BfxDnqQK4RWUa";
$db_name = "epiz_24542305_ganymede";


$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$conn){
    echo ("database not connected". mysqli_error($conn));
}else{
    echo(" database connected");
}

?>
<?php

//connect database
require_once('connect.php');

//get data from form
$fullname =$_POST['fullname'];
$username =$_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

$pass = md5($password);
date_default_timezone_set("Africa/Lagos");
$date = date("Y-m-d H: i:s", time());

//check password
if($password === $password2){
    //further check
    //check if username already exist
    $sql = "SELECT username from `user` WHERE username='$username'";
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $count = mysqli_num_rows($query);
    if($count>0){
        header ("Refresh:3, url=signup.html");
        die("OPPS!!! USERNAME ALREADY EXIST!!!");
    }


    //check if email aleady exist
    $sql = "SELECT email FROM `user` WHERE email='$email'";
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $count = mysqli_num_rows($query);
    if($count>0){
        header ("Refresh:3, url=signup.html");
        die("OPPS!!! EMAIL ALREADY EXIST!!!");
    }


    //add details to database if all the check is passed
    $sql = "INSERT INTO `user` (username, password_hash, email, created_at)
     VALUES ('$username', '$pass', '$email', '$date'";
     $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

     if($query){
         header("Refresh:3, url=dashboard.html");
         echo "REGISTRATION SUCCESSFUL!!!";
     }else{
         echo("REGISTRATION NOT SUCCESSFUL!!!");
     }

}else{
    //return to registration page
    header("Refresh:3, url=signup.html");
    die("OPPS!!! PASSWORD DOES NOT MATCH!");
}


?>

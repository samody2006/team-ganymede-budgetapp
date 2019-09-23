<?php

//connect database
require_once('connect.php');

//get data from form
$fullname =$_POST['fullname'];
$username =$_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

//check password
if($password === $password2){
    //further check
    //check if username already exist
    $sql = "SELECT username from `user` WHERE username=$username";
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $count = mysqli_num_rows($query);
    if($count>0){
        header ("Refresh:3, url=signup.html");
        die("OPPS!!! USERNAME ALREADY EXIST!!!");
    }


    //check if email aleady exist
    $sql = "SELECT email from `user` WHERE email=$email";
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $count = mysqli_num_rows($query);
    if($count>0){
        header ("Refresh:3, url=signup.html");
        die("OPPS!!! EMAIL ALREADY EXIST!!!");
    }


    //add details to database if all the check is passed



}else{
    //return to registration page
    header("Refresh:3, url=signup.html");
    die("OPPS!!! PASSWORD DOES NOT MATCH!");
}


?>
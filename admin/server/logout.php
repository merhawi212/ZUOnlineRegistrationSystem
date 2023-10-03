<?php
session_start();
include 'connection.php';

$user=$_SESSION["login"];
$username= $user;
//$username = substr($user, 0, strpos($user, "@"));
$query="update admin set status='inactive' WHERE username='$username' "; 
$result= mysqli_query($connection, $query);
//echo $query;

session_destroy();
setcookie ('PHPSESSID', '', time( )-1, '/', '', 0, 0);
header("Location:login.php");

    
?>
<?php
  $db_hostname = 'localhost';
  $db_database = 'university_class_scheduler';
  $db_username = 'root';
  $db_password = '';
$connection_2 = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
if(!$connection_2){
    die("unable to connect".mysqli_connect_errno());
}
?>
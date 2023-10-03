<?php
  $db_hostname = 'localhost';
  $db_database = 'course_registration_system';
  $db_username = 'root';
  $db_password = '';
$connection = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
if(!$connection){
    die("unable to connect".mysqli_connect_errno());
}
?>
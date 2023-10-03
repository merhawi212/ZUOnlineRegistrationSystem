<?php
session_start();
 date_default_timezone_set('Asia/dubai');
 
if(empty($_SESSION["login"])){
    header("Location:login.php");
  

} else {
   if(time() - $_SESSION["lastAccessTimeStamp"] >18000) 
    {
        session_unset();
        session_destroy();
         header("Location:login.php");
    } 
}

?>